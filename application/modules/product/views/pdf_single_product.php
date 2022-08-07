<html>
    <head>
    <meta charset="utf-8">    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="./assets/admin/css/bootstrap.min.css" rel="stylesheet"> -->
    <title><?= 'Products Detail'; ?></title>

    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .reports_table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        .reports_table td, .reports_table th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        .reports_table tr:nth-child(even){background-color: #f2f2f2;}

        .reports_table tr:hover {background-color: #ddd;}

        .reports_table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        }
    </style>

    </head>

    <body>

<div class="panel panel-default">
	
	<div class="panel-heading">
	  <div class="row">
		  <div class="col-md-6">
		  	 <h3> <i class="fa-fw fa fa-plus border-right"></i> <?php echo "Product Detail" ?> </h3>
		  </div>
		  <div class="col-md-6">
			  <div class="box-icon d-flex flex-row float-right"> 
			  </div>
		  </div>
	  </div>
    </div>
  
    <div class="panel-body">
        <div class="row" style="width: 100%; padding: 10px; display: flex; flex-direction: row;
				column-gap: 2rem;">
            <div class="col-md-5" style="width: 35%; float: left; padding: 5px;">
                <?php 
                if($product->image) {
                    echo '<img width="90%" src="'. base_url() .'assets/uploads/products/'.$product->image.'"  id="" class="img-responsive img-thumbnail">';
                } else {
                    echo '<img width="90%" src="'. base_url() .'assets/uploads/products/dummy.png" id="" class="img-responsive img-thumbnail">';
                }
                ?>
                
            </div>
            <div class="col-md-7" style="width: 60%; float: left; padding: 5px;">
                <div class="table-responsive">
                <table id="" class="table items table-striped table-bordered table-condensed table-hover reports_table">
                    <tbody>
                    <tr>
                        <td>Type</td>
                        <td><span id="type"><?= $product->type ?></span></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><span id="name"><?= $product->name ?></span></td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td><span id="code"><?= $product->code ?></span></td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td><span id="brand"><?= $brand->name ?></span></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><span id="category"><?= $category->name ?></span></td>
                    </tr>
                    <tr>
                        <td>Unit</td>
                        <td><span id="unit"><?= $unit->name ?></span></td>
                    </tr>
                    <tr>
                        <td>Cost</td>
                        <td><span id="cost"><?= $product->cost ?></span></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><span id="price"><?= $product->price ?></span></td>
                    </tr>
                    <tr>
                        <td>Tax Rate</td>
                        <td><span id=""><?= $tax_rate->name ?></span></td>
                    </tr>
                    <tr>
                        <td>Tax Method</td>
                        <td><span id=""><?= $tax_rate->tax_method == 1 ? 'Exclusive' : 'Inclusive' ?></span></td>
                    </tr>
                    <?php if ($variants) {
                        ?>
                        <tr>
                            <td><?= ('Product Variants'); ?></td>
                            <td><?php foreach ($variants as $variant) {
                            echo '<span class="label label-primary">' . $variant->name . '</span> ';
                        } ?></td>
                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        
        <div class="row"  style="width: 100%; clear: both; display: flex; flex-direction: row; column-gap: 2rem;"> 
            <div class="col-md-5" style="width: 80%;"> 
            <?php if (!empty($warehouses) && $product->type == 'standard') {
            ?>
                <h3 class="bold"><?= ('Warehouse Quantity') ?></h3>
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-striped table-condensed reports_table">
                        <thead>
                        <tr>
                            <th><?= ('Warehouse Name') ?></th>
                            <th><?= ('Quantity') . ' (' . ('Rack') . ')'; ?></th>
                            <?php
                            // if ($Owner || $Admin || $this->session->userdata('show_cost')) {
                                echo '<th>' . ('Avg Cost') . '</th>';
                            //} ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($warehouses as $warehouse) {
                                // if ($warehouse->quantity != 0) {
                                    echo '<tr><td>' . $warehouse->name . ' (' . $warehouse->code . ')</td><td><strong>' . $this->sls->formatQuantity($warehouse->quantity) . '</strong>' . ($warehouse->rack ? ' (' . $warehouse->rack . ')' : '') . '</td>' . '<td>' . $this->sls->formatDecimal($warehouse->avg_cost) . '</td>' . '</tr>';
                                // }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <?php
                } ?>
            </div>

            <div class="col-md-7" style="width: 80%;">
                <?php if (!empty($options)) {
                    ?>
                    <h3 class="bold"><?= ('Product Variants Quantity'); ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed reports_table">
                            <thead>
                            <tr>
                                <th>Warehouse Name</th>
                                <th>Product Variant</th>
                                <th>Quantity (Racks)</th>
                                <th>Cost</th><th>Price</th>                                                    </tr>
                            </thead>
                            <tbody>
                                <?php
                                // print_r($options);
                                foreach ($options as $option) {
                                    // if ($option->wh_qty != 0) {
                                        echo '<tr><td>' . $option->wh_name . '</td><td>' . $option->name . '</td><td class="text-center">' . $this->sls->formatQuantity($option->wh_qty) . '</td>';
                                        // if ($Owner || $Admin && (!$Customer || $this->session->userdata('show_cost'))) {
                                            echo '<td class="text-right">' . $this->sls->formatDecimal($option->cost) . '</td><td class="text-right">' . $this->sls->formatDecimal($option->price) . '</td>';
                                        // }
                                        echo '</tr>';
                                    // }
                                } ?>
                                </tbody>
                        </table>
                    </div>
                    <?php
                    } ?>
                    <?php if ($product->type == 'combo') {
                        ?>
                        <h3 class="bold"><?= ('combo items') ?></h3>
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped table-condensed reports_table">
                                <thead>
                                <tr>
                                    <th><?= ('Product Name') ?></th>
                                    <th><?= ('Quantity') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($combo_items as $combo_item) {
                                    echo '<tr><td>' . $combo_item->name . ' (' . $combo_item->code . ') </td><td>' . $this->sls->formatQuantity($combo_item->qty) . '</td></tr>';
                        } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } ?>
            </div>
        </div>


        </div>

</div>

</body>
</html>