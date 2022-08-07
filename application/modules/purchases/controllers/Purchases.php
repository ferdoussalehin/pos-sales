<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata('isLogIn')) {
            redirect('login');
        }

        $this->load->model('purchase_model');
        $this->load->model('app_model');

        $this->Settings = $this->app_model->get_setting();
        $this->pos_settings = $this->app_model->getPosSetting();	
    }

    public function index()
    {
        $data['title'] = 'Purchase List';
        $data['module'] = 'purchases';
        $data['page'] = 'purchases';

        echo modules::run('template/layout', $data);
    }

    public function getPurchases()
    {
        // echo '<pre>'; print_r($_POST); die;
        if($this->input->post()) {
            $category_id = $this->input->post('customf');
        }
        $totalData = 0;
        $data = array();
        
        if(isset($_POST['search']['value']) && $_POST['search']['value'] != '') 
        {
            $q = $_POST['search']['value'];
            $records = $this->purchase_model->getPurchases($_POST['length'], $_POST['start'], $_POST['order'], $q);
            $totalData = $this->purchase_model->getPurchasesTotal($q)->total_sale;
        } else {
            $records = $this->purchase_model->getPurchases($_POST['length'], $_POST['start'], $_POST['order']);
            $totalData = $this->purchase_model->getPurchasesTotal()->total_sale;
        }
        // echo '<pre>'; print_r($records); echo '<br> total'; print_r($_POST['search']['value']); die;
        $i = 0;
        if (isset($records) && count($records) > 0) {
            foreach ($records as $key => $value) {
                $i++;
                // $detail_link       = anchor("pos/view_receipt/".$value->id, '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
                $detail_link       = anchor("purchases/view/".$value->id,
                '<i class="fa fa-pencil" aria-hidden="true"></i> '. lang('purchase_detail'), array('class'=>'btn-sm', 'title'=>'View'));
                
                $view_payments_link = '<a href="#" class="view_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('view_payment') .'</a>';
                
                $edit_link         = anchor('pos/edit/'.$value->id, '<i class="fa fa-edit"></i> ' . lang('edit_purchase'), 'class="sledit"');
                $return_link       = anchor('sales/return_sale/'.$value->id, '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
                $payment_link = '<a href="#" class="add_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('add_payment') .'</a>';
                $pdf_link       = anchor('sales/pos/pdf_sale/'.$value->id, '<i class="fa fa-download"></i> ' . lang('pdf_download'));
                $delete_link = ' ' . anchor("pos/delete/".$value->id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete Purchase',
                    array('class'=>'', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
                $action = '<div class="text-center"><div class="btn-group text-left">'
                    . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                    . lang('actions') . ' </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        
                        <li>' . $detail_link . '</li>
                        <li>' . $edit_link . '</li>
                        <li>' . $pdf_link . '</li>
                        <li>' . $return_link . '</li>
                        <li>' . $payment_link . '</li>
                        <li>' . $view_payments_link . '</li>
                        <li>' . $delete_link . '</li>
                    </ul>
                </div></div>';
                if($value->status == 'received') {
                    $status = '<span class="row_status label label-success">'.$value->status.'</span>';
                } else if($value->status == 'pending'){
                    $status = '<span class="row_status label label-danger">'.$value->status.'</span>';
                }
                else if($value->status == 'ordered'){
                    $status = '<span class="row_status label label-danger">'.$value->status.'</span>';
                }
                if($value->payment_status == 'paid') {
                    $payment_status = '<span class="row_status label label-success">'.$value->payment_status.'</span>';
                } else if($value->payment_status == 'due'){
                    $payment_status = '<span class="row_status label label-danger">'.$value->payment_status.'</span>';
                }
                else if($value->payment_status == 'partial'){
                    $payment_status = '<span class="row_status label label-secondary">'.$value->payment_status.'</span>';
                }
                else if($value->payment_status == 'pending'){
                    $payment_status = '<span class="row_status label label-warning">'.$value->payment_status.'</span>';
                }

                $nestedData = array();
                $nestedData[] = $value->id;
                $nestedData[] = $value->date;
                $nestedData[] = $value->reference_no;
                $nestedData[] = $value->supplier;
                $nestedData[] = $this->sls->formatDecimal($value->grand_total);
                $nestedData[] = $this->sls->formatDecimal($value->paid);
                $nestedData[] = $this->sls->formatDecimal($value->grand_total - $value->paid);
                $nestedData[] = $status;
                $nestedData[] = $payment_status;
                   
                $nestedData[] = $action;

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

    public function view($id='')
    {
        $this->load->library('inv_qrcode');
        $sale_id = $id;
        $inv = $this->purchase_model->getPurchaseByID($sale_id);        
        $data['inv']  = $inv;
        $data['supplier']        = $this->app_model->getSupplierByID($inv->supplier_id);
        $data['warehouse']       = $this->app_model->getWarehouseByID($inv->warehouse_id);
        // print_r($inv->warehouse_id); die;

        $data['rows']            = $this->purchase_model->getAllPurchaseItems($sale_id);
        $this->data['return_purchase'] = $inv->return_id ? $this->purchase_model->getPurchaseByID($inv->return_id) : null;
        // $data['payments']        = $this->purchase_model->getPurchasePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

         $data['title']      = "Purchase Detail";
         $data['module']      = "purchases";
         $data['page']        = "view";

         echo Modules::run('template/layout', $data); 
    }

    public function modal_view($id='')
    {
        $this->load->library('inv_qrcode');
        $sale_id = $this->input->get('id');
        $inv = $this->purchase_model->getPurchaseByID($sale_id);        
        $data['inv']  = $inv;
        $data['supplier']        = $this->app_model->getSupplierByID($inv->supplier_id);
        $data['warehouse']       = $this->app_model->getWarehouseByID($inv->warehouse_id);
        // print_r($inv->warehouse_id); die;

        $data['rows']            = $this->purchase_model->getAllPurchaseItems($sale_id);
        $this->data['return_purchase'] = $inv->return_id ? $this->purchase_model->getPurchaseByID($inv->return_id) : null;
        // $data['payments']        = $this->purchase_model->getPurchasePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

        $this->load->view('purchases/modal_view', $data);
    }

    public function pdf_purchase($id = null)
    {
        $this->load->library('inv_qrcode');
        $data = array();
        $sale_id = $id;
        $inv = $this->purchase_model->getPurchaseByID($sale_id);
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['supplier']        = $this->app_model->getSupplierByID($inv->supplier_id);
        
        $data['rows']            = $this->purchase_model->getAllPurchaseItems($sale_id);
        // print_r($data['rows']); die;
        // $data['payments']        = $this->purchase_model->getPurchasePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

        $html = $this->load->view('purchases/pdf_purchase', $data, true);
        // print_r($html); die;
        $filename = $inv->reference_no.'.pdf';
        $this->sls->generate_pdf($html, $filename, null, null, null, null, null, 'L'); 
    }
    public function print_purchase($id = null)
    {
        $this->load->library('inv_qrcode');
        $data = array();
        $purchase_id = $id;

        $inv = $this->purchase_model->getPurchaseByID($purchase_id);
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['supplier']        = $this->app_model->getSupplierByID($inv->supplier_id);
        
        $data['rows']            = $this->purchase_model->getAllPurchaseItems($purchase_id);
        // print_r($data['rows']); die;
        // $data['payments']        = $this->purchase_model->getPurchasePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

        $print_data = array(
            'print_view' => $this->load->view('purchases/print_purchase', $data, true)
        );

        header('Content-Type: application/json');
        die(json_encode($print_data));
        exit;

    }

}