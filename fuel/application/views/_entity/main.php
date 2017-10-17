<?php $this->load->view('prepare_theme') ?>
<?php $this->load->view('_blocks/header') ?>
<?php $this->load->view('_admin/_blocks/navigation') ?>

<!-- Page Content -->
<div class="container entity-page">
    <div class="row wrapper">
        <div class="col-lg-2 pull-left">
            <?php echo $sidebar; ?>
        </div>
        <div class="col-lg-10 pull-right">
            <div class="bs-example" data-example-id="disabled-fieldset">
                <?php if (isset($form)): ?>
                    <?php echo $form; ?>
                <?php else: ?>
                    <?php echo $content; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
<?php $this->wyvern_blocks_model->render_footer($this->{$this->entity}); // This is done to allow rendering of scripts?>
