<style>
.product_link {
	cursor: pointer;
}
.box-icon {
	font-size: 18px;
}
</style>
<div class="panel panel-default">
	
  	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo "Product List" ?> </h3>
			</div>
			<div class="col-md-6">
				<div class="box-icon d-flex flex-row float-right"> 
						<div class="px-2 border-left">
							<?php
								echo  anchor("create_product/", '<i class="fa fa-plus-circle"></i>', array('class'=>'', 'title'=>'Add Product'));
							?>
						</div>
						<div class="px-2 border-left">
							<a href="#" id="price_pdf" class="tip" title="<?= lang('download_pdf') ?>">
                                <i class="icon fa fa-file-pdf-o"></i>
                            </a>
						</div>
						<div class="px-2 border-left">
							<a href="#" id="price_excel" class="tip" title="<?= ('Download Pdf') ?>">
                                <i class="icon fa fa-file-excel-o"></i>
                            </a>
						</div>

						<div class="dropdown px-2 border-left">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon fa fa-tasks tip" data-placement="left" title="" data-original-title="Actions"></i>
							</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="<?= base_url() ?>create_product"><i class="fa fa-plus-circle"></i> Add Product</a>
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
			<div class="row">
				<div class="col-md-6">
					<select name="" id="category_id" class="form-control select">
						<option value="">Select</option>
						<?php foreach($categories as $value) { ?>
							<option value="<?= $value->id ?>"> <?= $value->name ?> </option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3">
					<a id="btnSearch" onclick="" class="btn btn-primary">Search</a>
				</div>
			</div>
			<br>
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable_display">
			        <thead>
				        <tr>
				            <th>ID</th>
							<th>Code</th>
				            <th>Name</th>
				            <th>Secondary Name</th>
				            <th>category</th>
				            <th>cost</th>
				            <th>price</th>
				            <th>unit</th>
				            <th>hide pos</th>
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
	          url:'<?php echo base_url(); ?>'+"product/product/get_all_products",
	          type: "POST",
	          data:{
	            customf : customf
	          }
	      },
		//   dom: 'Bfrtip',
		//   buttons: [
   		// 	 'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
  		//   ],
		  createdRow: function(row, data, dataIndex) {
				row.id = data[0];
				$(row).addClass('product_link');
			  	$('td:eq(8)', row).html(hide_pos(row, data));
            	return row;
		  },
		  order: [],
	    //   order: [[2, 'desc']],
	    });
	}

	$("#btnSearch").on("click", function(e){
		e.preventDefault();
        var categoryId = $("#category_id").val();
		console.log(categoryId);
		$('.datatable_display').DataTable().destroy();
		fill_datatable(categoryId);
	});

	$('body').on('click', '.product_link td:not(:first-child, :nth-child(9), :last-child)', function () {
        
		var id = $(this).parent('.product_link').attr('id');
		$.ajax({
            type:"POST",
            url: site.base_url + 'product/product/modal_view/',
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
    // In your Javascript (external .js resource or <script> tag)
	$('.select2').select2();

});

	function hide_pos(row, data) 
    {
        if(data[8]=="1"){
            return '<input type="button" class="btn btn-primary btn-sm" value="Unhide" onClick="changehideStatus('+data[0]+','+data[8]+', this)">';
        }else{
           return '<input type="button" class="btn btn-primary btn-sm" value="hide" onClick="changehideStatus('+data[0]+','+data[8]+', this)">'; 
        }
    }
	function changehideStatus(productId, StatusNo, elm) {
        var $this = $(elm);
        $.ajax({
            url: site.base_url + 'product/product/hide_from_pos',
            method: 'POST',
            data: {productId: productId, StatusNo: StatusNo},
            success: function(data) {
                if(StatusNo==1){
                    $this.val("Hide");
                    $this.attr("onClick", "changehideStatus("+productId+",0, this)");
                }else{
                    $this.val("Unhide");
                    $this.attr("onClick", "changehideStatus("+productId+",1, this)");
                }
                
            }
        });
    }
</script>
