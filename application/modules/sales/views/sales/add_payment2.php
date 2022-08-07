<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
			<h4 class="modal-title" id="aModalLabel">Add Payment </h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                    <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span>
                </button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
                <?php //echo '<pre>'; print_r($inv); ?>
                <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo form_open_multipart('sale/savePayment/' . $inv->id, $attrib); ?>
                <div class="row"> 
                <?php if ($Admin) {
                ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="date"> <?= lang('date') ?> * </label>
                            <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ''), 'class="form-control datetime" id="date" required="required"'); ?>
                        </div>
                    </div>
                <?php
                } ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="reference_no"> <?= lang('reference_no') ?> * </label>
                        <?= form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $payment_ref), 'class="form-control tip" id="reference_no"'); ?>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $inv->id; ?>" name="sale_id"/>
                </div>

            <div class="payment-well" style="background-color: #ddd; padding: 8px">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="payment">
                            <div class="form-group">
                            <label for="amount"> <?= lang('amount') ?> * </label>
                                <input name="amount-paid" type="text" id="amount_1"
                                        value="<?= $this->sls->formatDecimal($inv->grand_total - $inv->paid); ?>"
                                        class="pa form-control kb-pad amount" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="paying_by"> <?= lang('paying_by') ?> * </label>
                            <select name="paid_by" id="paid_by_1" class="form-control paid_by" required="required">
                                <?= $this->sls->paid_opts(); ?>
                            </select>
                        </div>
                    </div>

                </div> 
                <div class="row"> 
                    <div class="col-sm-6">
                        <div class="pcheque_1" style="display:none;">
                            <div class="form-group"><?= lang('cheque_no'); ?>
                                <input name="cheque_no" type="text" id="cheque_no_1" class="form-control cheque_no"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="attachment"> <?= lang('attachment') ?> </label>
                <input id="attachment" type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>

            <div class="form-group">
                <label for="note"> <?= lang('note') ?> </label>
                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control" id="note"'); ?>
            </div>

            <div class="modal-footer">
                <?php echo form_submit('add_payment', lang('add_payment'), 'class="btn btn-primary"'); ?>
            </div>
                
            </div>

        </div>
</div>

<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {

        $(document).on('change', '.paid_by', function () {
            var p_val = $(this).val();
            $('#rpaidby').val(p_val);
            if (p_val == 'cash') {
                $('.pcheque_1').hide();
                $('.pcash_1').show();
                $('#amount_1').focus();
            } else if (p_val == 'Cheque') {
                $('.pcheque_1').show();
                $('#cheque_no_1').focus();
            } else {
                $('.pcheque_1').hide();
                $('.pcash_1').hide();
            }
        });

        
    });

</script>