<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
.attr {
	cursor: pointer;
}
</style>
<?php
// print_r($product);
if (!empty($variants)) {
    foreach ($variants as $variant) {
        $vars[] = addslashes($variant->name);
    }
} else {
    $vars = [];
}
?>
<div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                
                <div class="panel-body">
                <?php echo form_open_multipart("edit_product/$product->id", array("id"=>"create_product")) ?>
               
              <div class="form-group row">          
	                    <label for="product_type" class="col-md-2"><?php echo lang('type') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
						<select name="type" class="form-control select2" id="type" required="required">
							
							<?php
								$opts = ['standard' => ('standard'), 'combo' => ('combo'), 'digital' => ('digital'), 'service' => ('service')];
							?>
							<?php foreach($opts as $key=>$value) { ?>
								<option value="<?php echo $key; ?>" <?= $product->type == $key ? 'selected' : '' ?>><?php echo $value;?></option>
							<?php } ?>
						</select>
	                    </div>
	                    <label for="product_name" class="col-md-2"><?php echo lang('name') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                        <input name="name" class="form-control" type="text" placeholder="<?php echo ('name') ?>" id="product_name" minlength="2" value="<?= $product->name?>" required="required">
	           	 		</div>
               </div>

			   <div class="combo" style="display:<?php echo $combo_items ? '' : 'none'  ?>;">

					<div class="form-group row">   
						<label for="product_type" class="col-md-2"><?php echo ('Add Items') ?> <span class="text-danger">*</span></label>			
						<div class="col-md-4">	
						<?php echo form_input('add_item', '', 'class="form-control ttip" id="add_item" data-placement="top" data-trigger="focus" data-bv-notEmpty-message="' . lang('please_add_items_below') . '" placeholder="' . $this->lang->line('add_item') . '"'); ?>
						</div>		

					</div>
					<div class="form-group row">  
						<div class="col-md-6">	 
							<table id="prTable"
								class="table items table-striped table-bordered table-condensed table-hover">
								<thead>
								<tr>
									<th class="col-md-5 col-sm-5 col-xs-5"><?= ('product') . ' (' . lang('code') . ' - ' . lang('name') . ')'; ?></th>
									<th class="col-md-2 col-sm-2 col-xs-2"><?= ('quantity'); ?></th>
									<th class="col-md-3 col-sm-3 col-xs-3"><?= ('unit price'); ?></th>
									<th class="col-md-1 col-sm-1 col-xs-1 text-center">
										<i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
									</th>
								</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>			
					</div>
				</div>

               <div class="form-group row"> 
                        <label for="display_serial" class="col-md-2"><?php echo lang('display_serial') ?> <span class="text-danger"></span></label>
                        <div class="col-md-4">
                            <input name="display_serial" class="form-control" type="text" placeholder="<?php echo ('display serial') ?>" id="" value="<?= $product->display_serial ? $product->display_serial : '' ?>">
                        </div>
                        <label for="code" class="col-md-2"><?php echo lang('code') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-3">
							<?php 
							$Settings = new stdClass(); 
							$Settings->use_code_for_slug = '';
							?>
							<input name="code" type="text" class="form-control<?= ($Settings->use_code_for_slug ? ' gen_slug' : '') ?>" id="code"  placeholder="<?php echo ('code') ?>" value="<?= $product->code ? $product->code : '' ?>" required="required">
                            
	                    </div>
						<div class="col-md-1">
							<span class="form-control pointer" id="random_num" style="padding: 5px 10px;">
                                <i class="fa fa-random"></i>
                            </span>
	                    </div>
	            </div> 

	            <div class="form-group row">   
						<label for="is_packed" class="col-md-2"><?php echo lang('is_packed') ?> </label>	
						<div class="col-md-4">
							<input name="is_packed" type="checkbox" class="checkbox" id="is_packed" value="1" <?= $product->is_packed ? 'Checked' : '' ?>/>
	           	 		</div> 	
               </div>

			   <div id="packed_product_area" style="display:none;">				
			   <div class="form-group row"> 
                        <label for="packed_product" class="col-md-2"><?php echo lang('packed_product') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="packed_product" class="form-control select" id="packed_product">
								<option value="">Select packed product</option>
								<?php foreach($products as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product->packed_product == $row->id ? 'selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <label for="pack_piece" class="col-md-2"><?php echo lang('pack_piece') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                       <input name="pack_piece" class="form-control" type="text" value="<?= $product->pack_piece ? $product->pack_piece : ''  ?>" id="pack_piece">
	                    </div>
	            </div>
				</div>

				<div class="form-group row"> 
                        <label for="category" class="col-md-2"><?php echo lang('category') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
							<select name="category" class="form-control select" id="category" required="required">
								<option>Select Category</option>
								<?php foreach($categories as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product->category_id == $row->id ? 'selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <label for="subcategory" class="col-md-2"><?php echo lang('subcategory') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="subcategory" class="form-control select" id="subcategory">
								<option value="">Select category to load</option>
							</select>
	                    </div>
	            </div>

				<div class="form-group row"> 
						<label for="unit" class="col-md-2"><?php echo lang('unit') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
							<select name="unit" class="form-control select" id="unit" required="required">
								<option value="">Select unit</option>
								
								<?php foreach($units as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product->unit == $row->id ? 'selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	                    </div>

                        <label for="brand" class="col-md-2"><?php echo lang('brand') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="brand" class="form-control select" id="brand">
								<option value="">Select Brand</option>
								<?php foreach($brands as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $_POST['brand'] == $row->id ? 'selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>    
	            </div>
				
				<div class="form-group row"> 
                        <label for="product_cost" class="col-md-2"><?php echo lang('product_cost') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                        <input name="cost" class="form-control" type="text" placeholder="<?php echo 'product cost' ?>" id="cost" required="required" value="<?= $product->cost ? $product->cost : '' ?>">
	           	 		</div>      

	                    <label for="product_price" class="col-md-2"><?php echo lang('product_price') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="price" class="form-control" type="text" placeholder="<?php echo ('product price') ?>" id="price" required="required" value="<?= $product->price ? $product->price : '' ?>">
	                    </div>
	            </div>

				<div class="form-group row"> 
                        <label for="slug" class="col-md-2"><?php echo lang('slug') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="slug" class="form-control" type="text" placeholder="<?php echo 'slug' ?>" id="slug" value="<?= $product->slug ? $product->slug : '' ?>">
	           	 		</div>      

	                    <label for="second_name" class="col-md-2"><?php echo lang('second_name') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                       <input name="second_name" class="form-control" type="text" placeholder="<?php echo ('second name') ?>" id="second_name" value="<?= $product->second_name ? $product->second_name : '' ?>">
	                    </div>
	            </div>

	            <div class="form-group row">
	            		<label for="weight" class="col-md-2 standard_combo"><?php echo lang('weight') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="weight" class="form-control standard_combo" type="text" placeholder="<?php echo lang('weight') ?>" id="weight" value="<?= $product->weight ? $product->weight : '' ?>">
	           	 		</div>      

	                    <label for="barcode_symbology" class="col-md-2"><?php echo lang('barcode_symbology') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <?php
							$bs = ['code25' => 'Code25', 'code39' => 'Code39', 'code128' => 'Code128', 'ean8' => 'EAN8', 'ean13' => 'EAN13', 'upca' => 'UPC-A', 'upce' => 'UPC-E'];
							?>
							<select name="barcode_symbology" class="form-control select" id="barcode_symbology" required="required">
								<?php foreach($bs as $key => $value) { ?>
									<option value="<?php echo $key; ?>" <?= $key == $product->barcode_symbology ? 'Selected' : '' ?>><?php echo $value;?></option>
								<?php } ?>
							</select>
	                    </div>
	                    
	            </div>

				<div class="form-group row"> 
                        <label for="product_tax" class="col-md-2"><?php echo lang('product_tax') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="tax_rate" class="form-control select" id="tax_rate">
								<option>Select</option>
								<?php foreach($tax_rates as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $row->id == $product->tax_rate ? 'Selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <label for="tax_method" class="col-md-2"><?php echo lang('tax_method') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<?php
                            	$tm = ['1' => 'exclusive', '0' => 'inclusive'];
							?>
							<select name="tax_method" class="form-control select" id="tax_method">
	                       		<?php foreach($tm as $key => $value) { ?>
									<option value="<?php echo $key; ?>" <?= $product->tax_method == $key ? 'selected' : '' ?>><?php echo $value;?></option>
								<?php } ?>
							</select>
	                    </div>
	            </div>

				<div class="form-group row"> 
                        <label for="alert_quantity" class="col-md-2"><?php echo lang('alert_quantity') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="alert_quantity" class="form-control" type="text" placeholder="<?php echo 'Alert Quantity' ?>" id="alert_quantity" value="<?= $product->alert_quantity ? $product->alert_quantity : '' ?>">
	           	 		</div>      

	                    <label for="product_image" class="col-md-2"><?php echo lang('product_image') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<input type="file" name="image" class="form-control" id="image" tabindex="4">
	                    </div>
	            </div>

				<div class="form-group row"> 
                        <label for="select_printer" class="col-md-2"><?php echo lang('select_printer') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="printer_selection" class="form-control select" id="unit">
								<option value="">Select Printer</option>
								<?php foreach($printers as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product == $row->id ? 'selected' : '' ?>><?php echo $row->title;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <label for="hide_pos" class="col-md-2"><?php echo lang('hide_pos') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<input name="hide_pos" type="checkbox" class="checkbox" id="hide_pos" value="1" <?= $product->hide_pos ? 'Checked' : '' ?>/>
							
	           	 		</div>
	            </div>

				<div class="standard">

				<div class="form-group row">
					<div class="col-md-6">
					<?php
						if ($product_options) {
							?>
						<table class="table table-bordered table-condensed table-striped"
								style="<?= $product_options ? '' : 'display:none;'; ?> margin-top: 10px;">
							<thead>
							<tr class="active">
								<th><?= lang('name') ?></th>
								<th><?= ('warehouse') ?></th>
								<th><?= ('quantity') ?></th>
								<th><?= ('price addition') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ($product_options as $option) {
								echo '<tr><td class="col-xs-3"><input type="hidden" name="attr_id[]" value="' . $option->id . '"><span>' . $option->name . '</span></td><td class="code text-center col-xs-3"><span>' . $option->wh_name . '</span></td><td class="quantity text-center col-xs-2"><span>' . $this->sls->formatQuantity($option->wh_qty) . '</span></td><td class="price text-right col-xs-2">' . $this->sls->formatNumber($option->price) . '</td></tr>';
							} ?>
							</tbody>
						</table>
						<?php
						}		
						?>	
					</div>	

					<div class="col-md-6">
						<?php
						if ($product_variants) {
                                ?>
                                <h3 class="bold"><?=lang('update_variants'); ?></h3>
                                <table class="table table-bordered table-condensed table-striped" style="margin-top: 0px;">
                                <thead>
                                <tr class="active">
                                    <th class="col-xs-8"><?= lang('name') ?></th>
                                    <th class="col-xs-4"><?= ('price addition') ?></th>
									<th class="col-xs-4"> <?= 'Delete' ?> </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($product_variants as $pv) {
                                    echo '<tr><td class="col-xs-3"><input type="hidden" name="variant_id_' . $pv->id . '" value="' . $pv->id . '"><input type="text" name="variant_name_' . $pv->id . '" value="' . $pv->name . '" class="form-control"></td><td class="price text-right col-xs-2"><input type="text" name="variant_price_' . $pv->id . '" value="' . $pv->price . '" class="form-control"></td> <td> <span id="del_variant" data-pvid="'.$pv->id.'"><i class="fa fa-close"> </i> </span> </td></tr>';
                                } ?>
                                </tbody>
                                </table>
                            <?php
                            }
							?>
					</div>
				</div>
				

				<div class="form-group row"> 
                        <label for="product_variant" class="col-md-2"><?php echo lang('product_variant') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-1">
							<input type="checkbox" class="checkbox" name="attributes"
                                   id="attributes">
	           	 		</div>   
						<label for="product_details" class="col-md-3"><?php echo lang('product_variant_des') ?></label>	   
	            </div>
				</div>

				<div id="attr-con" style="display:none;">
					<div class="form-group row">
						<label for="product_variants" class="col-md-2"><?php echo ('Enter variants') ?> <span class="text-danger"></span></label>
						<div class="col-md-3">
							<input type="text" class="tagsinput" id="attributesInput" name="attributesInput" data-role="tagsinput">
						</div>
						<div class="col-md-1">
								<a href="#" id="addAttributes">
									<i class="fa fa-2x fa-plus-circle" id="addIcon"></i>
								</a>
						</div>	
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-6">
							<div class="table-responsive">
								<table id="attrTable" class="table table-bordered table-condensed table-striped"
									style="display:none; margin-bottom: 0; margin-top: 10px;">
									<thead>
									<tr class="active">
										<th><?= ('name') ?></th>
										<th><?= ('warehouse') ?></th>
										<th><?= ('quantity') ?></th>
										<th><?= ('price_addition') ?></th>
										<th><i class="fa fa-times attr-remove-all"></i></th>
									</tr>
									</thead>
									<tbody>
								
									</tbody>
								</table>
							</div>
					</div>			
				</div>

				<div class="form-group row"> 
                        <label for="supplier1" class="col-md-2"><?php echo lang('supplier1') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="supplier_1" class="form-control select" id="supplier_1">
								<option value="">Select Supplier</option>
								<?php foreach($suppliers as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product->supplier1 == $row->id ? 'Selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <div class="col-md-3">
	                       <input name="supplier_1_part_no" class="form-control" type="text" placeholder="<?php echo ('Supplier Part No.') ?>" id="supplier_1_part_no" value="<?= $product->supplier_1_part_no ? $product->supplier_1_part_no : '' ?>">
	                    </div>
						
	                    <div class="col-md-3">
	                       <input name="supplier_1_price" class="form-control" type="text" placeholder="<?php echo ('Supplier Price') ?>" id="supplier_1_price" value="<?= $product->supplier_1_price ? $product->supplier_1_price : '' ?>">
	                    </div>
	            </div>

				<div class="form-group row"> 
                        <label for="supplier2" class="col-md-2"><?php echo lang('supplier2') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<select name="supplier2" class="form-control select" id="supplier2">
								<option value="">Select Supplier</option>
								<?php foreach($suppliers as $row) { ?>
									<option value="<?php echo $row->id; ?>" <?= $product->supplier2 == $row->id ? 'Selected' : '' ?>><?php echo $row->name;?></option>
								<?php } ?>
							</select>
	           	 		</div>      

	                    <div class="col-md-3">
	                       <input name="supplier2_part_no" class="form-control" type="text" placeholder="<?php echo ('Supplier Part No.') ?>" id="supplier2_part_no" value="<?= $product->supplier_2_part_no ? $product->supplier_2_part_no : '' ?>">
	                    </div>
						
	                    <div class="col-md-3">
	                       <input name="supplier_2_price" class="form-control" type="text" placeholder="<?php echo ('Supplier Price') ?>" id="supplier_2_price" value="<?= $product->supplier_2_part_no ? $product->supplier_2_part_no : '' ?>">
	                    </div>
	            </div>
				
				<div class="form-group row"> 
                        <label for="product_details" class="col-md-2"><?php echo lang('product_details') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
							<textarea name="product_details" class="form-control" id="product_details"> <?= $product->product_details ? $product->product_details : '' ?> </textarea>
	           	 		</div>      
	            </div>

	            <div class="form-group">
	    			<button type="submit"  class="btn btn-success w-md m-b-5"><?php echo lang('edit') ?></button>
	                <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo lang('reset') ?></button>
	             </div>
	             <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

<link href="https://jqueryvalidation.org/files/demo/css/screen.css" rel="stylesheet">

<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
<!-- jquery-validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

<!-- jquery-validation -->
<!-- <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script> -->
<!-- <script src="../../plugins/jquery-validation/additional-methods.min.js"></script> -->


<script>
$("#create_product").validate();

$(document).ready(function() {

	let items = {};
	<?php
	if ($combo_items) {
		echo '
			let ci = ' . json_encode($combo_items) . ';
			$.each(ci, function() { add_product_item(this); });
			';
	}
	?>
	$('.gen_slug').change(function(e) {

		console.log($(this).val());
		var pattern = /[\u0600-\u06FF\u0750-\u077F]/;
		var rend=Math.random();
		if(pattern.test($(this).val())){
			getSlug(rend, 'products');
		}else{
			getSlug($(this).val(), 'products');
		}
		$("#code").val(rend);

	});
	$('#random_num').click(function () {
        var code = generateCardNo(8);
        $(this).parent('.input-group').children('input').val(code);
        // if (site.settings.use_code_for_slug) {
            getSlug(code, 'product');
        // }
    });
	function getSlug(title, type) {
		var slug_url = site.base_url + 'product/slug';
		$.get(slug_url, { title: title, type: type }, function (slug) {
			$('#slug').val(slug).change();
			$("#code").val(slug);
		});
	}
	function generateCardNo(x) {
		if (!x) {
			x = 16;
		}
		chars = '1234567890';
		no = '';
		for (var i = 0; i < x; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			no += chars.substring(rnum, rnum + 1);
		}
		return no;
	}

	$('#is_packed').on('click', function (e) {
		if($('#is_packed').is(':checked')) {
			$('#packed_product_area').slideDown();
		} else {
			$('#packed_product_area').slideUp();
		}
	});
	$('#attributes').on('click', function (e) {
		if($('#attributes').is(':checked')) {
			$('#attr-con').slideDown();
		} else {
			$(".select-tags").select2("val", "");
			$('#attr-con').slideUp();
		}
	});

	$('#addAttributes').click(function (e) {
		e.preventDefault();
		var attrs_val = $('#attributesInput').val(), attrs;
		// console.log(attrs_val);
		attrs = attrs_val.split(',');

		for (var i in attrs) {
		if (attrs[i] !== '') {
            <?php if (!empty($warehouses)) {
            	foreach ($warehouses as $warehouse) {
                	echo '$(\'#attrTable\').show().append(\'<tr class="attr"><td><input type="hidden" name="attr_name[]" value="\' + attrs[i] + \'"><span>\' + attrs[i] + \'</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value="' . $warehouse->id . '"><span>' . $warehouse->name . '</span></td><td class="quantity text-right"><input type="hidden" name="attr_quantity[]" value="0"><span>0</span></span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>\');';
            	}
        	} else {
            	?>
				$('#attrTable').show().append('<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' + attrs[i] + '"><span>' + attrs[i] + '</span></td><td class="code text-center"><input type="hidden" name="attr_warehouse[]" value=""><span></span></td><td class="quantity text-right"><input type="hidden" name="attr_quantity[]" value="0"><span>0</span></span></td><td class="price text-right"><input type="hidden" name="attr_price[]" value="0"><span>0</span></span></td><td class="text-center"><i class="fa fa-times delAttr"></i></td></tr>');
            <?php
        	} ?>
                
		}
        }
        });

		$(document).on('click', '.delAttr', function () {
            $(this).closest("tr").remove();
        });
        $(document).on('click', '.attr-remove-all', function () {
            $('#attrTable tbody').empty();
            $('#attrTable').hide();
        });
        var row, warehouses = <?= json_encode($warehouses); ?>;
        $(document).on('click', '.attr td:not(:last-child)', function () {
            row = $(this).closest("tr");
            $('#aModalLabel').text(row.children().eq(0).find('span').text());
            // $('#awarehouse').select2("val", (row.children().eq(1).find('input').val()));
			$('#awarehouse').val(row.children().eq(1).find('input').val());
            $('#aquantity').val(row.children().eq(2).find('input').val());
            $('#aprice').val(row.children().eq(3).find('span').text());
            $('#aModal').appendTo('body').modal('show');
        });

		$(document).on('click', '#updateAttr', function () {
            var wh = $('#awarehouse').val(), wh_name;
            $.each(warehouses, function () {
                if (this.id == wh) {
                    wh_name = this.name;
                }
            });
            row.children().eq(1).html('<input type="hidden" name="attr_warehouse[]" value="' + wh + '"><input type="hidden" name="attr_wh_name[]" value="' + wh_name + '"><span>' + wh_name + '</span>');
            row.children().eq(2).html('<input type="hidden" name="attr_quantity[]" value="' + $('#aquantity').val() + '"><span>' + parseFloat($('#aquantity').val()).toFixed(2) + '</span>');
			row.children().eq(3).html('<input type="hidden" name="attr_price[]" value="' + $('#aprice').val() + '"><span>' + parseFloat($('#aprice').val()).toFixed(2) + '</span>');
            $('#aModal').modal('hide');
        });

		$(document).on('click', '#del_variant', function () {
			const pvid = $(this).data('pvid');
			// console.log($(this).closest('tr')); 
			$(this).closest('tr').remove();
			$.ajax({
				url: site.base_url + 'product/product/delete_product_variant',
				method: 'post',
				data: { pvid: pvid },
				success: function(data) {
					// $('table').reload();
					// $(this).closest('tr').remove();
				}
			});
		});

		$('#type').change(function () {
            var t = $(this).val();
			console.log(t);
            if (t !== 'standard') {
                $('.standard').slideUp();
                $('#unit').attr('disabled', true);
                $('#cost').attr('disabled', true);
				$('#attributesInput').val('');
				$('#attrTable tbody').empty();
                // $('#track_quantity').iCheck('uncheck');
            } else {
                $('.standard').slideDown();
                // $('#track_quantity').iCheck('check');
				
                $('#unit').attr('disabled', false);
                $('#cost').attr('disabled', false);
            }
            if (t !== 'digital') {
                $('.digital').slideUp();
                $('#file_link').removeAttr('required');
                // $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
            } else {
                $('.digital').slideDown();
                $('#file_link').attr('required', 'required');
                // $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
            }
            if (t !== 'combo') {
                $('.combo').slideUp();
            } else {
                $('.combo').slideDown();
            }
            if (t == 'standard' || t == 'combo') {
                $('.standard_combo').slideDown();
            } else {
                $('.standard_combo').slideUp();
            }
        });

		var t = $('#type').val();
        if (t !== 'standard') {
            $('.standard').slideUp();
            $('#unit').attr('disabled', true);
            $('#cost').attr('disabled', true);
            // $('#track_quantity').iCheck('uncheck');
        } else {
            $('.standard').slideDown();
            // $('#track_quantity').iCheck('check');
            $('#unit').attr('disabled', false);
            $('#cost').attr('disabled', false);
        }
        if (t !== 'digital') {
            $('.digital').slideUp();
            $('#file_link').removeAttr('required');
            // $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'file_link');
        } else {
            $('.digital').slideDown();
            $('#file_link').attr('required', 'required');
            // $('form[data-toggle="validator"]').bootstrapValidator('addField', 'file_link');
        }
        if (t !== 'combo') {
            $('.combo').slideUp();
        } else {
            $('.combo').slideDown();
        }
        if (t == 'standard' || t == 'combo') {
            $('.standard_combo').slideDown();
        } else {
            $('.standard_combo').slideUp();
        }

		$("#add_item").autocomplete({
            
            source: site.base_url + 'product/product/suggestions',
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
				// console.log(ui.item);
                if (ui.item.id !== 0) {
                    var row = add_product_item(ui.item);
                    if (row) {
                        $(this).val('');
                    }
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>');
                }
            }
        });
		
		function add_product_item(item) {
            if (item == null) {
                return false;
            }
            item_id = item.id;
            if (items[item_id]) {
                items[item_id].qty = (parseFloat(items[item_id].qty) + 1).toFixed(2);
            } else {
                items[item_id] = item;
            }
			console.log(items);
            let pp = 0.0;
            $("#prTable tbody").empty();
            $.each(items, function () {
                var row_no = this.id;
                var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '"></tr>');
                tr_html = '<td><input name="combo_item_id[]" type="hidden" value="' + this.id + '"><input name="combo_item_name[]" type="hidden" value="' + this.name + '"><input name="combo_item_code[]" type="hidden" value="' + this.code + '"><span id="name_' + row_no + '">' + this.code + ' - ' + this.name + '</span></td>';
                tr_html += '<td><input class="form-control text-center rquantity" name="combo_item_quantity[]" type="text" value="' + formatDecimal(this.qty) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td><input class="form-control text-center rprice" name="combo_item_price[]" type="text" value="' + formatDecimal(this.price) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="combo_item_price_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.prependTo("#prTable");
				
				let price = parseFloat(this.price) * parseFloat(this.qty);
                pp += price;
				
            });
            $('.item_' + item_id).addClass('warning');
            $('#price').val(pp);
            return true;
        }

		$(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete items[id];
            $(this).closest('#row_' + id).remove();
            calculate_price();
        });
		function calculate_price() {
            var rows = $('#prTable').children('tbody').children('tr');
            var pp = 0.0;
            $.each(rows, function () {
                pp += formatDecimal(parseFloat($(this).find('.rprice').val())*parseFloat($(this).find('.rquantity').val()));
            });
            $('#price').val(pp);
            return true;
        }

        $(document).on('change', '.rquantity, .rprice', function () {
            calculate_price();
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete items[id];
            $(this).closest('#row_' + id).remove();
            calculate_price();
        });
	
});
	
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

<div class="modal" id="aModal" tabindex="-1" role="dialog" aria-labelledby="aModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
			<h4 class="modal-title" id="aModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                    <iclass="fa fa-2x">&times;</i></span><span class="sr-only">Close</span>
                </button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="awarehouse" class="col-sm-4 control-label"><?= ('warehouse') ?></label>
                        <div class="col-sm-8">
                            <?php
                            // $wh[''] = '';
                            foreach ($warehouses as $warehouse) {
                                $wh[$warehouse->id] = $warehouse->name;
                            }
                            echo form_dropdown('warehouse', $wh, '', 'id="awarehouse" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="aquantity" class="col-sm-4 control-label"><?= ('quantity') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="aquantity">
                        </div>
                    </div>
                    <input type="hidden" id="aquantity" value="0">
                    <div class="form-group">
                        <label for="aprice" class="col-sm-4 control-label"><?= ('price_addition') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="aprice">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateAttr"><?= ('submit') ?></button>
            </div>
        </div>
    </div>
</div>