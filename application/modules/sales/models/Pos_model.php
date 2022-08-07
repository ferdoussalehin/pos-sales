<?php

 defined('BASEPATH') OR exit('No direct script access allowed');

 class Pos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getPosSales($length, $start, $order=null, $q='')
    {
        $column = ['sales.id', 'sales.date', 'sales.reference_no', 'sales.biller','sales.customer', 'sales.grand_total', 'sales.paid'];
        $this->db
                ->select('sales.id, sales.date, sales.reference_no, sales.biller, sales.customer, sales.grand_total, sales.paid, sales.sale_status, sales.payment_status')
                ->from('sales')
                ->where('sales.pos', 1)
                ;
        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('sales.id', $q)
                ->or_like('sales.date', $q)
                ->or_like('sales.reference_no', $q)
                ->or_like('sales.customer', $q)
                ->or_like('sales.biller', $q)
                ->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('sales.id', 'desc');
        }
        $result = $this->db
                ->limit($length, $start)
                ->get()
                ->result();

        return $result;
    }

    public function getPosSalesTotal()
    {
        return $this->db->select('COUNT(id) AS total_sale')->where('pos', 1)->get('sales')->row();
    }

    public function addSale($data = [], $items = [], $payments = [], $sid = null, $pc_no = 1)
    {
        // $this->sma->print_arrays($cost);
        $this->db->trans_start();
        $data['reference_no'] = $this->app_model->getReference('pos');
        if ($this->db->insert('sales', $data)) {
            $sale_id = $this->db->insert_id();
            //  order status entry
            $q = $this->db->get_where('order_status_tracking', ['order_id' => $sale_id], 1);
            if ($q->num_rows() > 0) {
            }else {
                $status_data = array('order_id' => $sale_id, 'status_id' => 1);
                $this->db->insert('order_status_tracking', $status_data);
            }
            //            order status entry end
            // $item_quantity = 0;
            foreach ($items as $item) {
                $item['sale_id'] = $sale_id;
                $this->db->insert('sale_items', $item);
                $sale_item_id = $this->db->insert_id();
                // $item_quantity += $item['quantity']; 
                
            }
            
            // if ($data['sale_status'] == 'completed') {
            //     $this->app_model->syncPurchaseItems($cost);
            // }
            $this->app_model->syncQuantity($sale_id);
            // if ($sid) {
            //     $this->deleteBill($sid);
            // }
            // $this->sma->update_award_points($data['grand_total'], $data['customer_id'], $data['created_by']);
            $this->app_model->updateReference('pos');
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            log_message('error', 'An errors has been occurred while adding the sale (Add:Pos_model.php)');
        } else {
            $msg = [];
            if (!empty($payments)) {
                $paid = 0;
                foreach ($payments as $payment) {
                    if (!empty($payment) && isset($payment['amount']) && $payment['amount'] != 0) {
                        $payment['sale_id']      = $sale_id;
                        $payment['reference_no'] = $this->app_model->getReference('pay');

                            $this->db->insert('payments', $payment);
                            $this->app_model->updateReference('pay');
                            $paid += $payment['amount'];
                        
                    }
                }
                $this->app_model->syncSalePayments($sale_id);
            }
            return ['sale_id' => $sale_id, 'message' => $msg, 'reference_no' => $data['reference_no']];
        }


    }

    public function updateSale($id, $data = [], $items = [], $payments = [], $sid = null, $pc_no = 1)
    {
        
        $this->db->trans_start();
        if ($this->db->update('sales', $data, ['id' => $id])) {
            //  order status entry
            $q = $this->db->get_where('order_status_tracking', ['order_id' => $sale_id], 1);
            if ($q->num_rows() > 0) {
            }else {
                $status_data = array('order_id' => $sale_id, 'status_id' => 1);
                $this->db->insert('order_status_tracking', $status_data);
            }
            // order status entry end
            $this->db->delete('sale_items', ['sale_id' => $id]);
            foreach ($items as $item) {
                $item['sale_id'] = $id;
                $this->db->insert('sale_items', $item);
                $sale_item_id = $this->db->insert_id();
                
            }
            $this->app_model->syncQuantity($sale_id);
            if ($data['sale_status'] == 'completed') {
                $this->app_model->syncPurchaseItems($cost);
            }

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            log_message('error', 'An errors has been occurred while adding the sale (Add:Pos_model.php)');
        } else {
            $msg = [];
            if (!empty($payments)) {
                $this->db->delete('payments', ['sale_id' => $id]);
                $paid = 0;
                foreach ($payments as $payment) {
                    if (!empty($payment) && isset($payment['amount']) && $payment['amount'] != 0) {
                        $payment['sale_id']      = $id;
                        $payment['reference_no'] = $this->app_model->getReference('pay');

                            $this->db->insert('payments', $payment);
                            $this->app_model->updateReference('pay');
                            $paid += $payment['amount'];
                        
                    }
                }
                $this->app_model->syncSalePayments($id);
            }
            return ['sale_id' => $id, 'message' => $msg, 'reference_no' => $data['reference_no']];
        }

    }

    public function deleteSale($id)
    {
        $this->db->trans_start();
        $sale       = $this->getInvoiceByID($id);
        // $items = $this->getAllInvoiceItems($id);
        // $this->app_model->syncQuantity(null, null, $items);

        if ($this->db->delete('sale_items', ['sale_id' => $id]) && $this->db->delete('sales', ['id' => $id])) {
            $this->db->delete('sales', ['sale_id' => $id]);
            $this->db->delete('payments', ['sale_id' => $id]);
            $this->app_model->syncQuantity(null, null, $sale_items);
        }
        $this->db->delete('attachments', ['subject_id' => $id, 'subject_type' => 'sale']);
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            log_message('error', 'An errors has been occurred while adding the sale (Delete:Sales_model.php)');
        } else {
            return true;
        }
        return false;
    }

    public function getInvoiceByID($id)
    {
        $q = $this->db->get_where('sales', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return false;
    }

    public function fetch_products($category_id, $subcategory_id = null, $brand_id = null)
    {
        // $this->db->limit($limit, $start);
        if ($brand_id) {
            $this->db->where('brand', $brand_id);
        } elseif ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        if ($subcategory_id) {
            $this->db->where('subcategory_id', $subcategory_id);
        }
        $this->db->where('hide_pos !=', 1);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('products');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getSubCategories($parent_id)
    {
        $this->db->where('parent_id', $parent_id)->order_by('name');
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getWHProduct($code, $warehouse_id)
    {
        $this->db->select('products.*, warehouses_products.quantity, categories.id as category_id, categories.name as category_name')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->join('categories', 'categories.id=products.category_id', 'left')
            ->where('hide_pos !=', 1)
            ->group_by('products.id');
        $q = $this->db->get_where('products', ['products.code' => $code, 'warehouses_products.warehouse_id' => $warehouse_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return false;
    }
    public function getProductOptions($product_id, $warehouse_id, $all = null)
    {
        $wpv = "( SELECT option_id, warehouse_id, quantity from {$this->db->dbprefix('warehouses_products_variants')} WHERE product_id = {$product_id}) FWPV";
        $this->db->select('product_variants.id as id, product_variants.name as name, product_variants.price as price, product_variants.quantity as total_quantity, FWPV.quantity as quantity', false)
            ->join($wpv, 'FWPV.option_id=product_variants.id', 'left')
            //->join('warehouses', 'warehouses.id=product_variants.warehouse_id', 'left')
            ->where('product_variants.product_id', $product_id)
            ->group_by('product_variants.id');

        if (!$this->Settings->overselling && !$all) {
            $this->db->where('FWPV.warehouse_id', $warehouse_id);
            $this->db->where('FWPV.quantity >', 0);
        }
        $q = $this->db->get('product_variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductOptionByID($id)
    {
        $q = $this->db->get_where('product_variants', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCustomerByID($id)
    {
        $q = $this->db->get_where('customers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductNames($term, $warehouse_id, $pos = false, $limit = 5)
    {
        $wp = "( SELECT product_id, warehouse_id, quantity as quantity from {$this->db->dbprefix('warehouses_products')} ) FWP";

        $this->db->select('products.*, FWP.quantity as quantity, categories.id as category_id, categories.name as category_name', false)
            ->join($wp, 'FWP.product_id=products.id', 'left')
            // ->join('warehouses_products FWP', 'FWP.product_id=products.id', 'left')
            ->join('categories', 'categories.id=products.category_id', 'left')
            ->group_by('products.id');
        if ($this->Settings->overselling) {
            $this->db->where("({$this->db->dbprefix('products')}.name LIKE '%" . $term . "%' OR {$this->db->dbprefix('products')}.code LIKE '%" . $term . "%' OR  concat({$this->db->dbprefix('products')}.name, ' (', {$this->db->dbprefix('products')}.code, ')') LIKE '%" . $term . "%')");
        } else {
            $this->db->where("((({$this->db->dbprefix('products')}.track_quantity = 0 OR FWP.quantity > 0) AND FWP.warehouse_id = '" . $warehouse_id . "') OR {$this->db->dbprefix('products')}.type != 'standard') AND "
                . "({$this->db->dbprefix('products')}.name LIKE '%" . $term . "%' OR {$this->db->dbprefix('products')}.code LIKE '%" . $term . "%' OR  concat({$this->db->dbprefix('products')}.name, ' (', {$this->db->dbprefix('products')}.code, ')') LIKE '%" . $term . "%')");
        }
        // $this->db->order_by('products.name ASC');
        if ($pos) {
            $this->db->where('hide_pos !=', 1);
        }
         $this->db->order_by('products.id desc');
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getProductByCode($code)
    {
        $q = $this->db->get_where('products', ['code' => $code], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getAllInvoiceItems($sale_id)
    {
        if ($this->pos_settings->item_order == 0) {
            $this->db->select('sale_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, product_variants.name as variant, products.details as details, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('products', 'products.id=sale_items.product_id', 'left')
            ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
            ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
            ->group_by('sale_items.id')
            ->order_by('id', 'asc');
        } elseif ($this->pos_settings->item_order == 1) {
            $this->db->select('sale_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, product_variants.name as variant, categories.id as category_id, categories.name as category_name, products.details as details, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
            ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
            ->join('products', 'products.id=sale_items.product_id', 'left')
            ->join('categories', 'categories.id=products.category_id', 'left')
            ->group_by('sale_items.id')
            ->order_by('categories.id', 'asc');
        }

        $q = $this->db->get_where('sale_items', ['sale_id' => $sale_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getInvoicePayments($sale_id)
    {
        $q = $this->db->get_where('payments', ['sale_id' => $sale_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return array();
    }

    public function getSaleItemById($id='')
    {
        return $this->db->get_where('sale_items', ['id' => $id])->row();
    }

    public function addPayment($payment = [], $customer_id = null)
    {
        // print_r($payment); die;
        if (isset($payment['sale_id']) && isset($payment['paid_by']) && isset($payment['amount'])) {
            $payment['pos_paid'] = $payment['amount'];
            $inv                 = $this->getInvoiceByID($payment['sale_id']);
            $paid                = $inv->paid + $payment['amount'];

            unset($payment['cc_cvv2']);
            $this->db->insert('payments', $payment);
            $paid += $payment['amount'];

            $this->app_model->syncSalePayments($payment['sale_id']);
            return true;
        }
        return false;
    }

    public function updatePayment($id, $payment = [])
    {
        // print_r($payment); die;
        if (isset($payment['sale_id']) && isset($payment['paid_by']) && isset($payment['amount'])) {
            $payment['pos_paid'] = $payment['amount'];
            $inv                 = $this->getInvoiceByID($payment['sale_id']);
            $paid                = $inv->paid + $payment['amount'];

            unset($payment['cc_cvv2']);
            $this->db->where('id', $id)->update('payments', $payment);
            $paid += $payment['amount'];

            $this->app_model->syncSalePayments($payment['sale_id']);
            return true;
        }
        return false;
    }

    public function deletePayment($id)
    {
        $opay = $this->getPaymentByID($id);
        if ($this->db->delete('payments', ['id' => $id])) {
            $this->app_model->syncSalePayments($opay->sale_id);
            
            return true;
        }
        return false;
    }
    public function getPaymentByID($id)
    {
        $q = $this->db->get_where('payments', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
}





