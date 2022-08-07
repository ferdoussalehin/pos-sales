

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
                            echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller), 'id="slbiller" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" required="required" class="form-control input-tip select" style="width:100%;"'); ?>
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
                        echo form_dropdown('order_tax', $tr, ($_POST['order_tax'] ?? $Settings->default_tax_rate2), 'id="sltax2" data-placeholder="' . lang('select') . ' ' . lang('order_tax') . '" class="form-control input-tip select" style="width:100%;"'); ?>
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
                            echo form_dropdown('sale_status', $sst, '', 'class="form-control input-tip" required="required" id="slsale_status"'); ?>

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
                                echo form_dropdown('payment_status', $pst, '', 'class="form-control input-tip" required="required" id="slpayment_status"'); ?>

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
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0, total_discount = 0, total = 0, allow_discount = <?= ($Admin || $this->session->userdata('allow_discount')) ? 1 : 0; ?>,
        tax_rates = <?php echo json_encode($tax_rates); ?>;
    //var audio_success = new Audio('<?=$assets?>sounds/sound2.mp3');
    //var audio_error = new Audio('<?=$assets?>sounds/sound3.mp3');
    $(document).ready(function () {

        <?php 
        print_r($inv); die;
        if ($inv) {
            print_r($inv_items); die;
        ?>
            localStorage.setItem('sldate', '<?= ($inv->date) ?>');
            localStorage.setItem('slcustomer', '<?= $inv->customer_id ?>');
            localStorage.setItem('slbiller', '<?= $inv->biller_id ?>');
            localStorage.setItem('slref', '<?= $inv->reference_no ?>');
            localStorage.setItem('slwarehouse', '<?= $inv->warehouse_id ?>');
            localStorage.setItem('slsale_status', '<?= $inv->sale_status ?>');
            localStorage.setItem('slpayment_status', '<?= $inv->payment_status ?>');
            localStorage.setItem('slpayment_term', '<?= $inv->payment_term ?>');
            localStorage.setItem('slnote', '<?= str_replace(["\r", "\n"], '', ($inv->note)); ?>');
            localStorage.setItem('slinnote', '<?= str_replace(["\r", "\n"], '', ($inv->staff_note)); ?>');
            localStorage.setItem('sldiscount', '<?= $inv->order_discount_id ?>');
            localStorage.setItem('sltax2', '<?= $inv->order_tax_id ?>');
            localStorage.setItem('slshipping', '<?= $inv->shipping ?>');
            localStorage.setItem('slitems', JSON.stringify(<?= $inv_items; ?>));
        <?php
        } ?>
        
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

        // If there is any item in localStorage
        if (localStorage.getItem('slitems')) {
            loadItems();
        }    

       
        <?php if ($quote_id) {
        ?>
            // localStorage.setItem('sldate', '<?= $this->sma->hrld($quote->date) ?>');
            localStorage.setItem('slcustomer', '<?= $quote->customer_id ?>');
            localStorage.setItem('slbiller', '<?= $quote->biller_id ?>');
            localStorage.setItem('slwarehouse', '<?= $quote->warehouse_id ?>');
            localStorage.setItem('slnote', '<?= str_replace(["\r", "\n"], '', ($quote->note)); ?>');
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
        console.log('hello', slitems);
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
                '</span> <i class="pull-right fa fa-edit tip pointer edit" id="' +
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"> </script>