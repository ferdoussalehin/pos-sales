<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   

class Permission extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('permission_model');
      if (! $this->session->userdata('isLogIn'))
            redirect('login');
    
    }

public function role_list(){
    $data['title']      = display('role_list');
    $user_count         = $this->permission_model->user_count();
    $user_list          = $this->permission_model->user_list();
    $data['user_count'] = $user_count;
    $data['user_list']  = $user_list;
    $data['module']     = "dashboard";  
    $data['page']       = "role/role_view_form";  
    echo Modules::run('template/layout', $data); 
    }


}