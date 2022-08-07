<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php
$wm = ['0' => lang('no'), '1' => lang('yes')];
$ps = ['0' => lang('disable'), '1' => lang('enable')];
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
	  <div class="row">
		  <div class="col-md-6">
		  	 <h3> <i class="fa-fw fa fa-plus border-right"></i> <?php echo "Pos Settings" ?> </h3>
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
                echo form_open_multipart('pos_settings', $attrib);
                ?>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= ('POS Configuration') ?></legend>
                    <div class="row">
                
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="pro_limit"><?= ('Display Products'); ?> * </label>
                                <?= form_input('pro_limit', $pos->pro_limit, 'class="form-control" id="limit" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="pin_code"><?= ('POS Pin Code'); ?> * </label>
                                <?= form_password('pin_code', $pos->pin_code, 'class="form-control" pattern="[0-9]{4,8}"id="pin_code"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="default_category"><?= ('Default Category'); ?> * </label>
                               
                                <?php
                                $ct[''] = lang('select') . ' ' . lang('default_category');
                                foreach ($categories as $catrgory) {
                                    $ct[$catrgory->id] = $catrgory->name;
                                }
                                echo form_dropdown('category', $ct, $pos->default_category, 'class="form-control" id="default_category" required="required" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="default_biller"><?= ('Default Biller'); ?> * </label>
                                <?php
                                $bl[0] = 'Select';
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                if (isset($_POST['biller'])) {
                                    $biller = $_POST['biller'];
                                } else {
                                    $biller = '';
                                }
                                echo form_dropdown('biller', $bl, $pos->default_biller, 'class="form-control" id="default_biller" required="required" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="default_customer"><?= ('Default Customer'); ?> * </label>
                                <?php
                                    $cus[''] = 'Select';
                                    foreach ($customers as $customer) {
                                        $cus[$customer->id] = $customer->name;
                                    }
                                    echo form_dropdown('customer', $cus,  (isset($_POST['customer']) ? $_POST['customer'] : $pos->default_customer), 'id="poscustomer" class="form-control pos-input-tip select2" required="required" style="width:80%;" '); 
                                ?> 
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="display_time"><?= ('Display Time'); ?> * </label>
                                <?php
                                $yn = ['1' => lang('yes'), '0' => lang('no')];
                                echo form_dropdown('display_time', $yn, $pos->display_time, 'class="form-control" id="display_time" required="required"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="onscreen_keyboard"><?= ('Keyboard'); ?> * </label>
                                <?php
                                echo form_dropdown('keyboard', $yn, $pos->keyboard, 'class="form-control" id="keyboard" required="required"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="product_button_color"><?= lang('product_button_color'); ?> * </label>
                                <?php $col = ['default' => lang('default'), 'primary' => lang('primary'), 'info' => lang('info'), 'warning' => lang('warning'), 'danger' => lang('danger')];
                                echo form_dropdown('product_button_color', $col, $pos->product_button_color, 'class="form-control" id="product_button_color" required="required"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="rounding"><?= lang('rounding'); ?> * </label>
                                <?php
                                $rnd = ['0' => lang('disable'), '1' => lang('to_nearest_005'), '2' => lang('to_nearest_050'), '3' => lang('to_nearest_number'), '4' => lang('to_next_number')];
                                echo form_dropdown('rounding', $rnd, $pos->rounding, 'class="form-control" id="rounding" required="required"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="item_order"><?= lang('item_order'); ?> * </label>
                                <?php $oopts = [0 => lang('default'), 1 => lang('category')]; ?>
                                <?= form_dropdown('item_order', $oopts, $pos->item_order, 'class="form-control" id="item_order" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="after_sale_page"><?= lang('after_sale_page'); ?> * </label>
                                <?php $popts = [0 => lang('receipt'), 1 => lang('pos')]; ?>
                                <?= form_dropdown('after_sale_page', $popts, $pos->after_sale_page, 'class="form-control" id="after_sale_page" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="display_customer_details"><?= lang('display_customer_details'); ?> * </label>
                                <?php $popts = [0 => lang('no'), 1 => lang('yes')]; ?>
                                <?= form_dropdown('customer_details', $popts, $pos->customer_details, 'class="form-control" id="customer_details" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="pos_layout_type"><?= lang('pos_layout_type'); ?> * </label>
                                <?php $popts = [0 => lang('restaurant'), 1 => lang('grocery'), 2 => lang('wholesale'), 3 => lang('restaurant_two')]; ?>
                                <?= form_dropdown('pos_layout_type', $popts, $pos->pos_layout_type, 'class="form-control" id="pos_layout_type" required="required"'); ?>
                            </div>
                        </div>

                    </div>
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('pos_printing') ?></legend> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="printing"><?= lang('printing'); ?> * </label>
                            <?php
                            $opts = [0 => lang('local_install'), 1 => lang('web_browser_print'), 3 => lang('php_pos_print_app')];
                            ?>
                            <?= form_dropdown('remote_printing', $opts, $pos->remote_printing, 'class="form-control select2" id="remote_printing" style="width:100%;" required="required"'); ?>
                            <span class="help-block"><?= lang('print_recommandations'); ?></span>
                            
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </fieldset>

                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('custom_fileds') ?></legend>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cf_title1"><?= lang('cf_title1'); ?> * </label>
                            <?= form_input('cf_title1', $pos->cf_title1, 'class="form-control tip" id="tcf1"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cf_value1"><?= lang('cf_value1'); ?> * </label>
                            <?= form_input('cf_value1', $pos->cf_value1, 'class="form-control tip" id="vcf1"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cf_title2"><?= lang('cf_title2'); ?> * </label>
                            <?= form_input('cf_title2', $pos->cf_title2, 'class="form-control tip" id="tcf2"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cf_value2"><?= lang('cf_value2'); ?> * </label>
                            <?= form_input('cf_value2', $pos->cf_value2, 'class="form-control tip" id="vcf2"'); ?>
                        </div>
                    </div>

                    </div>
                </fieldset>

                <?= form_submit('update_settings', lang('update_settings'), 'class="btn btn-primary"'); ?>

                <?= form_close(); ?>
<br> <br>
            </div>

        </div>

    </div>

</div>