<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    //-------------------------------
    // Author: Ai Softz
    //-------------------------------    

class Settings extends MX_Controller {
 	
   	public function __construct()
   	{
   		parent::__construct();
   		$this->load->model('settings_model'); 
   		$this->load->model('app_model'); 

  		if (! $this->session->userdata('isLogIn'))
  			redirect('login');

		$this->Settings = $this->app_model->get_setting();
		
   	}

    function index()
    {

        // $this->load->library('gst');
        $this->form_validation->set_rules('site_name', lang('site_name'), 'trim|required');
        $this->form_validation->set_rules('dateformat', lang('dateformat'), 'trim|required');

		if ($this->form_validation->run() === true) {

            $tax1 = ($this->input->post('tax_rate') != 0) ? 1 : 0;
            $tax2 = ($this->input->post('tax_rate2') != 0) ? 1 : 0;
			
			$data['data'] = (object)$postData = [
				'site_name' => $this->input->post('site_name'),
				'rows_per_page'  => $this->input->post('rows_per_page'),
                'dateformat'     => $this->input->post('dateformat'),
                'timezone'       => $this->input->post('timezone'),
                'mmode'          => trim($this->input->post('mmode')),
                'iwidth'         => $this->input->post('iwidth'),
                'iheight'        => $this->input->post('iheight'),
                'twidth'         => $this->input->post('twidth'),
                'theight'        => $this->input->post('theight'),
                'watermark'      => $this->input->post('watermark'),
                'accounting_method'    => $this->input->post('accounting_method'),
                'default_email'        => $this->input->post('email'),
                'language'             => $lang,
                'default_warehouse'    => $this->input->post('warehouse'),
                'default_tax_rate'     => $this->input->post('tax_rate'),
                'default_tax_rate2'    => $this->input->post('tax_rate2'),
                'sales_prefix'         => $this->input->post('sales_prefix'),
                'quote_prefix'         => $this->input->post('quote_prefix'),
                'purchase_prefix'      => $this->input->post('purchase_prefix'),
                'transfer_prefix'      => $this->input->post('transfer_prefix'),
                'delivery_prefix'      => $this->input->post('delivery_prefix'),
                'payment_prefix'       => $this->input->post('payment_prefix'),
                'ppayment_prefix'      => $this->input->post('ppayment_prefix'),
                'qa_prefix'            => $this->input->post('qa_prefix'),
                'return_prefix'        => $this->input->post('return_prefix'),
                'returnp_prefix'       => $this->input->post('returnp_prefix'),
                'expense_prefix'       => $this->input->post('expense_prefix'),
                'auto_detect_barcode'  => trim($this->input->post('detect_barcode')),
                'theme'                => trim($this->input->post('theme')),
                'product_serial'       => $this->input->post('product_serial'),
                'customer_group'       => $this->input->post('customer_group'),
                'product_expiry'       => $this->input->post('product_expiry'),
                'product_discount'     => $this->input->post('product_discount'),
                'default_currency'     => $this->input->post('currency'),
                'bc_fix'               => $this->input->post('bc_fix'),
                'tax1'                 => $tax1,
                'tax2'                 => $tax2,
                'overselling'          => $this->input->post('restrict_sale'),
                'reference_format'     => $this->input->post('reference_format'),
                'racks'                => $this->input->post('racks'),
                'attributes'           => $this->input->post('attributes'),
                'restrict_calendar'    => $this->input->post('restrict_calendar'),
                'captcha'              => $this->input->post('captcha'),
                'item_addition'        => $this->input->post('item_addition'),
                'protocol'             => $this->input->post('protocol'),
                'mailpath'             => $this->input->post('mailpath'),
                'smtp_host'            => $this->input->post('smtp_host'),
                'smtp_user'            => $this->input->post('smtp_user'),
                'smtp_port'            => $this->input->post('smtp_port'),
                'smtp_crypto'          => $this->input->post('smtp_crypto') ? $this->input->post('smtp_crypto') : null,
                'decimals'             => $this->input->post('decimals'),
                'decimals_sep'         => $this->input->post('decimals_sep'),
                'thousands_sep'        => $this->input->post('thousands_sep'),
                'default_biller'       => $this->input->post('biller'),
                'invoice_view'         => $this->input->post('invoice_view'),
                'rtl'                  => $this->input->post('rtl'),
                'each_spent'           => $this->input->post('each_spent') ? $this->input->post('each_spent') : null,
                'ca_point'             => $this->input->post('ca_point') ? $this->input->post('ca_point') : null,
                'each_sale'            => $this->input->post('each_sale') ? $this->input->post('each_sale') : null,
                'sa_point'             => $this->input->post('sa_point') ? $this->input->post('sa_point') : null,
                'sac'                  => $this->input->post('sac'),
                'qty_decimals'         => $this->input->post('qty_decimals'),
                'display_all_products' => $this->input->post('display_all_products'),
                'display_symbol'       => $this->input->post('display_symbol'),
                'symbol'               => $this->input->post('symbol'),
                'remove_expired'       => $this->input->post('remove_expired'),
                'barcode_separator'    => $this->input->post('barcode_separator'),
                'set_focus'            => $this->input->post('set_focus'),
                'disable_editing'      => $this->input->post('disable_editing'),
                'price_group'          => $this->input->post('price_group'),
                'barcode_img'          => $this->input->post('barcode_renderer'),
                'update_cost'          => $this->input->post('update_cost'),
                'apis'                 => $this->input->post('apis'),
                'pdf_lib'              => $this->input->post('pdf_lib'),
                'state'                => $this->input->post('state'),
                'use_code_for_slug'    => $this->input->post('use_code_for_slug'),
                'ws_barcode_type'      => $this->input->post('ws_barcode_type'),
                'ws_barcode_chars'     => $this->input->post('ws_barcode_chars'),
                'flag_chars'           => $this->input->post('flag_chars'),
                'item_code_start'      => $this->input->post('item_code_start'),
                'item_code_chars'      => $this->input->post('item_code_chars'),
                'price_start'          => $this->input->post('price_start'),
                'price_chars'          => $this->input->post('price_chars'),
                'price_divide_by'      => $this->input->post('price_divide_by'),
                'weight_start'         => $this->input->post('weight_start'),
                'weight_chars'         => $this->input->post('weight_chars'),
                'weight_divide_by'     => $this->input->post('weight_divide_by'),
                'ksa_qrcode'           => $this->input->post('ksa_qrcode'),
                'online_link'     => $this->input->post('online_link'),
                'api_key'     => $this->input->post('api_key'),
			];
			// echo '<pre>'; print_r($postData); die;
			if($this->settings_model->updateSetting($postData)) {
				$this->session->set_flashdata('message', lang('save_successfully'));
			} else {
				$this->session->set_flashdata('exception', lang('please_try_again'));
			}
			redirect('settings');
		}
		else {
			$data['currencies']      = $this->settings_model->getAllCurrencies();
			$data['warehouses']      = $this->settings_model->getAllWarehouses();
			$data['date_formats']    = $this->settings_model->getDateFormats();
			$data['billers']    = $this->settings_model->getAllBillers();
			$data['Settings'] = $this->Settings;
            $data['tax_rates']       = $this->app_model->getAllTaxRates();

			$data['module']      = "settings";
  			$data['page']        = "settings";

  			echo Modules::run('template/layout', $data); 
		}
    }

    function pos_settings()
    {
        $this->form_validation->set_message('is_natural_no_zero', lang('no_zero_required'));
        $this->form_validation->set_rules('pro_limit', lang('pro_limit'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('pin_code', lang('delete_code'), 'numeric');
        $this->form_validation->set_rules('category', lang('default_category'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('customer', lang('default_customer'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('biller', lang('default_biller'), 'required|is_natural_no_zero');

        if ($this->form_validation->run() === true) {

            $data = [
            'pro_limit'                 => $this->input->post('pro_limit'),
            'pin_code'                  => $this->input->post('pin_code') ? $this->input->post('pin_code') : null,
            'default_category'          => $this->input->post('category'),
            'default_customer'          => $this->input->post('customer'),
            'default_biller'            => $this->input->post('biller'),
            'display_time'              => $this->input->post('display_time'),
            'receipt_printer'           => $this->input->post('receipt_printer'),
            'cash_drawer_codes'         => $this->input->post('cash_drawer_codes'),
            'cf_title1'                 => $this->input->post('cf_title1'),
            'cf_title2'                 => $this->input->post('cf_title2'),
            'cf_value1'                 => $this->input->post('cf_value1'),
            'cf_value2'                 => $this->input->post('cf_value2'),
            'keyboard'                  => $this->input->post('keyboard'),
            'pos_printers'              => $this->input->post('pos_printers'),
            'product_button_color'      => $this->input->post('product_button_color'),
            'authorize'                 => $this->input->post('authorize'),
            'rounding'                  => $this->input->post('rounding'),
            'item_order'                => $this->input->post('item_order'),
            'after_sale_page'           => $this->input->post('after_sale_page'),
            'printer'                   => $this->input->post('receipt_printer'),
            'order_printers'            => json_encode($this->input->post('order_printers')),
            'auto_print'                => $this->input->post('auto_print'),
            'remote_printing'           => $this->input->post('remote_printing'),
            'customer_details'          => $this->input->post('customer_details'),
            'local_printers'            => $this->input->post('local_printers'),
            'pos_layout_type'           => $this->input->post('pos_layout_type'),
            ];
            // echo '<pre>'; print_r($data); die;
            if($this->settings_model->updatePosSetting($data)) {
				$this->session->set_flashdata('message', lang('save_successfully'));
			} else {
				$this->session->set_flashdata('exception', lang('please_try_again'));
			}
			redirect('pos_settings');

        }else {
            $data['title']      = "pos_settings";
            $data['module']      = "settings";
            $data['page']        = "pos_settings";
            $pos_settings = $this->app_model->getPosSetting();
            $data['pos'] = $pos_settings;
            $data['categories']  = $this->app_model->getAllCategories();
            $data['billers']       = $this->app_model->getAllBillers();
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);

            echo Modules::run('template/layout', $data); 

        }

            
    }

    public function units()
    {

            $data['title']      = "units";
            $data['module']      = "settings";
            $data['page']        = "units";

            echo Modules::run('template/layout', $data); 
    }

    public function get_units() {

    	$totalData = 0;
		$data = array();
		if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
        {
            $q = $_POST['search']['value'];
            $records = $this->settings_model->get_units($_POST['length'], $_POST['start'], $_POST['order'], null,  $q);
            $totalData = sizeof($records); 
        }else{
            
            $records = $this->settings_model->get_units($_POST['length'], $_POST['start'], $_POST['order'], $category_id);
            
            $all_records = $this->settings_model->total_get_units($category_id);
		    $totalData = sizeof($all_records); 
        }
		
		$i = 0;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $key => $value) {
				$i++;
				$nestedData = array();
				$nestedData[] = $value->id;
				$nestedData[] = $value->code;
				$nestedData[] = $value->name;

                $edit = '<a href="#" class="edit_unit btn btn-success btn-sm" data-id="'. $value->id . '"> <i class="fa fa-pencil"> </i> '. '</a>';    
				$edit .= ' ' . anchor("settings/delete_unit/".$value->id,
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

    public function delete_unit($id=null) 
    {
        if(!$id) {
            $this->session->set_flashdata('message', lang('id_not_found'));
            redirect('settings/units');
        }
        if($this->settings_model->delete_unit($id)) {
            $this->session->set_flashdata('message', lang('unit_deleted_successfully'));
            redirect('settings/units');
        }
    }

    public function add_unit() 
    {
        $this->load->view('settings/add_unit');
    }

    public function saveUnit() 
    {

        $data['title'] = lang('add_unit');
        #-------------------------------#
        $this->form_validation->set_rules('code',lang('code'),'required|max_length[200]');
        $this->form_validation->set_rules('name',lang('name'),'required|max_length[200]');

        #-------------------------------#

        $data['unit'] = (object)$postData = [
            'name'    => $this->input->post('name',true),
            'code'    => $this->input->post('code',true),
        ]; 

        #-------------------------------#
        if ($this->form_validation->run() === true) {

                if ($this->settings_model->add_unit($postData)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("settings/units");
        } else { 
            redirect("settings/units");
        } 
    }

    public function edit_unit($id = null) 
    {
        $data = [];
        if($id) {
            $unit = $this->app_model->getUnitByID($id);
            $data['unit'] = $unit;
        }
        
        $this->load->view('settings/edit_unit', $data);
    }

    public function editUnit() 
    {

        $data['title'] = lang('edit_unit');
        #-------------------------------#
        $this->form_validation->set_rules('code',lang('code'),'required|max_length[200]');
        $this->form_validation->set_rules('name',lang('name'),'required|max_length[200]');

        #-------------------------------#
        $id = $this->input->post('id');
        $data['unit'] = (object)$postData = [
            'name'    => $this->input->post('name',true),
            'code'    => $this->input->post('code',true),
        ]; 

        #-------------------------------#
        if ($this->form_validation->run() === true) {

                if ($this->settings_model->editUnit($id, $postData)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("settings/units");
        } else { 
            redirect("settings/units");
        } 
    }

    public function categories()
    {
            $data['title']      = "categories";
            $data['module']      = "settings";
            $data['page']        = "categories";

            echo Modules::run('template/layout', $data); 
    }
    public function get_categories() {

    	$totalData = 0;
		$data = array();
		if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
        {
            $q = $_POST['search']['value'];
            $records = $this->settings_model->get_categories($_POST['length'], $_POST['start'], $_POST['order'], null,  $q);
            $totalData = sizeof($records); 
        }else{
            
            $records = $this->settings_model->get_categories($_POST['length'], $_POST['start'], $_POST['order'], $category_id);
            
            $all_records = $this->settings_model->total_get_categories($category_id);
		    $totalData = sizeof($all_records); 
        }
		
		$i = 0;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $key => $value) {
				$i++;
				$nestedData = array();
				$nestedData[] = $value->id;
				$nestedData[] = $value->code;
				$nestedData[] = $value->name;

                $edit = '<a href="#" class="edit_unit btn btn-success btn-sm" data-id="'. $value->id . '"> <i class="fa fa-pencil"> </i> '. '</a>';    
				$edit .= ' ' . anchor("settings/delete_unit/".$value->id,
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

}