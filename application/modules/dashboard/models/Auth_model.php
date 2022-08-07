<?php defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------    
    
    #------------------------------------    

class Auth_model extends CI_Model {


	public function checkUser($data = array())
	{
		return $this->db->select("a.*,a.logo as image,CONCAT_WS(' ', a.first_name, a.last_name) AS fullname,IF (a.user_type=1, 'Admin', 'User') as user_level")
			->from('users a')
			->where('a.username', $data['email'])
			->where('a.password', md5('gef'.$data['password']))
            ->where('a.status',1)
			->get();
	}



}
 