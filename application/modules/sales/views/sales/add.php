
<?php //echo '<pre>'; print_r($Settings); die; ?>
<div class="panel panel-default">
	
	<div class="panel-heading">
    </div>
    <div class="panel-body">
        <div id="pos">
            <?php
                $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo form_open_multipart('sales/add', $attrib);
                if ($quote_id) {
                    echo form_hidden('quote_id', $quote_id);
                }
                ?>
            <div class="row" style="margin: 15px 15px;"> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date"> <?= lang('date') ?> * </label>
                        <?php echo form_input('date', ($_POST['date'] ?? ''), 'class="form-control input-tip datetime" id="sldate" required="required"'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="reference_no"> <?= lang('reference_no') ?> </label>
                        <?php echo form_input('reference_no', ($_POST['reference_no'] ?? $slnumber), 'class="form-control input-tip" id="slref"'); ?>
                    </div>
                </div>
                <?php if ($Admin) {
                ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="biller"> <?= lang('biller') ?> * </label>
                            <?php
                            $bl[''] = '';
                            foreach ($billers as $biller) {
                                $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                            }
                            echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller), 'id="slbiller" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" required="required" class="form-control input-tip select2" style="width:100%;"'); ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="warehouse"> <?= lang('warehouse') ?> * </label>
                        <?php
                            $wh[''] = 'Select';
                            foreach ($warehouses as $warehouse) {
                                $wh[$warehouse->id] = $warehouse->name;
                            }
                            echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse), 'id="slwarehouse" class="form-control select2"  required="required" style="width:100%;" '); 
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="customer"> <?= lang('customer') ?> * </label>
                        <?php
                            $cus[''] = 'Select';
                            foreach ($customers as $customer) {
                                $cus[$customer->id] = $customer->name;
                            }
                            echo form_dropdown('customer', $cus, ($_POST['customer'] ?? $default_customer->id), 'id="slcustomer" class="form-control select2" required="required" style="width:80%;" '); 
                        ?> 
                    </div>
                </div>

                <div class="col-md-12" id="sticker">
                    <div class="well well-sm">
                        <div class="form-group" style="margin-bottom:0;">
                            <div class="input-group wide-tip">
                                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                    <i class="fa fa-2x fa-barcode addIcon"></i></a></div>
                                <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . lang('add_product_to_order') . '"'); ?>
                                <?php if ($Owner || $Admin || $GP['products-add']) {
                                            ?>
                                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                    <a href="#" id="addManually" class="tip" title="<?= lang('add_product_manually') ?>">
                                        <i class="fa fa-2x fa-plus-circle addIcon" id="addIcon"></i>
                                    </a>
                                </div>
                                <?php
                                } if ($Owner || $Admin || $GP['sales-add_gift_card']) {
                                    ?>
                                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                    <a href="#" id="sellGiftCard" class="tip" title="<?= lang('sell_gift_card') ?>">
                                        <i class="fa fa-2x fa-credit-card addIcon" id="addIcon"></i>
                                    </a>
                                </div>
                                <?php
                                        } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div> 
            <div class="row" style="margin: 15px 15px;"> 
                <div class="col-md-12">
                    <div class="control-group table-group">
                        <label class="table-label"><?= lang('order_items'); ?> *</label>

                        <div class="controls table-controls">
                            <table id="slTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
                                <thead>
                                <tr>
                                    <th class=""><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')'; ?></th>
                                    <?php
                                    if ($Settings->product_serial) {
                                        echo '<th class="">' . lang('serial_no') . '</th>';
                                    }
                                    ?>
                                    <th class=""><?= lang('net_unit_price'); ?></th>
                                    <th class=""><?= lang('quantity'); ?></th>
                                    <?php
                                    if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {
                                        echo '<th class="">' . lang('discount') . '</th>';
                                    }
                                    ?>
                                    <?php
                                    if ($Settings->tax1) {
                                        echo '<th class="">' . lang('product_tax') . '</th>';
                                    }
                                    ?>
                                    <th>
                                        <?= lang('subtotal'); ?>
                                        
                                    </th>
                                    <th style="width: 30px !important; text-align: center;">
                                        <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="row" style="margin: 15px 15px;"> 
                <?php if ($Settings->tax2) {
                ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="table-label"><?= lang('order_tax'); ?> </label>
                        <?php
                        $tr[''] = 'Select';
                        foreach ($tax_rates as $tax) {
                            $tr[$tax->id] = $tax->name;
                        }
                        echo form_dropdown('order_tax', $tr, ($_POST['order_tax'] ?? $Settings->default_tax_rate2), 'id="sltax2" data-placeholder="' . lang('select') . ' ' . lang('order_tax') . '" class="form-control input-tip select2" style="width:100%;"'); ?>
                    </div>
                </div>
                <?php
                } ?>
                <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) {
                ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('order_discount'); ?> </label>
                            <?php echo form_input('order_discount', '', 'class="form-control input-tip" id="sldiscount"'); ?>
                        </div>
                    </div>
                    <?php
                    } ?>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('shipping'); ?> </label>
                            <?php echo form_input('shipping', '', 'class="form-control input-tip" id="slshipping"'); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('attachments'); ?> </label>
                            <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachments[]" multiple data-show-upload="false" data-show-preview="false" class="form-control file">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('sale_status'); ?> *</label>
                            <?php $sst = ['completed' => lang('completed'), 'pending' => lang('pending')];
                            echo form_dropdown('sale_status', $sst, '', 'class="form-control input-tip select2" required="required" id="slsale_status"'); ?>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('payment_term'); ?> </label>
                            <?php echo form_input('payment_term', '', 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('payment_term_tip') . '" id="slpayment_term"'); ?>

                        </div>
                    </div>
                    <?php if ($Owner || $Admin || $GP['sales-payments']) {
                    ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="table-label"><?= lang('payment_status'); ?> *</label>
                            <?php $pst = ['pending' => lang('pending'), 'due' => lang('due'), 'partial' => lang('partial'), 'paid' => lang('paid')];
                                echo form_dropdown('payment_status', $pst, '', 'class="form-control input-tip select2" required="required" id="slpayment_status"'); ?>

                        </div>
                    </div>
                    <?php
                    } else {
                        echo form_hidden('payment_status', 'pending');
                    }
                    ?>
                    
            </div>

            <div class="row" id="bt" style="margin: 15px 15px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="table-label"><?= lang('sale_note'); ?> *</label>
                            <?php echo form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="slnote" style="margin-top: 10px; height: 100px;"'); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="table-label"><?= lang('staff_note'); ?> *</label>
                            <?php echo form_textarea('staff_note', ($_POST['staff_note'] ?? ''), 'class="form-control" id="slinnote" style="margin-top: 10px; height: 100px;"'); ?>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div
                            class="fprom-group"><?php echo form_submit('add_sale', lang('submit'), 'id="add_sale" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                            <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                    </div>
            </div>
            <br> <br>
            
        </div>   
    </div>

</div>    

<script> 
    var count = 1, an = 1, product_variant = 0, 
        product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0, total_discount = 0, total = 0, allow_discount = <?= ($Admin || $this->session->userdata('allow_discount')) ? 1 : 0; ?>,
        tax_rates = <?php echo json_encode($tax_rates); ?>;
    //var audio_success = new Audio('<?=$assets?>sounds/sound2.mp3');
    //var audio_error = new Audio('<?=$assets?>sounds/sound3.mp3');
    $(document).ready(function () {
        // if (localStorage.getItem('remove_slls')) {
            <?php 
            if ($this->session->userdata('remove_slls')) {
            ?>
            if (localStorage.getItem('slitems')) {
                localStorage.removeItem('slitems');
            }
            if (localStorage.getItem('sldiscount')) {
                localStorage.removeItem('sldiscount');
            }
            if (localStorage.getItem('sltax2')) {
                localStorage.removeItem('sltax2');
            }
            if (localStorage.getItem('slref')) {
                localStorage.removeItem('slref');
            }
            if (localStorage.getItem('slshipping')) {
                localStorage.removeItem('slshipping');
            }
            if (localStorage.getItem('slwarehouse')) {
                localStorage.removeItem('slwarehouse');
            }
            if (localStorage.getItem('slnote')) {
                localStorage.removeItem('slnote');
            }
            if (localStorage.getItem('slinnote')) {
                localStorage.removeItem('slinnote');
            }
            if (localStorage.getItem('slcustomer')) {
                localStorage.removeItem('slcustomer');
            }
            if (localStorage.getItem('slbiller')) {
                localStorage.removeItem('slbiller');
            }
            if (localStorage.getItem('slcurrency')) {
                localStorage.removeItem('slcurrency');
            }
            if (localStorage.getItem('sldate')) {
                localStorage.removeItem('sldate');
            }
            if (localStorage.getItem('slsale_status')) {
                localStorage.removeItem('slsale_status');
            }
            if (localStorage.getItem('slpayment_status')) {
                localStorage.removeItem('slpayment_status');
            }
            if (localStorage.getItem('paid_by')) {
                localStorage.removeItem('paid_by');
            }
            if (localStorage.getItem('amount_1')) {
                localStorage.removeItem('amount_1');
            }
            if (localStorage.getItem('paid_by_1')) {
                localStorage.removeItem('paid_by_1');
            }
            if (localStorage.getItem('pcc_holder_1')) {
                localStorage.removeItem('pcc_holder_1');
            }
            if (localStorage.getItem('pcc_type_1')) {
                localStorage.removeItem('pcc_type_1');
            }
            if (localStorage.getItem('pcc_month_1')) {
                localStorage.removeItem('pcc_month_1');
            }
            if (localStorage.getItem('pcc_year_1')) {
                localStorage.removeItem('pcc_year_1');
            }
            if (localStorage.getItem('pcc_no_1')) {
                localStorage.removeItem('pcc_no_1');
            }
            if (localStorage.getItem('cheque_no_1')) {
                localStorage.removeItem('cheque_no_1');
            }
            if (localStorage.getItem('payment_note_1')) {
                localStorage.removeItem('payment_note_1');
            }
            if (localStorage.getItem('slpayment_term')) {
                localStorage.removeItem('slpayment_term');
            }
            localStorage.removeItem('remove_slls');
        <?php } ?>
        // if (!localStorage.getItem('sldate')) {
        //     $("#sldate").datetimepicker({
        //         format: false,
        //         fontAwesome: true,
        //         language: 'sma',
        //         weekStart: 1,
        //         todayBtn: 1,
        //         autoclose: 1,
        //         todayHighlight: 1,
        //         startView: 2,
        //         forceParse: 0
        //     }).datetimepicker('update', new Date());
        // }
        // $("#sldate").datetimepicker();
       
        <?php if ($quote_id) {
    ?>
        // localStorage.setItem('sldate', '<?= $this->sma->hrld($quote->date) ?>');
        localStorage.setItem('slcustomer', '<?= $quote->customer_id ?>');
        localStorage.setItem('slbiller', '<?= $quote->biller_id ?>');
        localStorage.setItem('slwarehouse', '<?= $quote->warehouse_id ?>');
        localStorage.setItem('slnote', '<?= str_replace(["\r", "\n"], '', $this->sma->decode_html($quote->note)); ?>');
        localStorage.setItem('sldiscount', '<?= $quote->order_discount_id ?>');
        localStorage.setItem('sltax2', '<?= $quote->order_tax_id ?>');
        localStorage.setItem('slshipping', '<?= $quote->shipping ?>');
        localStorage.setItem('slitems', JSON.stringify(<?= $quote_items; ?>));
        <?php
} ?>
        <?php if ($this->input->get('customer')) {
        ?>
        if (!localStorage.getItem('slitems')) {
            localStorage.setItem('slcustomer', <?=$this->input->get('customer'); ?>);
        }
        <?php
    } ?>
        <?php if ($Admin) {
        ?>
        // if (!localStorage.getItem('sldate')) {
        //     $("#sldate").datetimepicker({
        //         format: site.dateFormats.js_ldate,
        //         fontAwesome: true,
        //         language: 'sma',
        //         weekStart: 1,
        //         todayBtn: 1,
        //         autoclose: 1,
        //         todayHighlight: 1,
        //         startView: 2,
        //         forceParse: 0
        //     }).datetimepicker('update', new Date());
        // }
        $(document).on('change', '#sldate', function (e) {
            localStorage.setItem('sldate', $(this).val());
        });
        if (sldate = localStorage.getItem('sldate')) {
            $('#sldate').val(sldate);
        }
        <?php
    } ?>
        $(document).on('change', '#slbiller', function (e) {
            localStorage.setItem('slbiller', $(this).val());
        });
        if (slbiller = localStorage.getItem('slbiller')) {
            $('#slbiller').val(slbiller);
        }
        if (!localStorage.getItem('slref')) {
            localStorage.setItem('slref', '<?=$slnumber?>');
        }
        if (!localStorage.getItem('sltax2')) {
            localStorage.setItem('sltax2', <?=$Settings->default_tax_rate2;?>);
        }
        ItemnTotals();
        $('.bootbox').on('hidden.bs.modal', function (e) {
            $('#add_item').focus();
        });

        /* --------------------------
     * Edit Row Quantity Method
    --------------------------- */
    var old_row_qty;
    $(document)
        .on('focus', '.rquantity', function () {
            old_row_qty = $(this).val();
        })
        .on('change', '.rquantity', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val())) {
                $(this).val(old_row_qty);
                bootbox.alert('Unexpected Value');
                return;
            }
            var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
            slitems[item_id].row.base_quantity = new_qty;
            if (slitems[item_id].row.unit != slitems[item_id].row.base_unit) {
                $.each(slitems[item_id].units, function () {
                    if (this.id == slitems[item_id].row.unit) {
                        slitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                    }
                });
            }
            slitems[item_id].row.qty = new_qty;
            localStorage.setItem('slitems', JSON.stringify(slitems));
            loadItems();
        });

    /* ----------------------
     * Delete Row Method
     * ---------------------- */
    $(document).on('click', '.sldel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        delete slitems[item_id];
        row.remove();
        if (slitems.hasOwnProperty(item_id)) {
        } else {
            localStorage.setItem('slitems', JSON.stringify(slitems));
            loadItems();
            return;
        }
    });


        // If there is any item in localStorage
        if (localStorage.getItem('slitems')) {
            loadItems();
        }

    }); /* End ready function */
</script>

<script> 




$(document).ready(function(){

    $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#slcustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above').' Customer.';?>');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get',
                    url: site.base_url + 'sales/sale/suggestions',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#slwarehouse").val(),
                        customer_id: $("#slcustomer").val()
                    },
                    success: function (data) {
                        $(this).removeClass('ui-autocomplete-loading');
                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_invoice_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });


        /* -----------------------
     * Edit Row Modal Hanlder
     ----------------------- */
    $(document).on('click', '.edit', function () {
        var row = $(this).closest('tr');
        var row_id = row.attr('id');
        item_id = row.attr('data-item-id');
        item = slitems[item_id];
        var qty = row.children().children('.rquantity').val(),
            product_option = row.children().children('.roption').val(),
            unit_price = formatDecimal(row.children().children('.ruprice').val()),
            discount = row.children().children('.rdiscount').val();
        if (item.options !== false) {
            $.each(item.options, function () {
                if (this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
                    unit_price = parseFloat(item.row.real_unit_price) + parseFloat(this.price);
                }
            });
        }
        var real_unit_price = item.row.real_unit_price;
        var net_price = unit_price;
        $('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
        if (site.settings.tax1) {
            // $('#ptax').select2('val', item.row.tax_rate);
            $("#ptax").prop('selectedIndex', item.row.tax_rate);
            $('#old_tax').val(item.row.tax_rate);
            var item_discount = 0,
                ds = discount ? discount : '0';
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal(parseFloat((unit_price * parseFloat(pds[0])) / 100), 4);
                } else {
                    item_discount = parseFloat(ds);
                }
            } else {
                item_discount = parseFloat(ds);
            }
            net_price -= item_discount;
            var pr_tax = item.row.tax_rate,
                pr_tax_val = 0;
            if (pr_tax !== null && pr_tax != 0) {
                $.each(tax_rates, function () {
                    if (this.id == pr_tax) {
                        if (this.type == 1) {
                            if (slitems[item_id].row.tax_method == 0) {
                                pr_tax_val = formatDecimal((net_price * parseFloat(this.rate)) / (100 + parseFloat(this.rate)), 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                                net_price -= pr_tax_val;
                            } else {
                                pr_tax_val = formatDecimal((net_price * parseFloat(this.rate)) / 100, 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                            }
                        } else if (this.type == 2) {
                            pr_tax_val = parseFloat(this.rate);
                            pr_tax_rate = this.rate;
                        }
                    }
                });
            }
        }
        if (site.settings.product_serial !== 0) {
            $('#pserial').val(row.children().children('.rserial').val());
        }
        var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        if (item.options !== false) {
            var o = 1;
            opt = $('<select id="poption" name="poption" class="form-control select2" />');
            $.each(item.options, function () {
                if (o == 1) {
                    if (product_option == '') {
                        product_variant = this.id;
                    } else {
                        product_variant = product_option;
                    }
                }
                $('<option />', { value: this.id, text: this.name }).appendTo(opt);
                o++;
            });
        } else {
            product_variant = 0;
        }

        uopt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        if (item.units) {
            uopt = $('<select id="punit" name="punit" class="form-control select2" />');
            $.each(item.units, function () {
                if (this.id == item.row.unit) {
                    $('<option />', { value: this.id, text: this.name, selected: true }).appendTo(uopt);
                } else {
                    $('<option />', { value: this.id, text: this.name }).appendTo(uopt);
                }
            });
        }

        $('#poptions-div').html(opt);
        $('#punits-div').html(uopt);
        $('select.select').select2({ minimumResultsForSearch: 7 });
        $('#pquantity').val(qty);
        $('#old_qty').val(qty);
        $('#pprice').val(unit_price);
        $('#punit_price').val(formatDecimal(parseFloat(unit_price) + parseFloat(pr_tax_val)));
        $('#poption').select2('val', item.row.option);
        $('#old_price').val(unit_price);
        $('#row_id').val(row_id);
        $('#item_id').val(item_id);
        $('#pserial').val(row.children().children('.rserial').val());
        $('#pdiscount').val(discount);
        $('#padiscount').val('');
        $('#psubt').val(row.find('.ssubtotal').text());
        $('#net_price').text(formatMoney(net_price));
        $('#pro_tax').text(formatMoney(pr_tax_val));
        $('#prModal').appendTo('body').modal('show');
    });

    /* -----------------------
     * Edit Row Method
     ----------------------- */
     $(document).on('click', '#editItem', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id'),
            new_pr_tax = $('#ptax').val(),
            new_pr_tax_rate = false;
        if (new_pr_tax) {
            $.each(tax_rates, function () {
                if (this.id == new_pr_tax) {
                    new_pr_tax_rate = this;
                }
            });
        }
        var price = parseFloat($('#pprice').val());
        var unit = $('#punit').val();
        var base_quantity = parseFloat($('#pquantity').val());
        if (unit != slitems[item_id].row.base_unit) {
            $.each(slitems[item_id].units, function () {
                if (this.id == unit) {
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                }
            });
        }
        if (item.options !== false) {
            var opt = $('#poption').val();
            $.each(item.options, function () {
                if (this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    price = price - parseFloat(this.price);
                    // price = price - parseFloat(this.price) * parseFloat(base_quantity);
                }
            });
        }
        if (site.settings.product_discount == 1 && $('#pdiscount').val()) {
            if (!($('#pdiscount').val()) || ($('#pdiscount').val() != 0 && $('#pdiscount').val() > price)) {
                bootbox.alert(lang.unexpected_value);
                return false;
            }
        }
        var discount = $('#pdiscount').val() ? $('#pdiscount').val() : '';
        if (!is_numeric($('#pquantity').val())) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var quantity = parseFloat($('#pquantity').val());
        // if (site.settings.product_discount == 1 && $('#padiscount').val()) {
        //     if (!is_numeric($('#padiscount').val()) || $('#padiscount').val() > price * quantity) {
        //         bootbox.alert(lang.unexpected_value);
        //         return false;
        //     }
        //     discount = formatDecimal(parseFloat($('#padiscount').val()) / quantity, 4);
        // }
        // console.log(discount);

        slitems[item_id].row.fup = 1;
        slitems[item_id].row.qty = quantity;
        slitems[item_id].row.base_quantity = parseFloat(base_quantity);
        slitems[item_id].row.real_unit_price = price;
        slitems[item_id].row.unit = unit;
        slitems[item_id].row.tax_rate = new_pr_tax;
        slitems[item_id].tax_rate = new_pr_tax_rate;
        slitems[item_id].row.discount = discount;
        slitems[item_id].row.option = $('#poption').val() ? $('#poption').val() : '';
        slitems[item_id].row.serial = $('#pserial').val();
        localStorage.setItem('slitems', JSON.stringify(slitems));
        $('#prModal').modal('hide');

        loadItems();
        return;
    });

    $('#prModal').on('shown.bs.modal', function (e) {
        if ($('#poption').select2('val') != '') {
            $('#poption').select2('val', product_variant);
            product_variant = 0;
        }
    });
    /* ------------------------------
     * Show manual item addition modal
     ------------------------------- */
     $(document).on('click', '#addManually', function (e) {
        if (count == 1) {
            slitems = {};
            if ($('#slwarehouse').val() && $('#slcustomer').val()) {
                $('#slcustomer').select2('readonly', true);
                $('#slwarehouse').select2('readonly', true);
            } else {
                bootbox.alert('Select customer avobe!');
                item = null;
                return false;
            }
        }
        $('#mnet_price').text('0.00');
        $('#mpro_tax').text('0.00');
        $('#mModal').appendTo('body').modal('show');
        return false;
    });
    
    $(document).on('click', '#addItemManually', function (e) {
        var mid = new Date().getTime(),
            mcode = $('#mcode').val(),
            mname = $('#mname').val(),
            mtax = parseInt($('#mtax').val()),
            munit = parseInt($('#munit').val()),
            mqty = parseFloat($('#mquantity').val()),
            mdiscount = $('#mdiscount').val() ? $('#mdiscount').val() : '0',
            unit_price = parseFloat($('#mprice').val()),
            mtax_rate = {};
        if (mcode && mname && mqty && unit_price) {
            $.each(tax_rates, function () {
                if (this.id == mtax) {
                    mtax_rate = this;
                }
            });

            slitems[mid] = {
                id: mid,
                item_id: mid,
                label: mname + ' (' + mcode + ')',
                row: {
                    id: mid,
                    code: mcode,
                    name: mname,
                    quantity: mqty,
                    base_quantity: mqty,
                    price: unit_price,
                    unit_price: unit_price,
                    real_unit_price: unit_price,
                    tax_rate: mtax,
                    unit: munit,
                    tax_method: 0,
                    qty: mqty,
                    type: 'manual',
                    discount: mdiscount,
                    serial: '',
                    option: '',
                },
                tax_rate: mtax_rate,
                units: false,
                options: false,
            };
            localStorage.setItem('slitems', JSON.stringify(slitems));
            loadItems();
        }
        $('#mModal').modal('hide');
        $('#mcode').val('');
        $('#mname').val('');
        $('#mtax').val('');
        $('#munit').val('');
        $('#mquantity').val('');
        $('#mdiscount').val('');
        $('#mprice').val('');
        return false;
    });
        
});

/* -----------------------------
        * Add Sale Order Item Function
        * @param {json} item
        * @returns {Boolean}
        ---------------------------- */
        function add_invoice_item(item) {
            console.log(item);
            // let count = 1;
            if (count == 1) {
                console.log(count);
                slitems = {};
                if ($('#slwarehouse').val() && $('#slcustomer').val()) {
                    $('#slcustomer').select2('readonly', true);
                    $('#slwarehouse').select2('readonly', true);
                } else {
                    bootbox.alert('Select Avobe');
                    item = null;
                    return;
                }
            }
            if (item == null) return;

            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            if (slitems[item_id]) {
                var new_qty = parseFloat(slitems[item_id].row.qty) + 1;
                slitems[item_id].row.base_quantity = new_qty;
                if (slitems[item_id].row.unit != slitems[item_id].row.base_unit) {
                    $.each(slitems[item_id].units, function () {
                        if (this.id == slitems[item_id].row.unit) {
                            slitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                        }
                    });
                }
                slitems[item_id].row.qty = new_qty;
            } else {
                slitems[item_id] = item;
            }
            slitems[item_id].order = new Date().getTime();
            localStorage.setItem('slitems', JSON.stringify(slitems));
            loadItems();
            return true;
        }

function loadItems() {
    if (localStorage.getItem('slitems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $('#slTable tbody').empty();
        slitems = JSON.parse(localStorage.getItem('slitems'));
        sortedItems = slitems;
        $('#add_sale, #edit_sale').attr('disabled', false);
        $.each(sortedItems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            item.order = item.order ? item.order : new Date().getTime();
            var product_id = item.row.id,
                item_type = item.row.type,
                combo_items = item.combo_items,
                item_price = item.row.price,
                item_qty = item.row.qty,
                item_aqty = item.row.quantity,
                item_tax_method = item.row.tax_method,
                item_ds = item.row.discount,
                item_discount = 0,
                item_option = item.row.option,
                item_code = item.row.code,
                item_serial = item.row.serial,
                item_name = item.row.name.replace(/"/g, '&#034;').replace(/'/g, '&#039;');
            var product_unit = item.row.unit,
                base_quantity = item.row.base_quantity;
            var unit_price = item.row.real_unit_price;
            if (item.units && item.row.fup != 1 && product_unit != item.row.base_unit) {
                $.each(item.units, function () {
                    if (this.id == product_unit) {
                        base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4);
                        unit_price = formatDecimal(parseFloat(item.row.base_unit_price) * unitToBaseQty(1, this), 4);
                    }
                });
            }

            var sel_opt = '';
            if (item.options !== false) {
                $.each(item.options, function () {
                    if (this.id == item_option) {
                        sel_opt = this.name;
                        if (this.price != 0 && this.price != '' && this.price != null) {
                            // item_price = unit_price + parseFloat(this.price) * parseFloat(base_quantity);
                            item_price = parseFloat(unit_price) + parseFloat(this.price);
                            unit_price = item_price;
                        }
                    }
                });
            }

            var ds = item_ds ? item_ds : '0';
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal((unit_price * parseFloat(pds[0])) / 100, 4);
                } else {
                    item_discount = formatDecimal(ds);
                }
            } else {
                item_discount = formatDecimal(ds);
            }
            product_discount += formatDecimal(item_discount * item_qty, 4);

            unit_price = formatDecimal(unit_price - item_discount);
            var pr_tax = item.tax_rate;
            var pr_tax_val = 0,
                pr_tax_rate = 0;
            if (site.settings.tax1 == 1) {
                if (pr_tax !== false && pr_tax != 0) {
                    if (pr_tax.type == 1) {
                        if (item_tax_method == '0') {
                            pr_tax_val = formatDecimal((unit_price * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 4);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        } else {
                            pr_tax_val = formatDecimal((unit_price * parseFloat(pr_tax.rate)) / 100, 4);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        }
                    } else if (pr_tax.type == 2) {
                        pr_tax_val = parseFloat(pr_tax.rate);
                        pr_tax_rate = pr_tax.rate;
                    }
                }
            }
            pr_tax_val = formatDecimal(pr_tax_val);
            product_tax += formatDecimal(pr_tax_val * item_qty);
            item_price = item_tax_method == 0 ? formatDecimal(unit_price - pr_tax_val, 4) : formatDecimal(unit_price);
            unit_price = formatDecimal(unit_price + item_discount, 4);

            var row_no = item.id;
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');

            tr_html =
                '<td><input name="product_id[]" type="hidden" class="rid" value="' +
                product_id +
                '"><input name="product_type[]" type="hidden" class="rtype" value="' +
                item_type +
                '"><input name="product_code[]" type="hidden" class="rcode" value="' +
                item_code +
                '"><input name="product_name[]" type="hidden" class="rname" value="' +
                item_name +
                '"><input name="product_option[]" type="hidden" class="roption" value="' +
                item_option +
                '"><span class="sname" id="name_' +
                row_no +
                '">' +
                item_code +
                ' - ' +
                item_name +
                (sel_opt != '' ? ' (' + sel_opt + ')' : '') +
                '</span><i class="pull-right fa fa-edit tip pointer edit" id="' +
                row_no +
                '" data-item="' +
                item_id +
                '" title="Edit" style="cursor:pointer;"></i></td>';
            if (site.settings.product_serial == 1) {
                tr_html +=
                    '<td class="text-right"><input class="form-control input-sm rserial" name="serial[]" type="text" id="serial_' +
                    row_no +
                    '" value="' +
                    item_serial +
                    '"></td>';
            }
            tr_html +=
                '<td class="text-right"><input class="form-control input-sm text-right rprice" name="net_price[]" type="hidden" id="price_' +
                row_no +
                '" value="' +
                item_price +
                '"><input class="ruprice" name="unit_price[]" type="hidden" value="' +
                unit_price +
                '"><input class="realuprice" name="real_unit_price[]" type="hidden" value="' +
                item.row.real_unit_price +
                '"><span class="text-right sprice" id="sprice_' +
                row_no +
                '">' +
                formatMoney(item_price) +
                '</span></td>';
            tr_html +=
                '<td><input class="form-control text-center rquantity" tabindex="' +
                (site.settings.set_focus == 1 ? an : an + 1) +
                '" name="quantity[]" type="text" value="' +
                formatQuantity2(item_qty) +
                '" data-id="' +
                row_no +
                '" data-item="' +
                item_id +
                '" id="quantity_' +
                row_no +
                '" onClick="this.select();"><input name="product_unit[]" type="hidden" class="runit" value="' +
                product_unit +
                '"><input name="product_base_quantity[]" type="hidden" class="rbase_quantity" value="' +
                base_quantity +
                '"></td>';
            if ((site.settings.product_discount == 1 && allow_discount == 1) || item_discount) {
                tr_html +=
                    '<td class="text-right"><input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' +
                    row_no +
                    '" value="' +
                    item_ds +
                    '"><span class="text-right sdiscount text-danger" id="sdiscount_' +
                    row_no +
                    '">' +
                    formatMoney(0 - item_discount * item_qty) +
                    '</span></td>';
            }
            if (site.settings.tax1 == 1) {
                tr_html +=
                    '<td class="text-right"><input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' +
                    row_no +
                    '" value="' +
                    pr_tax.id +
                    '"><span class="text-right sproduct_tax" id="sproduct_tax_' +
                    row_no +
                    '">' +
                    (parseFloat(pr_tax_rate) != 0 ? '(' + formatDecimal(pr_tax_rate) + ')' : '') +
                    ' ' +
                    formatMoney(pr_tax_val * item_qty) +
                    '</span></td>';
            }
            tr_html +=
                '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' +
                row_no +
                '">' +
                formatMoney((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)) +
                '</span></td>';
            tr_html +=
                '<td class="text-center"><i class="fa fa-times tip pointer sldel" id="' +
                row_no +
                '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo('#slTable');
            total += formatDecimal((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty), 4);
            count += parseFloat(item_qty);
            an++;

            if (item_type == 'standard' && item.options !== false) {
                $.each(item.options, function () {
                    if (this.id == item_option && base_quantity > this.quantity) {
                        $('#row_' + row_no).addClass('danger');
                        if (site.settings.overselling != 1) {
                            console.log('standard, disable');
                            $('#add_sale, #edit_sale').attr('disabled', true);
                        }
                    }
                });
            } else if (item_type == 'standard' && base_quantity > item_aqty) {
                $('#row_' + row_no).addClass('danger');
                if (site.settings.overselling != 1) {
                    console.log('standard, disable2');
                    $('#add_sale, #edit_sale').attr('disabled', true);
                }
            } else if (item_type == 'combo') {
                if (combo_items === false) {
                    $('#row_' + row_no).addClass('danger');
                    if (site.settings.overselling != 1) {
                        console.log('combo, disable');
                        $('#add_sale, #edit_sale').attr('disabled', true);
                    }
                } else {
                    $.each(combo_items, function () {
                        if (parseFloat(this.quantity) < parseFloat(this.qty) * base_quantity && this.type == 'standard') {
                            $('#row_' + row_no).addClass('danger');
                            if (site.settings.overselling != 1) {
                                console.log('standard, disableLast');
                                $('#add_sale, #edit_sale').attr('disabled', true);
                            }
                        }
                    });
                }
            }
        });

        var col = 2;
        if (site.settings.product_serial == 1) {
            col++;
        }
        var tfoot =
            '<tr id="tfoot" class="tfoot active"><th colspan="' +
            col +
            '">Total</th><th class="text-center">' +
            formatQty(parseFloat(count) - 1) +
            '</th>';
        if ((site.settings.product_discount == 1 && allow_discount == 1) || product_discount) {
            tfoot += '<th class="text-right">' + formatMoney(product_discount) + '</th>';
        }
        if (site.settings.tax1 == 1) {
            tfoot += '<th class="text-right">' + formatMoney(product_tax) + '</th>';
        }
        tfoot +=
            '<th class="text-right">' +
            formatMoney(total) +
            '</th><th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i></th></tr>';
        $('#slTable tfoot').html(tfoot);

        // Order level discount calculations
        if ((sldiscount = localStorage.getItem('sldiscount'))) {
            var ds = sldiscount;
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) {
                    order_discount = formatDecimal((total * parseFloat(pds[0])) / 100, 4);
                } else {
                    order_discount = formatDecimal(ds);
                }
            } else {
                order_discount = formatDecimal(ds);
            }

            //total_discount += parseFloat(order_discount);
        }

        // Order level tax calculations
        if (site.settings.tax2 != 0) {
            if ((sltax2 = localStorage.getItem('sltax2'))) {
                $.each(tax_rates, function () {
                    if (this.id == sltax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        } else if (this.type == 1) {
                            invoice_tax = formatDecimal(((total - order_discount) * this.rate) / 100, 4);
                        }
                    }
                });
            }
        }

        total_discount = parseFloat(order_discount + product_discount);
        // Totals calculations after item addition
        var gtotal = parseFloat(total + invoice_tax - order_discount);
        $('#total').text(formatMoney(total));
        $('#titems').text(an - 1 + ' (' + formatQty(parseFloat(count) - 1) + ')');
        $('#total_items').val(parseFloat(count) - 1);
        //$('#tds').text('('+formatMoney(product_discount)+'+'+formatMoney(order_discount)+')'+formatMoney(total_discount));
        $('#tds').text(formatMoney(order_discount));
        if (site.settings.tax2 != 0) {
            $('#ttax2').text(formatMoney(invoice_tax));
        }
        // $('#tship').text(formatMoney(shipping));
        $('#gtotal').text(formatMoney(gtotal));
        if (an > parseInt(site.settings.bc_fix) && parseInt(site.settings.bc_fix) > 0) {
            $('html, body').animate({ scrollTop: $('#sticker').offset().top }, 500);
            $(window).scrollTop($(window).scrollTop() + 1);
        }
        if (count > 1) {
            $('#slcustomer').select2('readonly', true);
            $('#slwarehouse').select2('readonly', true);
        }
        set_page_focus();
    }
}
</script>


<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="prModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span></button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <?php if ($Settings->tax1) {
                                    ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[''] = '';
                                    foreach ($tax_rates as $tax) {
                                        $tr[$tax->id] = $tax->name;
                                    }
                                    echo form_dropdown('ptax', $tr, '', 'id="ptax" class="form-control pos-input-tip select2" style="width:100%;"'); ?>
                            </div>
                        </div>
                    <?php
                                } ?>
                    <?php if ($Settings->product_serial) {
                                    ?>
                        <div class="form-group">
                            <label for="pserial" class="col-sm-4 control-label"><?= lang('serial_no') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pserial">
                            </div>
                        </div>
                    <?php
                                } ?>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punit" class="col-sm-4 control-label"><?= lang('product_unit') ?></label>
                        <div class="col-sm-8">
                            <div id="punits-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>
                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount) {
                                    ?>
                        <div class="form-group">
                            <label for="pdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount" <?= $allow_discount ? '' : 'readonly="true"'; ?>>
                            </div>
                        </div>
                    <?php
                                } ?>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('unit_price') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice" <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly'; ?>>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="net_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <input type="hidden" id="punit_price" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="mcode" class="col-sm-4 control-label"><?= lang('product_code') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mname" class="col-sm-4 control-label"><?= lang('product_name') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mname">
                        </div>
                    </div>
                    <?php if ($Settings->tax1) {
                            ?>
                        <div class="form-group">
                            <label for="mtax" class="col-sm-4 control-label"><?= lang('product_tax') ?> *</label>

                            <div class="col-sm-8">
                                <?php
                                $tr[''] = '';
                            foreach ($tax_rates as $tax) {
                                $tr[$tax->id] = $tax->name;
                            }
                            echo form_dropdown('mtax', $tr, '', 'id="mtax" class="form-control input-tip select" style="width:100%;"'); ?>
                            </div>
                        </div>
                    <?php
                        } ?>
                    <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label"><?= lang('quantity') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="munit" class="col-sm-4 control-label"><?= lang('unit') ?> *</label>

                        <div class="col-sm-8">
                            <?php
                            $uts[''] = '';
                            foreach ($units as $unit) {
                                $uts[$unit->id] = $unit->name;
                            }
                            echo form_dropdown('munit', $uts, '', 'id="munit" class="form-control input-tip select" style="width:100%;"');
                            ?>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {
                                ?>
                        <div class="form-group">
                            <label for="mdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mdiscount">
                            </div>
                        </div>
                    <?php
                            } ?>
                    <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label"><?= lang('unit_price') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="mnet_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"> </script>