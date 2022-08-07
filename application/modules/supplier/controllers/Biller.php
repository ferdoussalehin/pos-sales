<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------      

class Biller extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
  
        $this->load->model(array(
            'supplier_model')); 
        if (! $this->session->userdata('isLogIn'))
            redirect('login');
          
    }

    function index() {
        $data['title']             = 'biller List';
        $data['module']            = "supplier";
        $data['page']              = "biller_list"; 

        echo modules::run('template/layout', $data);
    }

    public function biller_list() {

		$data = array();
		if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
		{
            $q = $_POST['search']['value'];
            $records = $this->supplier_model->getBillers($_POST['length'], $_POST['start'], $_POST['order'], $q);
            $totalData = sizeof($records); 
		}else{
			$records = $this->supplier_model->getBillers($_POST['length'], $_POST['start'], $_POST['order']);

			$totalData = $this->supplier_model->getBillersTotal()->total_row;
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

				$edit = anchor("edit_biller/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
				$edit .= ' ' . anchor("supplier/biller/delete_biller/".$value->id,
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

    public function delete_biller($id = null) {

    	if($this->supplier_model->delete_biller($id)) {
    		$this->session->set_flashdata('message', lang('delete_successfully'));
    	} else {
    		$this->session->set_flashdata('message', lang('please_try_again'));
    	}

    	redirect('billers');
    }

    public function create_biller() 
      {

        $data['title'] = lang('add_biller');
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

                $image = $this->fileupload->do_upload(
                    './assets/uploads/logos/',
                    'image'
                );
                $thumb_path = './assets/uploads/logos';
                // if image is uploaded then resize the image
                if ($image !== false && $image != null) {
                    $this->fileupload->do_resize(
                        $image, 
                        210,
                        48
                    );
                }
                $postData['logo'] = $image;

                if ($this->supplier_model->create_biller($postData)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("billers");

        } else { 

	            $data['module']   = "supplier";  
	            $data['page']     = "create_biller_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function edit_biller($id = null) 
      {

        $data['title'] = lang('add_biller');
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

        $data['biller'] = (object)$postData = [
            'id'    => $id,
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
// print_r($_POST); print_r($_FILES); die;
            $image = $this->fileupload->do_upload(
                './assets/uploads/logos/',
                'image'
            );
            // print_r($image); die;
            // if image is uploaded then resize the image
            if ($image !== false && $image != null) {
                $this->fileupload->do_resize(
                    $image, 
                    300,
                    70
                );
            }
            $postData['logo'] = !empty($image) ? $image : $this->input->post('old_image');
            // print_r($postData); die;

            if ($this->supplier_model->update_biller($postData)) {
                    $this->session->set_flashdata('message', lang('save_successfully'));
            } else {
                    $this->session->set_flashdata('exception', lang('please_try_again'));
            }

            redirect("billers");

        } else { 
	            $data['module']   = "supplier"; 
                $data['data'] = $this->supplier_model->billerById($id);   
	            $data['page']     = "edit_biller_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

}

?>