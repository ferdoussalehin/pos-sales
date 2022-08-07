<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    //-------------------------------
    // Author: Ai Softz
    //-------------------------------    

class Dashboard extends MX_Controller {
 	
   	public function __construct()
   	{
   		parent::__construct();
   		$this->db->query('SET SESSION sql_mode = ""');
   		$this->load->model('dashboard_model'); 

  		if (! $this->session->userdata('isLogIn'))
  			redirect('login');
   	}
 
		function index()
    {

  		$data['module']      = "dashboard";
  		$data['page']        = "home/home";

  		echo Modules::run('template/layout', $data); 
	   }

}
