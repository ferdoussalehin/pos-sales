<?php defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------    

 #------------------------------------    

class Template_model extends CI_Model {

	public function setting()
	{
		return $this->db->get('web_setting')->row();
	}

	public function getPosSetting()
    {
        $q = $this->db->get('pos_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
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
  


}
 