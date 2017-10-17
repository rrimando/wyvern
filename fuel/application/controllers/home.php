<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
        $this->load->model('wyvern_user_model');
        $this->load->model('wyvern_page_model');

        $this->page = 'home';
    }

    function _remap($method) {
        $param_offset = 2;

        // Default to index
        if (!method_exists($this, $method)) {
            // We need one more param
            $param_offset = 1;
            $method = 'index';
        }

        // Since all we get is $method, load up everything else in the URI
        $params = array_slice($this->uri->rsegment_array(), $param_offset);

        // Call the determined method with all params
        call_user_func_array(array($this, $method), $params);
    }

    public function index($page = 'home') {
        $this->wyvern_page_model->render($page);
    }

}
