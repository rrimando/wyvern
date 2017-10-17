<?php $CI = & get_instance(); ?>
<?php $CI->load->model('wyvern_blocks_model'); ?>
<?php $sidebar = $CI->wyvern_blocks_model->generate_sidebar(array(), '_partials/blog/admin/sidebar'); ?>
<?php echo $sidebar; ?>

<!--Page Content -->
<div id = "page-wrapper">
    <div class = "container-fluid">
        <div class = "row">
            <div class = "col-lg-12">
                <h1 class = "page-header">Content Goes Here</h1>
                <?php session_dump();
                ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
