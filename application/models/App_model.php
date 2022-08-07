<?php

defined('BASEPATH') or exit('No direct script access allowed');

class App_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->Settings = $this->get_setting();
    }

    public function getAllWarehouses()
    {
        $q = $this->db->get('warehouses');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_setting()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getPosSetting()
    {
        $q = $this->db->get('pos_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    public function getTaxRateByID($id)
    {
        $q = $this->db->get_where('tax_rates', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function calculateTax($product_details = null, $tax_details = null, $custom_value = null, $c_on = null)
    {
        $value      = $custom_value ? $custom_value : (($c_on == 'cost') ? $product_details->cost : $product_details->price);
        $tax_amount = 0;
        $tax        = 0;
        if ($tax_details && $tax_details->type == 1 && $tax_details->rate != 0) {
            if ($product_details && $product_details->tax_method == 1) {
                $tax_amount = $this->sls->formatDecimal((($value) * $tax_details->rate) / 100, 4);
                $tax        = $this->sls->formatDecimal($tax_details->rate, 0) . '%';
            } else {
                $tax_amount = $this->sls->formatDecimal((($value) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                $tax        = $this->sls->formatDecimal($tax_details->rate, 0) . '%';
            }
        } elseif ($tax_details && $tax_details->type == 2) {
            $tax_amount = $this->sls->formatDecimal($tax_details->rate);
            $tax        = $this->sls->formatDecimal($tax_details->rate, 0);
        }
        return ['id' => $tax_details ? $tax_details->id : null, 'tax' => $tax, 'amount' => $tax_amount];
    }
    /**-------------------------------------------------------------------------
     * After a Sale decrease product quantity, warehouse product quantity, product variant quantity and warehouse product variant quantity
     * 
     * After a Purchase increase product quantity, warehouse product quantity, product variant quantity and warehouse product variant quantity
     * -------------------------------------------------------------------------
     */
    public function syncQuantity($sale_id = null, $purchase_id = null, $oitems = null, $product_id = null)
    {
        if ($sale_id) {
            $sale_items = $this->getAllSaleItems($sale_id);
            foreach ($sale_items as $item) {
                if ($item->product_type == 'standard') {
                    $this->syncProductQtySale($item->product_id, $item->warehouse_id, $item->quantity);
                    if (isset($item->option_id) && !empty($item->option_id)) {
                        $this->syncVariantQtySale($item->option_id, $item->warehouse_id, $item->product_id, $item->quantity);
                    }
                } elseif ($item->product_type == 'combo') {
                    $wh          = $this->Settings->overselling ? null : $item->warehouse_id;
                    $combo_items = $this->getProductComboItems($item->product_id, $wh);
                    foreach ($combo_items as $combo_item) {
                        if ($combo_item->type == 'standard') {
                            $this->syncProductQtySale($combo_item->id, $item->warehouse_id);
                        }
                    }
                }
            }
        } elseif ($purchase_id) {
            $purchase_items = $this->getAllPurchaseItems($purchase_id);
            foreach ($purchase_items as $item) {
                $this->syncProductQtyPurchase($item->product_id, $item->warehouse_id);
                $this->checkOverSold($item->product_id, $item->warehouse_id);
                if (isset($item->option_id) && !empty($item->option_id)) {
                    $this->syncVariantQtyPurchase($item->option_id, $item->warehouse_id, $item->product_id);
                    $this->checkOverSold($item->product_id, $item->warehouse_id, $item->option_id);
                }
            }
        } elseif ($oitems) {
            foreach ($oitems as $item) {
                if (isset($item->product_type)) {
                    if ($item->product_type == 'standard') {
                        $this->syncProductQty($item->product_id, $item->warehouse_id);
                        if (isset($item->option_id) && !empty($item->option_id)) {
                            $this->syncVariantQty($item->option_id, $item->warehouse_id, $item->product_id);
                        }
                    } elseif ($item->product_type == 'combo') {
                        $combo_items = $this->getProductComboItems($item->product_id, $item->warehouse_id);
                        foreach ($combo_items as $combo_item) {
                            if ($combo_item->type == 'standard') {
                                $this->syncProductQty($combo_item->id, $item->warehouse_id);
                            }
                        }
                    }
                } else {
                    $this->syncProductQty($item->product_id, $item->warehouse_id);
                    if (isset($item->option_id) && !empty($item->option_id)) {
                        $this->syncVariantQty($item->option_id, $item->warehouse_id, $item->product_id);
                    }
                }
            }
        } elseif ($product_id) {
            $warehouses = $this->getAllWarehouses();
            foreach ($warehouses as $warehouse) {
                $this->syncProductQty($product_id, $warehouse->id);
                $this->checkOverSold($product_id, $warehouse->id);
                $quantity           = 0;
                $warehouse_products = $this->getWarehouseProducts($product_id);
                foreach ($warehouse_products as $product) {
                    $quantity += $product->quantity;
                }
                $this->db->update('products', ['quantity' => $quantity], ['id' => $product_id]);
                if ($product_variants = $this->getProductVariants($product_id)) {
                    foreach ($product_variants as $pv) {
                        $this->syncVariantQty($pv->id, $warehouse->id, $product_id);
                        $this->checkOverSold($product_id, $warehouse->id, $pv->id);
                        $quantity           = 0;
                        $warehouse_variants = $this->getWarehouseProductsVariants($pv->id);
                        foreach ($warehouse_variants as $variant) {
                            $quantity += $variant->quantity;
                        }
                        $this->db->update('product_variants', ['quantity' => $quantity], ['id' => $pv->id]);
                    }
                }
            }
        }
    }
    public function syncSalePayments($id)
    {
        $sale = $this->getSaleByID($id);
        if ($payments = $this->getSalePayments($id)) {
            $paid        = 0;
            $grand_total = $sale->grand_total + $sale->rounding;
            foreach ($payments as $payment) {
                $paid += $payment->amount;
            }

            $payment_status = $paid == 0 ? 'pending' : $sale->payment_status;
            if ($this->sls->formatDecimal($grand_total) == 0 || $this->sls->formatDecimal($grand_total) <= $this->sls->formatDecimal($paid)) {
                $payment_status = 'paid';
            } elseif ($sale->due_date <= date('Y-m-d') && !$sale->sale_id) {
                $payment_status = 'due';
            } elseif ($paid != 0) {
                $payment_status = 'partial';
            }

            if ($this->db->update('sales', ['paid' => $paid, 'payment_status' => $payment_status], ['id' => $id])) {
                return true;
            }
        } else {
            $payment_status = ($sale->due_date <= date('Y-m-d')) ? 'due' : 'pending';
            if ($this->db->update('sales', ['paid' => 0, 'payment_status' => $payment_status], ['id' => $id])) {
                return true;
            }
        }

        return false;
    }
    public function getSaleByID($id)
    {
        $q = $this->db->get_where('sales', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getSalePayments($sale_id)
    {
        $q = $this->db->get_where('payments', ['sale_id' => $sale_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    

    public function getAllSaleItems($sale_id)
    {
        $q = $this->db->get_where('sale_items', ['sale_id' => $sale_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductComboItems($pid, $warehouse_id = null)
    {
        $this->db->select('products.id as id, combo_items.item_code as code, combo_items.quantity as qty, products.name as name, products.type as type, combo_items.unit_price as unit_price, warehouses_products.quantity as quantity')
            ->join('products', 'products.code=combo_items.item_code', 'left')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by('combo_items.id');
        if ($warehouse_id) {
            $this->db->where('warehouses_products.warehouse_id', $warehouse_id);
        }
        $q = $this->db->get_where('combo_items', ['combo_items.product_id' => $pid]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return false;
    }
    /**-------------------------------------------------------------
     * After a sale decreasev product and warehouse product quantity
     * -------------------------------------------------------------
     */
    public function syncProductQtySale($product_id, $warehouse_id, $item_quantity='')
    {
        
        /*___ decrease product quantity ___*/
        $product_qty = $this->db->get_where('products', ['id' => $product_id])->row()->quantity;
        $new_product_qty = ($product_qty - $item_quantity);

        if ($this->db->update('products', ['quantity' => $new_product_qty], ['id' => $product_id])) {
            /*___ decrease warehouse product quantity ___*/
            $wh_balance_qty = $this->db->get_where('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $warehouse_id])->row()->quantity;
            $new_wh_balance_qty = ($wh_balance_qty - $item_quantity);
            if ($this->getWarehouseProducts($product_id, $warehouse_id)) {
                $this->db->update('warehouses_products', ['quantity' => $new_wh_balance_qty], ['product_id' => $product_id, 'warehouse_id' => $warehouse_id]);
            } 
            return true;
        }
        return false;
    }
    public function syncProductQtyPurchase($product_id, $warehouse_id, $item_quantity='')
    {
        /*___ increase product quantity ___*/
        $product_qty = $this->db->get_where('products', ['id' => $product_id])->row()->quantity;
        $new_product_qty = ($product_qty + $item_quantity);

        if ($this->db->update('products', ['quantity' => $new_product_qty], ['id' => $product_id])) {
            /*___ increase warehouse product quantity ___*/
            $wh_balance_qty = $this->db->get_where('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $warehouse_id])->row()->quantity;
            $new_wh_balance_qty = ($wh_balance_qty + $item_quantity);
            if ($this->getWarehouseProducts($product_id, $warehouse_id)) {
                $this->db->update('warehouses_products', ['quantity' => $new_wh_balance_qty], ['product_id' => $product_id, 'warehouse_id' => $warehouse_id]);
            } 
            return true;
        }
        return false;
    }
    private function getBalanceQuantity($product_id, $warehouse_id = null)
    {
        $this->db->select('SUM(COALESCE(quantity_balance, 0)) as stock', false);
        $this->db->where('product_id', $product_id)->where('quantity_balance !=', 0);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $this->db->group_start()->where('status', 'received')->or_where('status', 'partial')->group_end();
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    public function getProductByID($id)
    {
        $q = $this->db->get_where('products', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getBalanceQuantityxxx($product_id, $warehouse_id = null)
    {
        $this->db->select('SUM(COALESCE(quantity_balance, 0)) as stock', false);
        $this->db->where('product_id', $product_id)->where('quantity_balance !=', 0);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $this->db->group_start()->where('status', 'received')->or_where('status', 'partial')->group_end();
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }

    public function checkOverSold($product_id, $warehouse_id, $option_id = null)
    {
        $clause = ['purchase_id' => null, 'transfer_id' => null, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'option_id' => $option_id];
        if ($os = $this->getPurchasedItem($clause)) {
            if ($os->quantity_balance < 0) {
                if ($pis = $this->getPurchasedItems($product_id, $warehouse_id, $option_id, true)) {
                    $quantity = $os->quantity_balance;
                    foreach ($pis as $pi) {
                        if ($pi->quantity_balance >= (0 - $quantity) && $quantity != 0) {
                            $balance = $pi->quantity_balance + $quantity;
                            $this->db->update('purchase_items', ['quantity_balance' => $balance], ['id' => $pi->id]);
                            $quantity = 0;
                            break;
                        } elseif ($quantity != 0) {
                            $quantity = $quantity + $pi->quantity_balance;
                            $this->db->update('purchase_items', ['quantity_balance' => 0], ['id' => $pi->id]);
                        }
                    }
                    $this->db->update('purchase_items', ['quantity_balance' => $quantity], ['id' => $os->id]);
                }
            }
        }
    }

    public function syncVariantQtySale($variant_id, $warehouse_id, $product_id = null, $item_quantity='')
    {
        /*___ decrease product variant quantity___*/
        $product_variant_qty = $this->db->get_where('product_variants', ['id' => $variant_id, 'product_id' => $product_id])->row()->quantity;
        $new_product_variant_qty = ($product_variant_qty - $item_quantity);

        if ($this->db->update('product_variants', ['quantity' => $new_product_variant_qty], ['id' => $variant_id])) {
            /*___ decrease warehouse product variant quantity______*/
            if ($this->getWarehouseProductsVariants($variant_id, $warehouse_id)) {
                $wh_prod_var_qty = $this->db->get_where('warehouses_products_variants', ['option_id' => $variant_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id])->row()->quantity;
                $new_wh_prod_var_qty = ($wh_prod_var_qty - $item_quantity);
                $this->db->update('warehouses_products_variants', ['quantity' => $new_wh_prod_var_qty], ['option_id' => $variant_id, 'warehouse_id' => $warehouse_id]);
            } 
            return true;
        }
        return false;
    }

    public function syncVariantQtyPurchase($variant_id, $warehouse_id, $product_id = null, $item_quantity='')
    {
        /*___ increase product variant quantity___*/
        $product_variant_qty = $this->db->get_where('product_variants', ['id' => $variant_id, 'product_id' => $product_id])->row()->quantity;
        $new_product_variant_qty = ($product_variant_qty + $item_quantity);
        
        if ($this->db->update('product_variants', ['quantity' => $new_product_variant_qty], ['id' => $variant_id])) {
            /*___ increase warehouse product variant quantity______*/
            if ($this->getWarehouseProductsVariants($variant_id, $warehouse_id)) {
                $wh_prod_var_qty = $this->db->get_where('warehouses_products_variants', ['option_id' => $variant_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id])->row()->quantity;
                $new_wh_prod_var_qty = ($wh_prod_var_qty + $item_quantity);
                $this->db->update('warehouses_products_variants', ['quantity' => $new_wh_prod_var_qty], ['option_id' => $variant_id, 'warehouse_id' => $warehouse_id]);
            } 
            return true;
        }
        return false;
    }

    public function getPurchasedItem($clause)
    {
        $orderby = empty($this->Settings->accounting_method) ? 'asc' : 'desc';
        $this->db->order_by('date', $orderby);
        $this->db->order_by('purchase_id', $orderby);
        if (!isset($clause['option_id']) || empty($clause['option_id'])) {
            $this->db->group_start()->where('option_id', null)->or_where('option_id', 0)->group_end();
        }
        $q = $this->db->get_where('purchase_items', $clause);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getBalanceVariantQuantity($variant_id, $warehouse_id = null)
    {
        $this->db->select('SUM(COALESCE(quantity_balance, 0)) as stock', false);
        $this->db->where('option_id', $variant_id)->where('quantity_balance !=', 0);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $this->db->group_start()->where('status', 'received')->or_where('status', 'partial')->group_end();
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }

    public function getWarehouseProducts($product_id, $warehouse_id = null)
    {
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get_where('warehouses_products', ['product_id' => $product_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getWarehouseProductsVariants($option_id, $warehouse_id = null)
    {
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get_where('warehouses_products_variants', ['option_id' => $option_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductVariants($product_id)
    {
        $q = $this->db->get_where('product_variants', ['product_id' => $product_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getUnitByID($id)
    {
        $q = $this->db->get_where('units', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getUnits()
    {
        $q = $this->db->get('units');
        if ($q->num_rows() > 0) {
           
            return $q->result();
        }
        return false;
    }
    public function getBrandByID($id)
    {
        $q = $this->db->get_where('brands', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getSupplierByID($id)
    {
        $q = $this->db->get_where('suppliers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getCategoryByID($id)
    {
        $q = $this->db->get_where('categories', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getAllCategories()
    {
        //$this->db->where('parent_id', null)->or_where('parent_id', 0)->order_by('name');
        $this->db
        ->group_start()
            ->where('parent_id', null)
            ->or_where('parent_id', 0)
        ->group_end()
        ->where('hide_status', 0)
        ->order_by('code');
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllCurrencies()
    {
        $q = $this->db->get('currencies');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getPurchasedItems($product_id, $warehouse_id, $option_id = null, $nonPurchased = false)
    {
        // $orderby = empty($this->Settings->accounting_method) ? 'asc' : 'desc';
        $this->db->select('id, purchase_id, transfer_id, quantity, quantity_balance, net_unit_cost, unit_cost, item_tax, base_unit_cost');
        $this->db->where('product_id', $product_id)->where('warehouse_id', $warehouse_id)->where('quantity_balance !=', 0);
        if (!isset($option_id) || empty($option_id)) {
            $this->db->group_start()->where('option_id', null)->or_where('option_id', 0)->group_end();
        } else {
            $this->db->where('option_id', $option_id);
        }
        if ($nonPurchased) {
            $this->db->group_start()->where('purchase_id !=', null)->or_where('transfer_id !=', null)->group_end();
        }
        $this->db->group_start()->where('status', 'received')->or_where('status', 'partial')->group_end();
        $this->db->group_by('id');
        $this->db->order_by('date', $orderby);
        $this->db->order_by('purchase_id', $orderby);
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllCustomers()
    {
        $q = $this->db->get('customers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getCustomerByID($id = null)
	{
		return $this->db->select('*')
			->from('customers')
			->where('id', $id)
			->get()
			->row();
	}
    public function getBillerByID($id = null)
	{
		return $this->db->select('*')
			->from('billers')
			->where('id', $id)
			->get()
			->row();
	}

    public function getAllTaxRates()
    {
        $q = $this->db->get('tax_rates');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getWarehouseByID($id)
    {
        $q = $this->db->get_where('warehouses', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getAllBillers()
    {
        $q = $this->db->get_where('billers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function calculateDiscount($discount = null, $amount = 0, $order = null)
    {
        if ($discount && ($order || $this->Settings->product_discount)) {
            $dpos = strpos($discount, '%');
            if ($dpos !== false) {
                $pds = explode('%', $discount);
                return $this->sls->formatDecimal(((($this->sls->formatDecimal($amount)) * (float) ($pds[0])) / 100), 4);
            }
            return $this->sls->formatDecimal($discount, 4);
        }
        return 0;
    }
    public function calculateOrderTax($order_tax_id = null, $amount = 0)
    {
        if ($this->Settings->tax2 != 0 && $order_tax_id) {
            if ($order_tax_details = $this->getTaxRateByID($order_tax_id)) {
                if ($order_tax_details->type == 1) {
                    return $this->sls->formatDecimal((($amount * $order_tax_details->rate) / 100), 4);
                }
                return $this->sls->formatDecimal($order_tax_details->rate, 4);
            }
        }
        return 0;
    }
    public function getReference($field)
    {
        $q = $this->db->get_where('order_ref', ['ref_id' => 1], 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            switch ($field) {
                case 'so':
                    $prefix = $this->Settings->sales_prefix;
                    break;
                case 'pos':
                    $prefix = isset($this->Settings->sales_prefix) ? $this->Settings->sales_prefix . '/POS' : '';
                    break;
                case 'po':
                    $prefix = $this->Settings->purchase_prefix;
                    break;
                case 'pay':
                    $prefix = $this->Settings->payment_prefix;
                    break;
                default:
                    $prefix = '';
            }

            $ref_no = $prefix;

            if ($this->Settings->reference_format == 1) {
                $ref_no .= date('Y') . '/' . sprintf('%04s', $ref->{$field});
            } elseif ($this->Settings->reference_format == 2) {
                $ref_no .= date('Y') . '/' . date('m') . '/' . sprintf('%04s', $ref->{$field});
            } elseif ($this->Settings->reference_format == 3) {
                $ref_no .= sprintf('%04s', $ref->{$field});
            } else {
                $ref_no .= $this->getRandomReference();
            }
// print_r($ref_no); die;
            return $ref_no;
        }
        return false;
    }
    public function getRandomReference($len = 12)
    {
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= mt_rand(0, 9);
        }

        if ($this->getSaleByReference($result)) {
            $this->getRandomReference();
        }

        return $result;
    }
    public function updateReference($field)
    {
        $q = $this->db->get_where('order_ref', ['ref_id' => 1], 1);
        if ($q->num_rows() > 0) {
            $ref = $q->row();
            $this->db->update('order_ref', [$field => $ref->{$field} + 1], ['ref_id' => 1]);
            return true;
        }
        return false;
    }
    public function getSaleByReference($ref)
    {
        $this->db->like('reference_no', $ref, 'both');
        $q = $this->db->get('sales', 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function singleUser($id = null)
    {
        return $this->db->select("
                users.*,users.logo as image
            ")
            ->from('users')
            ->where('users.id', $id)
            ->get()
            ->row();
    }

}