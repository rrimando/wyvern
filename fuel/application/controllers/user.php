<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!is_logged() && !is_admin_logged()) {
            redirect('login');
        }

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
        $this->load->model('wyvern_page_model');

        $this->page = 'User';
    }

    function _remap($method, $params) {

        // Default to index
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            // Have to fix this to be able to do more actions
            $this->wyvern_page_model->render('user/' . $method);
        }
    }

    public function index() {
        // Check Authentication
        $this->wyvern_page_model->render('user/home');
    }

    public function home() {
        $this->wyvern_page_model->render('user/home');
    }

    public function profile() {
        $this->page = 'Profile';
        $this->wyvern_page_model->render('user/profile');
    }

    public function forgot_password() {
        $this->page = 'Forgot Password';
        $this->wyvern_page_model->render('forgot_password');
    }

}
