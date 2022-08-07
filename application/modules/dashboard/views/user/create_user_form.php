	<link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                
                <div class="panel-body">
                <?php echo form_open_multipart("create_user", array("id"=>"create_user")) ?>
                    
                   

              <div class="form-group row">          
	                    <label for="firstname" class="col-md-2"><?php echo lang('first_name') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="firstname" class="form-control" type="text" placeholder="<?php echo lang('first_name') ?>" id="firstname" minlength="2">
	                    </div>
	                    <label for="lastname" class="col-md-2"><?php echo lang('last_name') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                        <input name="lastname" class="form-control" type="text" placeholder="<?php echo lang('last_name') ?>" id="lastname" minlength="2">
	           	 		</div>
               </div>

               <div class="form-group row"> 
                        <label for="username" class="col-md-2"><?php echo ('Username') ?> <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input name="username" class="form-control" type="text" placeholder="<?php echo ('Username') ?>" id="username_id" minlength="4">
                        </div>
                        <label for="password" class="col-md-2"><?php echo ('Password') ?> <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input name="password" class="form-control" type="password" placeholder="<?php echo ('Password') ?>" id="password" minlength="4">
                            
                        </div>
	            </div> 

	            <div class="form-group row">    
	            		<label for="phone" class="col-md-2"><?php echo ('Phone') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                        <input name="phone" class="form-control" type="tel" placeholder="" id="phone" value="<?php echo $user->phone ?>" minlength="4">
	                        <input name="phone_hidden" type="hidden" id="phone_hidden">
	           	 		</div>      
	                    <label for="email" class="col-md-2"><?php echo ('Email') ?> <span class="text-danger">*</span></label>
	                    <div class="col-md-4">
	                       <input name="email" class="form-control" type="email" placeholder="<?php echo ('Email') ?>" id="email">
	                    </div>
               </div>

	            <div class="form-group row"> 

                        <label for="user_type" class="col-md-2"><?php echo ('User Type')?> <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <label class="radio-inline">
                                <?php echo form_radio('user_type', '0',(($user->user_type==0 || $user->user_type==null)?true:false) , 'id="user_type"'); ?>User
                            </label> &nbsp;&nbsp;
                            <label class="radio-inline">
                                <?php echo form_radio('user_type', '1', (($user->user_type==1)?true:false), 'id="user_type"'); ?>Admin
                            </label>
                           
                        </div>
                        <label for="status" class="col-md-2"><?php echo ('Status')?> <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($user->status==1 || $user->status==null)?true:false), 'id="status"'); ?>Active
                            </label> &nbsp;&nbsp;
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($user->status=="0")?true:false) , 'id="status"'); ?>Inactive
                            </label> 
                        </div>
	            </div>

	            <div class="form-group row">
	            	
	            		<label for="image" class="col-md-2"><?php echo ('Image') ?></label>
		                <div class="col-md-4">
	                        <div>
	                            <input type="file" name="image" id="edit_image" class="custom-input-file" />
	                           
	                        </div>
		                </div>
	                    
	                    <div class="">
	                    </div>
	                    
	              </div>

	            <div class="form-group">
	    			<button type="submit"  class="btn btn-success w-md m-b-5"><?php echo ('Add User') ?></button>
	                <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo ('Reset') ?></button>
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
$("#create_user").validate();
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