<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php
$wm = ['0' => lang('no'), '1' => lang('yes')];
$ps = ['0' => lang('disable'), '1' => lang('enable')];
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
	  <div class="row">
		  <div class="col-md-6">
		  	 <h3> <i class="fa-fw fa fa-plus border-right"></i> <?php echo "Settings" ?> </h3>
		  </div>
		  <div class="col-md-6">
			  <div class="box-icon d-flex flex-row float-right"> 
			  </div>
		  </div>
	  </div>
    </div>
  
    <div class="panel-body">

        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('update_info'); ?></p>

                <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => 'off'];
                echo form_open_multipart('settings', $attrib);
                ?>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= ('Site Config') ?></legend>
                <div class="row">
                
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_name"><?= ('Site Name'); ?> * </label>
                                    <?= form_input('site_name', $Settings->site_name, 'class="form-control tip" id="site_name"  required="required"'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= ('Language'); ?> * </label>
                                    <?php
                                    $lang = [
                                        'arabic'               => 'Arabic',
                                        'english'              => 'English',
                                        
                                    ];
                                    echo form_dropdown('language', $lang, $Settings->language, 'class="form-control tip" id="language" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="currency"><?= ('Default Currency'); ?> *</label>

                                    <div class="controls"> <?php
                                    foreach ($currencies as $currency) {
                                        $cu[$currency->code] = $currency->name;
                                    }
                                        echo form_dropdown('currency', $cu, $Settings->default_currency, 'class="form-control tip" id="currency" required="required" style="width:100%;"');
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="currency"><?= lang('display_currency_symbol'); ?> *</label>
                                    <?php $opts = [0 => lang('disable'), 1 => lang('before'), 2 => lang('after')]; ?>
                                    <?= form_dropdown('display_symbol', $opts, $Settings->display_symbol, 'class="form-control" id="display_symbol" style="width:100%;" required="required"'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="email"><?= ('Default Email'); ?> *</label>
                                    <?= form_input('email', $Settings->default_email, 'class="form-control tip" id="email"  required="required"'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rtl"><?= ('RTL Support '); ?></label>
                                    <div class="controls">
                                        <?php
                                        echo form_dropdown('rtl', $ps, $Settings->rtl, 'id="rtl" class="form-control tip" required="required" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rows_per_page"><?= ('Rows Per Page'); ?> *</label>
                                    <?php
                                    $rppopts = ['10' => '10', '25' => '25', '50' => '50',  '100' => '100', '-1' => lang('all') . ' (' . lang('not_recommended') . ')'];
                                    echo form_dropdown('rows_per_page', $rppopts, $Settings->rows_per_page, 'id="rows_per_page" class="form-control tip" style="width:100%;" required="required"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="dateformat"><?= ('Date Format'); ?> *</label>
                                    <div class="controls">
                                        <?php
                                        foreach ($date_formats as $date_format) {
                                            $dt[$date_format->id] = $date_format->js;
                                        }
                                        echo form_dropdown('dateformat', $dt, $Settings->dateformat, 'id="dateformat" class="form-control tip" style="width:100%;" required="required"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"
                                        for="warehouse"><?= ('Default Warehouse'); ?> *</label>
                                    <div class="controls"> <?php
                                    foreach ($warehouses as $warehouse) {
                                        $wh[$warehouse->id] = $warehouse->name . ' (' . $warehouse->code . ')';
                                    }
                                        echo form_dropdown('warehouse', $wh, $Settings->default_warehouse, 'class="form-control tip" id="warehouse" required="required" style="width:100%;"');
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"
                                        for="biller"><?= ('Default Biller'); ?> *</label>
                                    <?php
                                    $bl[''] = 'Select Biller';
                                    foreach ($billers as $biller) {
                                        $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                    }
                                    echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller), 'id="biller" data-placeholder="' . 'Select' . ' ' . 'Biller' . '" required="required" class="form-control input-tip select" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"
                                        for="api_key"><?= ('API Key'); ?> *</label>
                                    <?= form_input('api_key', $Settings->api_key, 'class="form-control tip" id="api_key"'); ?>
                                </div>
                            </div>
                </div> 
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= ('Products') ?></legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="product_tax"><?= lang('product_tax'); ?> *</label>
                                <?php
                                echo form_dropdown('tax_rate', $ps, $Settings->default_tax_rate, 'class="form-control tip" id="tax_rate" required="required" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="racks"><?= ('Racks'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('racks', $ps, $Settings->racks, 'id="racks" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="attributes"><?= ('Variants'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('attributes', $ps, $Settings->attributes, 'id="attributes" class="form-control tip"  required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="product_expiry"><?= lang('product_expiry'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('product_expiry', $ps, $Settings->product_expiry, 'id="product_expiry" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="remove_expired"><?= lang('remove_expired'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    $re_opts = [0 => lang('no') . ', ' . lang('i_ll_remove'), 1 => lang('yes') . ', ' . lang('remove_automatically')];
                                    echo form_dropdown('remove_expired', $re_opts, $Settings->remove_expired, 'id="remove_expired" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="image_size"><?= lang('image_size'); ?> (Width :
                                    Height) *</label>

                                <div class="row">
                                    <div class="col-md-5">
                                        <?= form_input('iwidth', $Settings->iwidth, 'class="form-control tip" id="iwidth" placeholder="image width" required="required"'); ?>
                                    </div>
                                    <div class="col-md-5">
                                        <?= form_input('iheight', $Settings->iheight, 'class="form-control tip" id="iheight" placeholder="image height" required="required"'); ?></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="thumbnail_size"><?= lang('thumbnail_size'); ?>
                                    (Width : Height) *</label>

                                <div class="row">
                                    <div class="col-md-5">
                                        <?= form_input('twidth', $Settings->twidth, 'class="form-control tip" id="twidth" placeholder="thumbnail width" required="required"'); ?>
                                    </div>
                                    <div class="col-md-5">
                                        <?= form_input('theight', $Settings->theight, 'class="form-control tip" id="theight" placeholder="thumbnail height" required="required"'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="display_all_products"><?= lang('display_all_products'); ?> *</label>
                                <?php
                                    $dopts = [0 => lang('hide_with_0_qty'), 1 => lang('show_with_0_qty')];
                                    echo form_dropdown('display_all_products', $dopts, ($_POST['display_all_products'] ?? $Settings->display_all_products), 'class="tip form-control" required="required" id="display_all_products" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="barcode_separator"><?= lang('barcode_separator'); ?> *</label>
                                <?php
                                    $bcopts = ['-' => lang('dash'), '.' => lang('dot'), '~' => lang('tilde'), '_' => lang('underscore')];
                                    echo form_dropdown('barcode_separator', $bcopts, ($_POST['barcode_separator'] ?? $Settings->barcode_separator), 'class="tip form-control" required="required" id="barcode_separator" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="barcode_renderer"><?= lang('barcode_renderer'); ?> *</label>
                                <?php
                                    $bcropts = [1 => lang('image'), 0 => lang('svg')];
                                    echo form_dropdown('barcode_renderer', $bcropts, ($_POST['barcode_renderer'] ?? $Settings->barcode_img), 'class="tip form-control" required="required" id="barcode_renderer" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label class="control-label" for="update_cost_with_purchase"><?= lang('update_cost_with_purchase'); ?> *</label>
                                <?= form_dropdown('update_cost', $wm, $Settings->update_cost, 'class="form-control" id="update_cost" required="required"'); ?>
                            </div>
                        </div>

                    </div> 
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= ('Sales') ?></legend>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="overselling"><?= lang('over_selling'); ?></label>

                                <div class="controls">
                                    <?php
                                    $opt = [1 => lang('yes'), 0 => lang('no')];
                                    echo form_dropdown('restrict_sale', $opt, $Settings->overselling, 'class="form-control tip" id="overselling" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="item_addition"><?= lang('item_addition'); ?></label>
                                <div class="controls">
                                    <?php
                                    $ia = [0 => lang('add_new_item'), 1 => lang('increase_quantity_if_item_exist')];
                                    echo form_dropdown('item_addition', $ia, $Settings->item_addition, 'id="item_addition" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="reference_format"><?= lang('reference_format'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    $ref = [1 => lang('prefix_year_no'), 2 => lang('prefix_month_year_no'), 3 => lang('sequence_number'), 4 => lang('random_number')];
                                    echo form_dropdown('reference_format', $ref, $Settings->reference_format, 'class="form-control tip" required="required" id="reference_format" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="invoice_tax"><?= lang('invoice_tax'); ?> *</label>
                                <?php $tr['0'] = lang('disable');
                                foreach ($tax_rates as $rate) {
                                    $tr[$rate->id] = $rate->name;
                                }
                                echo form_dropdown('tax_rate2', $tr, $Settings->default_tax_rate2, 'id="tax_rate2" class="form-control tip" required="required" style="width:100%;"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="product_discount"><?= lang('product_level_discount'); ?></label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('product_discount', $ps, $Settings->product_discount, 'id="product_discount" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="product_serial"><?= lang('product_serial'); ?></label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('product_serial', $ps, $Settings->product_serial, 'id="product_serial" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="detect_barcode"><?= lang('auto_detect_barcode'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('detect_barcode', $ps, $Settings->auto_detect_barcode, 'id="detect_barcode" class="form-control tip" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="ksa_qrcode"><?= lang('ksa_qrcode'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    echo form_dropdown('ksa_qrcode', $ps, $Settings->ksa_qrcode, 'class="form-control tip" required="required" id="ksa_qrcode" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="invoice_view"><?= lang('invoice_view'); ?> *</label>

                                <div class="controls">
                                    <?php
                                    $opt_inv = [1 => lang('tax_invoice'), 0 => lang('standard'), 2 => lang('indian_gst')];
                                    echo form_dropdown('invoice_view', $opt_inv, $Settings->invoice_view, 'class="form-control tip" required="required" id="invoice_view" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>


                    </div> 
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= ('Prefix') ?></legend>
                    <div class="row"> 
                    <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="sales_prefix"><?= lang('sales_prefix'); ?></label>

                                <?= form_input('sales_prefix', $Settings->sales_prefix, 'class="form-control tip" id="sales_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="return_prefix"><?= lang('return_prefix'); ?></label>

                                <?= form_input('return_prefix', $Settings->return_prefix, 'class="form-control tip" id="return_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="payment_prefix"><?= lang('payment_prefix'); ?></label>
                                <?= form_input('payment_prefix', $Settings->payment_prefix, 'class="form-control tip" id="payment_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="ppayment_prefix"><?= lang('ppayment_prefix'); ?></label>
                                <?= form_input('ppayment_prefix', $Settings->ppayment_prefix, 'class="form-control tip" id="ppayment_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="delivery_prefix"><?= lang('delivery_prefix'); ?></label>

                                <?= form_input('delivery_prefix', $Settings->delivery_prefix, 'class="form-control tip" id="delivery_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="quote_prefix"><?= lang('quote_prefix'); ?></label>

                                <?= form_input('quote_prefix', $Settings->quote_prefix, 'class="form-control tip" id="quote_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="purchase_prefix"><?= lang('purchase_prefix'); ?></label>

                                <?= form_input('purchase_prefix', $Settings->purchase_prefix, 'class="form-control tip" id="purchase_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="returnp_prefix"><?= lang('returnp_prefix'); ?></label>

                                <?= form_input('returnp_prefix', $Settings->returnp_prefix, 'class="form-control tip" id="returnp_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="transfer_prefix"><?= lang('transfer_prefix'); ?></label>
                                <?= form_input('transfer_prefix', $Settings->transfer_prefix, 'class="form-control tip" id="transfer_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="expense_prefix"><?= lang('expense_prefix'); ?></label>
                                <?= form_input('expense_prefix', $Settings->expense_prefix, 'class="form-control tip" id="expense_prefix"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"
                                       for="qa_prefix"><?= lang('qa_prefix'); ?></label>
                                <?= form_input('qa_prefix', $Settings->qa_prefix, 'class="form-control tip" id="qa_prefix"'); ?>
                            </div>
                        </div>


                    </div> 
                </fieldset>

                <div class="cleafix"></div>
                <div class="form-group">
                    <div class="controls">
                        <?= form_submit('update_settings', ('Update Settings'), 'class="btn btn-primary btn-lg"'); ?>
                    </div>
                </div>
                <?= form_close(); ?>
<br><br>
            </div> 
        </div>   
    </div>

</div>