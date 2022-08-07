	<link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                
                <div class="panel-body">
                <?php echo form_open_multipart("create_customer", array("id"=>"create_customer")) ?>
                    
                   

              <div class="form-group row">          
	                    <label for="customer_name" class="col-md-2"><?php echo lang('customer_name') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="customer_name" class="form-control" type="text" placeholder="<?php echo lang('customer_name') ?>" id="customer_name" minlength="2" >
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

	            <div class="form-group">
	    			<button type="submit"  class="btn btn-success w-md m-b-5"><?php echo lang('add_customer') ?></button>
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
$("#create_customer").validate();
</script>

 <script>
   const phoneInputField = document.querySelector("#phone");
   const phoneInput = window.intlTelInput(phoneInputField, {
   	 separateDialCode: true,
     utilsScript:
       "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
   });
   $(document).on("keyup", "#phone", function(){
      const phoneNumber = phoneInput.getNumber();
      $("#phone_hidden").val(phoneNumber);
    });
   phoneInputField.addEventListener("countrychange", function() {
   		$("#phone").val("");
   		console.log();
      console.log(phoneInput.getSelectedCountryData());
   });
 </script>