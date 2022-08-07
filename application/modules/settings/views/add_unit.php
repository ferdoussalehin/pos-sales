<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
			<h4 class="modal-title" id="aModalLabel">Sales Detail</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                    <i class="fa fa-2x">&times;</i></span><span class="sr-only">Close</span>
                </button>
                
            </div>
            <div class="modal-body" id="pr_popover_content">
            <?php echo form_open_multipart("settings/saveUnit", array("id"=>"add_unit")) ?>
                    
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="form-group ">
                                <label> <?= lang('code') ?> *</label>
                                <input name="code" class="form-control" type="text" placeholder="<?php echo lang('code') ?>" required="required"/>
                            </div> 
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group ">
                                <label> <?= lang('name') ?> *</label>
                                <input name="name" class="form-control" type="text" placeholder="<?php echo lang('name') ?>" required="required"/>
                            </div> 
                        </div>
                    </div>
     
                     <div class="form-group">
                         <button type="submit"  class="btn btn-success w-md m-b-5"><?php echo lang('add') ?></button>
                        
                      <?php echo form_close() ?>
     
                 </div>
            </div>
        </div>
</div>


<script>
$("#add_unit").validate();
</script>

 