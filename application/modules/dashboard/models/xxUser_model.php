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
        $user_login = array(
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
        $this->db->insert('users', $user_login);
        return true;
	}

    public function update($data = array())
    {

        $userdata = array(
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'logo'       => $data['image'],
            'status'     => $data['status']
        );
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('users', $userdata);
        $user_login = array(
            'username' => $data['username'],
            'password' => $data['password'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'user_type'=> $data['user_type'],
            'status'   => $data['status'],
        );
        // echo "<pre>";print_r($userdata); print_r($user_login); exit();
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('user_login', $user_login);
        return true;
    }

	public function get_users_list()
	{
		return $this->db->select("a.*, CONCAT_WS(' ', a.first_name, a.last_name) AS fullname,b.*,b.status as status,b.username as username")
			->from('users a')
			->join('user_login b','a.user_id = b.user_id')
			->order_by('a.user_id', 'desc')
			->group_by('a.user_id')
			->get()
			->result();
	}

    public function single($id = null)
    {
        return $this->db->select("
                a.*,a.logo as image,b.*,b.status as status,b.username as username
            ")
            ->from('users a')
            ->join('user_login b','b.user_id = a.user_id')
            ->where('b.id', $id)
            //->order_by('a.user_id', 'desc')
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
