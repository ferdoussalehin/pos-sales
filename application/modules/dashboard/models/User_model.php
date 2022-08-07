<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------    
    # Author: Bdtask Ltd
    # Author link: https://www.bdtask.com/
    # Dynamic style php file
    # Developed by :Isahaq
    #------------------------------------    

class User_model extends CI_Model {

	public function create($data = array())
	{
		// echo "<pre>";print_r($data); exit();
		$user_id = $this->generator(6);
        $userdata = array(
            'user_id'   => $user_id,
            'username'  => $data['username'],
            'phone'  => $data['phone'],
            'email'  => $data['email'],
            'password'  => $data['password'],
            'user_type' => $data['user_type'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'logo'       => $data['image'],
            'status'    => $data['status'],
        );
        $this->db->insert('users', $userdata);
        return true;
	}

    public function update($data = array())
    {

        $userdata = array(
            
            'username'  => $data['username'],
            'phone'  => $data['phone'],
            'email'  => $data['email'],
            'password'  => $data['password'],
            'user_type' => $data['user_type'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'logo'       => $data['image'],
            'status'    => $data['status'],
        );
// print_r($userdata);exit();
        $this->db->where('id', $data['id']);
        $this->db->update('users', $userdata);
        return true;
    }

    public function single($id = null)
    {
        return $this->db->select("
                users.*,users.logo as image
            ")
            ->from('users')
            ->where('users.id', $id)
            ->get()
            ->row();
    }

	public function generator($lenth) {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 9);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    public function delete($id = null)
    {
         $this->db->where('user_id', $id)
            ->delete("users");
        $this->db->where('user_id', $id)
            ->delete("user_login"); 
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


}
