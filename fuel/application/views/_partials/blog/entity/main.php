<?php $this->load->view('_blocks/header') ?>
<?php $this->load->view('_partials/blog/admin/header') ?>

<?php $CI = & get_instance(); ?>
<?php $CI->load->model('wyvern_blocks_model'); ?>
<?php $sidebar = $CI->wyvern_blocks_model->generate_sidebar(array(), '_partials/blog/admin/sidebar'); ?>
<?php echo $sidebar; ?>

<!--Page Content -->
<div id = "page-wrapper">
    <div class = "container-fluid">
        <div class = "row">
            <div class = "col-lg-12">
                <h1 class = "page-header"><?php echo ucwords(str_replace("_", " ", $this->entity)); ?> </h1>
                <?php if (isset($form)): ?>
                    <?php echo $form; ?>
                <?php else: ?>
                    <?php echo $content; ?>
                <?php endif; ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php $this->load->view('_partials/blog/admin/footer') ?>

<?php $this->wyvern_blocks_model->render_footer($this->{$this->entity}); // This is done to allow rendering of scripts?>
