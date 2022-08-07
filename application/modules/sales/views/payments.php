<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            
            <h4 class="modal-title" id="myModalLabel"><?= lang('view_payments') . ' (' . lang('sale') . ' ' . lang('reference') . ': ' . $inv->reference_no . ')'; ?></h4>
            
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="CompTable" cellpadding="0" cellspacing="0" 
                       class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="width:30%;"><?= lang('date'); ?></th>
                        <th style="width:30%;"><?= lang('reference_no'); ?></th>
                        <th style="width:15%;"><?= lang('amount'); ?></th>
                        <th style="width:15%;"><?= lang('paid_by'); ?></th>
                        <th style="width:10%;"><?= lang('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($payments)) {
                    foreach ($payments as $payment) {
                        ?>
                            <tr class="row<?= $payment->id ?>">
                                <td><?= ($payment->date); ?></td>
                                <td><?= $payment->reference_no; ?></td>
                                <td><?= $this->sls->formatMoney($payment->amount) . ' ' . (($payment->attachment) ? '<a href="' . admin_url('welcome/download/' . $payment->attachment) . '"><i class="fa fa-chain"></i></a>' : ''); ?></td>
                                <td><?= lang($payment->paid_by); ?></td>
                                <td>
                                    <div class="text-center">
                                        <?php if ($payment->paid_by != 'gift_card') {
                                        ?>
                                               
                                               <?php 
                                               $payment_link = '<a href="#" class="edit_payment" data-id="'. $payment->id . '"> <i class="fa fa-edit"> </i> </a>';

                                               echo $payment_link;

                                               $delete_link = ' ' . anchor("sales/pos/delete_payment/".$payment->id,
                                                '<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                                array('class'=>'', 'title'=>'Delete', 'onclick' => "return confirm('Do you want delete this record')"));
                                                echo $delete_link;
                                                ?>   
                                        <?php
                                    } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
    }
} else {
    echo "<tr><td colspan='5'>" . lang('no_data_available') . '</td></tr>';
} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="UTF-8">

    $(document).on('click', '.edit_payment', function(){
		const id = $(this).data('id');
		$.ajax({
			url: site.base_url + 'sales/pos/edit_payment/' + id + '/<?= $inv->id ?>',
			dataType: 'html',
			success: function(response) {
				$('#myModal').html(response);
				$('#myModal').modal('show');
			}
		});

	});

    $(document).ready(function () {
        $(document).on('click', '.po-delete', function () {
            var id = $(this).attr('id');
            $(this).closest('tr').remove();
        });
        $(document).on('click', '.email_payment', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $.get(link, function(data) {
                bootbox.alert(data.msg);
            });
            return false;
        });
    });
</script>
