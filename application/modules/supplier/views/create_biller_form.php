

<div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                
                <div class="panel-body">
                <?php echo form_open_multipart("create_biller", array("id"=>"create_biller")) ?>
                    
                   

              <div class="form-group row">          
	                    <label for="name" class="col-md-2"><?php echo lang('name') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="name" class="form-control" type="text" placeholder="<?php echo lang('name') ?>" id="name" minlength="2" >
	                    </div>
	                    <label for="company_name" class="col-md-2"><?php echo lang('company_name') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="company_name" class="form-control" type="text" placeholder="<?php echo lang('company_name') ?>" id="company_name" minlength="2">
	           	 		</div>
               </div>

               <div class="form-group row"> 
                        <label for="phone" class="col-md-2"><?php echo lang('phone') ?> <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input name="phone" class="form-control" type="text" placeholder="<?php echo lang('phone') ?>" id="" minlength="4" >
                        </div>
                        <label for="email" class="col-md-2"><?php echo lang('email') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="email" class="form-control" type="email" placeholder="<?php echo lang('email') ?>" id="email" >
	                    </div>
	            </div> 

	            <div class="form-group row">    
	            		<label for="address" class="col-md-2"><?php echo lang('address') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                        <input name="address" class="form-control" type="text" placeholder="<?php echo lang('address') ?>" id="address" minlength="4" >
	                        
	           	 		</div>      
	                    <label for="city" class="col-md-2"><?php echo lang('city') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="city" class="form-control" type="text" placeholder="<?php echo lang('city') ?>" id="city" >
	                    </div>
               </div>

	            <div class="form-group row"> 

                        <label for="state" class="col-md-2"><?php echo lang('state') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="state" class="form-control" type="text" placeholder="<?php echo lang('state') ?>" id="state" minlength="4">
	                        
	           	 		</div>      
	                    <label for="zip" class="col-md-2"><?php echo lang('zip') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                       <input name="zip" class="form-control" type="text" placeholder="<?php echo lang('zip') ?>" id="zip">
	                    </div>
	            </div>

	            <div class="form-group row">
	            	
	            		<label for="country" class="col-md-2"><?php echo lang('country') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                        <input name="country" class="form-control" type="text" placeholder="<?php echo lang('country') ?>" id="country" minlength="4">
	                        
	           	 		</div>      
	                    <label for="vat_number" class="col-md-2"><?php echo lang('vat_number') ?> <span class="text-danger"></span></label>
	                    <div class="col-md-4">
	                       <input name="vat_number" class="form-control" type="text" placeholder="<?php echo lang('vat_number') ?>" id="vat_number">
	                    </div>
	                    
	              </div>
                  <div class="form-group row">
	            	
	            		<label for="image" class="col-md-2"><?php echo ('Image') ?></label>
		                <div class="col-md-4">
	                        <div>
	                            <input type="file" name="image" id="edit_image" class="custom-input-file" />
	                           
	                        </div>
		                </div>
	                    <label for="preview" class="col-md-2"><?php echo ('Preview') ?></label>
	                    <div class="col-md-4">
	                        <img src="<?php echo base_url(!empty($user->image) ? $user->image : "./assets/admin/img/icons/default.png") ?>" class="img-thumbnail" width="125" height="100">
	                    </div>
	                    <div class="">

	                    </div>
	                    <input type="hidden" name="old_image" id="old_image" value="<?php echo $user->image ?>">
	              </div>

	            <div class="form-group">
	    			<button type="submit"  class="btn btn-success w-md m-b-5"><?php echo lang('add_supplier') ?></button>
	                <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo lang('reset') ?></button>
	             </div>
	             <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

<link href="https://jqueryvalidation.org/files/demo/css/screen.css" rel="stylesheet">

<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
$("#create_supplier").validate();
</script>

 