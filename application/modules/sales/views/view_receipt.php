<!doctype html>
<head> 
<meta charset="utf-8">
<style type="text/css" media="all"> 
	#receipt-data {
		width: 480px;
		margin: auto;
	}
	@media print {
        @page { margin: 0; }
        body { margin: 0; }
		.no-print { display: none; }
		#receipt-data { max-width: 480px;  margin: 0 auto; font-size: 22px; }
		.no-border { border: none !important; }
		.border-bottom { border-bottom: 1px solid #ddd !important; }
		table tfoot { display: table-row-group; }
		.breadcrumb { display: none; }
		.footer { display: none; }
		#print-btn { display: none; }
        
	}
</style>

</head>
	<body>
		<div class="">
			<div id="receiptData" style="height: fit-content; ">
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
                        <?php 
                            echo '<p>' . lang('sale_number') . ': ' . $inv->id . '<br>';
                            echo lang('date') . ': ' . ($inv->date) . '<br>';
                            echo lang('sale_ref') . ': ' . $inv->reference_no . '<br>';
                            echo lang('sales_person') . ': ' . $created_by->first_name . ' ' . $created_by->last_name . '</p>';
                            echo lang('customer') . ': ' . ($customer->name && $customer->name != '-' ? $customer->name : $customer->name) . '<br>';
                        ?>

                        <table class="table table-condensed"> 
                            <tbody>
                            <?php
                            // echo '<pre>';print_r($rows); die;
                            $r           = 1;
                            $category    = 0;
                            $tax_summary = [];
                            foreach ($rows as $row) {
                                if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                                    $category = $row->category_id;
                                    echo '<tr><td colspan="100%" class="no-border"><strong>' . $row->category_name . '</strong></td></tr>';
                                }
                                echo '<tr><td colspan="2" class="no-border">#' . $r . ': &nbsp;&nbsp;' . product_name($row->product_name, ($printer ? $printer->char_per_line : null)) . ($row->variant ? ' (' . $row->variant . ')' : '') , ($row->serial_no ? '<br>' . $row->serial_no : '') . '<span class="pull-right">' . ($row->tax_code ? '*' . $row->tax_code : '') . '</span></td></tr>';
                                if (!empty($row->second_name)) {
                                    echo '<tr><td colspan="2" class="no-border">' . $row->second_name . '</td></tr>';
                                }
                                if (!empty($row->comment)) {
                                    echo '<tr><td colspan="2" class="no-border">' . $row->comment . '</td></tr>';
                                }
                                echo '<tr><td class="no-border border-bottom">' . $this->sls->formatQuantity($row->unit_quantity) . ($row->product_unit_code ? $row->product_unit_code : '') . ' x ' . ($row->item_discount != 0 ? '(' . $this->sls->formatMoney($row->unit_price + ($row->item_discount / $row->unit_quantity)) . ' - ' . $this->sls->formatMoney($row->item_discount / $row->unit_quantity) . ')' : $this->sls->formatMoney($row->unit_price)) . ($row->item_tax != 0 ? ' [' . lang('tax') . ' <small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' . $this->sls->formatMoney($row->item_tax) . ($row->hsn_code ? ' (' . lang($row->product_type == 'service' ? 'sac_code' : 'hsn_code') . ': ' . $row->hsn_code . ')' : '') . ']' : '') . '</td><td class="no-border border-bottom text-right">' . $this->sls->formatMoney($row->subtotal) . '</td></tr>';

                                $r++;
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><?=lang('total');?></th>
                                <th class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax));?></th>
                            </tr>
                            <?php
                            if ($inv->order_tax != 0) {
                                echo '<tr><th>' . lang('tax') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
                            }
                            if ($inv->order_discount != 0) {
                                echo '<tr><th>' . lang('order_discount') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</th></tr>';
                            }

                            if ($inv->shipping != 0) {
                                echo '<tr><th>' . lang('shipping') . '</th><th class="text-right">' . $this->sls->formatMoney($inv->shipping) . '</th></tr>';
                            }

                            if ($return_sale) {
                                if ($return_sale->surcharge != 0) {
                                    echo '<tr><th>' . lang('return_surcharge') . '</th><th class="text-right">' . $this->sls->formatMoney($return_sale->surcharge) . '</th></tr>';
                                }
                            }

                            if ($pos_settings->rounding || $inv->rounding != 0) {
                                ?>
                                <tr>
                                    <th><?=lang('rounding'); ?></th>
                                    <th class="text-right"><?= $this->sls->formatMoney($inv->rounding); ?></th>
                                </tr>
                                <tr>
                                    <th><?=lang('grand_total'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)); ?></th>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <th><?=lang('grand_total'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></th>
                                </tr>
                                <?php
                            }
                            if ($inv->paid < ($inv->grand_total + $inv->rounding)) {
                                ?>
                                <tr>
                                    <th><?=lang('paid_amount'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></th>
                                </tr>
                                <tr>
                                    <th><?=lang('due_amount'); ?></th>
                                    <th class="text-right"><?=$this->sls->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></th>
                                </tr>
                                <?php
                            } ?>
                        </tfoot>
                        </table>
                        <?php
                        if ($payments) {
                            echo '<table class="table table-striped table-condensed"><tbody>';
                            foreach ($payments as $payment) {
                                echo '<tr>';
                                if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                                    echo '<td>' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td colspan="2">' . lang('amount') . ': ' . $this->sls->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang('change') . ': ' . ($payment->pos_balance > 0 ? $this->sls->formatMoney($payment->pos_balance) : 0) . '</td>';
                                }  elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                    echo '<td>' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td colspan="2">' . lang('amount') . ': ' . $this->sls->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang('cheque_no') . ': ' . $payment->cheque_no . '</td>';
                                }  elseif ($payment->paid_by == 'other' && $payment->amount) {
                                    echo '<td colspan="2">' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td colspan="2">' . lang('amount') . ': ' . $this->sls->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo $payment->note ? '</tr><td colspan="4">' . lang('payment_note') . ': ' . $payment->note . '</td>' : '';
                                }
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        }
                        ?>
                        <p class="text-center"> Thank you for shopping with us. Please come again</p>

						<div class="order_barcodes text-center">
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

                        <div class="row py-5" id="print-btn">
                            <button onclick="window.print();" class="col-md-12 btn btn-block btn-primary">print</button>    
                            <a href="<?= base_url('product/product/pdf_single_product/' . $product->id) ?>" class="col-md-12 tip btn btn-default border" title="<?= ('Pdf') ?>">
                                <i class="fa fa-download"></i> <span class=""><?= ('Pdf') ?></span>
                            </a>
                            
                        </div>
						<br><br>
                    </div>
            </div>
	</div>

    <script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.4.1.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/admin/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>

    <!-- jQuery UI -->
    <link href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script> 
        <?php
        // if ($pos_settings->remote_printing == 1) {
            ?>
            $(document).ready(function(){
                window.print();
                return false;
            });
            <?php
        // }
        
        ?>
        
    </script>

	</body>
</html>

