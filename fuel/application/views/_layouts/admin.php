<?php $this->load->view('prepare_theme') ?>
<?php $this->load->view('_blocks/header') ?>
<?php if (is_admin_logged()): ?>
    <?php $this->load->view('_admin/_blocks/navigation') ?>
<?php endif; ?>

<!-- Page Content -->

<div class="container admin-page">
    <?php if (is_admin_logged()): ?>
        <div class="row wrapper">   
            <div class="col-lg-3 text-left">
                <?php echo $this->wyvern_blocks_model->generate_sidebar(); ?>
            </div>
            <div class="col-lg-9 text-left">
                <?php echo fuel_var('body', $this->wyvern_page_model->render_block('body')); ?>
            </div>
        </div>
        <!-- /.row -->
    <?php else: ?>
        <div class="row wrapper">   
            <div class="col-lg-12 text-left">
                <?php echo fuel_var('body', $this->wyvern_page_model->render_block('body')); ?>
            </div>
        </div>
        <!-- /.row -->
    <?php endif; ?>
</div>

<!-- /.container -->
<?php $this->wyvern_page_model->render_footer(); // This is done to allow rendering of scripts?>
