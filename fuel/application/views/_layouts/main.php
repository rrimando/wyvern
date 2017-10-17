<?php $this->load->view('prepare_theme') ?>
<?php $this->load->view('_blocks/header') ?>

<?php if (isset($this->wyvern_page_model->page_structure['page']['header']['partials'])): ?>

    <?php echo $this->wyvern_page_model->render_block('header'); ?>

<?php else: ?>

    <?php $this->load->view('_blocks/navigation') ?>

<?php endif; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-12 text-center">
            <?php echo fuel_var('body', $this->wyvern_page_model->render_block('body')); ?>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
<?php $this->wyvern_page_model->render_footer(); // This is done to allow rendering of scripts?>

