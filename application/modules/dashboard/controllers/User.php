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

			$records = $this->db->select("users.*, CONCAT_WS(' ', first_name, last_name) AS fullname")
					->from('users')
					->group_start()
					->like('users.username',$q)
					->or_like('users.email',$q)
					->or_like('users.phone',$q)
					->group_end()
					->limit($_POST['length'], $_POST['start'])
					->order_by('users.username', 'asc')
					->get()
					->result();	

        	$totalData = sizeof($records); 

		}else{
			$records = $this->db->select("users.*")
					->from('users')
					->limit($_POST['length'], $_POST['start'])
					->order_by('users.username', 'asc')
					->get()
					->result();
			$all_users = $this->db->get('users')->result();
			$totalData = sizeof($all_users); 

			// print_r($records); exit();
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

				$edit = anchor("user/view/".$value->id,
                    '<i class="fa fa-file-text" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-warning  btn-sm', 'title'=>'View'));
				$edit .= ' ' . anchor("edit_user/".$value->id,
                    ' <i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
				$edit .= ' ' . anchor("dashboard/user/delete_user/".$value->id,
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

	public function create_user_form()
	{ 
		

		$data['title']    = lang('add_user');
		/*-----------------------------------*/
		$this->form_validation->set_rules('firstname', lang('first_name'),'required|max_length[50]');
		$this->form_validation->set_rules('lastname', lang('last_name'),'required|max_length[50]');
		$this->form_validation->set_rules('username', lang('username'),'required|max_length[32]|is_unique[users.username]');
		$this->form_validation->set_rules('email', lang('email'), "required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules('phone_hidden', 'Phone Number ', 'required|is_unique[users.phone]'); 
		$this->form_validation->set_rules('password', 'Password','required|max_length[32]|md5');
		$this->form_validation->set_rules('status', lang('status'),'required|max_length[1]');

        $image = $this->fileupload->do_upload(
			'./assets/uploads/users/',
			'image'
		);
		$thumb_path = './assets/uploads/users/thumbs';
        // if image is uploaded then resize the image
		if ($image !== false && $image != null) {
			$this->fileupload->do_resize(
				$image, 
				210,
				48
			);
		}
		/*-----------------------------------*/
		$data['user'] = (object)$userData = array(

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

				if ($this->user_model->create($userData)) {
					$this->session->set_flashdata('message', lang('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}
				redirect("users");

		} else {

			$data['module'] = "dashboard";  
			$data['page']   = "user/create_user_form"; 
			echo Modules::run('template/layout', $data);
		}

	
}

	public function edit_user_form($id = null)
	{ 
	

		$data['title']    = lang('add_user');
		#------------------------#
		$this->form_validation->set_rules('firstname', lang('first_name'),'required|max_length[50]');
		$this->form_validation->set_rules('lastname', lang('last_name'),'required|max_length[50]');

		// Check whether username, phone or email is unique or not 
		$users = $this->db->get_where('users', array('id' => $id))->row(); 

		$original_username = !empty($users) ? $users->username : ''; 
		$original_email = !empty($users) ? $users->email : ''; 
		$original_phone = !empty($users) ? $users->phone : ''; 
	
		if($this->input->post('username') != $original_username) {
		   $is_unique_username =  '|is_unique[users.username]';
		} else {
		   $is_unique_username =  '';
		}
		if($this->input->post('phone_hidden') != $original_phone) {
		   $is_unique_phone =  '|is_unique[users.phone]';
		} else {
		   $is_unique_phone =  '';
		}
		if($this->input->post('email') != $original_email) {
		   $is_unique_email =  '|is_unique[users.email]';
		} else {
		   $is_unique_email =  '';
		}
		// .End Check

		$this->form_validation->set_rules('username', 'User Name', 'required'.$is_unique_username);
		$this->form_validation->set_rules('phone_hidden', 'Phone Number', 'required'.$is_unique_phone);
		$this->form_validation->set_rules('email', 'Email Number', 'required'.$is_unique_email);
		$this->form_validation->set_rules('status', lang('status'),'required|max_length[1]');

        $image = $this->fileupload->do_upload(
			'./assets/uploads/users/',
			'image'

		);
		$image_thumbs = $this->fileupload->do_upload(
			'./assets/uploads/users/thumbs/',
			'image'

		);

		if ($image_thumbs !== false && $image_thumbs != null) {
			$this->fileupload->do_resize(
				$image_thumbs, 
				210,
				200
			);
		}
        
		/*-----------------------------------*/
		$data['user'] = (object)$userData = array(
			
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
			
				if ($this->user_model->update($userData)) {
					$this->session->set_flashdata('message', lang('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', lang('please_try_again'));
				}

				redirect("users");

		} else {

			$data['module'] = "dashboard";  
			$data['page']   = "user/edit_user_form"; 
			$data['title']  = lang('edit_user');
			$data['user']   = $this->user_model->single($id);

			echo Modules::run('template/layout', $data);
		}

		// call back validate function
	
	}

	public function view($id = null)
	{ 

		$data['module'] = "dashboard";  
		$data['page']   = "user/view"; 
		$data['title']  = lang('view_user');
		$data['data']   = $this->user_model->single($id);

		echo Modules::run('template/layout', $data);

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
