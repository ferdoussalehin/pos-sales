<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 #------------------------------------      

class Product extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
  
        $this->load->model(array(
            'product_model', 'app_model')); 
        if (! $this->session->userdata('isLogIn')) {
            redirect('login');
        }
        $this->Settings = $this->app_model->get_setting();
          
    }

    function index() 
    {
        $data['categories']  = $this->app_model->getAllCategories();

        $data['title']             = 'Product List';
        $data['module']            = "product";
        $data['page']              = "product_list"; 

        echo modules::run('template/layout', $data);
    }

    public function get_all_products() {

        // echo '<pre>'; print_r($_POST); die;
        if($this->input->post()) {
            $category_id = $this->input->post('customf');
        }
        $totalData = 0;
        $data = array();
        if(isset($_POST['search']['value']) && ($_POST['search']['value'] != ""))
        {
            $q = $_POST['search']['value'];
            $records = $this->product_model->get_products($_POST['length'], $_POST['start'], $_POST['order'], null,  $q);
            $totalData = sizeof($records); 
        }else{
            
            $records = $this->product_model->get_products($_POST['length'], $_POST['start'], $_POST['order'], $category_id);
            
            $all_records = $this->product_model->total_get_products($category_id);
		    $totalData = sizeof($all_records); 
        }
        
        $i = 0;
        if (isset($records) && count($records) > 0) {
            foreach ($records as $key => $value) {
                $i++;
                $hide_pos = '';
                if($value->hide_pos == 1) {
                    $hide_pos .= '<input type="button" id="hide_pos" class="btn btn-primary btn-sm" value="Unhide" data-id="'.$value->id.'" data-hide_pos="'.$value->hide_pos.'">';
                } else {
                    $hide_pos .= '<input type="button" id="hide_pos" class="btn btn-primary btn-sm" value="Hide" data-id="'.$value->id.'" data-hide_pos="'.$value->hide_pos.'">';
                }
                $nestedData = array();
                $nestedData[] = $value->id;
                $nestedData[] = $value->code;
                $nestedData[] = $value->name;
                $nestedData[] = $value->name_alt;
                $nestedData[] = $value->cat_name;
                $nestedData[] = $this->sls->formatDecimal($value->cost);
                $nestedData[] = $this->sls->formatDecimal($value->price);
                $nestedData[] = $value->unit_name;
                $nestedData[] = $value->hide_pos;

                $edit = anchor("view_product/".$value->id,
                    '<i class="fa fa-file-text" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-warning btn-sm', 'title'=>'View'));
                $edit .= ' ' . anchor("edit_product/".$value->id,
                    '<i class="fa fa-pencil" aria-hidden="true"></i> ',
                    array('class'=>'btn btn-success btn-sm', 'title'=>'Update'));
                $edit .= ' ' . anchor("product/delete/".$value->id,
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

    public function delete($id = null)
    {

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if (!$id) {
            json_encode(['error' => 1, 'msg' => ('id not found')]);
        }

        if ($this->product_model->deleteProduct($id)) {
            if ($this->input->is_ajax_request()) {
                json_encode(['error' => 0, 'msg' => ('product deleted')]);
            }
            $this->session->set_flashdata('message', ('product deleted'));
            redirect('product');
        }
    }

    public function hide_from_pos()
    {
        // print_r($this->input->post());die;
        $productId = $this->input->post('productId');
        $statusNo = $this->input->post('statusNo');

        if($statusNo == 0) {
            $statusNo = 1;
        } elseif($statusNo == 1) {
            $statusNo = 0;
        }
        $update = $this->product_model->hide_from_pos($productId, $statusNo);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function create_product() 
    {

        $data['title'] = lang('add_product');
        #-------------------------------#
        $this->form_validation->set_rules('category', lang('category'), 'required|is_natural_no_zero');
        if ($this->input->post('type') == 'standard') {
            $this->form_validation->set_rules('cost', lang('product_cost'), 'required');
            $this->form_validation->set_rules('unit', lang('product_unit'), 'required');
        }
        $this->form_validation->set_rules('code', lang('product_code'), 'is_unique[products.code]|alpha_dash');
        
        $this->form_validation->set_rules('weight', lang('weight'), 'numeric');
        $this->form_validation->set_rules('product_image', lang('product_image'), 'xss_clean');

        #-------------------------------#

        $image_url = $this->fileupload->do_upload(
			'./assets/uploads/products/',
			'image'
		);
        
        #-------------------------------#
        if ($this->form_validation->run() === true) {
// echo '<pre>'; print_r($_POST); die;
            $data['data'] = (object)$postData = [

                'display_serial'    => $this->input->post('display_serial'),
                'code'              => $this->input->post('code'),
                'barcode_symbology' => $this->input->post('barcode_symbology'),
                'name'              => htmlspecialchars($this->input->post('name')),
                'type'              => $this->input->post('type'),
                'brand'             => $this->input->post('brand'),
                'category_id'       => $this->input->post('category'),
                'subcategory_id'    => $this->input->post('subcategory') ? $this->input->post('subcategory') : null,
                'cost'              => $this->sls->formatDecimal($this->input->post('cost')),
                'price'             => $this->sls->formatDecimal($this->input->post('price')),
                'unit'              => $this->input->post('unit'),
                'sale_unit'         => $this->input->post('default_sale_unit'),
                'purchase_unit'     => $this->input->post('default_purchase_unit'),
                'tax_rate'          => $this->input->post('tax_rate'),
                'tax_method'        => $this->input->post('tax_method'),
                'alert_quantity'    => $this->input->post('alert_quantity'),
                'track_quantity'    => $this->input->post('track_quantity') ? $this->input->post('track_quantity') : '0',
                'details'           => $this->input->post('details'),
                'product_details'   => $this->input->post('product_details'),
                'supplier1'         => $this->input->post('supplier_1'),
                'supplier1price'    => $this->sls->formatDecimal($this->input->post('supplier_1_price')),
                'supplier2'         => $this->input->post('supplier_2'),
                'supplier2price'    => $this->sls->formatDecimal($this->input->post('supplier_2_price')),
                
                'supplier1_part_no' => $this->input->post('supplier_1_part_no'),
                'supplier2_part_no' => $this->input->post('supplier_2_part_no'),
                
                'file'              => $this->input->post('file_link'),
                'slug'              => $this->input->post('slug'),
                'weight'            => $this->input->post('weight'),
                'featured'          => $this->input->post('featured'),
                'hsn_code'          => $this->input->post('hsn_code'),
                'hide'              => $this->input->post('hide') ? $this->input->post('hide') : 0,
                'second_name'       => htmlspecialchars($this->input->post('second_name')),
                'is_packed'         => $this->input->post('is_packed') ? $this->input->post('is_packed') : 0,
                'pack_piece'        => $this->input->post('pack_piece'),
                'packed_product'    => $this->input->post('packed_product'),
                'printer_selection'    => $this->input->post('printer_selection'),
                'image'             => $image_url
            ]; 

            if ($this->input->post('type') == 'standard') {
                if ($this->input->post('attributesInput')) {
                    $a = sizeof($_POST['attr_name']);
                    for ($r = 0; $r <= $a; $r++) {
                        if (isset($_POST['attr_name'][$r])) {
                            $product_attributes[] = [
                                'name'         => $_POST['attr_name'][$r],
                                'warehouse_id' => $_POST['attr_warehouse'][$r],
                                'quantity'     => $_POST['attr_quantity'][$r],
                                'price'        => $_POST['attr_price'][$r],
                            ];
                            $pv_total_quantity += $_POST['attr_quantity'][$r];
                        }
                    }
                } else {
                    $product_attributes = null;
                }
            }
            if ($this->input->post('type') == 'service') {
                $data['track_quantity'] = 0;
            } elseif ($this->input->post('type') == 'combo') {
                $total_price = 0;
                $c           = sizeof($_POST['combo_item_code']) - 1;
                for ($r = 0; $r <= $c; $r++) {
                    if (isset($_POST['combo_item_code'][$r]) && isset($_POST['combo_item_quantity'][$r]) && isset($_POST['combo_item_price'][$r])) {
                        $items[] = [
                            'item_code'  => $_POST['combo_item_code'][$r],
                            'quantity'   => $_POST['combo_item_quantity'][$r],
                            'unit_price' => $_POST['combo_item_price'][$r],
                        ];
                    }
                    $total_price += $_POST['combo_item_price'][$r] * $_POST['combo_item_quantity'][$r];
                }
                if ($this->sls->formatDecimal($total_price) != $this->sls->formatDecimal($this->input->post('price'))) {
                    $this->form_validation->set_rules('combo_price', 'combo_price', 'required');
                    $this->form_validation->set_message('required', lang('pprice_not_match_ciprice'));
                }
                $data['track_quantity'] = 0;
            }
            if (!isset($items)) {
                $items = null;
            }
            // $tax_rate = $this->site->getTaxRateByID($postData['tax_rate']);
            // echo '<pre>';  print_r($postData); print_r($items); die;
                // if ($this->product_model->create($postData)) {
                if ($this->product_model->add_product($postData, $product_attributes, $items)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("product");

        } else { 
                $data['products'] = $this->product_model->get_all_products();
                $data['categories'] = $this->product_model->get_all_categories();
                $data['brands'] =  $this->product_model->get_all_brands();
                $data['units'] =  $this->product_model->get_all_units();
                $data['tax_rates'] =  $this->product_model->get_tax_rates();
                $data['printers'] =  $this->product_model->get_all_printers();
                $data['suppliers'] =  $this->product_model->get_all_suppliers();
                $data['variants'] =  $this->product_model->getAllVariants();
                $data['warehouses'] =  $this->product_model->getAllWarehouses();

                $data['title']   = "Add Product";  
	            $data['module']   = "product";  
	            $data['page']     = "create_product_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function edit_product($id = null) 
    {

        $data['title'] = lang('add_product');
        #-------------------------------#
        $this->form_validation->set_rules('category', lang('category'), 'required|is_natural_no_zero');
        if ($this->input->post('type') == 'standard') {
            $this->form_validation->set_rules('cost', lang('product_cost'), 'required');
            $this->form_validation->set_rules('unit', lang('product_unit'), 'required');
        }
        $this->form_validation->set_rules('code', lang('product_code'), 'alpha_dash');
        
        $this->form_validation->set_rules('weight', lang('weight'), 'numeric');
        $this->form_validation->set_rules('product_image', lang('product_image'), 'xss_clean');

        #-------------------------------#

        $image_url = $this->fileupload->do_upload(
			'./assets/uploads/products/',
			'image'
		);
        
        #-------------------------------#
        if ($this->form_validation->run() === true) {
// echo '<pre>'; print_r($_POST); die;
            $data['data'] = (object)$postData = [

                'display_serial'    => $this->input->post('display_serial'),
                'code'              => $this->input->post('code'),
                'barcode_symbology' => $this->input->post('barcode_symbology'),
                'name'              => htmlspecialchars($this->input->post('name')),
                'type'              => $this->input->post('type'),
                'brand'             => $this->input->post('brand'),
                'category_id'       => $this->input->post('category'),
                'subcategory_id'    => $this->input->post('subcategory') ? $this->input->post('subcategory') : null,
                'cost'              => $this->sls->formatDecimal($this->input->post('cost')),
                'price'             => $this->sls->formatDecimal($this->input->post('price')),
                'unit'              => $this->input->post('unit'),
                'sale_unit'         => $this->input->post('default_sale_unit'),
                'purchase_unit'     => $this->input->post('default_purchase_unit'),
                'tax_rate'          => $this->input->post('tax_rate'),
                'tax_method'        => $this->input->post('tax_method'),
                'alert_quantity'    => $this->input->post('alert_quantity'),
                'track_quantity'    => $this->input->post('track_quantity') ? $this->input->post('track_quantity') : '0',
                'details'           => $this->input->post('details'),
                'product_details'   => $this->input->post('product_details'),
                'supplier1'         => $this->input->post('supplier_1'),
                'supplier1price'    => $this->sls->formatDecimal($this->input->post('supplier_1_price')),
                'supplier2'         => $this->input->post('supplier_2'),
                'supplier2price'    => $this->sls->formatDecimal($this->input->post('supplier_2_price')),
                
                'supplier1_part_no' => $this->input->post('supplier_1_part_no'),
                'supplier2_part_no' => $this->input->post('supplier_2_part_no'),
                
                'file'              => $this->input->post('file_link'),
                'slug'              => $this->input->post('slug'),
                'weight'            => $this->input->post('weight'),
                'featured'          => $this->input->post('featured'),
                'hsn_code'          => $this->input->post('hsn_code'),
                'hide'              => $this->input->post('hide') ? $this->input->post('hide') : 0,
                'second_name'       => htmlspecialchars($this->input->post('second_name')),
                'is_packed'         => $this->input->post('is_packed') ? $this->input->post('is_packed') : 0,
                'pack_piece'        => $this->input->post('pack_piece'),
                'packed_product'    => $this->input->post('packed_product'),
                'printer_selection'    => $this->input->post('printer_selection'),
                'image'             => $image_url
            ]; 

            if ($this->input->post('type') == 'standard') {

                if ($product_variants = $this->product_model->getProductOptions($id)) {
                    foreach ($product_variants as $pv) {
                        $update_variants[] = [
                            'id'    => $this->input->post('variant_id_' . $pv->id),
                            'name'  => $this->input->post('variant_name_' . $pv->id),
                            'cost'  => $this->input->post('variant_cost_' . $pv->id),
                            'price' => $this->input->post('variant_price_' . $pv->id),
                        ];
                    }
                }
                if ($this->input->post('attributesInput')) {
                    $a = sizeof($_POST['attr_name']);
                    for ($r = 0; $r <= $a; $r++) {
                        if (isset($_POST['attr_name'][$r])) {
                            $product_attributes[] = [
                                'name'         => $_POST['attr_name'][$r],
                                'warehouse_id' => $_POST['attr_warehouse'][$r],
                                'quantity'     => $_POST['attr_quantity'][$r],
                                'price'        => $_POST['attr_price'][$r],
                            ];
                            $pv_total_quantity += $_POST['attr_quantity'][$r];
                        }
                    }
                } else {
                    $product_attributes = null;
                }
            }
            if ($this->input->post('type') == 'service') {
                $data['track_quantity'] = 0;
            } elseif ($this->input->post('type') == 'combo') {
                $total_price = 0;
                $c           = sizeof($_POST['combo_item_code']) - 1;
                for ($r = 0; $r <= $c; $r++) {
                    if (isset($_POST['combo_item_code'][$r]) && isset($_POST['combo_item_quantity'][$r]) && isset($_POST['combo_item_price'][$r])) {
                        $items[] = [
                            'item_code'  => $_POST['combo_item_code'][$r],
                            'quantity'   => $_POST['combo_item_quantity'][$r],
                            'unit_price' => $_POST['combo_item_price'][$r],
                        ];
                    }
                    $total_price += $_POST['combo_item_price'][$r] * $_POST['combo_item_quantity'][$r];
                }
                if ($this->sls->formatDecimal($total_price) != $this->sls->formatDecimal($this->input->post('price'))) {
                    $this->form_validation->set_rules('combo_price', 'combo_price', 'required');
                    $this->form_validation->set_message('required', lang('pprice_not_match_ciprice'));
                }
                $data['track_quantity'] = 0;
            }
            // $tax_rate = $this->site->getTaxRateByID($postData['tax_rate']);
            // echo '<pre>';  print_r($postData); print_r($product_attributes); print_r($items); die;
                // if ($this->product_model->create($postData)) {
                if ($this->product_model->updateProduct($id, $postData, $product_attributes, $update_variants, $items)) {
                        $this->session->set_flashdata('message', lang('save_successfully'));
                } else {
                        $this->session->set_flashdata('exception', lang('please_try_again'));
                }

            redirect("product");

        } else { 
                $data['product'] = $this->product_model->getProductByID($id);
                $data['product_options'] = $this->product_model->getProductOptionsWithWH($id);
                $data['product_variants']    = $this->product_model->getProductOptions($id);
                $data['combo_items']         = ($id && $data['product']->type == 'combo') ? $this->product_model->getProductComboItems($id) : null;
                $data['categories'] = $this->product_model->get_all_categories();
                $data['brands'] =  $this->product_model->get_all_brands();
                $data['units'] =  $this->product_model->get_all_units();
                $data['tax_rates'] =  $this->product_model->get_tax_rates();
                $data['printers'] =  $this->product_model->get_all_printers();
                $data['suppliers'] =  $this->product_model->get_all_suppliers();
                $data['variants'] =  $this->product_model->getAllVariants();
                $data['warehouses'] =  $this->product_model->getAllWarehouses();
                $data['products'] = $this->product_model->get_all_products();
// print_r($data['combo_items']); die;
	            $data['module']   = "product";  
	            $data['page']     = "edit_product_form";  
	            echo Modules::run('template/layout', $data); 

        } 
    }

    public function view_product($id = null) 
    {
                $pr_details = $this->product_model->getProductByID($id);
                if ($pr_details->type == 'combo') {
                    $data['combo_items'] = $this->product_model->getProductComboItems($id);
                }
                $data['product']          = $pr_details;
                $data['unit']             = $this->app_model->getUnitByID($pr_details->unit);
                $data['brand']            = $this->app_model->getBrandByID($pr_details->brand);
                $data['category']         = $this->app_model->getCategoryByID($pr_details->category_id);
                $data['options']          = $this->product_model->getProductOptionsWithWH($id);
                $data['variants']         = $this->product_model->getProductOptions($id);
                $data['warehouses']       = $this->product_model->getAllWarehousesWithPQ($id);
                $data['tax_rate']         = $pr_details->tax_rate ? $this->app_model->getTaxRateByID($pr_details->tax_rate) : null;
                // $data['popup_attributes'] = $this->popup_attributes;
                // $data['warehouses']       = $this->product_model->getAllWarehousesWithPQ($id);
                // $data['sold']             = $this->product_model->getSoldQty($id);
                // $data['purchased']        = $this->product_model->getPurchasedQty($id);

               
// print_r($data['combo_items']); die;
                $data['title']   = "Product Detail"; 
	            $data['module']   = "product";  
	            $data['page']     = "view_product";  
	            echo Modules::run('template/layout', $data); 

    }
    public function get_product_byid()
    {
        // print_r($this->input->post('id'));
        if($this->input->post('id')) {
            $id = $this->input->post('id');

            $product = $this->product_model->getProductByID($id);
            $data['product'] = $product;

            echo json_encode($product);

            // $this->load->view('product/product/modal_view', $data);
        }
    }

    public function modal_view($id=null)
    {
        
        $id = $this->input->post('id');
        $pr_details = $this->product_model->getProductByID($id);
        if ($pr_details->type == 'combo') {
            $data['combo_items'] = $this->product_model->getProductComboItems($id);
        }
        $data['product']          = $pr_details;
        $data['unit']             = $this->app_model->getUnitByID($pr_details->unit);
        $data['brand']            = $this->app_model->getBrandByID($pr_details->brand);
        $data['category']         = $this->app_model->getCategoryByID($pr_details->category_id);
        $data['options']          = $this->product_model->getProductOptionsWithWH($id);
        $data['variants']         = $this->product_model->getProductOptions($id);
        $data['warehouses']       = $this->product_model->getAllWarehousesWithPQ($id);
        
         $this->load->view('product/modal_view', $data);
    }

    public function pdf_product_list($category_id='')
    {
        $data = array();
        $records = $this->product_model->get_all_products_export($category_id);
        $data['products']  = $records;

        $html = $this->load->view('product/pdf_product_list', $data, true);
        $filename = 'Products_list.pdf';
        $this->sls->generate_pdf($html, $filename, null, null, null, null, null, 'L'); 

        // $this->load->library('pdf'); 
        // $filename = 'Products_list';
        // $this->pdf->createpdf('product/pdf_product_list', $data, $filename);
    }

    public function pdf_single_product($id='')
    {
        $pr_details = $this->product_model->getProductByID($id);
        
        if ($pr_details->type == 'combo') {
            $data['combo_items'] = $this->product_model->getProductComboItems($id);
        }
        $data['product']          = $pr_details;
        $data['unit']             = $this->app_model->getUnitByID($pr_details->unit);
        $data['brand']            = $this->app_model->getBrandByID($pr_details->brand);
        $data['category']         = $this->app_model->getCategoryByID($pr_details->category_id);
        $data['tax_rate']         = $pr_details->tax_rate ? $this->app_model->getTaxRateByID($pr_details->tax_rate) : null;
        $data['warehouses']       = $this->product_model->getAllWarehousesWithPQ($id);
        $data['options']          = $this->product_model->getProductOptionsWithWH($id);
        $data['variants']         = $this->product_model->getProductOptions($id);

        $filename = 'products_detail_'.$pr_details->code.'.pdf';
        $html = $this->load->view('product/pdf_single_product', $data, true);
        $this->sls->generate_pdf($html, $filename, null, null, null, null, null, 'L'); 
    }

    public function delete_product_variant()
    {
        if($this->input->post()) {
//  print_r($_POST); die;
            $pvid = $this->input->post('pvid');

            $del = $this->db->where('id', $pvid)->delete('product_variants');
            if($del) {
                $del = $this->db->where('option_id', $id)->delete('warehouses_products_variants');
            }
            return true;
        }
    }

    public function suggestions()
    {
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . admin_url('welcome') . "'; }, 10);</script>");
        }
        $term = addslashes($term);
        $rows = $this->product_model->getProductNames($term);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = ['id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => 1];
            }
            $this->sls->send_json($pr);
            // echo json_encode($pr);
        } else {
            $this->sls->send_json([['id' => 0, 'label' => lang('no_match_found'), 'value' => $term]]);
        }
    }

    public function slug()
    {
        echo $this->sls->slug($this->input->get('title', true), $this->input->get('type', true));
        exit();
    }

    public function product_list_excel($categoryId='')
    {
        $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Products');
            $this->excel->getActiveSheet()->SetCellValue('A1', lang('name'));
            $this->excel->getActiveSheet()->SetCellValue('B1', lang('second_name'));
            $this->excel->getActiveSheet()->SetCellValue('C1', lang('code'));
            $this->excel->getActiveSheet()->SetCellValue('D1', lang('brand'));
            $this->excel->getActiveSheet()->SetCellValue('E1', ('Category Code'));
            $this->excel->getActiveSheet()->SetCellValue('F1', ('Sale') . ' ' . ('Unit'));
            $this->excel->getActiveSheet()->SetCellValue('G1', ('Quantity'));
            $this->excel->getActiveSheet()->SetCellValue('H1', ('Cost'));
            $this->excel->getActiveSheet()->SetCellValue('I1', ('Price'));
            $this->excel->getActiveSheet()->SetCellValue('J1', ('Alert Quantity'));
            $this->excel->getActiveSheet()->SetCellValue('K1', ('Tax Rate'));
            $this->excel->getActiveSheet()->SetCellValue('L1', ('Tax Method'));
            $this->excel->getActiveSheet()->SetCellValue('M1', ('Image'));
            $this->excel->getActiveSheet()->SetCellValue('N1', ('Subcategory Code'));
            $this->excel->getActiveSheet()->SetCellValue('O1', ('Product Variants'));
            $this->excel->getActiveSheet()->SetCellValue('P1', ('Supplier Name'));
            $this->excel->getActiveSheet()->SetCellValue('Q1', ('Supplier Part No'));
            $this->excel->getActiveSheet()->SetCellValue('R1', ('Supplier Price'));
            $this->excel->getActiveSheet()->SetCellValue('S1', ('Details'));

            $row = 2;
            $products = $this->product_model->get_all_products_export($categoryId);
            foreach ($products as $r) {
                $product   = $this->product_model->getProductDetail($r->id);
                $brand     = $this->app_model->getBrandByID($product->brand);
                $units = $this->app_model->getUnitByID($product->unit);
                
                $variants         = $this->product_model->getProductOptions($r->id);
                $product_variants = '';
                if ($variants) {
                    $i = 1;
                    $v = count($variants);
                    foreach ($variants as $variant) {
                        $product_variants .= trim($variant->name) . ($i != $v ? '|' : '');
                        $i++;
                    }
                }
                $quantity = $product->quantity;
                if ($wh) {
                    if ($wh_qty = $this->product_model->getProductQuantity($r->id, $wh)) {
                        $quantity = $wh_qty['quantity'];
                    } else {
                        $quantity = 0;
                    }
                }
                $supplier = $this->app_model->getSupplierByID($product->supplier1);

                $this->excel->getActiveSheet()->SetCellValue('A' . $row, $product->name);
                $this->excel->getActiveSheet()->SetCellValue('B' . $row, $product->second_name);
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $product->code);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, ($brand ? $brand->name : ''));
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $product->category_code);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $units->name);
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $quantity);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $product->cost);
                // if ($this->Owner || $this->Admin || $this->session->userdata('show_price')) {
                $this->excel->getActiveSheet()->SetCellValue('I' . $row, $product->price);
                // }
                $this->excel->getActiveSheet()->SetCellValue('J' . $row, $product->alert_quantity);
                $this->excel->getActiveSheet()->SetCellValue('K' . $row, $product->tax_rate_name);
                $this->excel->getActiveSheet()->SetCellValue('L' . $row, $product->tax_method ? ('exclusive') : ('inclusive'));
                $this->excel->getActiveSheet()->SetCellValue('M' . $row, $product->image);
                $this->excel->getActiveSheet()->SetCellValue('N' . $row, $product->subcategory_code);
                $this->excel->getActiveSheet()->SetCellValue('O' . $row, $product_variants);
                        
                $this->excel->getActiveSheet()->SetCellValue('P' . $row, $supplier ? $supplier->name : '');
                $this->excel->getActiveSheet()->SetCellValue('Q' . $row, $supplier ? $product->supplier1_part_no : '');
                $this->excel->getActiveSheet()->SetCellValue('R' . $row, $supplier ? $product->supplier1price : '');
                $this->excel->getActiveSheet()->SetCellValue('S' . $row, $product->details);
                
                $row++;
            }

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(40);
            $this->excel->getDefaultStyle()->getAlignment()->setVertical('center');
            $filename = 'products_' . date('Y_m_d_H_i_s');
            $this->load->helper('excel');
            create_excel($this->excel, $filename);
                
    }

}