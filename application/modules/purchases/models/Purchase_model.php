<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getPurchases($length, $start, $order, $q=null)
    {
        $column = ['purchases.id', 'purchases.date', 'purchases.reference_no', 'purchases.supplier', 'purchases.grand_total', 'purchases.paid' ];

        $this->db
                ->select('purchases.id, purchases.date, purchases.reference_no, purchases.supplier, purchases.grand_total, purchases.paid, purchases.status, purchases.payment_status')
                ->from('purchases');

        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('purchases.id', $q)
                ->or_like('purchases.date', $q)
                ->or_like('purchases.reference_no', $q)
                ->or_like('purchases.supplier', $q)
                ->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('id', 'desc');
        }

        $results = $this->db
                        ->limit($length, $start)
                        ->get()->
                        result();
        
        return $results;
    }

    public function getPurchasesTotal($q=null)
    {
        $this->db->select('COUNT(id) AS total_sale')->from('purchases');

        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('purchases.id', $q)
                ->or_like('purchases.date', $q)
                ->or_like('purchases.reference_no', $q)
                ->or_like('purchases.supplier', $q)
                ->group_end();
        }

        return $this->db->get()->row();
    }

    public function getPurchaseByID($id=null)
    {
        $q = $this->db->get_where('purchases', ['id' => $id], 1);
        if($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function xxgetAllPurchaseItems($id=null)
    {
        $this->db
                ->select('purchase_items.*, products.second_name, products.unit, product_variants.name as variant_name')
                ->from('purchase_items')
                ->join('products', 'products.id = purchase_items.product_id', 'left')
                ->join('product_variants', 'prodcut_variants.id = purchase_items.option_id', 'left')
                ->group_by('purchase_items.id')
                ;
        $q = $this->db->get_where('purchase_items', ['purchase_id' => $id]);
        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function getAllPurchaseItems($purchase_id)
    {
        $this->db->select('purchase_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.unit, products.details as details, product_variants.name as variant, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('products', 'products.id=purchase_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id=purchase_items.option_id', 'left')
            ->join('tax_rates', 'tax_rates.id=purchase_items.tax_rate_id', 'left')
            ->group_by('purchase_items.id')
            ->order_by('id', 'asc');
        $q = $this->db->get_where('purchase_items', ['purchase_id' => $purchase_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

}