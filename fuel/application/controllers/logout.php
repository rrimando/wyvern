<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
    }

    public function index() {
        $this->wyvern_user_model->logout();
        redirect(site_url());
    }

}
