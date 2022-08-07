<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    //-------------------------------
    // Author: Ai Softz
    //-------------------------------    

class Pos extends MX_Controller {
 	
   	public function __construct()
   	{
   		parent::__construct();
   		// $this->load->model('settings_model'); 
   		$this->load->model('pos_model'); 
   		$this->load->model('app_model'); 

  		if (! $this->session->userdata('isLogIn'))
  			redirect('login');

		$this->Settings = $this->app_model->get_setting();
        $this->pos_settings = $this->app_model->getPosSetting();

        // echo '<pre>'; print_r($_SESSION); die;
		
   	}

    function sales() 
    {
        $data['title']             = 'Pos Sales List';
        $data['module']            = "sales";
        $data['page']              = "pos_sales"; 

        echo modules::run('template/layout', $data);
    }

    public function getPosSales()
    {
        // echo '<pre>'; print_r($_POST); die;
        if($this->input->post()) {
            $category_id = $this->input->post('customf');
        }
        $totalData = 0;
        $data = array();
        if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
        {
            $q = $_POST['search']['value'];
            $records = $this->pos_model->getPosSales($_POST['length'], $_POST['start'], $_POST['order'], $q);
            $totalData = sizeof($records); 
            // print_r($records); die;
        }else{
            
            $records = $this->pos_model->getPosSales($_POST['length'], $_POST['start'], $_POST['order']);
            
            $totalData = $this->pos_model->getPosSalesTotal()->total_sale;
        }
        // echo '<pre>'; print_r($records); echo '<br> total'; print_r($_POST['search']['value']); die;
        $i = 0;
        if (isset($records) && count($records) > 0) {
            foreach ($records as $key => $value) {
                $i++;
                // $detail_link       = anchor("pos/view_receipt/".$value->id, '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
                $detail_link       = anchor("pos/view/".$value->id,
                '<i class="fa fa-pencil" aria-hidden="true"></i> '. lang('sale_detail'), array('class'=>'btn-sm', 'title'=>'View'));
                $view_receipt_link       = anchor("pos/view_receipt/".$value->id,
                '<i class="fa fa-pencil" aria-hidden="true"></i> '. lang('view_receipt'), array('class'=>'btn-sm', 'title'=>'View Receipt'));
                $view_payments_link = '<a href="#" class="view_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('view_payment') .'</a>';
                
                $edit_link         = anchor('pos/edit/'.$value->id, '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
                $return_link       = anchor('sales/return_sale/'.$value->id, '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
                $payment_link = '<a href="#" class="add_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('add_payment') .'</a>';
                $pdf_link       = anchor('sales/pos/pdf_sale/'.$value->id, '<i class="fa fa-download"></i> ' . lang('pdf_download'));
                $delete_link = ' ' . anchor("pos/delete/".$value->id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete Sale',
                    array('class'=>'', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
                $action = '<div class="text-center"><div class="btn-group text-left">'
                    . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                    . lang('actions') . ' </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        
                        <li>' . $detail_link . '</li>
                        
                        <li>' . $view_receipt_link . '</li>
                        <li>' . $edit_link . '</li>
                        <li>' . $pdf_link . '</li>
                        <li>' . $return_link . '</li>
                        <li>' . $payment_link . '</li>
                        <li>' . $view_payments_link . '</li>
                        <li>' . $delete_link . '</li>
                    </ul>
                </div></div>';
                if($value->sale_status == 'completed') {
                    $sale_status = '<span class="row_status label label-success">'.$value->sale_status.'</span>';
                } else if($value->sale_status == 'pending'){
                    $sale_status = '<span class="row_status label label-danger">'.$value->sale_status.'</span>';
                }
                else if($value->sale_status == 'returned'){
                    $sale_status = '<span class="row_status label label-danger">'.$value->sale_status.'</span>';
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
                $nestedData[] = $value->biller;
                $nestedData[] = $value->customer;
                $nestedData[] = $this->sls->formatDecimal($value->grand_total);
                $nestedData[] = $this->sls->formatDecimal($value->paid);
                $nestedData[] = $this->sls->formatDecimal($value->grand_total - $value->paid);
                $nestedData[] = $sale_status;
                $nestedData[] = $payment_status;

                $edit = anchor("view_product/".$value->id,
                    '<i class="fa fa-file-text" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-warning btn-sm', 'title'=>'View'));
                $edit .= ' ' . anchor("pos/edit/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
                $edit .= ' ' . anchor("product/delete/".$value->id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i>',
                    array('class'=>'btn btn-danger btn-sm', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
                   
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

    /* ------------------------------- */

    public function delete($id = null)
    {

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if (!$id) {
            $this->sls->send_json(['error' => 1, 'msg' => lang('id_not_found')]);
        }

        $inv = $this->pos_model->getInvoiceByID($id);
        if ($inv->sale_status == 'returned') {
            $this->sls->send_json(['error' => 1, 'msg' => lang('sale_x_action')]);
        }

        if ($this->pos_model->deleteSale($id)) {
            if ($this->input->is_ajax_request()) {
                $this->sls->send_json(['error' => 0, 'msg' => lang('sale_deleted')]);
            }
            $this->session->set_flashdata('message', lang('sale_deleted'));
            redirect('pos/sales');
        }
    }

    function index()
    {
    // echo '<pre>';    print_r($this->input->post()); die;
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('warehouse', lang('warehouse'), 'required');
        // $this->form_validation->set_rules('biller', lang('biller'), 'required');
        if ($this->form_validation->run() == true) {
            //validate form input
            
            // echo '<pre>';   print_r($this->input->post()); die;
            $suspend           = $this->input->post('suspend') ? true : false;

            $date             = date('Y-m-d H:i:s');
            $warehouse_id     = $this->input->post('warehouse');
            $customer_id      = $this->input->post('customer');
            $biller_id        = $this->input->post('biller');
            $total_items      = $this->input->post('total_items');
            $sale_status      = 'completed';
            $payment_term     = 0;
            $due_date         = date('Y-m-d', strtotime('+' . $payment_term . ' days'));
            $shipping         = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->app_model->getCustomerByID($customer_id);
            $customer         = $customer_details->company && $customer_details->company != '-' ? $customer_details->company : $customer_details->name;
            $biller_details   = $this->app_model->getBillerByID($biller_id);
            $biller           = $biller_details->company && $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            // $note             = $this->sma->clear_tags($this->input->post('pos_note'));
            // $staff_note       = $this->sma->clear_tags($this->input->post('staff_note'));

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $digital          = false;
            $gst_data         = [];
            $total_cgst       = $total_sgst       = $total_igst       = 0;
            $i                = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_type          = $_POST['product_type'][$r];
                $item_code          = $_POST['product_code'][$r];
                $item_name          = $_POST['product_name'][$r];
                $item_comment       = $_POST['product_comment'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sls->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sls->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_serial        = $_POST['serial'][$r]           ?? '';
                $item_tax_rate      = $_POST['product_tax'][$r]      ?? null;
                $item_discount      = $_POST['product_discount'][$r] ?? null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->pos_model->getProductByCode($item_code) : null;
                    // $unit_price = $real_unit_price;
                    if ($item_type == 'digital') {
                        $digital = true;
                    }
                    $pr_discount      = $this->app_model->calculateDiscount($item_discount, $unit_price);
                    $unit_price       = $this->sls->formatDecimal($unit_price - $pr_discount);
                    $item_net_price   = $unit_price;
                    $pr_item_discount = $this->sls->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_item_tax = $item_tax = 0;
                    $tax         = '';

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $tax_details = $this->app_model->getTaxRateByID($item_tax_rate);
                        $ctax        = $this->app_model->calculateTax($product_details, $tax_details, $unit_price);
                        $item_tax    = $this->sls->formatDecimal($ctax['amount']);
                        $tax         = $ctax['tax'];
                        if (!$product_details || (!empty($product_details) && $product_details->tax_method != 1)) {
                            $item_net_price = $unit_price - $item_tax;
                        }
                        $pr_item_tax = $this->sls->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculateIndianGST($pr_item_tax, ($biller_details->state == $customer_details->state), $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_unit_quantity) + $pr_item_tax);
                    $unit     = $this->app_model->getUnitByID($item_unit);

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'product_type'      => $item_type,
                        'option_id'         => $item_option,
                        'net_unit_price'    => $item_net_price,
                        'unit_price'        => $this->sls->formatDecimal($item_net_price + $item_tax),
                        'quantity'          => $item_quantity,
                        'product_unit_id'   => $unit ? $unit->id : null,
                        'product_unit_code' => $unit ? $unit->code : null,
                        'unit_quantity'     => $item_unit_quantity,
                        'warehouse_id'      => $warehouse_id,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->sls->formatDecimal($subtotal),
                        'serial_no'         => $item_serial,
                        'real_unit_price'   => $real_unit_price,
                        'comment'           => $item_comment,
                    ];

                    $products[] = ($product + $gst_data);
                    $total += $this->sls->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } elseif ($this->pos_settings->item_order == 0) {
                krsort($products);
            }
            $order_discount = $this->app_model->calculateDiscount($this->input->post('discount'), ($total + $product_tax), true);
            $total_discount = $this->sls->formatDecimal(($order_discount + $product_discount), 4);
            $order_tax      = $this->app_model->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->sls->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total = $this->sls->formatDecimal(($total + $total_tax + $this->sls->formatDecimal($shipping) - $this->sls->formatDecimal($order_discount)), 4);
            $rounding    = 0;
            if ($this->pos_settings->rounding) {
                $round_total = $this->sls->roundNumber($grand_total, $this->pos_settings->rounding);
                $rounding    = $this->sls->formatMoney($round_total - $grand_total);
            }
            $data = ['date'         => $date,
                'customer_id'       => $customer_id,
                'customer'          => $customer,
                'biller_id'         => $biller_id,
                'biller'            => $biller,
                'warehouse_id'      => $warehouse_id,
                'note'              => $note,
                'staff_note'        => $staff_note,
                'total'             => $total,
                'product_discount'  => $product_discount,
                'order_discount_id' => $this->input->post('discount'),
                'order_discount'    => $order_discount,
                'total_discount'    => $total_discount,
                'product_tax'       => $product_tax,
                'order_tax_id'      => $this->input->post('order_tax'),
                'order_tax'         => $order_tax,
                'total_tax'         => $total_tax,
                'shipping'          => $this->sls->formatDecimal($shipping),
                'grand_total'       => $grand_total,
                'total_items'       => $total_items,
                'sale_status'       => $sale_status,
                'payment_status'    => $grand_total > 0 ? 'due' : 'paid',
                'payment_term'      => $payment_term,
                'rounding'          => $rounding,
                'suspend_note'      => $this->input->post('suspend_note'),
                'pos'               => 1,
                'paid'              => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,
                'created_by'        => $this->session->userdata('id'),
                'hash'              => hash('sha256', microtime() . mt_rand()),
                'customer_type'        => $this->input->post('is_dine_in') ? $this->input->post('is_dine_in'):1,
            ];
            
            if (!$suspend) {
                $p    = isset($_POST['amount']) ? sizeof($_POST['amount']) : 0;
                $paid = 0;
                for ($r = 0; $r < $p; $r++) {
                    if (isset($_POST['amount'][$r]) && !empty($_POST['amount'][$r]) && isset($_POST['paid_by'][$r]) && !empty($_POST['paid_by'][$r])) {
                        $amount = $this->sls->formatDecimal($_POST['balance_amount'][$r] > 0 ? $_POST['amount'][$r] - $_POST['balance_amount'][$r] : $_POST['amount'][$r]);
                        $payment[] = [
                            'date' => $date,
                            // 'reference_no' => $this->site->getReference('pay'),
                            'amount'      => $amount,
                            'paid_by'     => $_POST['paid_by'][$r],
                            'cheque_no'   => $_POST['cheque_no'][$r],
                            'created_by'  => $this->session->userdata('id'),
                            'type'        => 'received',
                            'note'        => $_POST['payment_note'][$r],
                            'pos_paid'    => $_POST['amount'][$r],
                            'pos_balance' => $_POST['balance_amount'][$r],
                        ];
                        
                    }
                }
            }
// echo '<pre>'; print_r($products); print_r($data); print_r($payment); die;
            if ($suspend) {
                if ($this->pos_model->suspendSale($data, $products, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    $this->session->set_flashdata('message', $this->lang->line('sale_suspended'));
                    redirect('pos/add');
                }
            } else {
                if ($sale = $this->pos_model->addSale($data, $products, $payment, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    
                    $this->session->set_flashdata('message', lang('sale_added'));
                    // $redirect_to = $this->pos_settings->after_sale_page ? 'pos_resturant_two' : 'pos_resturant_two/view/' . $sale['sale_id'];
                    // if ($this->pos_settings->auto_print) {
                    //     if ($this->Settings->remote_printing != 1) {
                    //         $redirect_to .= '?print=' . $sale['sale_id'];
                    //     }
                    // }
                    redirect('pos/add');
                } else {
                    $this->session->set_flashdata('message', lang('sale_not_added'));
                    redirect('pos/add');
                }
            }
            // echo '<pre>'; print_r($payment); die;

        } else {
            $data['categories']  = $this->app_model->getAllCategories();
            $data['warehouses'] =  $this->app_model->getAllWarehouses();
            $data['Settings'] =  $this->Settings;
            $data['pos_settings']       = $this->pos_settings;
            $data['tax_rates']     = $this->app_model->getAllTaxRates();
            $data['billers']       = $this->app_model->getAllBillers();
            $cus_id = $this->pos_settings->default_customer;
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);
            $data['default_customer'] =  $this->pos_model->getCustomerByID($cus_id);

            $data['module']      = "sales";
            $data['page']        = "add";

            echo Modules::run('template/layout_pos', $data); 
        }
        // $this->load->view('sales/add');
    }

    public function edit($id = null) 
    {
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('warehouse', lang('warehouse'), 'required');
        
        if ($this->form_validation->run() == true) {

            // echo '<pre>'; print_r($_POST); die;
            $suspend           = $this->input->post('suspend') ? true : false;

            $date             = date('Y-m-d H:i:s');
            $warehouse_id     = $this->input->post('warehouse');
            $customer_id      = $this->input->post('customer');
            $biller_id        = $this->input->post('biller');
            $total_items      = $this->input->post('total_items');
            $sale_status      = 'completed';
            $payment_term     = 0;
            $due_date         = date('Y-m-d', strtotime('+' . $payment_term . ' days'));
            $shipping         = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->app_model->getCustomerByID($customer_id);
            $customer         = $customer_details->company && $customer_details->company != '-' ? $customer_details->company : $customer_details->name;
            $biller_details   = $this->app_model->getBillerByID($biller_id);
            $biller           = $biller_details->company && $biller_details->company != '-' ? $biller_details->company : $biller_details->name;

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $digital          = false;
            $gst_data         = [];
            $total_cgst       = $total_sgst       = $total_igst       = 0;
            $i                = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_type          = $_POST['product_type'][$r];
                $item_code          = $_POST['product_code'][$r];
                $item_name          = $_POST['product_name'][$r];
                $item_comment       = $_POST['product_comment'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sls->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sls->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_serial        = $_POST['serial'][$r]           ?? '';
                $item_tax_rate      = $_POST['product_tax'][$r]      ?? null;
                $item_discount      = $_POST['product_discount'][$r] ?? null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->pos_model->getProductByCode($item_code) : null;
                    // $unit_price = $real_unit_price;
                    if ($item_type == 'digital') {
                        $digital = true;
                    }
                    $pr_discount      = $this->app_model->calculateDiscount($item_discount, $unit_price);
                    $unit_price       = $this->sls->formatDecimal($unit_price - $pr_discount);
                    $item_net_price   = $unit_price;
                    $pr_item_discount = $this->sls->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_item_tax = $item_tax = 0;
                    $tax         = '';

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $tax_details = $this->app_model->getTaxRateByID($item_tax_rate);
                        $ctax        = $this->app_model->calculateTax($product_details, $tax_details, $unit_price);
                        $item_tax    = $this->sls->formatDecimal($ctax['amount']);
                        $tax         = $ctax['tax'];
                        if (!$product_details || (!empty($product_details) && $product_details->tax_method != 1)) {
                            $item_net_price = $unit_price - $item_tax;
                        }
                        $pr_item_tax = $this->sls->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculateIndianGST($pr_item_tax, ($biller_details->state == $customer_details->state), $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_unit_quantity) + $pr_item_tax);
                    $unit     = $this->app_model->getUnitByID($item_unit);

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'product_type'      => $item_type,
                        'option_id'         => $item_option,
                        'net_unit_price'    => $item_net_price,
                        'unit_price'        => $this->sls->formatDecimal($item_net_price + $item_tax),
                        'quantity'          => $item_quantity,
                        'product_unit_id'   => $unit ? $unit->id : null,
                        'product_unit_code' => $unit ? $unit->code : null,
                        'unit_quantity'     => $item_unit_quantity,
                        'warehouse_id'      => $warehouse_id,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->sls->formatDecimal($subtotal),
                        'serial_no'         => $item_serial,
                        'real_unit_price'   => $real_unit_price,
                        'comment'           => $item_comment,
                    ];

                    $products[] = ($product + $gst_data);
                    $total += $this->sls->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } elseif ($this->pos_settings->item_order == 0) {
                krsort($products);
            }
            $order_discount = $this->app_model->calculateDiscount($this->input->post('discount'), ($total + $product_tax), true);
            $total_discount = $this->sls->formatDecimal(($order_discount + $product_discount), 4);
            $order_tax      = $this->app_model->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->sls->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total = $this->sls->formatDecimal(($total + $total_tax + $this->sls->formatDecimal($shipping) - $this->sls->formatDecimal($order_discount)), 4);
            $rounding    = 0;
            if ($this->pos_settings->rounding) {
                $round_total = $this->sls->roundNumber($grand_total, $this->pos_settings->rounding);
                $rounding    = $this->sls->formatMoney($round_total - $grand_total);
            }
            $data = ['date'         => $date,
                'customer_id'       => $customer_id,
                'customer'          => $customer,
                'biller_id'         => $biller_id,
                'biller'            => $biller,
                'warehouse_id'      => $warehouse_id,
                'note'              => $note,
                'staff_note'        => $staff_note,
                'total'             => $total,
                'product_discount'  => $product_discount,
                'order_discount_id' => $this->input->post('discount'),
                'order_discount'    => $order_discount,
                'total_discount'    => $total_discount,
                'product_tax'       => $product_tax,
                'order_tax_id'      => $this->input->post('order_tax'),
                'order_tax'         => $order_tax,
                'total_tax'         => $total_tax,
                'shipping'          => $this->sls->formatDecimal($shipping),
                'grand_total'       => $grand_total,
                'total_items'       => $total_items,
                'sale_status'       => $sale_status,
                'payment_status'    => $grand_total > 0 ? 'due' : 'paid',
                'payment_term'      => $payment_term,
                'rounding'          => $rounding,
                'suspend_note'      => $this->input->post('suspend_note'),
                'pos'               => 1,
                'paid'              => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,
                'created_by'        => $this->session->userdata('user_id'),
                'hash'              => hash('sha256', microtime() . mt_rand()),
                'customer_type'        => $this->input->post('is_dine_in') ? $this->input->post('is_dine_in'):1,
            ];
            
            if (!$suspend) {
                $p    = isset($_POST['amount']) ? sizeof($_POST['amount']) : 0;
                $paid = 0;
                for ($r = 0; $r < $p; $r++) {
                    if (isset($_POST['amount'][$r]) && !empty($_POST['amount'][$r]) && isset($_POST['paid_by'][$r]) && !empty($_POST['paid_by'][$r])) {
                        $amount = $this->sls->formatDecimal($_POST['balance_amount'][$r] > 0 ? $_POST['amount'][$r] - $_POST['balance_amount'][$r] : $_POST['amount'][$r]);
                        $payment[] = [
                            'date' => $date,
                            // 'reference_no' => $this->site->getReference('pay'),
                            'amount'      => $amount,
                            'paid_by'     => $_POST['paid_by'][$r],
                            'cheque_no'   => $_POST['cheque_no'][$r],
                            'created_by'  => $this->session->userdata('id'),
                            'type'        => 'received',
                            'note'        => $_POST['payment_note'][$r],
                            'pos_paid'    => $_POST['amount'][$r],
                            'pos_balance' => $_POST['balance_amount'][$r],
                        ];
                        
                    }
                }
            }
// echo '<pre>'; print_r($products); print_r($data); print_r($payment); die;
            if ($suspend) {
                if ($this->pos_model->suspendSale($data, $products, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    $this->session->set_flashdata('message', $this->lang->line('sale_suspended'));
                    redirect('pos/sales');
                }
            } else {
                if ($sale = $this->pos_model->updateSale($id, $data, $products, $payment, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    
                    $this->session->set_flashdata('message', lang('sale_added'));
                    
                    redirect('pos/sales');
                } else {
                    $this->session->set_flashdata('message', lang('sale_not_added'));
                    redirect('pos/sales');
                }
            }

        }
        else{
            $sale_id = $id;
            $inv = $this->pos_model->getInvoiceByID($sale_id);        
            $data['inv']  = $inv;
            $biller_id                     = $inv->biller_id;
            $customer_id                   = $inv->customer_id;
            $data['customer']        = $this->app_model->getCustomerByID($customer_id);
            
            $rows  = $this->pos_model->getAllInvoiceItems($sale_id);
            // echo '<pre>'; print_r($rows); die;
            // $data['items'] = array('row' => $data['rows']);
            foreach($rows as $r) {
                
                $row = $this->pos_model->getWHProduct($r->product_code, $inv->warehouse_id);
                // $saleItem = $this->pos_model->getSaleItemById($r->id);
                // echo '<pre>'; print_r($saleItem); die;
                if ($row) {
                    unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                    $row->item_tax_method = $row->tax_method;
                    $row->qty             = $r->quantity;
                    $row->discount        = '0';
                    $row->serial          = '';
                    $options              = $this->pos_model->getProductOptions($row->id, $warehouse_id);
                    if ($options) {
                        $opt = current($options);
                        if (!$option) {
                            $option = $opt->id;
                        }
                    } else {
                        $opt        = json_decode('{}');
                        $opt->price = 0;
                    }
                    $row->option   = $option;
                    $row->quantity = $r->quantity;
                    $pis           = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                    if ($pis) {
                        foreach ($pis as $pi) {
                            $row->quantity += $pi->quantity_balance;
                        }
                    }
                    if ($row->type == 'standard' && ($row->quantity < 0)) {
                        echo null;
                        die();
                    }
                    if ($options) {
                        $option_quantity = 0;
                        foreach ($options as $option) {
                            $pis = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                            if ($pis) {
                                foreach ($pis as $pi) {
                                    $option_quantity += $pi->quantity_balance;
                                }
                            }
                            if ($option->quantity > $option_quantity) {
                                $option->quantity = $option_quantity;
                            }
                        }
                    }
    
                    $row->real_unit_price = $row->price;
                    $row->base_quantity   = $r->quantity;
                    $row->base_unit       = $row->unit;
                    $row->base_unit_price = $row->price;
                    $row->unit            = $row->sale_unit ? $row->sale_unit : $row->unit;
                    $row->comment         = '';
                    $combo_items          = false;
                    if ($row->type == 'combo') {
                        $combo_items = $this->pos_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    // $units = array();
                    $units    = $this->app_model->getUnits();
                    $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);
                    
                    $pr[] = ['id' => sha1(uniqid(mt_rand(), true)), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'category' => $row->category_id, 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options];
    
                }
            }
            $data ['items'] = $pr;
            $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
            
            $data['categories']  = $this->app_model->getAllCategories();
            $data['warehouses'] =  $this->app_model->getAllWarehouses();
            $data['Settings'] =  $this->Settings;
            $data['pos_settings']       = $this->pos_settings;
            $data['tax_rates']     = $this->app_model->getAllTaxRates();
            $data['billers']       = $this->app_model->getAllBillers();
            $cus_id = $this->pos_settings->default_customer;
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);
            $data['default_customer'] =  $this->pos_model->getCustomerByID($cus_id);

            $data['module']      = "sales";
            $data['title']      = "Sale Edit";
            $data['page']        = "edit";

            echo Modules::run('template/layout_pos', $data); 
        }


    }

    public function ajax_category_data()
    {
        if($this->input->post()) {
            $category_id = $this->input->post('catId');

            $subcategories = $this->pos_model->getSubCategories($category_id);
            $scats = '';
            if ($subcategories) {
                foreach ($subcategories as $category) {
                    $scats .= '<button id="subcategory-' . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"" . base_url() . 'assets/uploads/thumbs/' . ($category->image ? $category->image : 'no_image.png') . "\" class='img-rounded img-thumbnail' /><span>" . $category->name . '</span></button>';
                }
            }
            $products = $this->ajax_products($category_id);
            header('Content-Type: application/json');
            die(json_encode(['products' => $products, 'subcategories' => $scats]));
            exit;
        }
    }

    public function modal_view()
    {
        $this->load->library('inv_qrcode');
        $sale_id = $this->input->get('id');
        $inv = $this->pos_model->getInvoiceByID($sale_id);        
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['customer']        = $this->app_model->getCustomerByID($customer_id);
        $data['biller']          = $this->app_model->getBillerByID($biller_id);
        // print_r($biller_id); die;
        $data['rows']            = $this->pos_model->getAllInvoiceItems($sale_id);
        $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
		$data['Settings']       = $this->Settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
        // $data['warehouses']       = $this->pos_model->getAllWarehousesWithPQ($id);
        
         $this->load->view('sales/modal_view', $data);
    }

    public function view($id='')
    {
        $this->load->library('inv_qrcode');
        $sale_id = $id;
        $inv = $this->pos_model->getInvoiceByID($sale_id);        
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['customer']        = $this->app_model->getCustomerByID($customer_id);
        $data['biller']          = $this->app_model->getBillerByID($biller_id);
        // print_r($biller_id); die;
        $data['rows']            = $this->pos_model->getAllInvoiceItems($sale_id);
        $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
        // $data['warehouses']       = $this->pos_model->getAllWarehousesWithPQ($id);
		$data['Settings']       = $this->Settings;
        //  $data['title']      = "View Reciept";
         $data['module']      = "sales";
         $data['page']        = "view";

         echo Modules::run('template/layout', $data); 
    }

    public function view_receipt($id='')
    {
        $this->load->library('inv_qrcode');
        $sale_id = $id;
        $inv = $this->pos_model->getInvoiceByID($sale_id);        
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['customer']        = $this->app_model->getCustomerByID($customer_id);
        $data['biller']          = $this->app_model->getBillerByID($biller_id);
        // print_r($biller_id); die;
        $data['rows']            = $this->pos_model->getAllInvoiceItems($sale_id);
        $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
        // $data['warehouses']       = $this->pos_model->getAllWarehousesWithPQ($id);
        
        //  $data['title']      = "View Reciept";
        //  $data['module']      = "sales";
        //  $data['page']        = "view_reciept";

        //  echo Modules::run('template/layout', $data); 
         $this->load->view('sales/view_receipt', $data);
    }

    public function pdf_sale($id = null)
    {
        $this->load->library('inv_qrcode');
        $data = array();
        $sale_id = $id;
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['customer']        = $this->app_model->getCustomerByID($customer_id);
        $data['biller']          = $this->app_model->getBillerByID($biller_id);
        // print_r($biller_id); die;
        $data['rows']            = $this->pos_model->getAllInvoiceItems($sale_id);
        $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

        $html = $this->load->view('sales/pdf_sale', $data, true);
        // print_r($html); die;
        $filename = $inv->reference_no.'.pdf';
        $this->sls->generate_pdf($html, $filename, null, null, null, null, null, 'L'); 
    }

    public function print_sale($id = null)
    {
        $this->load->library('inv_qrcode');
        $data = array();
        $sale_id = $id;
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        $data['inv']  = $inv;
        $biller_id                     = $inv->biller_id;
        $customer_id                   = $inv->customer_id;
        $data['customer']        = $this->app_model->getCustomerByID($customer_id);
        $data['biller']          = $this->app_model->getBillerByID($biller_id);
        // print_r($biller_id); die;
        $data['rows']            = $this->pos_model->getAllInvoiceItems($sale_id);
        $data['payments']        = $this->pos_model->getInvoicePayments($sale_id);
		$data['pos_settings']       = $this->pos_settings;
        $data['created_by']      = $this->app_model->singleUser($inv->created_by);
		$data['Settings']       = $this->Settings;

        $print_data = array(
            'print_view' => $this->load->view('sales/print_sale', $data, true)
        );

        header('Content-Type: application/json');
        die(json_encode($print_data));
        exit;

    }

    public function ajax_products($category_id='')
    {
        if ($this->input->get('brand_id')) {
            $brand_id = $this->input->get('brand_id');
        }
        if ($this->input->get('category_id')) {
            $category_id = $this->input->get('category_id');
        } 
        if ($this->input->get('subcategory_id')) {
            $subcategory_id = $this->input->get('subcategory_id');
        } else {
            $subcategory_id = null;
        }
        $products = $this->pos_model->fetch_products($category_id, $subcategory_id, $brand_id);
// print_r($category_id); print_r($products); die;
        $prods = '<div>';
        if(!empty($products)) {

            foreach($products as $product) {

                $pr_id = $product->id;
                if($pr_id < 10) {
                    $pr_id = '0'. ($pr_id / 100) * 100;
                }
                if($category_id < 10) {
                    $category_id = '0'. ($category_id / 100) * 100;
                }

                $prods .= '<button id="product-' . $category_id . $pr_id . ' type="button" value="'. $product->code . '" title="' . $product->name . '" class="btn-prni product pos-tip"><img src="' . base_url() . 'assets/uploads/products/' . $product->image . '" alt="'. $product->name . '" class="img-rounded"/> <span>' . $product->name . '</span></button>';

            }
        }
        $prods .= '</div>';

        return $prods;
    }

    public function getProductDataByCode()
    {
            if ($this->input->get('code')) {
                $code = $this->input->get('code', true);
            }
            if ($this->input->get('warehouse_id')) {
                $warehouse_id = $this->input->get('warehouse_id', true);
            }
            if ($this->input->get('customer_id')) {
                $customer_id = $this->input->get('customer_id', true);
            }
            if (!$code) {
                echo null;
                die();
            }
            $row = $this->pos_model->getWHProduct($code, $warehouse_id);
            
            if ($row) {
                unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                $row->item_tax_method = $row->tax_method;
                $row->qty             = 1;
                $row->discount        = '0';
                $row->serial          = '';
                // print_r($code); echo ', '; print_r($warehouse_id);  echo ', ';
                $options              = $this->pos_model->getProductOptions($row->id, $warehouse_id);
                // echo 'op-';print_r($options); die;
                if ($options) {
                    $opt = current($options);
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt        = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option   = $option;
                $row->quantity = 0;
                $pis           = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if ($pis) {
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($row->type == 'standard' && ($row->quantity < 0)) {
                    echo null;
                    die();
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if ($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }

                $row->real_unit_price = $row->price;
                $row->base_quantity   = 1;
                $row->base_unit       = $row->unit;
                $row->base_unit_price = $row->price;
                $row->unit            = $row->sale_unit ? $row->sale_unit : $row->unit;
                $row->comment         = '';
                $combo_items          = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->pos_model->getProductComboItems($row->id, $warehouse_id);
                }
                // $units = array();
                $units    = $this->app_model->getUnits();
                $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);
                
                $pr = ['id' => sha1(uniqid(mt_rand(), true)), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'category' => $row->category_id, 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options];
                // echo '<pre>'; print_r($code); print_r($units); die;
                header('Content-Type: application/json');
                die(json_encode($pr));
                exit;

            }
    }

    public function suggestions($pos = 0)
    {
        $term         = $this->input->get('term', true);
        $warehouse_id = $this->input->get('warehouse_id', true);
        $customer_id  = $this->input->get('customer_id', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . admin_url('welcome') . "'; }, 10);</script>");
        }

        $analyzed  = $this->sls->analyze_term($term);
        $sr        = $analyzed['term'];
        $option_id = $analyzed['option_id'];
        $sr        = addslashes($sr);
        $strict    = $analyzed['strict'] ?? false;
        $qty       = $strict ? null : $analyzed['quantity'] ?? null;
        $bprice    = $strict ? null : $analyzed['price']    ?? null;

        $warehouse      = $this->app_model->getWarehouseByID($warehouse_id);
        $customer       = $this->app_model->getCustomerByID($customer_id);
        // $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows           = $this->pos_model->getProductNames($sr, $warehouse_id, $pos);
        
        if ($rows) {
            $r = 0;
            foreach ($rows as $row) {
                // print_r($row); die;
                $c = uniqid(mt_rand(), true);
                if($row->is_packed =='1'){
                    if($row->packed_product){
                        $row->child_product=$this->getChildProduct($row->packed_product, $warehouse_id, $customer_id, $term, $r, $row->pack_piece);
                    }else{
                        $row->is_packed=0;
                    }
                }
                unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                $option               = false;
                $row->quantity        = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty             = 1;
                $row->discount        = '0';
                $row->serial          = '';
                $options              = $this->pos_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $option_id && $r == 0 ? $this->pos_model->getProductOptionByID($option_id) : $options[0];
                    if (!$option_id || $r > 0) {
                        $option_id = $opt->id;
                    }
                } else {
                    $opt        = json_decode('{}');
                    $opt->price = 0;
                    $option_id  = false;
                }
                $row->option = $option_id;
                $pis         = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if ($pis) {
                    $row->quantity = 0;
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->app_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if ($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                
                $row->price = $row->price;    
                $row->real_unit_price = $row->price;
                $row->base_quantity   = 1;
                $row->base_unit       = $row->unit;
                $row->base_unit_price = $row->price;
                $row->unit            = $row->sale_unit ? $row->sale_unit : $row->unit;
                $row->comment         = '';
                $combo_items          = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                }
                if ($qty) {
                    $row->qty           = $qty;
                    $row->base_quantity = $qty;
                } else {
                    $row->qty = ($bprice ? $bprice / $row->price : 1);
                }
                $units    = $this->app_model->getUnitByID($row->base_unit);
                $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);

                $pr[] = ['id' => sha1($c . $r), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'category' => $row->category_id,
                    'row'     => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
                $r++;
            }
            $this->sls->send_json($pr);
            
        } else {
            $this->sls->send_json([['id' => 0, 'label' => lang('no_match_found'), 'value' => $term]]);
        }
    }
    
    public function add_payment()
    {
        if($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $data['payments'] = $this->pos_model->getInvoicePayments($id);
        $data['inv']      = $this->pos_model->getInvoiceByID($id);
        $data['payment_ref'] = $this->app_model->getReference('pay');

        $isAdmin = $this->session->userdata('isAdmin');
        $data['Admin']       = $isAdmin;

        $this->load->view('sales/add_payment', $data);
    }

    public function savePayment($id = null)
    {

        $this->form_validation->set_rules('reference_no', lang('reference_no'), 'required');
        $this->form_validation->set_rules('amount-paid', lang('amount'), 'required');
        $this->form_validation->set_rules('paid_by', lang('paid_by'), 'required');
        
        if ($this->form_validation->run() == true) {
            $sale = $this->pos_model->getInvoiceByID($this->input->post('sale_id'));
            
            if ($Admin) {
                $date = $this->input->post('date');
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $payment = [
                'date'         => $date,
                'sale_id'      => $this->input->post('sale_id'),
                'reference_no' => $this->input->post('reference_no'),
                'amount'       => $this->input->post('amount-paid'),
                'paid_by'      => $this->input->post('paid_by'),
                'cheque_no'    => $this->input->post('cheque_no'),
                'cc_no'        => $this->input->post('paid_by') == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
                'cc_holder'    => $this->input->post('pcc_holder'),
                'cc_month'     => $this->input->post('pcc_month'),
                'cc_year'      => $this->input->post('pcc_year'),
                'cc_type'      => $this->input->post('pcc_type'),
                'cc_cvv2'      => $this->input->post('pcc_ccv'),
                'note'         => $this->input->post('note'),
                'created_by'   => $this->session->userdata('id'),
                'type'         => $sale->sale_status == 'returned' ? 'returned' : 'received',
            ];

            if($this->pos_model->addPayment($payment)) {
                $this->session->set_flashdata('message', lang('payment_added'));
                redirect('pos/sales');
            }
            
            //$this->sma->print_arrays($payment);
        }
    }

    public function view_payment($id = null)
    {
        $id = $this->input->get('id');
        // print_r($id); die;
        $data['payments'] = $this->pos_model->getInvoicePayments($id);
        $data['inv']      = $this->pos_model->getInvoiceByID($id);
        $this->load->view('sales/payments', $data);
    }

    public function updatePayment()
    {

        $this->form_validation->set_rules('reference_no', lang('reference_no'), 'required');
        $this->form_validation->set_rules('amount-paid', lang('amount'), 'required');
        $this->form_validation->set_rules('paid_by', lang('paid_by'), 'required');
        
        if ($this->form_validation->run() == true) {
            $sale = $this->pos_model->getInvoiceByID($this->input->post('sale_id'));
            
            if ($Admin) {
                $date = $this->input->post('date');
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $id = $this->input->post('id');
            $payment = [
                'date'         => $date,
                'sale_id'      => $this->input->post('sale_id'),
                'reference_no' => $this->input->post('reference_no'),
                'amount'       => $this->input->post('amount-paid'),
                'paid_by'      => $this->input->post('paid_by'),
                'cheque_no'    => $this->input->post('cheque_no'),
                'note'         => $this->input->post('note'),
                'created_by'   => $this->session->userdata('id'),
                'type'         => $sale->sale_status == 'returned' ? 'returned' : 'received',
            ];

            if($this->pos_model->updatePayment($id, $payment)) {
                $this->session->set_flashdata('message', lang('payment_added'));
                redirect('pos/sales');
            }
            
            //$this->sma->print_arrays($payment);
        }
    }
    
    public function edit_payment($id = null, $sale_id)
    {
        // print_r($id); print_r($sale_id); die;
        $data['payment'] = $this->pos_model->getPaymentByID($id);
        $data['inv']      = $this->pos_model->getInvoiceByID($sale_id);

        $isAdmin = $this->session->userdata('isAdmin');
        $data['Admin']       = $isAdmin;

        $this->load->view('sales/edit_payment', $data);
    }

    public function delete_payment($id = null)
    {

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if (!$id) {
            $this->sls->send_json(['error' => 1, 'msg' => lang('id_not_found')]);
        }

        if ($this->pos_model->deletePayment($id)) {
            $this->session->set_flashdata('message', lang('payment_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


}