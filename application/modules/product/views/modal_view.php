
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
			<h4 class="modal-title" id="aModalLabel">Product Detail</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                    <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span>
                </button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">

                <div class="row">
					<div class="col-md-5">
                        <?php 
                        if($product->image) {
                            echo '<img src="'. base_url() .'assets/uploads/products/'.$product->image.'"  id="" class="img-responsive img-thumbnail">';
                        } else {
                            echo '<img src="'. base_url() .'assets/uploads/products/dummy.png" id="" class="img-responsive img-thumbnail">';
                        }
                        ?>
					</div>
					<div class="col-md-7">
						<div class="table-responsive">
						<table id="" class="table items table-striped table-bordered table-condensed table-hover">
                        <tbody>
                            <tr>
                                <td>Barcode</td>
                                <td><span id="barcode">
                                    <img src="<?= base_url('template/template/barcode/' . $product->code . '/' . $product->barcode_symbology . '/74/0'); ?>" alt="<?= $product->code; ?>" class="bcimg" />
                                    <?= $this->sls->qrcode('link', urlencode(base_url('products/view/' . $product->id)), 2); ?>
                                </span></td>
                            </tr>
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

                <br>
                <div class="row"> 
                    <div class="col-md-5"> 
                    <?php if (!empty($warehouses) && $product->type == 'standard') {
                    ?>
                        <h3 class="bold"><?= ('Warehouse Quantity') ?></h3>
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped table-condensed dfTable three-columns">
                                <thead>
                                <tr>
                                    <th><?= ('warehouse name') ?></th>
                                    <th><?= ('quantity') . ' (' . ('rack') . ')'; ?></th>
                                    <?php
                                    // if ($Owner || $Admin || $this->session->userdata('show_cost')) {
                                        echo '<th>' . ('avg cost') . '</th>';
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

                    <div class="col-md-7">
                        <?php if (!empty($options)) {
                            ?>
                            <h3 class="bold"><?= ('Product Variants Quantity'); ?></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed dfTable">
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
                                        class="table table-bordered table-striped table-condensed dfTable two-columns">
                                        <thead>
                                        <tr>
                                            <th><?= ('product_name') ?></th>
                                            <th><?= ('quantity') ?></th>
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

                <div class="row px-3">
                    <a href="<?= base_url('products') ?>" class="col-md-3 tip btn btn-primary" title="<?= ('Products List') ?>">
                        <i class="fa fa-barcode"></i>
                        <span class=""><?= ('Products List') ?></span>
                    </a>
                    <a href="<?= base_url('product/product/pdf_single_product/' . $product->id) ?>" class="col-md-3 tip btn btn-secondary" title="<?= ('Pdf') ?>">
                        <i class="fa fa-download"></i> <span class=""><?= ('Pdf') ?></span>
                    </a>
                    <a href="<?= base_url('edit_product/' . $product->id) ?>" class="col-md-3 tip btn btn-warning tip" title="<?= ('Edit Product') ?>">
                        <i class="fa fa-edit"></i> <span class=""><?= ('Edit') ?></span>
                    </a>
                    <?php 
                    echo anchor("product/delete/".$product->id,
                    '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete',
                    array('class'=>'btn btn-danger btn-sm col-md-3 tip btn btn-danger', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"))
                    ?>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id=""><?= ('Close') ?></button>
            </div>
        </div>
    </div>
<!-- </div> -->