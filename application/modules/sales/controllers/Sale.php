<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    //-------------------------------
    // Author: Ai Softz
    //-------------------------------    

class Sale extends MX_Controller {
 	
   	public function __construct()
   	{
   		parent::__construct();
   		// $this->load->model('settings_model'); 
   		$this->load->model('pos_model'); 
   		$this->load->model('sales_model'); 
   		$this->load->model('app_model'); 

  		if (! $this->session->userdata('isLogIn'))
  			redirect('login');

		$this->Settings = $this->app_model->get_setting();
        $this->pos_settings = $this->app_model->getPosSetting();		
   	}

    function index() 
    {
        $data['title']             = 'Sales List';
        $data['module']            = "sales";
        $data['page']              = "sales/sales_list"; 

        echo modules::run('template/layout', $data);
    }

    public function getSales()
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
            $records = $this->sales_model->getSales($_POST['length'], $_POST['start'], $_POST['order'], $q);
            $totalData = sizeof($records); 
            // print_r($records); die;
        }else{
            
            $records = $this->sales_model->getSales($_POST['length'], $_POST['start'], $_POST['order']);
            
            $totalData = $this->sales_model->getSalesTotal()->total_sale;
        }
        // echo '<pre>'; print_r($records); echo '<br> total'; print_r($_POST['search']['value']); die;
        $i = 0;
        if (isset($records) && count($records) > 0) {
            foreach ($records as $key => $value) {
                $i++;
                // $detail_link       = anchor("pos/view_receipt/".$value->id, '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
                $detail_link       = anchor("sales/view/".$value->id,
                '<i class="fa fa-pencil" aria-hidden="true"></i> '. lang('sale_detail'), array('class'=>'btn-sm', 'title'=>'View'));
                $edit_link         = anchor('sales/edit/'.$value->id, '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
                $payment_link = '<a href="#" class="add_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('add_payment') .'</a>';
                $view_payments_link = '<a href="#" class="view_payment" data-id="'. $value->id . '"> <i class="fa fa-money"> </i> '. lang('view_payment') .'</a>';
                $pdf_link       = anchor('sales/sale/pdf_sale/'.$value->id, '<i class="fa fa-download"></i> ' . lang('pdf_download'));
                $return_link       = anchor('sales/return_sale/'.$value->id, '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
                $delete_link = ' ' . anchor("sales/delete/".$value->id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete Sale',
                    array('class'=>'', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
                $action = '<div class="text-center"><div class="btn-group text-left">'
                    . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                    . lang('actions') . ' </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        
                        <li>' . $detail_link . '</li>
                        <li>' . $edit_link . '</li>
                        <li>' . $return_link . '</li>
                        <li>' . $payment_link . '</li>
                        <li>' . $view_payments_link . '</li>
                        <li>' . $pdf_link . '</li>
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
                $edit .= ' ' . anchor("sale/edit/".$value->id,
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

    function add() 
    {
            // echo '<pre>';    print_r($_POST); die;
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('biller', lang('biller'), 'required');
        $this->form_validation->set_rules('sale_status', lang('sale_status'), 'required');
        if ($this->form_validation->run() == true) {
            //validate form input
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->app_model->getReference('so');
            // echo '<pre>';   print_r($this->input->post()); die;
            $suspend           = $this->input->post('suspend') ? true : false;

            if ($Admin) {
                $date = date('Y-m-d H:i:s', strtotime($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
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
                'reference_no'      => $reference,
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
                'payment_status'    => $this->input->post('payment_status'),
                'payment_term'      => $payment_term,
                'rounding'          => $rounding,
                'suspend_note'      => $this->input->post('suspend_note'),
                // 'pos'               => 0,
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
                    $this->session->set_userdata('remove_slls', 1);
                    $this->session->set_flashdata('message', $this->lang->line('sale_suspended'));
                    redirect('sales');
                }
            } else {
                if ($sale = $this->sales_model->addSale($data, $products, $payment, $did)) {
                    $this->session->set_userdata('remove_slls', 1);
                    
                    $this->session->set_flashdata('message', lang('sale_added'));
                    
                    redirect('sales');
                } else {
                    $this->session->set_flashdata('message', lang('sale_not_added'));
                    redirect('sales');
                }
            }
            // echo '<pre>'; print_r($payment); die;

        } else {
            $data['title']             = 'Pos Sales List';
            $data['module']            = "sales";
            $data['page']              = "sales/add"; 
            $data['Settings'] =  $this->Settings;
            $data['billers']       = $this->app_model->getAllBillers();
            $data['warehouses'] =  $this->app_model->getAllWarehouses();
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);
            $data['tax_rates']     = $this->app_model->getAllTaxRates();
            $data['units']     = $this->app_model->getUnits();

            echo modules::run('template/layout', $data);
        }
    }

    function edit($id = null) 
       {
            // echo '<pre>';    print_r($_POST); die;
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('biller', lang('biller'), 'required');
        $this->form_validation->set_rules('sale_status', lang('sale_status'), 'required');
        if ($this->form_validation->run() == true) {
            //validate form input
            // $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->app_model->getReference('so');
            // echo '<pre>';   print_r($this->input->post()); die;
            $suspend           = $this->input->post('suspend') ? true : false;

            if ($Admin) {
                $date = date('Y-m-d H:i:s', strtotime($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
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
                // 'reference_no'      => $reference,
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
                'payment_status'    => $this->input->post('payment_status'),
                'payment_term'      => $payment_term,
                'rounding'          => $rounding,
                'suspend_note'      => $this->input->post('suspend_note'),
                // 'pos'               => 0,
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
// echo '<pre>'; echo $id; print_r($products); print_r($data); print_r($payment); die;
            if ($suspend) {
                if ($this->sales_model->suspendSale($data, $products, $did)) {
                    $this->session->set_userdata('remove_slls', 1);
                    $this->session->set_flashdata('message', $this->lang->line('sale_suspended'));
                    redirect('sales');
                }
            } else {
                if ($sale = $this->sales_model->updateSale($id, $data, $products, $payment, $did)) {
                    $this->session->set_userdata('remove_slls', 1);
                    
                    $this->session->set_flashdata('message', lang('sale_added'));
                    
                    redirect('sales');
                } else {
                    $this->session->set_flashdata('message', lang('sale_not_added'));
                    redirect('sales');
                }
            }
            // echo '<pre>'; print_r($payment); die;

        } else {

            $data['inv'] = $this->sales_model->getInvoiceByID($id);
            if ($this->Settings->disable_editing) {
                if ($this->data['inv']->date <= date('Y-m-d', strtotime('-' . $this->Settings->disable_editing . ' days'))) {
                    $this->session->set_flashdata('error', sprintf(lang('sale_x_edited_older_than_x_days'), $this->Settings->disable_editing));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            $inv_items = $this->sales_model->getAllInvoiceItems($id);
            // echo '<pre>'; print_r($data['inv']);
            // print_r($inv_items); die;
            // krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                // $row = $this->site->getProductByID($item->product_id);
                $row = $this->sales_model->getWarehouseProduct($item->product_id, $item->warehouse_id);
                if (!$row) {
                    $row             = json_decode('{}');
                    $row->tax_method = 0;
                    $row->quantity   = 0;
                } else {
                    unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                }
                $pis = $this->app_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if ($pis) {
                    $row->quantity = 0;
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->id              = $item->product_id;
                $row->code            = $item->product_code;
                $row->name            = $item->product_name;
                $row->type            = $item->product_type;
                $row->base_quantity   = $item->quantity;
                $row->base_unit       = !empty($row->unit) ? $row->unit : $item->product_unit_id;
                $row->base_unit_price = !empty($row->price) ? $row->price : $item->unit_price;
                $row->unit            = $item->product_unit_id;
                $row->qty             = $item->unit_quantity;
                $row->quantity += $item->quantity;
                $row->discount        = $item->discount ? $item->discount : '0';
                $row->item_tax        = $item->item_tax      > 0 ? $item->item_tax      / $item->quantity : 0;
                $row->item_discount   = $item->item_discount > 0 ? $item->item_discount / $item->quantity : 0;
                $row->price           = $this->sls->formatDecimal($item->net_unit_price + $this->sls->formatDecimal($row->item_discount));
                $row->unit_price      = $row->tax_method ? $item->unit_price + $this->sls->formatDecimal($row->item_discount) + $this->sls->formatDecimal($row->item_tax) : $item->unit_price + ($row->item_discount);
                $row->real_unit_price = $item->real_unit_price;
                $row->tax_rate        = $item->tax_rate_id;
                $row->serial          = $item->serial_no;
                $row->option          = $item->option_id;
                $options              = $this->sales_model->getProductOptions($row->id, $item->warehouse_id, true);
                if ($options) {
                    foreach ($options as $option) {
                        $pis = $this->app_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                        if ($pis) {
                            $option->quantity = 0;
                            foreach ($pis as $pi) {
                                $option->quantity += $pi->quantity_balance;
                            }
                        }
                        if ($row->option == $option->id) {
                            $option->quantity += $item->quantity;
                        }
                    }
                }

                $combo_items = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    $te          = $combo_items;
                    foreach ($combo_items as $combo_item) {
                        $combo_item->quantity = $combo_item->qty * $item->quantity;
                    }
                }
                $units    = !empty($row->base_unit) ? $this->app_model->getUnitByID($row->base_unit) : null;
                $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);
                $ri       = $this->Settings->item_addition ? $row->id : $c;

                $pr[$ri] = ['id' => $c, 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')',
                    'row'        => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
                $c++;
            }

            $data['inv_items'] = json_encode($pr);

            // echo '<pre>'; print_r($data['inv']);
            // print_r($data['inv_items']); die;
            $data['id']        = $id;

            $data['Settings'] =  $this->Settings;
            $data['billers']       = $this->app_model->getAllBillers();
            $data['warehouses'] =  $this->app_model->getAllWarehouses();
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);
            $data['tax_rates']     = $this->app_model->getAllTaxRates();

            $data['title']             = 'Sales Edit';
            $data['module']            = "sales";
            $data['page']              = "sales/edit"; 

            echo modules::run('template/layout', $data);
        }
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

        $html = $this->load->view('sales/sales/pdf_sale', $data, true);
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
            'print_view' => $this->load->view('sales/sales/print_sale', $data, true)
        );

        header('Content-Type: application/json');
        die(json_encode($print_data));
        exit;

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
        $strict    = $analyzed['strict']                    ?? false;
        $qty       = $strict ? null : $analyzed['quantity'] ?? null;
        $bprice    = $strict ? null : $analyzed['price']    ?? null;

        $warehouse      = $this->app_model->getWarehouseByID($warehouse_id);
        $customer       = $this->app_model->getCustomerByID($customer_id);
        // $customer_group = $this->app_model->getCustomerGroupByID($customer->customer_group_id);
        $rows           = $this->sales_model->getProductNames($sr, $warehouse_id, $pos);
        if ($rows) {
            $r = 0;
            foreach ($rows as $row) {
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
                $options              = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $option_id && $r == 0 ? $this->sales_model->getProductOptionByID($option_id) : $options[0];
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
                if ($customer->price_group_id) {
                    if ($pr_group_price = $this->app_model->getProductGroupPrice($row->id, $customer->price_group_id)) {
                        $row->price = $pr_group_price->price;
                    }
                } elseif ($warehouse->price_group_id) {
                    if ($pr_group_price = $this->app_model->getProductGroupPrice($row->id, $warehouse->price_group_id)) {
                        $row->price = $pr_group_price->price;
                    }
                }
                // if ($customer_group->discount && $customer_group->percent < 0) {
                //     $row->discount = (0 - $customer_group->percent) . '%';
                // } else {
                //     $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                // }
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
                $units    = $this->app_model->getUnits();
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

    /* ------------------------------- */

    public function delete($id = null)
    {

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if (!$id) {
            $this->sls->send_json(['error' => 1, 'msg' => lang('id_not_found')]);
        }

        $inv = $this->sales_model->getInvoiceByID($id);
        if ($inv->sale_status == 'returned') {
            $this->sls->send_json(['error' => 1, 'msg' => lang('sale_x_action')]);
        }

        if ($this->sales_model->deleteSale($id)) {
            if ($this->input->is_ajax_request()) {
                $this->sls->send_json(['error' => 0, 'msg' => lang('sale_deleted')]);
            }
            $this->session->set_flashdata('message', lang('sale_deleted'));
            redirect('sales');
        }
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
         $data['title']      = "Sale Detail";
         $data['module']      = "sales";
         $data['page']        = "sales/view";

         echo Modules::run('template/layout', $data); 
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
        
         $this->load->view('sales/sales/modal_view', $data);
    }

    public function view_payment($id = null)
    {
        $id = $this->input->get('id');
        $data['payments'] = $this->sales_model->getInvoicePayments($id);
        $data['inv']      = $this->sales_model->getInvoiceByID($id);
        $this->load->view('sales/sales/payments', $data);
    }

    public function delete_payment($id = null)
    {

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if (!$id) {
            $this->sls->send_json(['error' => 1, 'msg' => lang('id_not_found')]);
        }

        if ($this->sales_model->deletePayment($id)) {
            $this->session->set_flashdata('message', lang('payment_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function add_payment()
    {
        if($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $data['payments'] = $this->sales_model->getInvoicePayments($id);
        $data['inv']      = $this->sales_model->getInvoiceByID($id);
        $data['payment_ref'] = $this->app_model->getReference('pay');

        $isAdmin = $this->session->userdata('isAdmin');
        $data['Admin']       = $isAdmin;

        $this->load->view('sales/sales/add_payment2', $data);
    }

    public function savePayment($id = null)
    {

        $this->form_validation->set_rules('reference_no', lang('reference_no'), 'required');
        $this->form_validation->set_rules('amount-paid', lang('amount'), 'required');
        $this->form_validation->set_rules('paid_by', lang('paid_by'), 'required');
        
        if ($this->form_validation->run() == true) {
            $sale = $this->sales_model->getInvoiceByID($this->input->post('sale_id'));
            
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
                'note'         => $this->input->post('note'),
                'created_by'   => $this->session->userdata('id'),
                'type'         => $sale->sale_status == 'returned' ? 'returned' : 'received',
            ];

            if($this->sales_model->addPayment($payment)) {
                $this->session->set_flashdata('message', lang('payment_added'));
                redirect('sales');
            }
            
            //$this->sma->print_arrays($payment);
        }
    }
    public function updatePayment()
    {

        $this->form_validation->set_rules('reference_no', lang('reference_no'), 'required');
        $this->form_validation->set_rules('amount-paid', lang('amount'), 'required');
        $this->form_validation->set_rules('paid_by', lang('paid_by'), 'required');
        
        if ($this->form_validation->run() == true) {
            $sale = $this->sales_model->getInvoiceByID($this->input->post('sale_id'));
            
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

            if($this->sales_model->updatePayment($id, $payment)) {
                $this->session->set_flashdata('message', lang('payment_added'));
                redirect('sales');
            }
            
            //$this->sma->print_arrays($payment);
        }
    }
    
    public function edit_payment($id = null, $sale_id)
    {
        // print_r($id); print_r($sale_id); die;
        $data['payment'] = $this->sales_model->getPaymentByID($id);
        $data['inv']      = $this->sales_model->getInvoiceByID($sale_id);

        $isAdmin = $this->session->userdata('isAdmin');
        $data['Admin']       = $isAdmin;

        $this->load->view('sales/sales/edit_payment2', $data);
    }

    function return_sale($id = null) 
       {
            // echo '<pre>';    print_r($_POST); die;
        $sale = $this->sales_model->getInvoiceByID($id);
        if ($sale->return_id || $sale->sale_status == 'returned') {
            $this->session->set_flashdata('exception', lang('sale_already_returned'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('biller', lang('biller'), 'required');
        $this->form_validation->set_rules('sale_status', lang('sale_status'), 'required');
        if ($this->form_validation->run() == true) {
            //validate form input
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->app_model->getReference('re');
            // echo '<pre>';   print_r($this->input->post()); die;
            $suspend           = $this->input->post('suspend') ? true : false;

            if ($Admin) {
                $date = date('Y-m-d H:i:s', strtotime($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
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
                $sale_item_id       = $_POST['sale_item_id'][$r];
                $item_comment       = $_POST['product_comment'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sls->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sls->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = (0 - $_POST['quantity'][$r]);
                $item_serial        = $_POST['serial'][$r]           ?? '';
                $item_tax_rate      = $_POST['product_tax'][$r]      ?? null;
                $item_discount      = $_POST['product_discount'][$r] ?? null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = (0 - $_POST['product_base_quantity'][$r]);

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
                        'sale_item_id'      => $sale_item_id,
                    ];
                    $si_return[] = [
                        'id'           => $sale_item_id,
                        'sale_id'      => $id,
                        'product_id'   => $item_id,
                        'option_id'    => $item_option,
                        'quantity'     => (0 - $item_quantity),
                        'warehouse_id' => $sale->warehouse_id,
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
                'reference_no'      => $reference,
                'sale_id'           => $id,
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
                'sale_status'       => 'returned',
                'payment_status'    => $this->input->post('payment_status'),
                'payment_term'      => $payment_term,
                'rounding'          => $rounding,
                'suspend_note'      => $this->input->post('suspend_note'),
                'pos'               => $this->input->post('pos'),
                'paid'              => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,
                'created_by'        => $this->session->userdata('id'),
                'hash'              => hash('sha256', microtime() . mt_rand()),
                'customer_type'        => $this->input->post('is_dine_in') ? $this->input->post('is_dine_in'):1,
                'return_sale_ref'   => $reference,
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
                            'amount'      => (0 - $amount),
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
// echo '<pre>'; echo $id; print_r($products); print_r($data); print_r($si_return); die;
            if ($suspend) {
                if ($this->pos_model->suspendSale($data, $products, $did)) {
                    $this->session->set_userdata('remove_slls', 1);
                    $this->session->set_flashdata('message', $this->lang->line('sale_suspended'));
                    redirect('sales');
                }
            } else {
                if ($sale = $this->sales_model->addSale($data, $products, $payment, $si_return, $did)) {
                    $this->session->set_userdata('remove_slls', 1);
                    
                    $this->session->set_flashdata('message', lang('sale_added'));
                    if($data['pos'] == 1) {
                        redirect('pos/sales');
                    } else {
                        redirect('sales');
                    }
                    
                } else {
                    $this->session->set_flashdata('message', lang('sale_not_added'));
                    if($data['pos'] == 1) {
                        redirect('pos/sales');
                    } else {
                        redirect('sales');
                    }
                }
            }
            // echo '<pre>'; print_r($payment); die;

        } else {

            $data['inv'] = $this->sales_model->getInvoiceByID($id);
            if ($this->Settings->disable_editing) {
                if ($this->data['inv']->date <= date('Y-m-d', strtotime('-' . $this->Settings->disable_editing . ' days'))) {
                    $this->session->set_flashdata('error', sprintf(lang('sale_x_edited_older_than_x_days'), $this->Settings->disable_editing));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            $inv_items = $this->sales_model->getAllInvoiceItems($id);
            // echo '<pre>'; print_r($data['inv']);
            // print_r($inv_items); die;
            // krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                // $row = $this->site->getProductByID($item->product_id);
                $row = $this->sales_model->getWarehouseProduct($item->product_id, $item->warehouse_id);
                if (!$row) {
                    $row             = json_decode('{}');
                    $row->tax_method = 0;
                    $row->quantity   = 0;
                } else {
                    unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                }
                $pis = $this->app_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if ($pis) {
                    $row->quantity = 0;
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->id              = $item->product_id;
                $row->code            = $item->product_code;
                $row->name            = $item->product_name;
                $row->type            = $item->product_type;
                $row->base_quantity   = $item->quantity;
                $row->base_unit       = !empty($row->unit) ? $row->unit : $item->product_unit_id;
                $row->base_unit_price = !empty($row->price) ? $row->price : $item->unit_price;
                $row->unit            = $item->product_unit_id;
                $row->qty             = $item->unit_quantity;
                $row->quantity += $item->quantity;
                $row->discount        = $item->discount ? $item->discount : '0';
                $row->item_tax        = $item->item_tax      > 0 ? $item->item_tax      / $item->quantity : 0;
                $row->item_discount   = $item->item_discount > 0 ? $item->item_discount / $item->quantity : 0;
                $row->price           = $this->sls->formatDecimal($item->net_unit_price + $this->sls->formatDecimal($row->item_discount));
                $row->unit_price      = $row->tax_method ? $item->unit_price + $this->sls->formatDecimal($row->item_discount) + $this->sls->formatDecimal($row->item_tax) : $item->unit_price + ($row->item_discount);
                $row->real_unit_price = $item->real_unit_price;
                $row->tax_rate        = $item->tax_rate_id;
                $row->serial          = $item->serial_no;
                $row->option          = $item->option_id;
                $options              = $this->sales_model->getProductOptions($row->id, $item->warehouse_id, true);
                if ($options) {
                    foreach ($options as $option) {
                        $pis = $this->app_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                        if ($pis) {
                            $option->quantity = 0;
                            foreach ($pis as $pi) {
                                $option->quantity += $pi->quantity_balance;
                            }
                        }
                        if ($row->option == $option->id) {
                            $option->quantity += $item->quantity;
                        }
                    }
                }

                $combo_items = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    $te          = $combo_items;
                    foreach ($combo_items as $combo_item) {
                        $combo_item->quantity = $combo_item->qty * $item->quantity;
                    }
                }
                $units    = !empty($row->base_unit) ? $this->app_model->getUnitByID($row->base_unit) : null;
                $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);
                $ri       = $this->Settings->item_addition ? $row->id : $c;

                $pr[$ri] = ['id' => $c, 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')',
                    'row'        => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
                $c++;
            }

            $data['inv_items'] = json_encode($pr);

            // echo '<pre>'; print_r($data['inv']);
            // print_r($data['inv_items']); die;
            $data['id']        = $id;

            $data['Settings'] =  $this->Settings;
            $data['billers']       = $this->app_model->getAllBillers();
            $data['warehouses'] =  $this->app_model->getAllWarehouses();
            $data['customers']  = $this->app_model->getAllCustomers($cus_id);
            $data['tax_rates']     = $this->app_model->getAllTaxRates();

            $data['title']             = 'Sales Return';
            $data['module']            = "sales";
            $data['page']              = "sales/return_sale"; 

            echo modules::run('template/layout', $data);
        }
    }

    public function return_sale_form($warehouse_id = null)
    {
        //$this->sma->checkPermissions();
        $this->data['error'] = '';
        if($this->input->post('return_sale_barcode')) 
        {
            $reference_no = $this->input->post('reference_no');
            $sale = $this->db->where('reference_no', $reference_no)->get('sales')->row();
            // print_r($sale); die;
            redirect('sales/return_sale_barcode/'.$sale->id);
        } else if($this->input->post('return_sale')) {
            $reference_no = $this->input->post('reference_no');
            $sale = $this->db->where('reference_no', $reference_no)->get('sales')->row();
            redirect('sales/return_sale/'.$sale->id);
        } else {
            $this->session->flashdata('error');
        }
        
        $data['title']             = 'Sales Return';
        $data['module']            = "sales";
        $data['page']              = "sales/return_sale_form"; 

        echo modules::run('template/layout', $data);
    }

    public function return_sale_barcode($id = null)
    {

        // if ($this->input->get('id')) {
        //     $id = $this->input->get('id');
        // }
        // print_r($id); die;
        $sale = $this->sales_model->getInvoiceByID($id);
        
        if ($sale->return_id) {
            $this->session->set_flashdata('error', lang('sale_already_returned'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->form_validation->set_rules('return_surcharge', lang('return_surcharge'), 'required');

        if ($this->form_validation->run() == true) {
            // echo '<pre>';print_r($this->input->post()); die;
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->app_model->getReference('re');
            if ($this->Owner || $this->Admin) {
                $date = $this->input->post('date');
            } else {
                $date = date('Y-m-d H:i:s');
            }

            $return_surcharge = $this->input->post('return_surcharge') ? $this->input->post('return_surcharge') : 0;
            $shipping         = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $note             = $this->input->post('note');
            $customer_details = $this->app_model->getCustomerByID($sale->customer_id);
            $biller_details   = $this->app_model->getBillerByID($sale->biller_id);

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $gst_data         = [];
            $total_cgst       = $total_sgst       = $total_igst       = 0;
            $i                = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_type          = $_POST['product_type'][$r];
                $item_code          = $_POST['product_code'][$r];
                $item_name          = $_POST['product_name'][$r];
                $sale_item_id       = $_POST['sale_item_id'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' && $_POST['product_option'][$r] != 'null' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sls->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sls->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = (0 - $_POST['quantity'][$r]);
                $item_serial        = $_POST['serial'][$r]           ?? '';
                $item_tax_rate      = $_POST['product_tax'][$r]      ?? null;
                $item_discount      = $_POST['product_discount'][$r] ?? null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = (0 - $_POST['product_base_quantity'][$r]);

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->sales_model->getProductByCode($item_code) : null;
                    // $unit_price = $real_unit_price;
                    $pr_discount      = $this->app_model->calculateDiscount($item_discount, $unit_price);
                    $unit_price       = $this->sls->formatDecimal(($unit_price - $pr_discount), 4);
                    $item_net_price   = $unit_price;
                    $pr_item_discount = $this->sls->formatDecimal($pr_discount * $item_unit_quantity, 4);
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
                    $subtotal = $this->sls->formatDecimal((($item_net_price * $item_unit_quantity) + $pr_item_tax), 4);
                    $unit     = $item_unit ? $this->app_model->getUnitByID($item_unit) : false;

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'product_type'      => $item_type,
                        'option_id'         => $item_option,
                        'net_unit_price'    => $item_net_price,
                        'unit_price'        => $this->sls->formatDecimal($item_net_price + $item_tax),
                        'quantity'          => $item_quantity,
                        'product_unit_id'   => $item_unit,
                        'product_unit_code' => $unit ? $unit->code : null,
                        'unit_quantity'     => $item_unit_quantity,
                        'warehouse_id'      => $sale->warehouse_id,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->sls->formatDecimal($subtotal),
                        'serial_no'         => $item_serial,
                        'real_unit_price'   => $real_unit_price,
                        'sale_item_id'      => $sale_item_id,
                    ];

                    $si_return[] = [
                        'id'           => $sale_item_id,
                        'sale_id'      => $id,
                        'product_id'   => $item_id,
                        'option_id'    => $item_option,
                        'quantity'     => (0 - $item_quantity),
                        'warehouse_id' => $sale->warehouse_id,
                    ];

                    $products[] = ($product + $gst_data);
                    $total += $this->sls->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } else {
                krsort($products);
            }

            $order_discount = (0 - $this->app_model->calculateDiscount($this->input->post('order_discount'), ($total + $product_tax)));
            $total_discount = $this->sls->formatDecimal(($order_discount + $product_discount), 4);
            $order_tax      = $this->app_model->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->sls->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total    = $this->sls->formatDecimal(($this->sls->formatDecimal($total) + $this->sls->formatDecimal($total_tax) + $this->sls->formatDecimal($return_surcharge) + (0 - $shipping) - $this->sls->formatDecimal($order_discount)), 4);
            $data           = [
                'date'              => $date,
                'sale_id'           => $id,
                'reference_no'      => $sale->reference_no,
                'customer_id'       => $sale->customer_id,
                'customer'          => $sale->customer,
                'biller_id'         => $sale->biller_id,
                'biller'            => $sale->biller,
                'warehouse_id'      => $sale->warehouse_id,
                'note'              => $note,
                'total'             => $total,
                'product_discount'  => $product_discount,
                'order_discount_id' => $this->input->post('discount') ? $this->input->post('order_discount') : null,
                'order_discount'    => $order_discount,
                'total_discount'    => $total_discount,
                'product_tax'       => $product_tax,
                'order_tax_id'      => $this->input->post('order_tax'),
                'order_tax'         => $order_tax,
                'total_tax'         => $total_tax,
                'surcharge'         => $this->sls->formatDecimal($return_surcharge),
                'grand_total'       => $grand_total,
                'created_by'        => $this->session->userdata('user_id'),
                'return_sale_ref'   => $reference,
                'shipping'          => $shipping,
                'sale_status'       => 'returned',
                'pos'               => $sale->pos,
                'payment_status'    => $sale->payment_status == 'paid' ? 'due' : 'pending',
            ];
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            if ($this->input->post('amount-paid') && $this->input->post('amount-paid') > 0) {
                $pay_ref = $this->input->post('payment_reference_no') ? $this->input->post('payment_reference_no') : $this->app_model->getReference('pay');
                $payment = [
                    'date'         => $date,
                    'reference_no' => $pay_ref,
                    'amount'       => (0 - $this->input->post('amount-paid')),
                    'paid_by'      => $this->input->post('paid_by'),
                    'cheque_no'    => $this->input->post('cheque_no'),
                    'cc_no'        => $this->input->post('pcc_no'),
                    'cc_holder'    => $this->input->post('pcc_holder'),
                    'cc_month'     => $this->input->post('pcc_month'),
                    'cc_year'      => $this->input->post('pcc_year'),
                    'cc_type'      => $this->input->post('pcc_type'),
                    'created_by'   => $this->session->userdata('user_id'),
                    'type'         => 'returned',
                ];
                $data['payment_status'] = $grand_total == $this->input->post('amount-paid') ? 'paid' : 'partial';
            } else {
                $payment = [];
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path']   = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size']      = $this->allowed_file_size;
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $photo              = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

            // $this->sma->print_arrays($data, $products, $si_return, $payment);
        }

        if ($this->form_validation->run() == true && $this->sales_model->addSale($data, $products, $payment, $si_return)) {
            $this->session->set_flashdata('message', lang('return_sale_added'));
            redirect($sale->pos ? 'pos/sales' : 'sales');
        } else {
            $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $data['inv'] = $sale;
            if ($data['inv']->sale_status != 'completed') {
                $this->session->set_flashdata('error', lang('sale_status_x_competed'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            if ($this->Settings->disable_editing) {
                if ($data['inv']->date <= date('Y-m-d', strtotime('-' . $this->Settings->disable_editing . ' days'))) {
                    $this->session->set_flashdata('error', sprintf(lang('sale_x_edited_older_than_x_days'), $this->Settings->disable_editing));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            $inv_items = $this->sales_model->getAllInvoiceItems($id);
            // krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->app_model->getProductByID($item->product_id);
                if (!$row) {
                    $row             = json_decode('{}');
                    $row->tax_method = 0;
                    $row->quantity   = 0;
                } else {
                    unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                }
                $pis = $this->app_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if ($pis) {
                    $row->quantity = 0;
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->id              = $item->product_id;
                $row->sale_item_id    = $item->id;
                $row->code            = $item->product_code;
                $row->name            = $item->product_name;
                $row->type            = $item->product_type;
                $row->unit            = $item->product_unit_id;
                $row->qty             = $item->unit_quantity;
                $row->oqty            = $item->unit_quantity;
                $row->discount        = $item->discount ? $item->discount : '0';
                $row->item_tax        = $item->item_tax      > 0 ? $item->item_tax      / $item->quantity : 0;
                $row->item_discount   = $item->item_discount > 0 ? $item->item_discount / $item->quantity : 0;
                $row->price           = $this->sls->formatDecimal($item->net_unit_price + $this->sls->formatDecimal($item->item_discount / $item->unit_quantity));
                $row->unit_price      = $row->tax_method ? $item->unit_price + $this->sls->formatDecimal($item->item_discount / $item->unit_quantity) - $this->sls->formatDecimal($item->item_tax / $item->unit_quantity) : $item->unit_price + ($item->item_discount / $item->unit_quantity);
                $row->real_unit_price = $item->real_unit_price;
                $row->base_quantity   = $item->quantity;
                $row->base_unit       = isset($row->unit) ? $row->unit : $item->product_unit_id;
                $row->base_unit_price = isset($row->unit_price) ? $row->unit_price : $item->unit_price;
                $row->tax_rate        = $item->tax_rate_id;
                $row->serial          = $item->serial_no;
                $row->option          = $item->option_id;
                $options              = $this->sales_model->getProductOptions($row->id, $item->warehouse_id, true);
                $units                = $this->app_model->getUnitByID($row->base_unit);
                $tax_rate             = $this->app_model->getTaxRateByID($row->tax_rate);
                $ri                   = $this->Settings->item_addition ? $row->id : $c;

                $pr[$ri] = ['id' => $c, 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'row' => $row, 'units' => $units, 'tax_rate' => $tax_rate, 'options' => $options];
                $c++;
            }
            $data['inv_items']   = json_encode($pr);
            $data['id']          = $id;
            $data['payment_ref'] = '';
            $data['reference']   = ''; // $this->site->getReference('re');
            $data['tax_rates']   = $this->app_model->getAllTaxRates();
            $data['Settings'] =  $this->Settings;

            $data['title']             = 'Sales Return';
            $data['module']            = "sales";
            $data['page']              = "sales/return_sale_barcode"; 

            echo modules::run('template/layout', $data);
        }
    }

    public function suggestions_return()
    {
        $term        = $this->input->get('term', true);
        $supplier_id = $this->input->get('supplier_id', true);
        $return_id = $this->input->get('return_id', true);
// print_r($this->input->get('return_id')); die;
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . admin_url('welcome') . "'; }, 10);</script>");
        }

        $analyzed  = $this->sls->analyze_term($term);
        $sr        = $analyzed['term'];
        $option_id = $analyzed['option_id'];
        $sr        = addslashes($sr);
        $qty       = $analyzed['quantity'] ?? null;
        $bprice    = $analyzed['price']    ?? null;

        $rows = $this->sales_model->getProductNamesReturn($sr, $return_id);
        // echo '<pre>';print_r($rows); die;
        if ($rows) {
            $r = 0;
            foreach ($rows as $row) {
                if($row->is_packed =='1'){
                    $row->child_product=$this->getChildProduct($row->packed_product, $supplier_id, $term, $r, $row->pack_piece);
                }
                $c                    = uniqid(mt_rand(), true);
                $option               = false;
                $row->item_tax_method = $row->tax_method;
                $options              = $this->sales_model->getProductOptions($row->id);
                if ($options) {
                    $opt = $option_id && $r == 0 ? $this->sales_model->getProductOptionByID($option_id) : current($options);
                    if (!$option_id || $r > 0) {
                        $option_id = $opt->id;
                    }
                } else {
                    $opt       = json_decode('{}');
                    $opt->cost = 0;
                    $option_id = false;
                }
                $row->option           = $option_id;
                $row->supplier_part_no = '';
                if ($row->supplier1 == $supplier_id) {
                    $row->supplier_part_no = $row->supplier1_part_no;
                } elseif ($row->supplier2 == $supplier_id) {
                    $row->supplier_part_no = $row->supplier2_part_no;
                } elseif ($row->supplier3 == $supplier_id) {
                    $row->supplier_part_no = $row->supplier3_part_no;
                } elseif ($row->supplier4 == $supplier_id) {
                    $row->supplier_part_no = $row->supplier4_part_no;
                } elseif ($row->supplier5 == $supplier_id) {
                    $row->supplier_part_no = $row->supplier5_part_no;
                }
                if ($opt->cost != 0) {
                    $row->cost = $opt->cost;
                }
                $row->cost             = $supplier_id ? $this->getSupplierCost($supplier_id, $row) : $row->cost;
                $row->real_unit_cost   = $row->cost;
                $row->base_quantity    = $row->quantity;
                $row->base_unit        = $row->unit;
                $row->base_unit_cost   = $row->cost;
                $row->base_unit_price = $row->price;
                $row->unit             = $row->purchase_unit ? $row->purchase_unit : $row->unit;
                $row->new_entry        = $row->quantity;
                $row->expiry           = '';
                $row->qty              = $row->quantity;
                $row->oqty              = $row->quantity;
                $row->sale_item_id     = $row->sale_item_id;
                $row->quantity_balance = '';
                $row->discount         = '0';
                unset($row->details, $row->product_details, $row->price, $row->file, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                $row->qty = $qty ? $qty : ($bprice ? $bprice / $row->cost : 1);

                $units    = $this->app_model->getUnitByID($row->base_unit);
                $tax_rate = $this->app_model->getTaxRateByID($row->tax_rate);

                if ($row->purchase_unit) {
                    foreach ($units as $unit) {
                        if ($unit->id == $row->purchase_unit) {
                            $row->real_unit_cost = $this->app_model->convertToUnit($unit, $row->cost);
                        }
                    }
                }

                $pr[] = ['id' => sha1($c . $r), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')',
                    'row'     => $row, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
                $r++;
            }
            $this->sls->send_json($pr);
        } else {
            $this->sls->send_json([['id' => 0, 'label' => lang('no_match_found'), 'value' => $term]]);
        }
    }

    public function getChildProduct($id, $warehouse_id, $customer_id, $term, $r, $pack_piece)
    {

        $analyzed  = $this->sls->analyze_term($term);
        $sr        = $analyzed['term'];
        $option_id = $analyzed['option_id'];
        $sr        = addslashes($sr);
        $qty       = $analyzed['quantity'] ?? null;
        $bprice    = $analyzed['price']    ?? null;

        $warehouse      = $this->site->getWarehouseByID($warehouse_id);
        $customer       = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);

        $row=$this->site->getProductByID($id);
        $c                    = uniqid(mt_rand(), true);
        unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
        $option               = false;
        $row->quantity        = 0;
        $row->item_tax_method = $row->tax_method;

        $row->discount        = '0';
        $row->serial          = '';
        $options              = $this->sales_model->getProductOptions($row->id, $warehouse_id);
        if ($options) {
            $opt = $option_id && $r == 0 ? $this->sales_model->getProductOptionByID($option_id) : $options[0];
            if (!$option_id || $r > 0) {
                $option_id = $opt->id;
            }
        } else {
            $opt        = json_decode('{}');
            $opt->price = 0;
            $option_id  = false;
        }
        $row->option = $option_id;
        $pis         = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
        if ($pis) {
            $row->quantity = 0;
            foreach ($pis as $pi) {
                $row->quantity += $pi->quantity_balance;
            }
        }
        if ($options) {
            $option_quantity = 0;
            foreach ($options as $option) {
                $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
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
        if ($this->sma->isPromo($row)) {
            $row->price = $row->promo_price;
        } elseif ($customer->price_group_id) {
            if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $customer->price_group_id)) {
                $row->price = $pr_group_price->price;
            }
        } elseif ($warehouse->price_group_id) {
            if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $warehouse->price_group_id)) {
                $row->price = $pr_group_price->price;
            }
        }
        if ($customer_group->discount && $customer_group->percent < 0) {
            $row->discount = (0 - $customer_group->percent) . '%';
        } else {
            $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
        }
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
        $row->qty = $qty ? $qty : ($bprice ? $bprice / $row->price : 1);
        $row->qty             = $pack_piece;
        $units    = $this->site->getUnitsByBUID($row->base_unit);
        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

        return ['id' => sha1($c . $r), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'category' => $row->category_id,
            'row'     => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
    }

}