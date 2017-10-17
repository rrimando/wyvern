<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
        $this->load->model('wyvern_user_model');
        $this->load->model('wyvern_page_model');
    }

    function _remap($method, $params) {

        // Default to index
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            $this->page($method, $params);
        }
    }

    public function index($page = 'admin/home') {
        if (is_admin_logged()) {
            $this->wyvern_page_model->render($page);
        } else {
            if (is_logged()) {
                redirect(site_url('user/home'));
            } else {
                redirect(site_url('login'));
            }
        }
    }

    public function dashboard() {
        if (is_admin_logged()) {
            redirect(site_url('admin'));
        } else {
            if (is_logged()) {
                redirect(site_url('user/home'));
            } else {
                redirect(site_url('login'));
            }
        }
    }

    public function page($page = 'home') {
        $this->wyvern_page_model->render('admin/' . $page);
    }

}
