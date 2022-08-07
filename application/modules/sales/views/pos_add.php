
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
                        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form'];
                        echo form_open('sales/pos', $attrib);?> 
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
                        <div class="clearfix"></div>
                            <div id="botbuttons" class="col-xs-12 text-center" style="padding: 15px">
                            <div class="row">
                                
                                <div class="col-md-4" style="padding: 0;">
                                    <div class="btn-group-vertical btn-block">
                                        <button type="submit" class="btn btn-success btn-block" id="payment">
                                            <i class="fa fa-money" style="margin-right: 5px;"></i><?=lang('payment');?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding: 0;">
                                    <button type="button" class="btn btn-danger btn-block btn-flat"
                                    id="reset">
                                        <?= lang('cancel'); ?>
                                    </button>
                                </div>
                            </div>
                            </div>
                    </div>
                </div> <!-- .End class="col-md-5" -->
                <?php echo form_close(); ?>    
                
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
    
let count = 1;

$(document).ready(function(){

    // If there is any item in localStorage
    if (localStorage.getItem('positems')) {
        loadItems();
    }

    $('#category-list .category').click(function(){
        $('#ajaxproducts').show();
        $('#category-list').hide();
    });
    $('#show_cat').click(function(){
        $('#ajaxproducts').hide();
        $('#category-list').show();
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

    $(document).on('click', '.category', function(){
        const catId = $(this).val();
        
        $.ajax({
            url: site.base_url + 'sales/pos/ajax_category_data',
            type: 'POST',
            datatype: 'json',
            data: {catId: catId},
            success: function(data){
                // console.log(data);
                $('#item-list').empty();
                let newPrs = $('<div></div>');
                newPrs.html(data.products);
                newPrs.appendTo('#item-list');
           }

        }).done(function(){

        });
    });
    $(document).on('click', '.posdel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');

        delete positems[item_id];
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
        
        return false;
    });

}); // End ready function

/* --------------------------
 * Add Invoice Items
 * @param {json} item
 * @returns {Boolean}
 --------------------------- */
function add_invoice_item(item) {
    // console.log(item);
    
    /* if count is 1 then initialize empty positems */
    if (count == 1) {
        positems = {};
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2('readonly', true);
            $('#poswarehouse').select2('readonly', true);
        } else {
            item = null;
            return;
        }
    }
    if (item == null) return;
    var settingsItemAddition = 1;
    var item_id = settingsItemAddition == 1 ? item.item_id : (Math.random()*10000);
    console.log(positems);
    /** 
      * if item is already in positems list
      */
    if (positems[item_id]) {
        
        var new_qty = parseFloat(positems[item_id].row.qty) + 1;
        positems[item_id].row.qty = new_qty;
    } else {
        positems[item_id] = item;
    }
    
    localStorage.setItem('positems', JSON.stringify(positems));
    loadItems();
    return true;
}


function loadItems() {

    if (localStorage.getItem('positems')) {
        total = 0;
        count = 1;
        an = 1;

        $('#posTable tbody').empty();
        positems = JSON.parse(localStorage.getItem('positems'));
        sortedItems = positems; // sort items as per requirement
        console.log(sortedItems);

        $.each(sortedItems, function () {
            var item = this;
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

            var settingsItemAddition = 1;
            var item_id = settingsItemAddition == 1 ? item.item_id : (Math.random()*10000);
            positems[item_id] = item;
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
            /* td product item input */
            tr_html =
                    '<td><input name="product_id[]" type="hidden" class="rid" value="' +
                    product_id +
                    '"><input name="product_code[]" type="hidden" class="rcode" value="' +
                    item_code +
                    '">'+
                    '"<span class="sname" id="name_' +
                    row_no +
                    '">' +
                    item_code +
                    ' - ' +
                    item_name +
                    '</span>' +
                    '</td>';
                /* td product price input */
                tr_html +=
                    '<td><input class="rprice" name="net_price[]" type="hidden" id="price_' +
                    row_no +
                    '" value="' +
                    item_price +
                    '">' +
                    '<input class="realuprice" name="real_unit_price[]" type="hidden" value="' +
                    item.row.real_unit_price +
                    '"><span class="text-right sprice" id="sprice_' +
                    row_no +
                    '">' +
                    formatMoney(parseFloat(item_price)) +
                    '</span></td>';
                tr_html +=
                    '<td>' +
                    '<input class="form-control input-sm kb-pad text-center rquantity" ' +
                    ' name="quantity[]" type="text"  value="' +
                    formatQuantity2(item_qty) +
                    '" data-id="' +
                    row_no +
                    '" data-item="' +
                    item_id +
                    '" id="quantity_' +
                    row_no +
                    '" onClick="this.select();">' +
                    '</td>';
                tr_html +=
                    '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' +
                    row_no +
                    '">' +
                    formatMoney((parseFloat(item_price)) * parseFloat(item_qty)) +
                    '</span></td>';
                tr_html +=
                    '<td class="text-center"><i class="fa fa-times tip pointer posdel" id="' +
                    row_no +
                    '" title="Remove" style="cursor:pointer;"></i></td>';
                
                newTr.html(tr_html);
                newTr.appendTo('#posTable');

                count += parseFloat(item_qty);
                an++;
                total += formatDecimal((parseFloat(item_price)) * parseFloat(item_qty), 4);
                var gtotal = parseFloat(total);
                $('#total').text(formatMoney(total));
                $('#titems').text(an - 1 + ' (' + formatQty(parseFloat(count) - 1) + ')');
                $('#total_items').val(parseFloat(count) - 1);
                $('#gtotal').text(formatMoney(gtotal));
        });

    }

}

</script>