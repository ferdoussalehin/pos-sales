<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

	public function create($data = array())
	{
		// print_r($data); exit();
		$this->db->insert('customers', $data);
        return true;
	}

	public function update($data = array())
	{

		$updatecustomer =  $this->db
							->where('id', $data["id"])
							->update("customers", $data);
    	return true;
	}

	public function delete($id = null) 
	{
		$delete_user = $this->db
							->where('id', $id)
							->delete('customers');
		return true;
	}

	public function customer_list($offset=null, $limit=null)
    {
  

        return $result = $this->db->select('customers.*')
			->from('customers a')
			->order_by('customers.name', 'asc')
			->limit($offset, $limit)
			->get()
			->result();

         
    }
    public function singledata($id = null)
	{
		return $this->db->select('*')
			->from('customers')
			->where('id', $id)
			->get()
			->row();
	}

}