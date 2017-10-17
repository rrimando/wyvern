<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
        $this->load->model('wyvern_page_model');
    }

    function _remap($page) {
        $this->v1($page);
    }

    public function v1($page = 'home') {
        if (is_logged() && $page == 'register') {
            redirect(site_url('user'));
        }
        /* Some Sites Might Not Want To Be Cached */
        // $this->output->cache(60);
        // Check if page slug exists
        $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/pages/' . $page . '.yml';
        if (is_file($file_path)) {
            $this->wyvern_page_model->render($page);
        } else {
            if (defined('WYVERN_SITE_TYPE')) {
                $page_slug = fetch_page_content($page, 'page_slug');
                if ($page_slug) {
                    $this->wyvern_page_model->render_blog_page($page);
                } else {
                    $this->wyvern_page_model->render($page);
                }
            } else {
                $this->wyvern_page_model->render($page);
            }
        }
    }
    
}
    