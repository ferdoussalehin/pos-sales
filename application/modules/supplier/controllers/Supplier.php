<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------      

class Supplier extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
  
        $this->load->model(array(
            'supplier_model')); 
        if (! $this->session->userdata('isLogIn'))
            redirect('login');
          
    }

    function index() {
        $data['title']             = 'supplier List';
        $data['module']            = "supplier";
        $data['page']              = "supplier_list"; 

        echo modules::run('template/layout', $data);
    }

      public function create_supplier() 
      {

        $data['title'] = lang('add_supplier');
        #-------------------------------#
        $this->form_validation->set_rules('name',lang('name'),'required|max_length[200]');

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

        $data['supplier'] = (object)$postData = [
            'name'    => $this->input->post('name',true),
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

                if ($this->supplier_model->create($postData)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("suppliers");

        } else { 

	            $data['module']   = "supplier";  
	            $data['page']     = "create_supplier_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function edit_supplier($id = null) 
      {

        $data['title'] = lang('add_supplier');
        #-------------------------------#
        $this->form_validation->set_rules('name',lang('name'),'required|max_length[200]');

        if(empty($id)){
        $this->form_validation->set_rules('email',lang('email'),'required|max_length[100]|valid_email|is_unique[suppliers.email]');
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
            'name'    => $this->input->post('name',true),
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

                if ($this->supplier_model->update($postData)) {
                        $this->session->set_flashdata('message', lang('update_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("suppliers");

        } else { 

	            $data['title']    = lang('edit_supplier');
            	$data['supplier'] = $this->supplier_model->singledata($id);  
            	$data['module']   = "supplier";  
            	$data['page']     = "edit_supplier_form"; 
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function delete_supplier($id = null) {

    	if($this->supplier_model->delete($id)) {
    		$this->session->set_flashdata('message', lang('delete_successfully'));
    	} else {
    		$this->session->set_flashdata('message', lang('please_try_again'));
    	}

    	redirect('suppliers');
    }
 
    public function get_all_supplier() {

    	$totalData = 0;
		$data = array();
		if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
		{
			$q = $_POST['search']['value'];
			
			$records = $this->db->select("suppliers.*")
					->from('suppliers')
					->group_start()
					->like('suppliers.name',$q)
					->or_like('suppliers.email',$q)
					->or_like('suppliers.phone',$q)
					->group_end()
					
					->limit($_POST['length'], $_POST['start'])
					->order_by('suppliers.id', 'desc')
					->get()
					->result();	

        	$totalData = sizeof($records); 


		}else{
			$records = $this->db->select("suppliers.*")
					->from('suppliers')
					->limit($_POST['length'], $_POST['start'])
					->order_by('suppliers.id', 'desc')
					->get()
					->result();
			$all_users = $this->db->get('suppliers')->result();
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

				$edit = anchor("edit_supplier/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
				$edit .= ' ' . anchor("supplier/supplier/delete_supplier/".$value->id,
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