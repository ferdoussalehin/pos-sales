<style>
.product_link {
	cursor: pointer;
}
.box-icon {
	font-size: 18px;
}
.purchase_link {
    cursor: pointer;
} 
</style>
<div class="panel panel-default">
	
  	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo "Purchase List" ?> </h3>
			</div>
			<div class="col-md-6">
				<div class="box-icon d-flex flex-row float-right"> 
						<div class="px-2 border-left">
							<?php
								echo  anchor("purchases/add", '<i class="fa fa-plus-circle"></i>', array('class'=>'', 'title'=>'Add Purchase'));
							?>
						</div>
						
						<div class="dropdown px-2 border-left">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon fa fa-tasks tip" data-placement="left" title="" data-original-title="Actions"></i>
							</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="<?= base_url() ?>pos/add"><i class="fa fa-plus-circle"></i> Add Product</a>
								<a id="price_excel" class="dropdown-item" href="#"> <i class="icon fa fa-file-excel-o"></i> Export Excel</a>
								
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
  <div class="panel-body">
	<div class="row">
    	<div class="col-sm-12 col-md-12">
			
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable_display">
			        <thead>
				        <tr>
				            <th><?= lang('id') ?></th>
							<th><?= lang('date') ?></th>
				            <th><?= lang('reference_no') ?></th>
				            <th><?= lang('supplier') ?></th>
				            <th><?= lang('grand_total') ?></th>
				            <th><?= lang('paid') ?></th>
				            <th><?= lang('balance') ?></th>
				            <th><?= lang('purchase_status') ?></th>
				            <th><?= lang('payment_status') ?></th>
				            <th >Action</th>
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
		  lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        	],
	      searching: true,
	      info: true,
	      lengthChange: true,
	      processing : true,
	      serverSide : true,
	      responsive: true,
	      
	      ajax:{
	          url:'<?php echo base_url(); ?>'+"purchases/purchases/getPurchases",
	          type: "POST",
	          data:{
	            customf : customf
	          }
	      },
		  createdRow: function(row, data, dataIndex) {
				row.id = data[0];
				$(row).addClass('purchase_link');
            	return row;
		  },
		  order: [],
	    });
	}


	$('body').on('click', '.purchase_link td:not(:first-child, :nth-child(9), :last-child)', function () {
        
		var id = $(this).parent('.purchase_link').attr('id');
		$.ajax({
            type:"get",
            url: site.base_url + 'purchases/purchases/modal_view/',
            data: { id: id },
            dataType: 'html',
            success: function(response){
				$('#myModal').html(response);
				$('#myModal').modal('show');
           }
        });
	});
	$(document).on('click', '#price_pdf', function(){
		var categoryId = $("#category_id").val();
		window.location.href = "<?= base_url('product/product/pdf_product_list/')?>"+categoryId ;
        return false;
	})
	$(document).on('click', '#price_excel', function(){
		var categoryId = $("#category_id").val();
		window.location.href = "<?= base_url('product/product/product_list_excel/')?>" +categoryId;
        return false;
	})

	$(document).on('click', '.add_payment', function(){
		const id = $(this).data('id');
		$.ajax({
			url: site.base_url + 'sales/pos/add_payment/',
			type: 'GET',
			dataType: 'html',
			data: {id: id},
			success: function(response) {
				$('#myModal').html(response);
				$('#myModal').modal('show');
			}
		});

	});
	$(document).on('click', '.view_payment', function(){
		const id = $(this).data('id');
		$.ajax({
			url: site.base_url + 'sales/pos/view_payment/',
			type: 'GET',
			dataType: 'html',
			data: {id: id},
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
