
<div class="row">
    <div class="col-sm-12 col-md-12">

	<div class="panel panel-default">
		<div class="panel-heading" style="border-bottom: 1px solid #e4e5e7; margin-bottom: 5px;">

			<div class="row">
				<div class="col-md-6">
					<h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo "Units" ?> </h3>
				</div>
				<div class="col-md-6">
					<div class="box-icon d-flex flex-row float-right"> 
							<div class="px-2 border-left">
								<?php
                                    echo '<a href="#" class="add_unit"> <i class="fa fa-plus-circle"> </i> '. '</a>';
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
				            <th>Unit Code</th>
				            <th>Unit Name</th>
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
	          url:'<?php echo base_url(); ?>'+"settings/settings/get_units",
	          type: "POST",
	          data:{
	            customf : customf
	          }
	      },

	    });

	    }

	    $(document).on('change','#filter_username', function(){
		      var value = $(this).val();
		      $('.datatable_display').DataTable().destroy();
		      fill_datatable(value);
	    });
        
        $(document).on('click', '.add_unit', function(){
		    $.ajax({
                url: site.base_url + 'settings/settings/add_unit',
                success: function(response) {
                    $('#myModal').html(response);
                    $('#myModal').modal('show');
                }
                });
		});
        $(document).on('click', '.edit_unit', function(){
            let id = $(this).data('id');
            $.ajax({
                url: site.base_url + 'settings/settings/edit_unit/' + id,
                success: function(response) {
                    $('#myModal').html(response);
                    $('#myModal').modal('show');
                }
            });

	    });
	    // In your Javascript (external .js resource or <script> tag)
		
		$('.select2').select2();

	});
</script>


