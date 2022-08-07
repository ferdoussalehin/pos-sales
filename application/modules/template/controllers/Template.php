<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#------------------------------------    
    
#------------------------------------    
//  define('UPDATE_INFO_URL','https://update.bdtask.com/saleserp/autoupdate/update_info');
class Template extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->db->query('SET SESSION sql_mode = ""');
		$this->load->model(array(
			'template_model'
		));
	}
 
	public function layout($data)
	{  
		$id = $this->session->userdata('id');
		$isAdmin = $this->session->userdata('isAdmin');
		$settingdata           = $this->template_model->get_setting();
		$data['Settings']       = $settingdata;
		$data['Setting']       = $settingdata;
		$pos_settings           = $this->template_model->getPosSetting();
		$data['pos_settings']       = $pos_settings;
		$data['Admin']       = $isAdmin;
		$data['discount_type'] = $settingdata->discount_type;
		$data['currency']      = $settingdata->currency;
        $data['position']      = $settingdata->currency_position;
        
		$this->load->view('layout', $data);
	}

	public function layout_pos($data)
	{  
		$id = $this->session->userdata('id');
		$isAdmin = $this->session->userdata('isAdmin');
		$settingdata           = $this->template_model->get_setting();
		$data['Settings']       = $settingdata;
		$pos_settings           = $this->template_model->getPosSetting();
		$data['pos_settings']       = $pos_settings;
		$data['Admin']       = $isAdmin;
		$data['discount_type'] = $settingdata->discount_type;
		$data['currency']      = $settingdata->currency;
        $data['position']      = $settingdata->currency_position;
        
		$this->load->view('layout_pos', $data);
	}
 
	public function login($data)
	{ 
		$data['setting'] = $this->template_model->get_setting();
		$data['Settings'] = $this->template_model->get_setting();
		$this->load->view('login', $data);
	}

	public function barcode($product_code = null, $bcs = 'code128', $height = 40, $text = true, $encoded = false)
    {
		$settingdata = $this->template_model->get_setting();
        $product_code = $encoded ? $this->sls->base64url_decode($product_code) : $product_code;
        if ($settingdata->barcode_img) {
            header('Content-Type: image/png');
        } else {
            header('Content-type: image/svg+xml');
        }
        echo $this->sls->barcode($product_code, $bcs, $height, $text, false, true);
    }
	  
 
}
