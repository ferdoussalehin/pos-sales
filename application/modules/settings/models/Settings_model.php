<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateSetting($data)
    {
        $this->db->where('setting_id', '1');
        if ($this->db->update('settings', $data)) {
            return true;
        }
        return false;
    }

    public function updatePosSetting($data)
    {
        $this->db->where('pos_id', '1');
        if ($this->db->update('pos_settings', $data)) {
            return true;
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
    public function getDateFormats()
    {
        $q = $this->db->get('date_format');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllBillers()
    {
        $q = $this->db->order_by('id', 'DESC')->get('billers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_units($length, $start, $order=null, $category_id='', $q='')
    {
        $column = array('units.code', 'units.name');
        $this->db
            ->select("units.*")
            ->from('units');

        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('units.code',$q)
                ->like('units.name',$q)
                ->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        }
        else {
            $this->db->order_by('units.id', 'DESC');
        }            
        $records =  $this->db->limit($length, $start)
                    ->get()
                    ->result()
                    ;
                    
        return $records;
    }

    public function total_get_units($category_id='')
    {
        $records = $this->db->get('units')->result();
        return $records;

    }

    public function add_unit($data = array())
	{
		$this->db->insert('units', $data);
        return true;
	}
    public function editUnit($id, $data = array())
	{
		$this->db->where('id', $id)->update('units', $data);
        return true;
	}
    public function delete_unit($id = null)
    {
        $this->db->where('id', $id)->delete('units');
        return true;
    }

    public function get_categories($length, $start, $order=null, $category_id='', $q='')
    {
        $column = array('categories.code', 'categories.name');
        $this->db
            ->select("categories.*")
            ->from('categories');

        if(!empty($q)) {
            $this->db
                ->group_start()
                ->like('categories.code',$q)
                ->like('categories.name',$q)
                ->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        }
        else {
            $this->db->order_by('categories.id', 'DESC');
        }            
        $records =  $this->db->limit($length, $start)
                    ->get()
                    ->result()
                    ;
                    
        return $records;
    }

    public function total_get_categories($category_id='')
    {
        $records = $this->db->get('categories')->result();
        return $records;

    }

}