<html>
<head> 
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        border: 1px solid #f2f2f2;
        padding: 8px;
        }

        .reports_table tr:nth-child(even){background-color: #fff;}

        .reports_table tr:hover {background-color: #fff;}

        .reports_table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        }
        .text-right {
            text-align: right;
        }
        .payment_table th{
            background-color: #ddd;
        }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link href="<?= base_url()?>assets/admin/css/custom.css" rel="stylesheet">
</head>
	<body>
    <div id="receiptData">
                    <div id="receipt-data">
                        <div class="text-center" style="text-align: center">
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
                        <div class="row" style="margin-bottom: 8px">
                            <div class="col-md-6" style="float: left; width: 50%">
                            <?php 
                                echo '<p>' . lang('sale_number') . ': ' . $inv->id . '<br>';
                                echo lang('date') . ': ' . ($inv->date) . '<br>';
                                echo lang('sale_ref') . ': ' . $inv->reference_no . '<br>';
                                echo lang('sales_person') . ': ' . $created_by->first_name . ' ' . $created_by->last_name . '</p>';
                                echo lang('customer') . ': ' . ($customer->name && $customer->name != '-' ? $customer->name : $customer->name) . '<br>';
                            ?>
                            </div>
                            <div class="col-md-6 text-right"  style="float: left; width: 50%"> 
                            
                            </div>
                        </div>
                        
                        <table class="table reports_table table-bordered table-hover"> 
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
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="<?= $col; ?>"><?=lang('total');?></td>
                                <td class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax));?></td>
                            </tr>
                            <?php
                            if ($inv->order_tax != 0) {
                                echo '<tr><td colspan="'. $col.'">' . lang('order_tax') . '</td><td class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</td></tr>';
                            }
                            if ($inv->order_discount != 0) {
                                echo '<tr><td colspan="'. $col.'">' . lang('order_discount') . '</td><td class="text-right">' . $this->sls->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</td></tr>';
                            }

                            if ($inv->shipping != 0) {
                                echo '<tr><td colspan="'. $col.'">' . lang('shipping') . '</td><td class="text-right">' . $this->sls->formatMoney($inv->shipping) . '</td></tr>';
                            }

                            if ($return_sale) {
                                if ($return_sale->surcharge != 0) {
                                    echo '<tr><td colspan="'. $col.'">' . lang('return_surcharge') . '</td><td class="text-right">' . $this->sls->formatMoney($return_sale->surcharge) . '</td></tr>';
                                }
                            }

                            if ($pos_settings->rounding || $inv->rounding != 0) {
                                ?>
                                <tr>
                                    <td><?=lang('rounding'); ?></td>
                                    <td class="text-right"><?= $this->sls->formatMoney($inv->rounding); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="<?= $col; ?>"><?=lang('grand_total'); ?></td>
                                    <td class="text-right"><?=$this->sls->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)); ?></td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan="<?= $col; ?>"><?=lang('grand_total'); ?></td>
                                    <td class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></td>
                                </tr>
                                <?php
                            }
                            // if ($inv->paid < ($inv->grand_total + $inv->rounding)) {
                                ?>
                                <tr>
                                    <td colspan="<?= $col; ?>"><?=lang('paid_amount'); ?></td>
                                    <td class="text-right"><?=$this->sls->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="<?= $col; ?>"><?=lang('due_amount'); ?></td>
                                    <td class="text-right"><?=$this->sls->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></td>
                                </tr>
                                <?php
                            // } ?>
                        </tfoot>
                        </table>
                        <br>
                        <?php if ($payments) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table reports_table payment_table table-bordered table-hover">
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
                        
                    </div>
                </div>

    
                <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>



	</body>
</html>

