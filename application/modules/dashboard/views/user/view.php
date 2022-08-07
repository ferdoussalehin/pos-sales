<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel panel-default">
	
	<div class="panel-heading">
	  <div class="row">
		  <div class="col-md-6">
		  	 <h3> <i class="fa-fw fa fa-plus border-right"></i> <?php echo "User Detail" ?> </h3>
		  </div>
		  <div class="col-md-6">
			  <div class="box-icon d-flex flex-row float-right"> 
			  </div>
		  </div>
	  </div>
    </div>
  
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <?php 
                if($data->logo) {
                    echo '<img src="'. base_url().$data->logo.'"  id="" class="img-responsive img-thumbnail" style="width: 50%">';
                } else {
                    echo '<img src="'. base_url() .'assets/uploads/users/dummy.png" id="" class="img-responsive img-thumbnail" style="width: 50%">';
                }
                ?>
                
            </div>
            <div class="col-md-7">
                <div class="table-responsive">
                <table id="" class="table items table-striped table-bordered table-condensed table-hover">
                    <tbody>
                    
                    <tr>
                        <td>Name</td>
                        <td><span id="name"><?= $data->first_name . ' ' . $data->last_name; ?></span></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><span id="email"><?= $data->email ?></span></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><span id="phone"><?= $data->phone ?></span></td>
                    </tr>
                    <tr>
                        <td>Company Name</td>
                        <td><span id="company_name"><?= $data->company_name ?></span></td>
                    </tr>
                    <tr>
                        <td>User Type</td>
                        <td><span id="unit"><?= $data->user_type == 1 ? 'Admin' : 'User' ?></span></td>
                    </tr>
                    
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

</div>