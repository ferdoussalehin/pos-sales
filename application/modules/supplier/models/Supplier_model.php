<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

	public function create($data = array())
	{
		$this->db->insert('suppliers', $data);
        return true;
	}

	public function update($data = array())
	{
		$updatesupplier =  $this->db
							->where('id', $data["id"])
							->update("suppliers", $data);
							
    	return true;
	}

	public function delete($id = null) 
	{
		$delete_user = $this->db
							->where('id', $id)
							->delete('suppliers');
		return true;
	}
	
    public function singledata($id = null)
	{
		return $this->db->select('*')
			->from('suppliers')
			->where('id', $id)
			->get()
			->row();
	}

	public function getBillers($length, $start, $order=null, $q='')
    {
        $column = array('billers.id', 'billers.name', 'billers.company_name', 'billers.email', 'billers.address');
        $this->db
			->select("billers.*")
			->from('billers');
 
        if(!empty($q)) {
            $this->db
				->group_start()
				->like('billers.name',$q)
				->or_like('billers.email',$q)
				->or_like('billers.phone',$q)
				->group_end();
        }
        if(isset($order)) {
            $this->db->order_by($column[$order[0]['column']], $order[0]['dir']);
        }
        else {
            $this->db->order_by('billers.id', 'DESC');
        }            
        $records =  $this->db->limit($length, $start)
                    ->get()
                    ->result()
                    ;
                    
        return $records;
    }
	public function getBillersTotal()
    {
        return $this->db->select('COUNT(id) AS total_row')->get('billers')->row();
    }

	public function delete_biller($id = null) 
	{
		$delete_user = $this->db->where('id', $id)->delete('billers');
		return true;
	}

	public function create_biller($data = array())
	{
		$this->db->insert('billers', $data);
        return true;
	}
	
	public function billerById($id = null)
	{
		return $this->db->select('*')
			->from('billers')
			->where('id', $id)
			->get()
			->row();
	}
	public function update_biller($data = array())
	{
		$updatesupplier =  $this->db
							->where('id', $data["id"])
							->update("billers", $data);
							
    	return true;
	}

}