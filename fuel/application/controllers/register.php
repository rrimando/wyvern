<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
      
        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_page_model');

        $this->page = 'register';
    }

    public function index() {
          
        if(is_logged()){
            redirect(site_url('user'));
        }
        
        // Check Authentication
        $this->wyvern_page_model->render('register');
    }
    
    function next($step = 'next') { // Next Steps
        // Check Sign Up Markers To Determine Fields Needed
        $this->wyvern_page_model->render("registration/{$step}");
    }
    
    function last() { // Next Steps
        // Check Sign Up Markers To Determine Fields Needed
        $this->wyvern_page_model->render('registration/last');
    }
    
    function verification() {
        $this->wyvern_page_model->render('registration/verification');
    }
    
    function terms() {
        
    }
    
    function complete() {
        redirect(site_url());
    }

}
