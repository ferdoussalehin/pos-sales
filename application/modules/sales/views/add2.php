<?php defined('BASEPATH') or exit('No direct script access allowed') ?>
<style> 
    #show_cat {
        width: 100%;
    }
    #category-list .btn-prni {
        border: 1px solid #eee;
        cursor: pointer;
        height: 120px;
        margin: 0 0 3px 2px;
        padding: 2px;
        width: 23.5%;
        min-width: 100px;
        overflow: hidden;
        display: inline-block;
        font-size: 13px;
    }
    
    #category-list {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
        
    }
    #category-list .btn-prni {
        position: relative;
    }
    #category-list .btn-prni img {
        max-height: 70px !important;
    }

    #category-list .btn-prni span {
        display: table-cell;
        height: 100%;
        line-height: 8px;
        vertical-align: middle;
        text-transform: uppercase;
        width: 100%;
        min-width: 82px;
        overflow: hidden;
        position: absolute;
        top: 85%;
        left: 0;
        bottom: 0;
        background-color: #fbfafa8c;
        text-shadow: 0 0 #b8b4b4;
    }
    #ajaxproducts{
        display: none;
    }
    #item-list {
        overflow: scroll;
        height: 227px;
        min-height: 515px;
        margin-top: 10px;
    }
    #item-list .btn-prni {
        position: relative;
    }
    #item-list .btn-prni {
        border: 2px solid #eee;
        cursor: pointer;
        height: 120px;
        margin: 0 0 3px 2px;
        padding: 2px;
        width: 23.5%;
        min-width: 100px;
        overflow: hidden;
        display: inline-block;
        font-size: 13px;
        background-color: #fff;
        
    }
    #item-list .btn-prni img {
        max-height: 70px !important;
    }
    #item-list .btn-prni span {
        display: table-cell;
        height: 100%;
        line-height: 8px;
        vertical-align: middle;
        text-transform: uppercase;
        width: 100%;
        min-width: 82px;
        overflow: hidden;
        position: absolute;
        top: 85%;
        left: 0;
        bottom: 0;
        background-color: #fbfafa8c;
        text-shadow: 0 0 #b8b4b4;
    }
    
</style>

<div class="panel panel-default">
	
	<div class="panel-heading">
    </div>
    <div class="panel-body">
        <div id="pos">
            <div class="row" style="margin: 15px 15px;"> 
                <div class="col-md-5"> 
                    <div id="left-top">
                    <div class="form-group">
                            <div class="input-group" style="z-index:1;">
                            <?php
                                $cus[''] = 'Select';
                                foreach ($customers as $customer) {
                                    $cus[$customer->id] = $customer->name;
                                }
                                echo form_dropdown('customer', $cus, ($_POST['customer'] ?? $default_customer->id), 'id="poscustomer" class="form-control pos-input-tip select2" required="required" style="width:80%;" '); 
                            ?> 
                            <div class="input-group-addon no-print" style="padding: 8px 8px; border-left: 0;">
                                <a href="#" id="toogle-customer-read-attr" class="external">
                                    <i class="fa fa-pencil" id="addIcon" style="font-size: 1.2em;"></i>
                                </a>
                            </div>
                            <div class="input-group-addon no-print" style="padding: 8px 8px;">
                                <a href="<?=base_url('customers/add'); ?>" id="add-customer" class="external" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-plus-circle" id="addIcon" style="font-size: 1.5em;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            $wh[''] = 'Select';
                        foreach ($warehouses as $warehouse) {
                            $wh[$warehouse->id] = $warehouse->name;
                        }
                        echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse), 'id="poswarehouse" class="form-control pos-input-tip select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" style="width:100%;" '); ?>
                    </div>
                    <div class="form-group"> 
                        <?php echo form_input('add_item', '', 'class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" placeholder="' . lang('search_product_by_name_code') . '" title="' . lang('au_pr_name_tip') . '"'); ?>
                    </div>
                    </div>
                    <div id="left-middle" style="height: 0px; min-height: 278px;">
                        <div id="product-list" style="height: 0px; min-height: 278px;overflow: scroll">
                            <table class="table items table-striped table-bordered table-condensed table-hover sortable_table"
                                    id="posTable" style="margin-bottom: 0;">
                                <thead>
                                <tr>
                                    <th width="40%"><?=lang('product');?></th>
                                    <th width="15%"><?=lang('price');?></th>
                                    <th width="15%"><?=lang('qty');?></th>
                                    <th width="20%"><?=lang('subtotal');?></th>
                                    <th style="width: 5%; text-align: center;">
                                        <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="clear:both;"></div>
                        </div>
                    </div> 
                    <div id="left-bottom"> 
                        <table id="totalTable"
                            style="width:100%; padding:5px; color:#000; background: #FFF;">
                            <tr style="border-top: 1px solid #DDD;">
                                <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('items');?></td>
                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                                    <span id="titems">0</span>
                                </td>
                                <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('total');?></td>
                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                                    <span id="total">0.00</span>
                                </td>
                            </tr>
                            <tr style="border-top: 1px solid #DDD;">
                                <td style="padding: 5px 10px;"><?=lang('order_tax');?>
                                    <a href="#" id="pptax2">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                    <span id="ttax2">0.00</span>
                                </td>
                                <td style="padding: 5px 10px;"><?=lang('discount');?>
                                    <?php if ($Admin || $this->session->userdata('allow_discount')) {
                                        ?>
                                    <a href="#" id="ppdiscount">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                        <?php
                                    } ?>
                                </td>
                                <td class="text-right" style="padding: 5px 10px;font-weight:bold;">
                                    <span id="tds">0.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 10px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#5e5e5e; color:#FFF;" colspan="2">
                                    <?=lang('total_payable');?>
                                    <a href="#" id="pshipping">
                                        <i class="fa fa-plus-square"></i>
                                    </a>
                                    <span id="tship"></span>
                                </td>
                                <td class="text-right" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#5e5e5e; color:#FFF;" colspan="2">
                                    <span id="gtotal">0.00</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div> <!-- .End class="col-md-5" -->
                    
                
                <div class="col-md-7"> 
                    <div id="proContainer"> 
                        <div class="row"> 
                            <div class="col-md-12"> 
                                <button type="button" id="show_cat" class="btn btn-secondary btn btn-info">Category</button>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12"> 
                                <div id="ajaxproducts">
                                    <div id="item-list" style="overflow: scroll;">
                                        <?php //echo $products; ?>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                                <div id="category-list">
                                    <?php
                                    foreach ($categories as $category) {
                                        echo '<button id="category-' . $category->id . '" type="button"'. ' value="'. $category->id . '" class="btn-prni category"> <img src="'. base_url() ."assets/uploads/categories/" . ($category->image ? $category->image : 'no_image.png') . '" class="img-rounded img-thumbnail/"><span>'. $category->name . '</span></button>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script> 

var pos_settings = <?=json_encode($pos_settings);?>;
var username = '<?=$this->session->userdata('username');?>', order_data = '', bill_data = '', count = 1;
var lang = {
    unexpected_value: '<?=lang('unexpected_value');?>',
    select_above: '<?=lang('select_above');?>',
    r_u_sure: '<?=lang('r_u_sure');?>',
    bill: '<?=lang('bill');?>',
    order: '<?=lang('order');?>',
    total: '<?=lang('total');?>',
    items: '<?=lang('items');?>',
    discount: '<?=lang('discount');?>',
    order_tax: '<?=lang('order_tax');?>',
    grand_total: '<?=lang('grand_total');?>',
    total_payable: '<?=lang('total_payable');?>',
    rounding: '<?=lang('rounding');?>',
    merchant_copy: '<?=lang('merchant_copy');?>'
};
var shipping = 0, KB = <?=$pos_settings->keyboard?>, product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0, total_discount = 0, total = 0, total_paid = 0, grand_total = 0;
var protect_delete = <?= (!$Admin) ? ($pos_settings->pin_code ? '1' : '0') : '0'; ?>;

$(document).ready(function(){

    // If there is any item in localStorage
    if (localStorage.getItem('positems')) {
        loadItems();
    }
    
    $('#poscustomer').attr('disabled', true);
    $('#poswarehouse').prop('disabled', true);

    $('#category-list .category').click(function(){
        $('#ajaxproducts').show();
        $('#category-list').hide();
    });
    $('#show_cat').click(function(){
        $('#ajaxproducts').hide();
        $('#category-list').show();
    });

    $(document).on('click', '.category', function(){
        const catId = $(this).val();
        $.ajax({
            url: site.base_url + 'sales/pos/ajax_category_data',
            type: 'POST',
            datatype: 'json',
            data: {catId: catId},
            success: function(data){
                $('#item-list').empty();
                let newPrs = $('<div></div>');
                newPrs.html(data.products);
                newPrs.appendTo('#item-list');
           }

        }).done(function(){

        });
    });

    $(document).on('click', '.product', function(e){
        const prCode = $(this).val();
        const warehouseId = $('#poswarehouse').val();

        $.ajax({
            url: site.base_url + 'sales/pos/getProductDataByCode',
            type: 'get',
            dataType: 'json',
            data: { code: prCode, warehouse_id: warehouseId},
            success: function(data) {
                // e.preventDefault();
                // console.log(data);
                if (data !== null) {
                    add_invoice_item(data);
                }

            }
        });
    });

    var old_row_qty;
    $(document)
        .on('focus', '.rquantity', function () {
            old_row_qty = $(this).val();
        })
        .on('change', '.rquantity', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
                $(this).val(old_row_qty);
                bootbox.alert(lang.unexpected_value);
                return;
            }
            var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
            positems[item_id].row.base_quantity = new_qty;
            if (positems[item_id].row.unit != positems[item_id].row.base_unit) {
                $.each(positems[item_id].units, function () {
                    if (this.id == positems[item_id].row.unit) {
                        positems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                    }
                });
            }
            positems[item_id].row.qty = new_qty;
            localStorage.setItem('positems', JSON.stringify(positems));
            loadItems();
        });

        /* ----------------------
     * Delete Row Method
     * ---------------------- */
    var pwacc = false;
    $(document).on('click', '.posdel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');

        delete positems[item_id];
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
        
        return false;
    });



}); // End ready function


/* -----------------------------
 * Add Sale Order Item Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
 function add_invoice_item(item) {
    console.log(item);
    /* if count is 1 then initialize empty positems */
    if (count == 1) {
        positems = {};
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2('readonly', true);
            $('#poswarehouse').select2('readonly', true);
        } else {
            // bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    if (item == null) return;
    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    /** 
      * if item is already in positems list
      */
    if (positems[item_id]) {
        var new_qty = parseFloat(positems[item_id].row.qty) + 1;
        positems[item_id].row.base_quantity = new_qty;
        if (positems[item_id].row.unit != positems[item_id].row.base_unit) {
            $.each(positems[item_id].units, function () {
                if (this.id == positems[item_id].row.unit) {
                    positems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        positems[item_id].row.qty = new_qty;
    } else {
        positems[item_id] = item;
    }
    positems[item_id].order = new Date().getTime();
    console.log('positems: ', positems);
    localStorage.setItem('positems', JSON.stringify(positems));
    loadItems();
    return true;
}

    
function is_numeric(mixed_var) {
    var whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
    return (
        (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -1)) &&
        mixed_var !== '' &&
        !isNaN(mixed_var)
    );
}

//localStorage.clear();
function loadItems() {
    if (localStorage.getItem('positems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;
        order_data = {};
        bill_data = {};

        $('#posTable tbody').empty();
        var time = new Date().getTime() / 1000;
        if (pos_settings.remote_printing != 1) {
            store_name = biller && biller.company != '-' ? biller.company : biller.name;
            order_data.store_name = store_name;
            bill_data.store_name = store_name;
            order_data.header = '\n' + lang.order + '\n\n';
            bill_data.header = '\n' + lang.bill + '\n\n';

            var pos_customer = 'C: ' + $('#select2-chosen-1').text() + '\n';
            var hr = 'R: ' + $('#reference_note').val() + '\n';
            var user = 'U: ' + username + '\n';
            var pos_curr_time = 'T: ' + date(site.dateFormats.php_ldate, time) + '\n';
            var ob_info = pos_customer + hr + user + pos_curr_time + '\n';
            order_data.info = ob_info;
            bill_data.info = ob_info;
            var o_items = '';
            var b_items = '';
        } else {
            $('#order_span').empty();
            $('#bill_span').empty();
            var styles =
                '<style>table, th, td { border-collapse:collapse; border-bottom: 1px solid #CCC; } .no-border { border: 0; } .bold { font-weight: bold; }</style>';
            var pos_head1 = '<span style="text-align:center;"><h3>' + site.settings.site_name + '</h3><h4>';
            var pos_head2 =
                '</h4><p class="text-left">C: ' +
                $('#select2-chosen-1').text() +
                '<br>R: ' +
                $('#reference_note').val() +
                '<br>U: ' +
                username +
                '<br>T: ' +
                /*date(site.dateFormats.php_ldate, time)*/ +
                '</p></span>';
            $('#order_span').prepend(styles + pos_head1 + ' ' + lang.order + ' ' + pos_head2);
            $('#bill_span').prepend(styles + pos_head1 + ' ' + lang.bill + ' ' + pos_head2);
            $('#order-table').empty();
            $('#bill-table').empty();
        }
        positems = JSON.parse(localStorage.getItem('positems'));
        if (pos_settings.item_order == 1) {
            sortedItems = _.sortBy(positems, function (o) {
                return [parseInt(o.category), parseInt(o.order)];
            });
        } else if (site.settings.item_addition != 1) {
            sortedItems = _.sortBy(positems, function (o) {
                return [parseInt(o.order)];
            });
        } else {
            sortedItems = positems;
        }
        var category = 0,
            print_cate = false;
        // var itn = parseInt(Object.keys(sortedItems).length);
        $.each(sortedItems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            positems[item_id] = item;
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
            var item_comment = item.row.comment ? item.row.comment : '';
            var item_ordered = item.row.ordered ? item.row.ordered : 0;
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
                    item_discount = formatDecimal(parseFloat((unit_price * parseFloat(pds[0])) / 100), 4);
                } else {
                    item_discount = formatDecimal(ds);
                }
            } else {
                item_discount = formatDecimal(ds);
            }
            product_discount += formatDecimal(item_discount * item_qty);

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
                        pr_tax_val = formatDecimal(pr_tax.rate);
                        pr_tax_rate = pr_tax.rate;
                    }
                    product_tax += pr_tax_val * item_qty;
                }
            }
            pr_tax_val = formatDecimal(pr_tax_val);
            item_price = item_tax_method == 0 ? formatDecimal(unit_price - pr_tax_val, 4) : formatDecimal(unit_price);
            unit_price = formatDecimal(unit_price + item_discount, 4);

            if (pos_settings.item_order == 1 && category != item.row.category_id) {
                category = item.row.category_id;
                print_cate = true;
                var newTh = $('<tr></tr>');
                newTh.html('<td colspan="100%"><strong>' + item.row.category_name + '</strong></td>');
                newTh.appendTo('#posTable');
            } else {
                print_cate = false;
            }

            var row_no = item.id;
            var newTr = $(
                '<tr id="row_' +
                    row_no +
                    '" class="row_' +
                    item_id +
                    (item.free ? ' warning' : '') +
                    '" data-item-id="' +
                    item_id +
                    '"></tr>'
            );

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
                '"><input name="product_comment[]" type="hidden" class="rcomment" value="' +
                item_comment +
                '"><span class="sname" id="name_' +
                row_no +
                '">' +
                item_code +
                ' - ' +
                item_name +
                (sel_opt != '' ? ' (' + sel_opt + ')' : '') +
                '</span><span class="lb"></span>' +
                (item.free
                    ? ''
                    : '<i class="pull-right fa fa-edit fa-bx tip pointer edit" id="' +
                      row_no +
                      '" data-item="' +
                      item_id +
                      '" title="Edit" style="cursor:pointer;"></i>') +
                '<i class="pull-right fa fa-comment fa-bx' +
                (item_comment != '' ? '' : '-o') +
                ' tip pointer comment" id="' +
                row_no +
                '" data-item="' +
                item_id +
                '" title="Comment" style="cursor:pointer;margin-right:5px;"></i></td>';
            tr_html += '<td class="text-right">';
            if (site.settings.product_serial == 1) {
                tr_html +=
                    '<input class="form-control input-sm rserial" name="serial[]" type="hidden" id="serial_' +
                    row_no +
                    '" value="' +
                    item_serial +
                    '">';
            }
            if (site.settings.product_discount == 1) {
                tr_html +=
                    '<input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' +
                    row_no +
                    '" value="' +
                    item_ds +
                    '">';
            }
            if (site.settings.tax1 == 1) {
                tr_html +=
                    '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' +
                    row_no +
                    '" value="' +
                    pr_tax.id +
                    '"><input type="hidden" class="sproduct_tax" id="sproduct_tax_' +
                    row_no +
                    '" value="' +
                    formatMoney(pr_tax_val * item_qty) +
                    '">';
            }
            tr_html +=
                '<input class="rprice" name="net_price[]" type="hidden" id="price_' +
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
                formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) +
                '</span></td>';
            tr_html +=
                '<td>' +
                (item.free
                    ? '<div class="text-center">' +
                      item_qty +
                      '<input type="hidden" name="quantity[]" type="text"  value="' +
                      formatQuantity2(item_qty) +
                      '"></div>'
                    : '<input class="form-control input-sm kb-pad text-center rquantity" tabindex="' +
                      (site.settings.set_focus == 1 ? an : an + 1) +
                      '" name="quantity[]" type="text"  value="' +
                      formatQuantity2(item_qty) +
                      '" data-id="' +
                      row_no +
                      '" data-item="' +
                      item_id +
                      '" id="quantity_' +
                      row_no +
                      '" onClick="this.select();">') +
                '<input name="product_unit[]" type="hidden" class="runit" value="' +
                product_unit +
                '"><input name="product_base_quantity[]" type="hidden" class="rbase_quantity" value="' +
                base_quantity +
                '"></td>';
            tr_html +=
                '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' +
                row_no +
                '">' +
                formatMoney((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)) +
                '</span></td>';
            tr_html +=
                '<td class="text-center"><i class="fa fa-times tip pointer posdel" id="' +
                row_no +
                '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            if (pos_settings.item_order == 1) {
                newTr.appendTo('#posTable');
            } else {
                newTr.prependTo('#posTable');
            }
            total += formatDecimal((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty), 4);
            count += parseFloat(item_qty);
            console.log('total: ', count);
            an++;

            if (item_type == 'standard' && item.options !== false) {
                $.each(item.options, function () {
                    if (this.id == item_option && base_quantity > this.quantity) {
                        $('#row_' + row_no).addClass('danger');
                    }
                });
            } else if (item_type == 'standard' && base_quantity > item_aqty) {
                $('#row_' + row_no).addClass('danger');
            } else if (item_type == 'combo') {
                if (combo_items === false) {
                    $('#row_' + row_no).addClass('danger');
                } else {
                    $.each(combo_items, function () {
                        if (parseFloat(this.quantity) < parseFloat(this.qty) * base_quantity && this.type == 'standard') {
                            $('#row_' + row_no).addClass('danger');
                        }
                    });
                }
            }

            var comments = item_comment.split(/\r?\n/g);
            if (pos_settings.remote_printing != 1) {
                b_items += product_name('#' + (an - 1) + ' ' + item_code + ' - ' + item_name) + '\n';
                for (var i = 0, len = comments.length; i < len; i++) {
                    b_items += comments[i].length > 0 ? '   * ' + comments[i] + '\n' : '';
                }
                b_items +=
                    printLine(
                        '   ' +
                            formatDecimal(item_qty) +
                            ' x ' +
                            formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) +
                            ': ' +
                            formatMoney((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))
                    ) + '\n';
                // o_items += printLine(product_name("#"+(an-1)+" "+ item_code + " - " + item_name) + ": [ "+ (item_ordered != 0 ? 'xxxx' : formatDecimal(item_qty))) + " ]\n";
                o_items +=
                    printLine(
                        product_name('#' + (an - 1) + ' ' + item_code + ' - ' + item_name) + ': [ ' + formatDecimal(item_qty) + ' ]'
                    ) + '\n';
                for (var i = 0, len = comments.length; i < len; i++) {
                    o_items += comments[i].length > 0 ? '   * ' + comments[i] + '\n' : '';
                }
                o_items += '\n';
            } else {
                if (pos_settings.item_order == 1 && print_cate) {
                    var bprTh = $('<tr></tr>');
                    bprTh.html('<td colspan="100%" class="no-border"><strong>' + item.row.category_name + '</strong></td>');
                    var oprTh = $('<tr></tr>');
                    oprTh.html('<td colspan="100%" class="no-border"><strong>' + item.row.category_name + '</strong></td>');
                    $('#order-table').append(oprTh);
                    $('#bill-table').append(bprTh);
                }
                var bprTr =
                    '<tr class="row_' +
                    item_id +
                    '" data-item-id="' +
                    item_id +
                    '"><td colspan="2" class="no-border">#' +
                    (an - 1) +
                    ' ' +
                    item_code +
                    ' - ' +
                    item_name +
                    (sel_opt != '' ? ' (' + sel_opt + ')' : '') +
                    '';
                for (var i = 0, len = comments.length; i < len; i++) {
                    bprTr += comments[i] ? '<br> <b>*</b> <small>' + comments[i] + '</small>' : '';
                }
                bprTr += '</td></tr>';
                bprTr +=
                    '<tr class="row_' +
                    item_id +
                    '" data-item-id="' +
                    item_id +
                    '"><td>(' +
                    formatDecimal(item_qty) +
                    ' x ' +
                    (item_discount != 0
                        ? '<del>' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val) + item_discount) + '</del>'
                        : '') +
                    formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) +
                    ')</td><td style="text-align:right;">' +
                    formatMoney((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)) +
                    '</td></tr>';
                var oprTr =
                    '<tr class="row_' +
                    item_id +
                    '" data-item-id="' +
                    item_id +
                    '"><td>#' +
                    (an - 1) +
                    ' ' +
                    item_code +
                    ' - ' +
                    item_name +
                    (sel_opt != '' ? ' (' + sel_opt + ')' : '') +
                    '';
                for (var i = 0, len = comments.length; i < len; i++) {
                    oprTr += comments[i] ? '<br> <b>*</b> <small>' + comments[i] + '</small>' : '';
                }
                // oprTr += '</td><td>[ ' + (item_ordered != 0 ? 'xxxx' : formatDecimal(item_qty)) +' ]</td></tr>';
                oprTr += '</td><td>[ ' + formatDecimal(item_qty) + ' ]</td></tr>';
                $('#order-table').append(oprTr);
                $('#bill-table').append(bprTr);
            }
        });
        // Order level discount calculations
        if ((posdiscount = localStorage.getItem('posdiscount'))) {
            var ds = posdiscount;
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) {
                    order_discount = formatDecimal(parseFloat((total * parseFloat(pds[0])) / 100), 4);
                } else {
                    order_discount = parseFloat(ds);
                }
            } else {
                order_discount = parseFloat(ds);
            }
            //total_discount += parseFloat(order_discount);
        }

        // Order level tax calculations
        if (site.settings.tax2 != 0) {
            if ((postax2 = localStorage.getItem('postax2'))) {
                $.each(tax_rates, function () {
                    if (this.id == postax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = formatDecimal(((total - order_discount) * this.rate) / 100, 4);
                        }
                    }
                });
            }
        }

        total = formatDecimal(total);
        product_tax = formatDecimal(product_tax);
        total_discount = formatDecimal(order_discount + product_discount);

        // Totals calculations after item addition
        
        var gtotal = parseFloat(total + invoice_tax - order_discount + parseFloat(shipping));
        $('#total').text(formatMoney(total));
        $('#titems').text(an - 1 + ' (' + formatQty(parseFloat(count) - 1) + ')');
        $('#total_items').val(parseFloat(count) - 1);
        $('#tds').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
        if (site.settings.tax2 != 0) {
            $('#ttax2').text(formatMoney(invoice_tax));
        }
        $('#tship').text(parseFloat(shipping) > 0 ? formatMoney(shipping) : '');
        $('#gtotal').text(formatMoney(gtotal));
        if (pos_settings.remote_printing != 1) {
            order_data.items = o_items;
            bill_data.items = b_items;
            var b_totals = '';
            b_totals += printLine(lang.total + ': ' + formatMoney(total)) + '\n';
            if (order_discount > 0 || product_discount > 0) {
                b_totals += printLine(lang.discount + ': ' + formatMoney(order_discount + product_discount)) + '\n';
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                b_totals += printLine(lang.order_tax + ': ' + formatMoney(invoice_tax)) + '\n';
            }
            b_totals += printLine(lang.grand_total + ': ' + formatMoney(gtotal)) + '\n';
            if (pos_settings.rounding != 0) {
                round_total = roundNumber(gtotal, parseInt(pos_settings.rounding));
                var rounding = formatDecimal(round_total - gtotal);
                b_totals += printLine(lang.rounding + ': ' + formatMoney(rounding)) + '\n';
                b_totals += printLine(lang.total_payable + ': ' + formatMoney(round_total)) + '\n';
            }
            b_totals += '\n' + lang.items + ': ' + (an - 1) + ' (' + (parseFloat(count) - 1) + ')' + '\n';
            bill_data.totals = b_totals;
            bill_data.footer = '\n' + lang.merchant_copy + '\n';
        } else {
            var bill_totals = '';
            bill_totals += '<tr class="bold"><td>' + lang.total + '</td><td style="text-align:right;">' + formatMoney(total) + '</td></tr>';

            if (order_discount > 0 || product_discount > 0) {
                bill_totals +=
                    '<tr class="bold"><td>' +
                    lang.discount +
                    '</td><td style="text-align:right;">' +
                    formatMoney(order_discount + product_discount) +
                    '</td></tr>';
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                bill_totals +=
                    '<tr class="bold"><td>' +
                    lang.order_tax +
                    '</td><td style="text-align:right;">' +
                    formatMoney(invoice_tax) +
                    '</td></tr>';
            }
            bill_totals +=
                '<tr class="bold"><td>' + lang.grand_total + '</td><td style="text-align:right;">' + formatMoney(gtotal) + '</td></tr>';
            if (pos_settings.rounding != 0) {
                round_total = roundNumber(gtotal, parseInt(pos_settings.rounding));
                var rounding = formatDecimal(round_total - gtotal);
                bill_totals +=
                    '<tr class="bold"><td>' + lang.rounding + '</td><td style="text-align:right;">' + formatMoney(rounding) + '</td></tr>';
                bill_totals +=
                    '<tr class="bold"><td>' +
                    lang.total_payable +
                    '</td><td style="text-align:right;">' +
                    formatMoney(round_total) +
                    '</td></tr>';
            }
            bill_totals +=
                '<tr class="bold"><td>' +
                lang.items +
                '</td><td style="text-align:right;">' +
                (an - 1) +
                ' (' +
                (parseFloat(count) - 1) +
                ')</td></tr>';
            $('#bill-total-table').empty();
            $('#bill-total-table').append(bill_totals);
            $('#bill_footer').append('<p class="text-center"><br>' + lang.merchant_copy + '</p>');
        }
        if (count > 1) {
            $('#poscustomer').select2('readonly', true);
            $('#poswarehouse').select2('readonly', true);
        } else {
            $('#poscustomer').select2('readonly', false);
            $('#poswarehouse').select2('readonly', false);
        }
        if (KB) {
            // display_keyboards();
        }
        if (site.settings.set_focus == 1) {
            $('#add_item').attr('tabindex', an);
            $('[tabindex=' + (an - 1) + ']')
                .focus()
                .select();
        } else {
            $('#add_item').attr('tabindex', 1);
            $('#add_item').focus();
        }
    }
}

function display_keyboards() {
    $('.kb-text').keyboard({
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'focus',
        usePreview: false,
        layout: 'custom',
        //layout: 'qwerty',
        display: {
            bksp: '\u2190',
            accept: 'return',
            default: 'ABC',
            meta1: '123',
            meta2: '#+=',
        },
        customLayout: {
            default: [
                'q w e r t y u i o p {bksp}',
                'a s d f g h j k l {enter}',
                '{s} z x c v b n m , . {s}',
                '{meta1} {space} {cancel} {accept}',
            ],
            shift: [
                'Q W E R T Y U I O P {bksp}',
                'A S D F G H J K L {enter}',
                '{s} Z X C V B N M / ? {s}',
                '{meta1} {space} {meta1} {accept}',
            ],
            meta1: [
                '1 2 3 4 5 6 7 8 9 0 {bksp}',
                '- / : ; ( ) \u20ac & @ {enter}',
                '{meta2} . , ? ! \' " {meta2}',
                '{default} {space} {default} {accept}',
            ],
            meta2: [
                '[ ] { } # % ^ * + = {bksp}',
                '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                '{meta1} ~ . , ? ! \' " {meta1}',
                '{default} {space} {default} {accept}',
            ],
        },
    });
    $('.kb-pad').keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout: 'custom',
        display: {
            b: '\u2190:Backspace',
        },
        customLayout: {
            default: ['1 2 3 {b}', '4 5 6 . {clear}', '7 8 9 0 %', '{accept} {cancel}'],
        },
    });
    var cc_key = site.settings.decimals_sep == ',' ? ',' : '{clear}';
    $('.kb-pad1').keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout: 'custom',
        display: {
            b: '\u2190:Backspace',
        },
        customLayout: {
            default: ['1 2 3 {b}', '4 5 6 . ' + cc_key, '7 8 9 0 %', '{accept} {cancel}'],
        },
    });
}

</script>