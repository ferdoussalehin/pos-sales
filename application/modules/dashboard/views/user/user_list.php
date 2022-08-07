
<div class="row">
    <div class="col-sm-12 col-md-12">

	<div class="panel panel-default">

		<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3> <i class="fa-fw fa fa-plus border-right"></i> <?php echo "User List" ?> </h3>
			</div>
			<div class="col-md-6">
				<div class="box-icon d-flex flex-row float-right">
					<div class="px-2 border-left">
						<?php
							echo  anchor("create_user/", '<i class="fa fa-plus-circle"></i>', array('class'=>'', 'title'=>'Add Product'));
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
				            <th>SL No</th>
				            <th>Image</th>
				            <th>User Name</th>
				            <th>Email</th>
				            <th>Phone</th>
				            <th>Name</th>
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
	          url:'<?php echo base_url(); ?>'+"dashboard/user/get_all_users",
	          type: "POST",
	          data:{
	            customf : customf
	          }
	      },
	     "createdRow": function( row, data, dataIndex ) {
	        $( row ).find('td:eq(0)').attr('data-label', 'SL No');
	        $( row ).find('td:eq(1)').attr('data-label', 'Image');
	        $( row ).find('td:eq(2)').attr('data-label', 'Username');
	        $( row ).find('td:eq(3)').attr('data-label', 'Email');
	        $( row ).find('td:eq(4)').attr('data-label', 'Phone');
	        $( row ).find('td:eq(5)').attr('data-label', 'Name');
	        $( row ).find('td:eq(6)').attr('data-label', 'Action');
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


