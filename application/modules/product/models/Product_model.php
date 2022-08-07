<?php

 defined('BASEPATH') OR exit('No direct script access allowed');

 class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    
    public function create($data = array())
	{
		// print_r($data); exit();
		$this->db->insert('products', $data);
        return true;
	}

    public function deleteProduct($id)
    {
        // $this->site->log('Product', ['model' => $this->getProductByID($id)]);
        if ($this->db->delete('products', ['id' => $id]) && $this->db->delete('warehouses_products', ['product_id' => $id])) {
            $this->db->delete('warehouses_products_variants', ['product_id' => $id]);
            $this->db->delete('product_variants', ['product_id' => $id]);
            // $this->db->delete('product_photos', ['product_id' => $id]);
            // $this->db->delete('product_prices', ['product_id' => $id]);
            return true;
        }
        return false;
    }

    public function add_product($data, $product_attributes, $items)
    {

        if ($this->db->insert('products', $data)) {
            $product_id = $this->db->insert_id();

            if ($items) {
                foreach ($items as $item) {
                    $item['product_id'] = $product_id;
                    $this->db->insert('combo_items', $item);
                }
            }

            $warehouses = $this->app_model->getAllWarehouses();
            foreach ($warehouses as $warehouse) {
                $this->db->insert('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $warehouse->id, 'quantity' => 0, 'avg_cost' => $data['cost']]);
            }
            // $this->db->insert('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $wh_qty['warehouse_id'], 'quantity' => $wh_qty['quantity'], 'rack' => $wh_qty['rack'], 'avg_cost' => $data['cost']]);

            $tax_rate = $this->app_model->getTaxRateByID($data['tax_rate']);

            if ($product_attributes) {
                // echo 'warehouse_qty'; die;
                foreach ($product_attributes as $pr_attr) {
                    $pr_attr_details = $this->getPrductVariantByPIDandName($product_id, $pr_attr['name']);

                    $pr_attr['product_id'] = $product_id;
                    $variant_warehouse_id  = $pr_attr['warehouse_id'];
                    unset($pr_attr['warehouse_id']);
                    if ($pr_attr_details) {
                        $option_id = $pr_attr_details->id;
                    } else {
                        $this->db->insert('product_variants', $pr_attr);
                        $option_id = $this->db->insert_id();
                    }
                    
                    if ($pr_attr['quantity'] != 0) {
                        // echo $pr_attr['quantity']; die;
                        $this->db->insert('warehouses_products_variants', ['option_id' => $option_id, 'product_id' => $product_id, 'warehouse_id' => $variant_warehouse_id, 'quantity' => $pr_attr['quantity']]);

                        $tax_rate_id = $tax_rate ? $tax_rate->id : null;
                        $tax         = $tax_rate ? (($tax_rate->type == 1) ? $tax_rate->rate . '%' : $tax_rate->rate) : null;
                        $unit_cost   = $data['cost'];
                        if ($tax_rate) {
                            if ($tax_rate->type == 1 && $tax_rate->rate != 0) {
                                if ($data['tax_method'] == '0') {
                                    $pr_tax_val    = ($data['cost'] * $tax_rate->rate) / (100 + $tax_rate->rate);
                                    $net_item_cost = $data['cost'] - $pr_tax_val;
                                    $item_tax      = $pr_tax_val * $pr_attr['quantity'];
                                } else {
                                    $net_item_cost = $data['cost'];
                                    $pr_tax_val    = ($data['cost'] * $tax_rate->rate) / 100;
                                    $unit_cost     = $data['cost'] + $pr_tax_val;
                                    $item_tax      = $pr_tax_val * $pr_attr['quantity'];
                                }
                            } else {
                                $net_item_cost = $data['cost'];
                                $item_tax      = $tax_rate->rate;
                            }
                        } else {
                            $net_item_cost = $data['cost'];
                            $item_tax      = 0;
                        }

                        $subtotal = (($net_item_cost * $pr_attr['quantity']) + $item_tax);
                        $item     = [
                            'product_id'        => $product_id,
                            'product_code'      => $data['code'],
                            'product_name'      => $data['name'],
                            'net_unit_cost'     => $net_item_cost,
                            'unit_cost'         => $unit_cost,
                            'quantity'          => $pr_attr['quantity'],
                            'option_id'         => $option_id,
                            'quantity_balance'  => $pr_attr['quantity'],
                            'quantity_received' => $pr_attr['quantity'],
                            'item_tax'          => $item_tax,
                            'tax_rate_id'       => $tax_rate_id,
                            'tax'               => $tax,
                            'subtotal'          => $subtotal,
                            'warehouse_id'      => $variant_warehouse_id,
                            'date'              => date('Y-m-d'),
                            'status'            => 'received',
                        ];
                        $item['option_id'] = !empty($item['option_id']) && is_numeric($item['option_id']) ? $item['option_id'] : null;
                        $this->db->insert('purchase_items', $item);
                    }

                    foreach ($warehouses as $warehouse) {
                        if (!$this->getWarehouseProductVariant($warehouse->id, $product_id, $option_id)) {
                            $this->db->insert('warehouses_products_variants', ['option_id' => $option_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse->id, 'quantity' => 0]);
                        }
                    }

                    // $this->app_model->syncVariantQty($option_id, $variant_warehouse_id);
                }
            }
        // $this->app_model->syncQuantity(null, null, null, $product_id);    
        return true;

    }

    }

    public function getProductDetail($id)
    {
        $this->db->select($this->db->dbprefix('products') . '.*, ' . $this->db->dbprefix('tax_rates') . '.name as tax_rate_name, ' . $this->db->dbprefix('tax_rates') . '.code as tax_rate_code, c.code as category_code, sc.code as subcategory_code', false)
            ->join('tax_rates', 'tax_rates.id=products.tax_rate', 'left')
            ->join('categories c', 'c.id=products.category_id', 'left')
            ->join('categories sc', 'sc.id=products.subcategory_id', 'left');
        $q = $this->db->get_where('products', ['products.id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function updateProduct($id, $data, $product_attributes, $update_variants, $items)
    {

        if ($this->db->update('products', $data, ['id' => $id])) {
            
            if ($items) {
                $this->db->delete('combo_items', ['product_id' => $id]);
                foreach ($items as $item) {
                    $item['product_id'] = $id;
                    $this->db->insert('combo_items', $item);
                }
            }
            $warehouses = $this->app_model->getAllWarehouses();
            // foreach ($warehouses as $warehouse) {
            //     $this->db->insert('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $warehouse->id, 'quantity' => 0, 'avg_cost' => $data['cost']]);
            // }
            
            $tax_rate = $this->app_model->getTaxRateByID($data['tax_rate']);

            if (!empty($update_variants)) {
                foreach ($update_variants as $variant) {
                    $vr = $this->getProductVariantByName($id, $variant['name']);
                    if ($vr) {
                        $this->db->update('product_variants', $variant, ['id' => $vr->id]);
                    } else {
                        if ($variant['id']) {
                            $this->db->delete('product_variants', ['id' => $variant['id']]);
                        } else {
                            $this->db->insert('product_variants', $variant);
                        }
                    }
                }
            }

            if ($product_attributes) {
                foreach ($product_attributes as $pr_attr) {
                    $pr_attr['product_id'] = $id;
                    $variant_warehouse_id  = $pr_attr['warehouse_id'];
                    unset($pr_attr['warehouse_id']);
                    $this->db->insert('product_variants', $pr_attr);
                    $option_id = $this->db->insert_id();

                    if ($pr_attr['quantity'] != 0) {
                        // print_r($option_id); die;
                        $this->db->insert('warehouses_products_variants', ['option_id' => $option_id, 'product_id' => $id, 'warehouse_id' => $variant_warehouse_id, 'quantity' => $pr_attr['quantity']]);

                        $tax_rate_id = $tax_rate ? $tax_rate->id : null;
                        $tax         = $tax_rate ? (($tax_rate->type == 1) ? $tax_rate->rate . '%' : $tax_rate->rate) : null;
                        $unit_cost   = $data['cost'];
                        if ($tax_rate) {
                            if ($tax_rate->type == 1 && $tax_rate->rate != 0) {
                                if ($data['tax_method'] == '0') {
                                    $pr_tax_val    = ($data['cost'] * $tax_rate->rate) / (100 + $tax_rate->rate);
                                    $net_item_cost = $data['cost'] - $pr_tax_val;
                                    $item_tax      = $pr_tax_val * $pr_attr['quantity'];
                                } else {
                                    $net_item_cost = $data['cost'];
                                    $pr_tax_val    = ($data['cost'] * $tax_rate->rate) / 100;
                                    $unit_cost     = $data['cost'] + $pr_tax_val;
                                    $item_tax      = $pr_tax_val * $pr_attr['quantity'];
                                }
                            } else {
                                $net_item_cost = $data['cost'];
                                $item_tax      = $tax_rate->rate;
                            }
                        } else {
                            $net_item_cost = $data['cost'];
                            $item_tax      = 0;
                        }

                        $subtotal = (($net_item_cost * $pr_attr['quantity']) + $item_tax);
                        $item     = [
                            'product_id'        => $id,
                            'product_code'      => $data['code'],
                            'product_name'      => $data['name'],
                            'net_unit_cost'     => $net_item_cost,
                            'unit_cost'         => $unit_cost,
                            'quantity'          => $pr_attr['quantity'],
                            'option_id'         => $option_id,
                            'quantity_balance'  => $pr_attr['quantity'],
                            'quantity_received' => $pr_attr['quantity'],
                            'item_tax'          => $item_tax,
                            'tax_rate_id'       => $tax_rate_id,
                            'tax'               => $tax,
                            'subtotal'          => $subtotal,
                            'warehouse_id'      => $variant_warehouse_id,
                            'date'              => date('Y-m-d'),
                            'status'            => 'received',
                        ];
                        $item['option_id'] = !empty($item['option_id']) && is_numeric($item['option_id']) ? $item['option_id'] : null;
                        $this->db->insert('purchase_items', $item);
                    }
                }
            }
            foreach ($warehouses as $warehouse) {
                if (!$this->getWarehouseProductVariant($warehouse->id, $id, $option_id)) {
                    $this->db->insert('warehouses_products_variants', ['option_id' => $option_id, 'product_id' => $id, 'warehouse_id' => $warehouse->id, 'quantity' => 0]);
                }
            }

        return true;

    }

    }

    public function getProductComboItems($pid)
    {
        $this->db->select($this->db->dbprefix('products') . '.id as id, ' . $this->db->dbprefix('products') . '.code as code, ' . $this->db->dbprefix('combo_items') . '.quantity as qty, ' . $this->db->dbprefix('products') . '.name as name, ' . $this->db->dbprefix('combo_items') . '.unit_price as price')->join('products', 'products.code=combo_items.item_code', 'left')->group_by('combo_items.id');
        $q = $this->db->get_where('combo_items', ['product_id' => $pid]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return false;
    }

    public function getProductVariantByName($product_id, $name)
    {
        $q = $this->db->get_where('product_variants', ['product_id' => $product_id, 'name' => $name], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductByID($id)
    {
        $q = $this->db->get_where('products', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getWarehouseProductVariant($warehouse_id, $product_id, $option_id = null)
    {
        $q = $this->db->get_where('warehouses_products_variants', ['product_id' => $product_id, 'option_id' => $option_id, 'warehouse_id' => $warehouse_id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getPrductVariantByPIDandName($product_id, $name)
    {
        $q = $this->db->get_where('product_variants', ['product_id' => $product_id, 'name' => $name], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductOptionsWithWH($pid)
    {
        $this->db->select($this->db->dbprefix('product_variants') . '.*, ' . $this->db->dbprefix('warehouses') . '.name as wh_name, ' . $this->db->dbprefix('warehouses') . '.id as warehouse_id, ' . $this->db->dbprefix('warehouses_products_variants') . '.quantity as wh_qty')
            ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left')
            ->join('warehouses', 'warehouses.id=warehouses_products_variants.warehouse_id', 'left')
            ->group_by(['' . $this->db->dbprefix('product_variants') . '.id', '' . $this->db->dbprefix('warehouses_products_variants') . '.warehouse_id'])
            ->order_by('warehouses.id');
        $q = $this->db->get_where('product_variants', ['product_variants.product_id' => $pid, 'warehouses_products_variants.quantity !=' => null]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getProductQuantity($product_id, $warehouse)
    {
        $q = $this->db->get_where('warehouses_products', ['product_id' => $product_id, 'warehouse_id' => $warehouse], 1);
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    public function getProductOptions($pid)
    {
        $q = $this->db->get_where('product_variants', ['product_id' => $pid]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_products($length, $start, $order=null, $category_id='', $q='')
    {
        $column = array('products.id', 'products.code', 'products.name', 'products.name_alt', 'categories.name');
        $this->db
            ->select("products.*, categories.name as cat_name, units.name AS unit_name")
            ->from('products')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('units', 'units.id = products.unit', 'left');

        if($category_id) {
            $this->db->where('products.category_id', $category_id);
        }    
        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('products.name',$q)
                ->or_like('products.name_alt',$q)
                ->or_like('categories.name',$q)
                ->or_like('products.code',$q)
                ->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        }
        else {
            $this->db->order_by('products.id', 'DESC');
        }            
        $records =  $this->db->limit($length, $start)
                    ->get()
                    ->result()
                    ;
                    
        return $records;
    }

    public function get_products_pdf($category_id='')
    {
        
        $this->db
            ->select("products.*, categories.name as cat_name, units.name AS unit_name")
            ->from('products')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('units', 'units.id = products.unit', 'left');

        if($category_id) {
            $this->db->where('products.category_id', $category_id);
        }    
          
        $records =  $this->db
                    ->order_by('products.id', 'desc')
                    ->get()
                    ->result();
        return $records;
    }
    
    public function total_get_products($category_id='')
    {
        if($category_id) {
            $this->db->where('category_id', $category_id);
        } 
        $records = $this->db->get('products')->result();
        return $records;

    }

    public function get_all_products()
    {
        $q = $this->db->order_by('id', 'DESC')->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_all_products_export($category_id)
    {
        if($category_id) {
            $this->db->where('category_id', $category_id);
        }
        $q = $this->db->order_by('id', 'DESC')->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    

    public function hide_from_pos($id, $StatusNo)
    {
        $update = $this->db->set('hide_pos', $StatusNo)->where('id', $id)->update('products');
        if($update) {
            return true;
        } else {
            return false;
        }
    }

    public function get_all_categories()
    {
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_all_units()
    {
        $q = $this->db->get('units');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_all_brands()
    {
        $q = $this->db->get('brands');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_tax_rates()
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
    public function get_all_printers()
    {
        $q = $this->db->get('printers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_all_suppliers()
    {
        $q = $this->db->get('suppliers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllVariants()
    {
        $q = $this->db->get('variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
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
    public function checkSlug($slug, $type = null)
    {
        if (!$type) {
            return $this->db->get_where('products', ['slug' => $slug], 1)->row();
        } elseif ($type == 'category') {
            return $this->db->get_where('categories', ['slug' => $slug], 1)->row();
        } elseif ($type == 'brand') {
            return $this->db->get_where('brands', ['slug' => $slug], 1)->row();
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

    public function getProductNames($term, $limit = 5)
    {
        $this->db->select('' . $this->db->dbprefix('products') . '.id, code, ' . $this->db->dbprefix('products') . '.name as name, ' . $this->db->dbprefix('products') . '.price as price, ' . $this->db->dbprefix('product_variants') . '.name as vname')
            ->where("type != 'combo' AND "
                . '(' . $this->db->dbprefix('products') . ".name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR
                concat(" . $this->db->dbprefix('products') . ".name, ' (', code, ')') LIKE '%" . $term . "%')");
        $this->db->join('product_variants', 'product_variants.product_id=products.id', 'left')
            ->where('' . $this->db->dbprefix('product_variants') . '.name', null)
            ->group_by('products.id')->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllWarehousesWithPQ($product_id)
    {
        $this->db->select('' . $this->db->dbprefix('warehouses') . '.*, ' . $this->db->dbprefix('warehouses_products') . '.quantity, ' . $this->db->dbprefix('warehouses_products') . '.rack, ' . $this->db->dbprefix('warehouses_products') . '.avg_cost')
            ->join('warehouses_products', 'warehouses_products.warehouse_id=warehouses.id', 'left')
            ->where('warehouses_products.product_id', $product_id)
            ->group_by('warehouses.id');
        $q = $this->db->get('warehouses');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
 	
 }