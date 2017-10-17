<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->init();
    }

    public function init($entity = '') {
        /* Strike A Pose */
        $this->load->model('wyvern_blocks_model');
    }

    function index() {
        redirect(site_url());
    }

    function view($report_page = '') {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }
        
        // Use the yaml file to lazy load other data
        
        $this->viewData['sidebar'] = $this->wyvern_blocks_model->generate_sidebar();
        $this->viewData['custom_report_code'] = $report_page;
        $this->load->view('_reports/main', $this->viewData);
    }

}
