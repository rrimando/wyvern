<?php 
/*
 *  Utilize to test new elements 
 * 
 */
?>

<?php $this->load->view('prepare_theme') ?>
<?php $this->load->view('_blocks/header') ?>
<?php $this->load->view('_blocks/navigation') ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-12 text-center">
            <?php echo $this->wyvern_page_model->render_partial('temp/ladda_test'); ?>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
<?php $this->wyvern_page_model->render_footer(); // This is done to allow rendering of scripts?>

