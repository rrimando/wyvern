<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_page_model');

        $this->page = 'login';
    }

    public function index() {
        // Check Authentication
        if (is_admin_logged()) {
            redirect(site_url('admin'));
        }

        if (is_logged()) {
            redirect(site_url('user'));
        }

        $this->wyvern_page_model->render('login');
    }

    public function form() {
        // Check Authentication
        $this->wyvern_page_model->render('login_form');
    }

}
