<?php
$CI = & get_instance();
$CI->load->model('wyvern_page_model');
?>

<?php if (isset($partials)): ?>
    <footer> 
        <?php foreach ($partials as $partial => $attributes): ?>

            <?php $this->wyvern_page_model->__partial($partial, $attributes); ?>
        <?php endforeach; ?>

    </footer>
<?php endif; ?>

<!-- Jquery Validation -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

<!-- Light Gallery -->
<script src="<?php echo base_url(); ?>assets/lightGallery/lightGallery.js"></script>

<!-- Light Box -->
<script src="<?php echo base_url(); ?>assets/lightbox/ekko-lightbox.js"></script>


<?php if (defined('WYVERN_UPLOADIFIVE')): ?>
    <!-- Uploadifive Javascipt -->
    <script src="<?php echo base_url(); ?>assets/uploadifive/jquery.uploadifive.js"></script>
<?php else: ?>
    <!-- Uploadify -->
    <script src="<?php echo base_url(); ?>assets/js/swfobject.js"></script>
    <script src="<?php echo base_url(); ?>assets/uploadify/jquery.uploadify.js"></script>
<?php endif; ?>


<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/src/js/bootstrap-datetimepicker.js"></script>

<!-- Scroll Javascript -->
<script src="<?php echo base_url(); ?>assets/scroll/jquery.custom-scrollbar.js"></script>

<!-- Wyvern Javascript -->
<script src="<?php echo base_url(); ?>assets/js/wyvern.js"></script>

<!-- Bootstrap Ladda -->
<script src="<?php echo base_url(); ?>assets/ladda/js/spin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/ladda/js/ladda.min.js"></script>

<?php /* Detect Admin Page */ ?>
<?php if (defined('WYVERN_SITE_TYPE') && WYVERN_SITE_TYPE == 'blog'): ?>
    <?php
    // Blog
    $site_theme = fetch_site_variable('site_settings_theme', 'site_settings');
    $_site_theme = ($site_theme) ? str_replace(" ", "_", strtolower($site_theme)) : false;
    ?>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/sb-admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assets/sb-admin/dist/js/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>assets/sb-admin/bower_components/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/sb-admin/bower_components/morrisjs/morris.min.js"></script>

    <!-- Media Element JavaScript -->
    <?php if (defined('WYVERN_VIDEOS') && (WYVERN_VIDEOS)): ?>

        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-namespace.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-utility.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-i18n.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-plugindetector.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-featuredetection.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-mediaelements.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/me-shim.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-library.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-player.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-playpause.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-progress.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-time.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-speed.js" type="text/javascript"></script>	
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-tracks.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-volume.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-stop.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/mediaelement/src/js/mep-feature-fullscreen.js" type="text/javascript"></script>

    <?php endif; ?>

    <?php if ($_site_theme): ?>
        <?php if (isset($CI->wyvern_page_model->page_structure) && !$CI->wyvern_page_model->page_structure['is_admin']): ?>

            <!-- Custom Theme JS -->
            <script src="<?php echo base_url(); ?>assets/<?php echo $_site_theme . "/js/" . $_site_theme; ?>.js"></script>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>

<?php if (!empty($page_scripts)): ?>

    <script type="text/javascript">
    <?php foreach ($page_scripts as $script): ?>

        <?php echo $script; ?>
    <?php endforeach; ?>

    </script>
<?php endif; ?>

<?php if (defined('WYVERN_FRONTEND_JS')): ?>

                <!-- <?php echo WYVERN_SITE_NAME; ?> Specific JS -->

    <?php $client_js = explode(',', WYVERN_FRONTEND_JS); ?>
    <?php foreach ($client_js as $js): ?>

        <script src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/js/<?php echo $js; ?>" ></script>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (defined('WYVERN_SESSION_CHECK') && (WYVERN_SESSION_CHECK) && (is_logged() || is_admin_logged())): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            //Increment the idle time counter every minute.
            setInterval(timer_increment, 60000); // 1 minute 
        });
    </script>
<?php endif; ?>

</body>
</html>
