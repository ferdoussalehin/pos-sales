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
        .col-md-6 {
            float: left; width: 50%
        }
</style>

<link href="<?= base_url()?>assets/admin/css/custom.css" rel="stylesheet">
</head>
	<body>
    <div id="receiptData">
                    <div id="receipt-data">
                    <div class="row well mx-5 my-0" style="display: flex">
                            <div class="col-md-6">
                            <h2 class=""><?= lang('ref'); ?>: <?= $inv->reference_no; ?></h2>
                            <?php if (!empty($inv->return_purchase_ref)) {
                                echo '<p>' . lang('return_ref') . ': ' . $inv->return_purchase_ref;
                                if ($inv->return_id) {
                                    echo ' <a data-target="#myModal2" data-toggle="modal" href="' . base_url('purchases/modal_view/' . $inv->return_id) . '"><i class="fa fa-external-link no-print"></i></a><br>';
                                } else {
                                    echo '</p>';
                                }
                            } ?>
                            <p style="font-weight:bold;"><?= lang('date'); ?>: <?= ($inv->date); ?></p>
                            <p style="font-weight:bold;"><?= lang('status'); ?>: <?= lang($inv->status); ?></p>
                            <p style="font-weight:bold;"><?= lang('payment_status'); ?>: <?= lang($inv->payment_status); ?></p>
                            <?php
                            if ($inv->payment_status != 'paid' && $inv->due_date) {
                                echo '<p style="font-weight:bold;">' . lang('due_date') . ': ' . ($inv->due_date) . '</p>';
                            } ?>
                            </div>
                            <div class="col-md-6 text-right"> 
                                
                            <?= $this->sls->qrcode('link', urlencode(base_url('purchases/purchases/view/' . $inv->id)), 2); ?>
                            </div>
                        </div>
                       <div class="row mx-5 my-0" style="display: flex">
                            <div class="col-md-6">
                            <h2 class=""><?= $supplier->company_name && $supplier->company_name != '-' ? $supplier->company_name : $supplier->name; ?></h2>
                            <?= $supplier->company_name              && $supplier->company_name != '-' ? '' : 'Attn: ' . $supplier->name ?>

                            <?php
                            echo $supplier->address . '<br />' . $supplier->city . ' ' . $supplier->postal_code . ' ' . $supplier->state . '<br />' . $supplier->country;

                            echo '<p>';

                            if ($supplier->vat_no != '-' && $supplier->vat_no != '') {
                                echo '<br>' . lang('vat_no') . ': ' . $supplier->vat_no;
                            }
                           
                            echo '</p>';
                            echo lang('tel') . ': ' . $supplier->phone . '<br />' . lang('email') . ': ' . $supplier->email;
                            ?>
                            </div>
                            <div class="col-md-6 text-right border-left"> 
                                <h2 class=""><?= $Settings->site_name; ?></h2>
                                <?= $warehouse->name ?>

                                <?php
                                echo $warehouse->address . '<br>';
                                echo($warehouse->phone ? lang('tel') . ': ' . $warehouse->phone . '<br>' : '') . ($warehouse->email ? lang('email') . ': ' . $warehouse->email : '');
                                ?>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered table-hover datatable_display reports_table"> 
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
                            <th style="padding-right:20px;"><?= lang('unit_cost'); ?></th>
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
                                    
                                    ?>
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><<?= $row->hsn_code ?: ''; ?></td>
                                    <?php
                                } ?>
                                <td style="width: 100px; text-align:center; vertical-align:middle;"><?= $this->sls->formatQuantity($row->unit_quantity) . ' ' . ($inv->sale_status == 'returned' ? $row->base_unit_code : $row->product_unit_code); ?></td>
                                <?php
                                if ($Settings->product_serial) {
                                    
                                    echo '<td>' . $row->serial_no . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;">
                                    
                                    <?= $this->sls->formatMoney($row->unit_cost); ?>
                                </td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small>' : '') . ' ' . $this->sls->formatMoney($row->item_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sls->formatMoney($row->item_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sls->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php    
                                $r++;
                            }

                            ?>
                            <?php
                            $col = $Settings->indian_gst ? 5 : 4;
                            if ($inv->status == 'partial') {
                                $col++;
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                $col++;
                            }
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                $col++;
                            }
                            if (($Settings->product_discount && $inv->product_discount != 0) && ($Settings->tax1 && $inv->product_tax > 0)) {
                                $tcol = $col - 2;
                            } elseif ($Settings->product_discount && $inv->product_discount != 0) {
                                $tcol = $col - 1;
                            } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                                $tcol = $col - 1;
                            } else {
                                $tcol = $col;
                            }
                            ?>
                            
                            <tr>
                                <td colspan="<?= $tcol; ?>" class="text-right" style="font-weight:bold;"><?=lang('total');?></td>
                                <?php
                                if ($inv->product_tax != 0) {
                                    echo '<td style="text-align:right;font-weight:bold;">' . $this->sls->formatMoney($return_purchase ? ($inv->product_tax + $return_purchase->product_tax) : $inv->product_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="text-align:right;font-weight:bold;">' . $this->sls->formatMoney($return_purchase ? ($inv->product_discount + $return_purchase->product_discount) : $inv->product_discount) . '</td>';
                                } 
                                ?>
                                <td style="text-align:right; padding-right:10px;font-weight:bold;"><?= $this->sls->formatMoney($return_purchase ? (($inv->total + $inv->product_tax) + ($return_purchase->total + $return_purchase->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                                
                            </tr>
                            <?php
                            if ($return_purchase) {
                                echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;font-weight:bold;">' . lang('return_total') . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;font-weight:bold;">' . $this->sls->formatMoney($return_purchase->grand_total) . '</td></tr>';
                            }
                            if ($inv->surcharge != 0) {
                                echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;font-weight:bold;">' . lang('return_surcharge') . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;font-weight:bold;">' . $this->sls->formatMoney($inv->surcharge) . '</td></tr>';
                            }
                            ?>
                            
                            <?php if ($inv->order_discount != 0) {
                                echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;font-weight:bold;">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;font-weight:bold;">' . ($inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '') . $this->sls->formatMoney($return_purchase ? ($inv->order_discount + $return_purchase->order_discount) : $inv->order_discount) . '</td></tr>';
                            }
                            ?>
                            <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                                echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;font-weight:bold;">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;font-weight:bold;">' . $this->sls->formatMoney($return_purchase ? ($inv->order_tax + $return_purchase->order_tax) : $inv->order_tax) . '</td></tr>';
                            }
                            ?>
                            <tr>
                                <td colspan="<?= $col; ?>"
                                    style="text-align:right; font-weight:bold;"><?= lang('grand_total'); ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sls->formatMoney($return_purchase ? ($inv->grand_total + $return_purchase->grand_total) : $inv->grand_total); ?></td>
                            </tr>
                            <tr>
                                <td colspan="<?= $col; ?>"
                                    style="text-align:right; font-weight:bold;"><?= lang('paid'); ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <td style="text-align:right; font-weight:bold;"><?= $this->sls->formatMoney($return_purchase ? ($inv->paid + $return_purchase->paid) : $inv->paid); ?></td>
                            </tr>
                            <tr>
                                <td colspan="<?= $col; ?>"
                                    style="text-align:right; font-weight:bold;"><?= lang('balance'); ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <td style="text-align:right; font-weight:bold;"><?= $this->sls->formatMoney(($return_purchase ? ($inv->grand_total + $return_purchase->grand_total) : $inv->grand_total) - ($return_purchase ? ($inv->paid + $return_purchase->paid) : $inv->paid)); ?></td>
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

                        
                    </div>
        </div>

	</body>
</html>

