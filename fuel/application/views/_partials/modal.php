<!-- Modal -->
<div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $content; ?>
            </div>
            <div class="modal-footer">
                <?php if (isset($close_label) && $close_label): ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $close_label; ?></button>
                <?php endif; ?>
                <?php if (isset($save_label) && $save_label): ?>
                    <button type="button" class="btn btn-primary"><?php echo $save_label; ?></button>
                <?php endif; ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
