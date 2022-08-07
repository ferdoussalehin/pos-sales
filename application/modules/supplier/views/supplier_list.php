
<div class="row">
    <div class="col-sm-12 col-md-12">

	<div class="panel panel-default">
		<div class="panel-heading" style="border-bottom: 1px solid #e4e5e7; margin-bottom: 5px;">

			<div class="row">
				<div class="col-md-6">
					<h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo "Supplier List" ?> </h3>
				</div>
				<div class="col-md-6">
					<div class="box-icon d-flex flex-row float-right"> 
							<div class="px-2 border-left">
								<?php
									echo  anchor("create_supplier/", '<i class="fa fa-plus-circle"></i>', array('class'=>'', 'title'=>'Add Supplier'));
								?>
							</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="panel-body">
			<div class="">
				<table class="table table-bordered table-hover datatable_display">
			        <thead>
				        <tr>
				            <th>ID</th>
				            <th>Name</th>
				            <th>Company Name</th>
				            <th>Email</th>
				            <th>Phone</th>
				            <th>Address</th>
				            <th>City</th>
				            
				            <th>Country</th>
				            <th>Action</th>
				        </tr>
				     </thead>
				     <tbody>
				     	
				     </tbody>

			    </table>

			</div>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		fill_datatable();

	function fill_datatable(customf = ''){
		//console.log(customf);
	    var customerDataTable = $(".datatable_display").DataTable({
	      language: {
	          paginate: {
	          next: '&#8250;',
	          previous: '&#8249;'
	        }
	      },
	      searching: true,
	      info: true,
	      "lengthChange": true,
	      "processing" : true,
	      "serverSide" : true,
	      "responsive": true,
	      "order" : [2],
	      "ajax":{
	          url:'<?php echo base_url(); ?>'+"supplier/supplier/get_all_supplier",
	          type: "POST",
	          data:{
	            customf : customf
	          }
	      },

	      // "columnDefs": [
	      // {
	      // "targets":[2],
	      // "orderable": true,
	      // }
	      // ]
	    });

	    }

	    $(document).on('change','#filter_username', function(){
		      var value = $(this).val();
		      $('.datatable_display').DataTable().destroy();
		      fill_datatable(value);
	    });

	    // In your Javascript (external .js resource or <script> tag)
		
		$('.select2').select2();

	});
</script>


