<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 	#------------------------------------    
    #------------------------------------    

class User extends MX_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model(array(
 			'user_model'  
 		));
 		// $this->load->library('MY_Form_validation');
		if (! $this->session->userdata('isAdmin'))
			redirect('login');
 	}
 
 	public function users() {
        $data['title']      = lang('user_list');
		$data['module'] 	= "dashboard";  
		$data['page']   	= "user/user_list";   

		echo Modules::run('template/layout', $data); 
    }

    public function get_all_users() {

    	$totalData = 0;
		$data = array();
		if(isset($_POST['search']['value'], $_POST['search']['value']) && ($_POST['search']['value'] != "" || $_POST['customf'] != ""))
		{
			$q = $_POST['search']['value'];
			$r = $_POST['customf'];

			$records = $this->db->select("a.*, CONCAT_WS(' ', a.first_name, a.last_name) AS 				fullname,b.*,b.status as status,b.username as username")
					->from('users a')
					->join('user_login b','a.user_id = b.user_id')
					->group_start()
					->like('b.username',$q)
					->or_like('b.email',$q)
					->or_like('b.phone',$q)
					->group_end()
					->like('b.username',$r)
					
					->limit($_POST['length'], $_POST['start'])
					->order_by('b.username', 'asc')
					->group_by('a.user_id')
					->get()
					->result();

        	$totalData = sizeof($records); 


		}else{
			$records = $this->db->select("a.*, CONCAT_WS(' ', a.first_name, a.last_name) AS 				fullname,b.*,b.status as status,b.username as username")
					->from('users a')
					->join('user_login b','a.user_id = b.user_id')
					->limit($_POST['length'], $_POST['start'])
					->order_by('b.username', 'asc')
					->group_by('a.user_id')
					->get()
					->result();
			$all_users = $this->db->get('users')->result();
			$totalData = sizeof($all_users); 
		}
		$i = 0;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $key => $value) {
				$i++;
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = '<img src="' . (!empty($value->logo)?base_url().$value->logo:base_url('assets/img/icons/default.jpg')). '"' . 'alt="Image" height="50" >';
				$nestedData[] = $value->username;
				$nestedData[] = $value->email;
				$nestedData[] = $value->phone;
				$nestedData[] = $value->first_name. ' '. $value->last_name;

				$edit = anchor("edit_user/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
				$edit .= ' ' . anchor("dashboard/user/delete_user/".$value->user_id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i>',
                    array('class'=>'btn btn-danger btn-sm', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
				$nestedData[] = $edit;

				$data[] = $nestedData;
			}
		}

		$json_data = array(
		"draw" => intval($_POST['draw']),
		"recordsTotal" => intval($totalData),
		"recordsFiltered" => intval($totalData),
		"data" => $data
		);
		echo json_encode($json_data);

    } 

	public function create_user_form($id = null)
	{ 
		

		$data['title']    = lang('add_user');
		/*-----------------------------------*/
		$this->form_validation->set_rules('firstname', lang('first_name'),'required|max_length[50]');
		$this->form_validation->set_rules('lastname', lang('last_name'),'required|max_length[50]');
		$this->form_validation->set_rules('username', lang('username'),'required|max_length[32]|is_unique[users.username]');
		$this->form_validation->set_rules('email', lang('email'), "required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules('phone', 'Phone Number ', 'required|is_unique[users.phone]'); 
		$this->form_validation->set_rules('password', lang('password'),'required|max_length[32]|md5');
		$this->form_validation->set_rules('status', lang('status'),'required|max_length[1]');

        $image = $this->fileupload->do_upload(
			'./admin/assets/img/user/', 
			'image'

		);
        
		/*-----------------------------------*/
		$data['user'] = (object)$userData = array(
			'user_id'     => $id,
			'id'          => $id,  
			'first_name'  => $this->input->post('firstname'),
			'last_name'   => $this->input->post('lastname'),
			'username' 	  => $this->input->post('username'),
			'email' 	  => $this->input->post('email'),
			'phone' 	  => $this->input->post('phone_hidden'),
			'password' 	  => (!empty($this->input->post('password'))?md5('gef'.$this->input->post('password')):$this->input->post('oldpassword')),
			'image'   	  => (!empty($image)?$image:$this->input->post('old_image')),
			'status'      => $this->input->post('status'),
			'user_type'   => $this->input->post('user_type'),
		);

		/*-----------------------------------*/
		if ($this->form_validation->run()) {
			if (empty($id)) {
				if ($this->user_model->create($userData)) {
					$this->session->set_flashdata('message', lang('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}
				redirect("users");

			} else {
				if ($this->user_model->update($userData)) {
					$this->session->set_flashdata('message', lang('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}

				redirect("users");
			}


		} else {

			$data['module'] = "dashboard";  
			$data['page']   = "user/create_user_form"; 
			echo Modules::run('template/layout', $data);
		}

		// call back validate function
		

	
	
}

public function edit_user_form($id = null)
	{ 
	

		$data['title']    = lang('add_user');
		/*-----------------------------------*/
		//$this->form_validation->set_rules('firstname', lang('first_name'),'required|max_length[50]');
		//$this->form_validation->set_rules('lastname', lang('last_name'),'required|max_length[50]');
		// $this->form_validation->set_rules('username', lang('username'),'callback_username_check');
		//$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		//$this->form_validation->set_rules('phone', 'Phone Number ', 'required|is_unique[user_login.phone]'); //{10} for 10 digits number
// print_r($id); exit();
		#------------------------#
		$users = $this->db->get_where('user_login', array('id' => $id))->row(); 
		$original_username = !empty($users) ? $users->username : ''; 
		$original_phone = !empty($users) ? $users->phone : ''; 
		if($this->input->post('username') != $original_username) {
		   $is_unique_username =  '|is_unique[user_login.username]';
		} else {
		   $is_unique_username =  '';
		}
		if($this->input->post('phone') != $original_phone) {
		   $is_unique_phone =  '|is_unique[user_login.phone]';
		} else {
		   $is_unique_phone =  '';
		}
		$this->form_validation->set_rules('username', 'User Name', 'required'.$is_unique_username);
		$this->form_validation->set_rules('phone', 'Phone Number', 'required'.$is_unique_phone);
		// if (!empty($id)) {   
       	
  //      	$this->form_validation->set_rules('email','Email','required|valid_email|edit_unique[user_login.email.'.$id.']');
  //      		---#callback fn not supported#---  
		// } else {
		// 	$this->form_validation->set_rules('email', lang('email'), "required|valid_email|is_unique[user_login.email]");
		// }
		#------------------------#
		//if(empty($id)){
		//$this->form_validation->set_rules('password', lang('password'),'required|max_length[32]|md5');
		//}

		//$this->form_validation->set_rules('status', lang('status'),'required|max_length[1]');

        $image = $this->fileupload->do_upload(
			'./admin/assets/img/user/', 
			'image'

		);
        
		/*-----------------------------------*/
		$data['user'] = (object)$userData = array(
			'user_id'     => $id,
			'id'          => $id,  
			'first_name'  => $this->input->post('firstname'),
			'last_name'   => $this->input->post('lastname'),
			'username' 	  => $this->input->post('username'),
			'email' 	  => $this->input->post('email'),
			'phone' 	  => $this->input->post('phone_hidden'),
			'password' 	  => (!empty($this->input->post('password'))?md5('gef'.$this->input->post('password')):$this->input->post('oldpassword')),
			'image'   	  => (!empty($image)?$image:$this->input->post('old_image')),
			'status'      => $this->input->post('status'),
			'user_type'   => $this->input->post('user_type'),
		);
 // echo "<pre>";print_r($data);exit();
		/*-----------------------------------*/
		if ($this->form_validation->run()) {
			if (empty($id)) {
				if ($this->user_model->create($userData)) {
					$this->session->set_flashdata('message', lang('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}
				redirect("users");

			} else {
				if ($this->user_model->update($userData)) {
					$this->session->set_flashdata('message', lang('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}

				redirect("users");
			}


		} else {

			$data['module'] = "dashboard";  
			$data['page']   = "user/edit_user_form"; 
			if(!empty($id)){
			$data['title']  = lang('edit_user');
			$data['user']   = $this->user_model->single($id);
			}

			
			echo Modules::run('template/layout', $data);
		}

		// call back validate function
		

	
	
}



function check_user_email($email) {        
    if($this->input->post('id'))
        $id = $this->input->post('id');
    else
        $id = '';
    $result = $this->user_model->check_unique_user_email($id, $email);
    if($result == 0)
        $response = true;
    else {
        $this->form_validation->set_message('check_user_email', 'Email must be unique');
        $response = false;
    }
    return $response;
}

public function username_check($str)
        {
                if ($str == 'test')
                {
                        $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

public function checkUserName($userName){
// print_r($userName);exit();
		  if ($this->checkUserexist($userName) == true) {
		    
		    $this->form_validation->set_message('checkUserName', 'This userName already exist!');
		    return false;
		   
		  } else {
		  	
		    return true;
		}
		}  
	public function checkUserexist($userName) {
			  $this->db->where('username', $userName);
			  $this->db->from('user_login');
			  $query = $this->db->get();
			  // print_r($query->num_rows());exit();
			  if ($query->num_rows() > 0) {
			    return true;
			  }
			  return false; 
		  }

	public function delete_user($id = null) {
        if ($this->user_model->delete($id)) {
      $this->session->set_flashdata('message', lang('delete_successfully'));
        } else {
       $this->session->set_flashdata('exception', lang('please_try_again'));
        }

        redirect("users");
    }

   
}
