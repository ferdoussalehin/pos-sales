
<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
			<h4 class="modal-title" id="aModalLabel">Sales Detail</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                    <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span>
                </button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
                <?php //echo '<pre>'; print_r($inv); ?>
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
                    </div>
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
                    
                    <div class="row px-3">
                        
                        <?php
                            if ($pos->remote_printing == 1) {
                                echo '<button onclick="window.print();" class="col-md-4 btn btn-block btn-primary">' . lang('print') . '</button>';
                            } else {
                                echo '<button onclick="return printReceipt()" class="col-md-4 btn btn-block btn-primary">' . lang('print') . '</button>';
                            } ?>
                        <a href="<?= base_url('sales/pos/pdf_sale/' . $inv->id) ?>" class="col-md-4 tip btn btn-secondary" title="<?= ('Pdf') ?>">
                            <i class="fa fa-download"></i> <span class=""><?= ('Pdf') ?></span>
                        </a>
                        
                        <button type="button" class="col-md-4 btn btn-warning" data-dismiss="modal"><?= lang('close'); ?></button>
                        
                    </div>
                    <?php
                    // if ($pos->remote_printing == 1) {
                ?>
                <div style="clear:both;"></div>
                <div class="col-xs-12" style="background:#F5F5F5; padding:10px;">
                    <p style="font-weight:bold;">
                        Please don't forget to disable the header and footer in browser print settings. You can set Zoom/Scale as you need.
                    </p>
                    <p style="text-transform: capitalize;">
                        <strong>FF:</strong> File &gt; Print Setup &gt; Margin &amp; Header/Footer Make all --blank--
                    </p>
                    <p style="text-transform: capitalize;">
                        <strong>chrome:</strong> Menu &gt; Print &gt; Disable Header/Footer in Option &amp; Set Margins to None
                    </p>
                </div>
                <?php
            //} ?>
            <div style="clear:both;"></div>
                </div>
            </div>
        </div>

</div>