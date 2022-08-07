<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------      

class Customer extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
  
        $this->load->model(array(
            'customer_model')); 
        if (! $this->session->userdata('isLogIn'))
            redirect('login');
          
    }

    function index() {
        $data['title']             = 'Customer List';
        $data['module']            = "customer";
        $data['page']              = "customer_list"; 

        echo modules::run('template/layout', $data);
    }

      public function create_customer() 
      {

        $data['title'] = lang('add_customer');
        #-------------------------------#
        $this->form_validation->set_rules('customer_name',lang('customer_name'),'required|max_length[200]');

        if(empty($id)){
        $this->form_validation->set_rules('email',lang('email'),'required|max_length[100]|valid_email|is_unique[customers.email]');
	    }else{
	        $this->form_validation->set_rules('email',lang('email'),'max_length[100]|valid_email');
	    }

        $this->form_validation->set_rules('phone',lang('phone'),'required|max_length[20]');
        $this->form_validation->set_rules('city',lang('city'),'required|max_length[100]'); 
        $this->form_validation->set_rules('state',lang('state'),'max_length[100]');
        $this->form_validation->set_rules('zip',lang('zip'),'max_length[30]');
        $this->form_validation->set_rules('country',lang('country'),'max_length[100]');  
        $this->form_validation->set_rules('address',lang('address'),'required|max_length[255]');

        #-------------------------------#

        $data['customer'] = (object)$postData = [
            'name'    => $this->input->post('customer_name',true),
            'company_name'    => $this->input->post('company_name',true),
            'email'   => $this->input->post('email', true),
            'phone'            => $this->input->post('phone', true),
            'city'             => $this->input->post('city', true) ,
            'state'            => $this->input->post('state', true) ,
            'zip'              => $this->input->post('zip', true) ,
            'country'          => $this->input->post('country', true) ,
            'address' => $this->input->post('address', true) ,
            'vat_number' => $this->input->post('vat_number', true) ,
            'status'           => 1,
            'create_by'        => $this->session->userdata('id') ,
            
        ]; 

        #-------------------------------#
        if ($this->form_validation->run() === true) {

                if ($this->customer_model->create($postData)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("customers");

        } else { 

	            $data['module']   = "customer";  
	            $data['page']     = "create_customer_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function edit_customer($id = null) 
      {

        $data['title'] = lang('add_customer');
        #-------------------------------#
        $this->form_validation->set_rules('customer_name',lang('customer_name'),'required|max_length[200]');

        if(empty($id)){
        $this->form_validation->set_rules('email',lang('email'),'required|max_length[100]|valid_email|is_unique[customers.email]');
	    }else{
	        $this->form_validation->set_rules('email',lang('email'),'max_length[100]|valid_email');
	    }

        $this->form_validation->set_rules('phone',lang('phone'),'required|max_length[20]');
        $this->form_validation->set_rules('city',lang('city'),'required|max_length[100]'); 
        $this->form_validation->set_rules('state',lang('state'),'max_length[100]');
        $this->form_validation->set_rules('zip',lang('zip'),'max_length[30]');
        $this->form_validation->set_rules('country',lang('country'),'max_length[100]');  
        $this->form_validation->set_rules('address',lang('address'),'required|max_length[255]');

        #-------------------------------#

        $data['customer'] = (object)$postData = [
        	'id'      => $this->input->post('id',true),
            'name'    => $this->input->post('customer_name',true),
            'company_name'    => $this->input->post('company_name',true),
            'email'   => $this->input->post('email', true),
            'phone'            => $this->input->post('phone', true),
            'city'             => $this->input->post('city', true) ,
            'state'            => $this->input->post('state', true) ,
            'zip'              => $this->input->post('zip', true) ,
            'country'          => $this->input->post('country', true) ,
            'address' => $this->input->post('address', true) ,
            'vat_number' => $this->input->post('vat_number', true) ,
            'status'           => 1,
            'create_by'        => $this->session->userdata('id') ,
            
        ]; 

        #-------------------------------#
        if ($this->form_validation->run() === true) {

                if ($this->customer_model->update($postData)) {
                        $this->session->set_flashdata('message', lang('update_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("customers");

        } else { 

	            $data['title']    = lang('edit_customer');
            	$data['customer'] = $this->customer_model->singledata($id);  
            	$data['module']   = "customer";  
            	$data['page']     = "edit_customer_form"; 
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function delete_customer($id = null) {

    	if($this->customer_model->delete($id)) {
    		$this->session->set_flashdata('message', lang('delete_successfully'));
    	} else {
    		$this->session->set_flashdata('message', lang('please_try_again'));
    	}

    	redirect('customers');
    }
 
    public function get_all_customers() {

    	$totalData = 0;
		$data = array();
		if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
		{
			$q = $_POST['search']['value'];
			
			$records = $this->db->select("customers.*")
					->from('customers')
					->group_start()
					->like('customers.name',$q)
					->or_like('customers.email',$q)
					->or_like('customers.phone',$q)
					->group_end()
					
					->limit($_POST['length'], $_POST['start'])
					->order_by('customers.id', 'desc')
					->get()
					->result();	

        	$totalData = sizeof($records); 


		}else{
			$records = $this->db->select("customers.*")
					->from('customers')
					->limit($_POST['length'], $_POST['start'])
					->order_by('customers.id', 'desc')
					->get()
					->result();
			$all_users = $this->db->get('customers')->result();
			$totalData = sizeof($all_users); 
		}
		
		$i = 0;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $key => $value) {
				$i++;
				$nestedData = array();
				$nestedData[] = $value->id;
				
				$nestedData[] = $value->name;
				$nestedData[] = $value->company_name;
				$nestedData[] = $value->email;
				$nestedData[] = $value->phone;
				$nestedData[] = $value->address;
				$nestedData[] = $value->city;
				
				$nestedData[] = $value->country;

				$edit = anchor("edit_customer/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
				$edit .= ' ' . anchor("customer/customer/delete_customer/".$value->id,
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