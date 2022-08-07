<style> 
@media print {
    .footer {
        display: none;
    }
    .breadcrumb {
        display: none;
    }
    .alert {
        display: none;
    }
    .no-print {
        display: none;
    }
    .border-bottom {
        display: none;
    }
    #receiptData {
        font-size: 22px;
        color: #000;
    }
}
</style>
<div class="panel panel-default">
	
  	<div class="panel-heading no-print">
		<div class="row">
			<div class="col-md-6">
				<h3><i class="fa-fw fa fa-barcode border-right"></i> <?php echo "Sale Detail" ?> </h3>
			</div>
			<div class="col-md-6">
				<div class="box-icon d-flex flex-row float-right"> 
						<div class="px-2 border-left">
							<a href="<?= base_url('sales/pos/pdf_sale/' . $inv->id) ?>" id="price_pdf" class="tip" title="<?= lang('download_pdf') ?>">
                                <i class="icon fa fa-file-pdf-o"></i>
                            </a>
						</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel-body">

    <div id="receiptData">
                    <div id="receipt-data">
                        <div class="text-center">
                            <?php //print_r($biller); die; ?>
                            <?= !empty($biller->logo) ? '<img src="' . base_url($biller->logo) . '" alt="">' : ''; ?>
                            <?php 
                            echo '<p>' . $biller->address . ' ' . $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state . ' ' . $biller->country .
                            '<br>' . lang('tel') . ': ' . $biller->phone;
                            
                            echo '<br>';
                            
                            if ($pos_settings->cf_title1 != '' && $pos_settings->cf_value1 != '') {
                                echo $pos_settings->cf_title1 . ': ' . $pos_settings->cf_value1 . '<br>';
                            }
                            if ($pos_settings->cf_title2 != '' && $pos_settings->cf_value2 != '') {
                                echo $pos_settings->cf_title2 . ': ' . $pos_settings->cf_value2 . '<br>';
                            }
                            echo '</p>';
                            ?>
                        </div>
                       <div class="row">
                            <div class="col-md-6">
                            <?php 
                                echo '<p>' . lang('sale_number') . ': ' . $inv->id . '<br>';
                                echo lang('date') . ': ' . ($inv->date) . '<br>';
                                echo lang('sale_ref') . ': ' . $inv->reference_no . '<br>';
                                echo lang('sales_person') . ': ' . $created_by->first_name . ' ' . $created_by->last_name . '</p>';
                                echo lang('customer') . ': ' . ($customer->name && $customer->name != '-' ? $customer->name : $customer->name) . '<br>';
                            ?>
                            </div>
                            <div class="col-md-6 text-right"> 
                            <?php
                            if ($Settings->ksa_qrcode) {
                                $qrtext = $this->inv_qrcode->base64([
                                    'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
                                    'vat_no'           => $biller->vat_no ?: $biller->get_no,
                                    'date'             => $inv->date,
                                    'grand_total'      => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
                                    'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
                                ]);
                                echo $this->sls->qrcode('text', $qrtext, 2);
                            } else {
                                echo $this->sls->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 2);
                            }
                            ?>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered table-hover datatable_display dataTable"> 
                        <thead>
                        
                        <tr>
                            <th><?= lang('no.'); ?></th>
                            <th><?= lang('description'); ?> (<?= lang('code'); ?>)</th>
                            
                            <th><?= lang('quantity'); ?></th>
                            <?php
                            if ($Settings->product_serial) {
                                echo '<th style="text-align:center; vertical-align:middle;">' . lang('serial_no') . '</th>';
                            }
                            ?>
                            <th style="padding-right:20px;"><?= lang('unit_price'); ?></th>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang('tax') . '</th>';
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang('discount') . '</th>';
                            }
                            ?>
                            <th style="padding-right:20px;"><?= lang('subtotal'); ?></th>
                        </tr>

                        </thead>
                            <tbody>
                            <?php
                            // echo '<pre>';print_r($rows); die;
                            $r           = 1;
                            $category    = 0;
                            $tax_summary = [];
                            $col = 4;
                            foreach ($rows as $row) {
                                ?>
                                <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                </td>
                                <?php if ($Settings->indian_gst) {
                                    $col++;
                                    ?>
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><<?= $row->hsn_code ?: ''; ?></td>
                                    <?php
                                } ?>
                                <td style="width: 100px; text-align:center; vertical-align:middle;"><?= $this->sls->formatQuantity($row->unit_quantity) . ' ' . ($inv->sale_status == 'returned' ? $row->base_unit_code : $row->product_unit_code); ?></td>
                                <?php
                                if ($Settings->product_serial) {
                                    $col++;
                                    echo '<td>' . $row->serial_no . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;">
                                    <?= $row->unit_price != $row->real_unit_price && $row->item_discount > 0 ? '<del>' . $this->sls->formatMoney($row->real_unit_price) . '</del>' : ''; ?>
                                    <?= $this->sls->formatMoney($row->unit_price); ?>
                                </td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    $col++;
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small>' : '') . ' ' . $this->sls->formatMoney($row->item_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    $col++;
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sls->formatMoney($row->item_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sls->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php    
                                $r++;
                            }

                            ?>
                            
                            
                            <tr>
                                <th colspan="<?= $col; ?>" class="text-right"><?=lang('total');?></th>
                                <th class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax));?></th>
                            </tr>
                            <?php
                            if ($inv->order_tax != 0) {
                                echo '<tr ><th colspan="'. $col.'" class="text-right">' . lang('order_tax') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
                            }
                            if ($inv->order_discount != 0) {
                                echo '<tr><th colspan="'. $col.'" class="text-right">' . lang('order_discount') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</th></tr>';
                            }

                            if ($inv->shipping != 0) {
                                echo '<tr><th colspan="'. $col.'" class="text-right">' . lang('shipping') . '</th><th class="text-right">' . $this->sls->formatMoney($inv->shipping) . '</th></tr>';
                            }

                            if ($return_sale) {
                                if ($return_sale->surcharge != 0) {
                                    echo '<tr><th colspan="'. $col.'" class="text-right">' . lang('return_surcharge') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale->surcharge) . '</th></tr>';
                                }
                            }
                            if ($pos_settings->rounding || $inv->rounding != 0) {
                                
                                ?>
                                <tr>
                                    <th class="text-right"><?=lang('rounding'); ?></th>
                                    <th class="text-right"><?= $this->sls->formatMoney($inv->rounding); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="<?= $col; ?>" class="text-right"><?=lang('grand_total'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)); ?></th>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <th colspan="<?= $col; ?>" class="text-right"><?=lang('grand_total'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></th>
                                </tr>
                                <?php
                                
                            }
                            // if ($inv->paid < ($inv->grand_total + $inv->rounding)) {
                                ?>
                                <tr>
                                    <th colspan="<?= $col; ?>" class="text-right"><?=lang('paid_amount'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="<?= $col; ?>" class="text-right"><?=lang('due_amount'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></th>
                                </tr>
                                <?php
                            // } ?>
                        </tbody>
                        </table>
                        
                        <br> <br>
                        <?php if ($payments) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable_display dataTable">
                                            <thead>
                                            <tr>
                                                <th><?= lang('date') ?></th>
                                                <th><?= lang('payment_reference') ?></th>
                                                <th><?= lang('paid_by') ?></th>
                                                <th><?= lang('amount') ?></th>
                                                <th><?= lang('created_by') ?></th>
                                                <th><?= lang('type') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($payments as $payment) {
                                                ?>
                                                <tr <?= $payment->type == 'returned' ? 'class="warning"' : ''; ?>>
                                                    <td><?= ($payment->date) ?></td>
                                                    <td><?= $payment->reference_no; ?></td>
                                                    <td><?= lang($payment->paid_by);
                                                    if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC') {
                                                        echo ' (' . $payment->cc_no . ')';
                                                    } elseif ($payment->paid_by == 'Cheque') {
                                                        echo ' (' . $payment->cheque_no . ')';
                                                    } ?></td>
                                                    <td><?= $this->sls->formatMoney($payment->amount); ?></td>
                                                    <td>
                                                        <?php
                                                        $payment_created_by = $this->app_model->singleUser($payment->created_by);
                                                        echo $payment_created_by->first_name . ' ' . $payment_created_by->last_name; 
                                                        ?></td>
                                                    <td><?= lang($payment->type); ?></td>
                                                </tr>
                                                <?php
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } ?>

                        <div class="row px-3 my-3 no-print">
                            <a href="<?= base_url('pos/sales') ?>" class="col-md-3 tip btn btn-primary" title="<?= ('Sales List') ?>">
                                <i class="fa fa-barcode"></i>
                                <span class=""><?= ('Sales List') ?></span>
                            </a>
                            <a href="<?= base_url('sales/pos/pdf_sale/' . $inv->id) ?>" class="col-md-3 tip btn btn-secondary" title="<?= ('Pdf') ?>">
                                <i class="fa fa-download"></i> <span class=""><?= ('Pdf') ?></span>
                            </a>
                            <a href="#" id="print_sale" class="col-md-3 tip btn btn-danger" title="<?= ('print') ?>">
                                <i class="fa fa-download"></i> <span class=""><?= ('print') ?></span>
                            </a>
                            <a href="<?= base_url('pos/edit/' . $inv->id) ?>" class="col-md-3 tip btn btn-warning tip" title="<?= ('Edit Product') ?>">
                                <i class="fa fa-edit"></i> <span class=""><?= ('Edit') ?></span>
                            </a>
                            
                        </div>
                    </div>
                </div>

	</div>

	
</div>

<br>
<br>
<br>


<script> 
    $(document).ready(function(){

        $(document).on('click', '#print_sale', function(){
            $.ajax({
                url: site.base_url + 'sales/pos/print_sale/<?= $inv->id ?>',
                dataType: 'html',
                success: function(response) {
                    $('#receiptData').innerHTML = response.print_view;
                    setTimeout(function() {
                        window.print();
                    }, 100);
                    
                }
            });
        });

    });
</script>