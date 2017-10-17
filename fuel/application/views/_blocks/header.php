<?php
/* Fix for using the back button after loggin out */
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$CI = & get_instance();
if (!$CI->load->is_model_loaded('wyvern_page_model')) {
    $CI->load->model('wyvern_page_model');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>       
        <?php if (defined('WYVERN_SITE_TYPE') && WYVERN_SITE_TYPE == 'blog'): ?>

            <?php
            $site_theme = fetch_site_variable('site_settings_theme', 'site_settings');
            $_site_theme = ($site_theme) ? str_replace(" ", "_", strtolower($site_theme)) : false;
            ?>

            <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/<?php echo $_site_theme; ?>/images/favicon.png" />

        <?php else: ?>

            <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/favicon.png" />

        <?php endif; ?>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php if (defined('WYVERN_INITIAL_WIDTH')): ?>

            <meta name="viewport" content="width=<?php echo WYVERN_INITIAL_WIDTH; ?>, initial-scale=1, maximum-scale=1">
        <?php else: ?>

            <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php endif; ?>

        <title><?php
            if (!empty($is_blog)) :
                echo $CI->fuel_blog->page_title($page_title, ' : ', 'right');
            else:
                echo isset($page_title) ? $page_title : WYVERN_SITE_NAME;
            endif;
            ?></title>
        <?php if (defined('WYVERN_FACEBOOK_API') && WYVERN_FACEBOOK_API == true): ?>

            <!-- FACEBOOK -->
            <?php
            // TODO Fix Meta OG For Other Sites
            $CI->wyvern_page_model->__partial('meta_og');
            ?>
        <?php endif; ?>

        <?php if (defined('WYVERN_META_AUTHOR')): ?>
            <meta name="author" content="<?php echo WYVERN_META_AUTHOR; ?>">
            <meta name="keywords" content="<?php echo WYVERN_META_KEYWORDS ?>">
            <meta name="description" content="<?php echo WYVERN_META_DESCRIPTION ?>">
        <?php endif; ?>

        <?php
        if (!empty($is_blog)):
            echo $CI->fuel_blog->header();
        endif;
        ?>

        <!-- Google Font -->
        <?php if (defined('WYVERN_GOOGLE_FONT')): ?>

            <link href='//fonts.googleapis.com/css?family=<?php echo WYVERN_GOOGLE_FONT; ?>' rel='stylesheet' type='text/css'>
        <?php endif; ?>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <?php /* LOCALIZE THIS FILE */ ?>
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <!-- Bootstrap Ladda CSS -->
        <link href="<?php echo base_url(); ?>assets/ladda/css/ladda-themeless.min.css" rel="stylesheet">

        <?php if (defined('WYVERN_UPLOADIFIVE')): ?>
            <!-- Uploadifive CSS -->
            <link href="<?php echo base_url(); ?>assets/uploadifive/uploadifive.css" rel="stylesheet">
        <?php else: ?>
            <!-- Uploadify CSS -->
            <link href="<?php echo base_url(); ?>assets/uploadify/uploadify.css" rel="stylesheet">
        <?php endif; ?>

        <!-- Gallery CSS -->
        <link href="<?php echo base_url(); ?>assets/lightGallery/lightGallery.css" rel="stylesheet">

        <!-- Lightbox CSS -->
        <link href="<?php echo base_url(); ?>assets/lightbox/ekko-lightbox.css" rel="stylesheet">

        <!-- Scrollbar Fix CSS -->
        <link href="<?php echo base_url(); ?>assets/scroll/jquery.custom-scrollbar.css" rel="stylesheet">

        <?php if (defined('WYVERN_REMOVE_WYVERN_CSS') && WYVERN_REMOVE_WYVERN_CSS != true): ?>      

            <!-- Custom CSS -->
            <!-- Wyvern Specific CSS -->
            <link href="<?php echo base_url(); ?>assets/css/wyvern.css" rel="stylesheet">
        <?php endif; ?>

        <!-- <?php echo WYVERN_SITE_NAME; ?> Specific CSS -->
        <?php $client_css = explode(',', WYVERN_FRONTEND_CSS); ?>
        <?php foreach ($client_css as $css): ?>

            <link href="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/css/<?php echo $css; ?>" rel="stylesheet">

        <?php endforeach; ?>

        <?php /* Detect Admin Page */ ?>
        <?php if (defined('WYVERN_SITE_TYPE') && WYVERN_SITE_TYPE == 'blog'): ?>

            <!-- MetisMenu CSS -->
            <link href="<?php echo base_url(); ?>assets/sb-admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

            <!-- Timeline CSS -->
            <link href="<?php echo base_url(); ?>assets/sb-admin/dist/css/timeline.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="<?php echo base_url(); ?>assets/sb-admin/dist/css/sb-admin-2.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            <link href="<?php echo base_url(); ?>assets/sb-admin/bower_components/morrisjs/morris.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="<?php echo base_url(); ?>assets/sb-admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

            <!-- Media Element -->
            <?php if (defined('WYVERN_VIDEOS') && (WYVERN_VIDEOS)): ?>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mediaelement/src/css/mediaelementplayer.css" />
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mediaelement/src/css/mejs-skins.css" />
            <?php endif; ?>

            <?php if ($_site_theme): ?>
                <?php if (isset($CI->wyvern_page_model->page_structure) && !$CI->wyvern_page_model->page_structure['is_admin']): ?>

                    <!-- Custom Theme CSS -->
                    <link href="<?php echo base_url(); ?>assets/<?php echo $_site_theme . "/css/" . $_site_theme; ?>.css" rel="stylesheet" type="text/css">
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>

        <?php if (defined('WYVERN_REMOVE_HEADER_FIX') && WYVERN_REMOVE_HEADER_FIX == true): ?>      
            <!-- header fix removed -->
        <?php else: ?>      
            <style>
                body {
                    padding-top: 70px;
                    /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
                }
            </style>
        <?php endif; ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery Version 1.11.1 -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <?php /* <!--script src="https://code.jquery.com/jquery-2.1.3.min.js"></script--> */ ?>

        <script type="text/javascript">

            var base_url = '<?php echo base_url(); ?>';

<?php if (WYVERN_CSRF): ?>

                var <?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';

<?php else: ?>

                var csrf_token = 'csrf_token';

<?php endif; ?>

        </script>

    </head>

    <body<?php echo isset($body_id) ? " id='{$body_id}'" : '' ?>>

        <?php if (!($this->wyvern_page_model->page_structure['is_admin'])): ?>
            <!-- FACEBOOK -->
            <?php if (defined('WYVERN_FACEBOOK_API') && WYVERN_FACEBOOK_API == true): ?>
                <div id="fb-root"></div>
                <script>
                    window.fbAsyncInit = function () {
                        FB.init({
                            appId: '<?php echo WYVERN_FACEBOOK_APP_ID; ?>',
                            xfbml: true,
                            version: 'v2.3'
                        });

                        // Place following code after FB.init call.
                        FB.Canvas.setAutoGrow();

                        function onLogin(response) {
                            if (response.status == 'connected') {
                                FB.api('/me?fields=first_name', function (data) {
                                    var welcomeBlock = document.getElementById('fb-welcome');
                                    welcomeBlock.innerHTML = 'Hello, ' + data.first_name + '!';
                                });
                            }
                        }

                        FB.getLoginStatus(function (response) {
                            // Check login status on load, and if the user is
                            // already logged in, go directly to the welcome message.
                            if (response.status == 'connected') {
                                onLogin(response);
                            } else {
                                // Otherwise, show Login dialog first.
                                FB.login(function (response) {
                                    onLogin(response);
                                }, {scope: 'user_friends, email'});
                            }
                        });
                    };

                    (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_US/sdk.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                </script>
                <div id="fb-root"></div>
                <h1 id="fb-welcome" class="hidden"></h1>

            <?php endif; ?>

        <?php endif; ?>
