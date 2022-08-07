<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    //-------------------------------
    // Author: Ai Softz
    //-------------------------------

class Auth extends MX_Controller {
 	
 	public function __construct()
 	{
        
 		parent::__construct();
 		$this->load->model(array(
 			'auth_model',
 		));

 	}

	public function index()
	{  
        
	if ($this->session->userdata('isLogIn'))
		redirect('dashboard');
    
		$data['title']    = lang('login'); 

		$this->form_validation->set_rules('email', lang('email'), 'required|valid_email|max_length[100]|trim');
		$this->form_validation->set_rules('password', lang('password'), 'required|max_length[32]|md5|trim');
		$error = '';
        
		$data['user'] = (object)$userData = array(
			'email' 	 => $this->input->post('email'),
			'password'   => $this->input->post('password'),
		);

		if ( $this->form_validation->run())  
		{
			 $user = $this->auth_model->checkUser($userData);

		     if($user->num_rows() > 0) {
             // session stored data          
             $sData = array(
					'isLogIn' 	  => true,
					'isAdmin' 	  => (($user->row()->user_type == 1)?true:false),
					'user_type'   => $user->row()->user_type,
					'id' 		  => $user->row()->id,
					'fullname'	  => $user->row()->fullname,
					'first_name'  => $user->row()->first_name,
					'last_name'   => $user->row()->last_name,
					'user_level'  => $user->row()->user_level,
					'email' 	  => $user->row()->username,
					'image' 	  => $user->row()->image,
					//'permission'  => json_encode($permission), 
					);	

					//store date to session 
					$this->session->set_userdata($sData);
					$this->session->set_flashdata('message', lang('welcome_back').' '.$user->row()->fullname);
                if($user->row()->user_type == 1){
					redirect('dashboard');
                }

			} else {

				$this->session->set_flashdata('exception', lang('wrong_username_or_password'));
				redirect('login');
			} 

		} else {

			echo Modules::run('template/login', $data);
		}
	}
  
	public function logout()
	{ 
		//destroy session
		$this->session->sess_destroy();
		redirect('login');
	}
  
}
