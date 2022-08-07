
	<div class="panel panel-default">

        <div class="panel-heading" style="border-bottom: 1px solid #e4e5e7; margin-bottom: 5px;">
            <div class="panel-title">
                <h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo lang('return_sale'); ?> </h3>
            </div>
        </div>
		<div class="panel-body">
             <div class="row">
                <div class="col-lg-6">
                <?php
                $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-resl-form'];
                echo form_open_multipart('sales/return_sale_form/', $attrib)
                ?>
                <div class="row px-3">
                    <div class="col-lg-12 border-bottom" style="width: 50%;">
                    <h3 class=""><?php echo ('Return By Barcode'); ?></h3>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-lg-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no"> <?= lang('reference_no') ?> </label>
                                <?php echo form_input('reference_no', '', 'class="form-control input-tip" id="reref"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="fprom-group"><?php echo form_submit('return_sale_barcode', $this->lang->line('submit'), 'id="" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?></div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div> 
            <div class="col-lg-6">
                <?php
                $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-resl-form'];
                echo form_open_multipart('sales/return_sale_form/', $attrib)
                ?>
                <div class="row px-3">
                    <div class="col-lg-12 border-bottom" style="width: 50%;">
                    <h3 class=""><?php echo ('Return By Product List'); ?></h3>
                    </div>
                </div>
                <div class="row my-3">
                
                    <div class="col-lg-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('reference_no', 'reref'); ?>
                                <?php echo form_input('reference_no', ($_POST['reference_no'] ?? ''), 'class="form-control input-tip" id="reref"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="fprom-group"><?php echo form_submit('return_sale', $this->lang->line('submit'), 'id="" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?></div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div> 
        </div> 
        </div>
    </div>


