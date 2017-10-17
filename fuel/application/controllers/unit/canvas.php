<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Canvas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug');

        /* Strike A Pose */
        // $this->load->model('wyvern_entity_model', 'doctor')->init('doctor');
    }

    public function index() {
        dandy();
    }

    public function create_entity() {
        $test_data = array(
            'name' => 'Rohan Rimando',
            'date_of_birth' => 'July 29, 1983',
            'listed_address' => 'Test Address 1',
            'clinic_address' => 'Test Address 2'
                //'specialty' => 'Jumping Jacks'
        );
        if ($this->doctor->create($test_data)) {
            dandy();
        } else {
            randy();
        }
    }

    public function block_test() {
        error_reporting(0);

        $this->load->model('wyvern_page_model');
        $this->load->view('_layouts/block_test');
    }

    public function fetch_entity() {     
       nice_dump($this->doctor->fetch(array('name' => 'Rohan Rimando')));
    }

    public function delete_entity() {
        nice_dump($this->doctor->delete(array('listed_address' => 'Test Address 1')));
    }

    public function facebook_api_test() {
        //https://api.facebook.com/method/fql.query?format=json&query=SELECT%20share_count,%20like_count%20FROM%20link_stat%20WHERE%20url='http:%5Cwww.lrinka.ltindex.php?act=main'
        
        $url = urlencode(rawurlencode('https://caltexfuelyourschoolph.com/page/single_project/20'));
        
        $redirect_url = "https://api.facebook.com/method/fql.query?format=json&query=SELECT%20share_count,%20like_count%20FROM%20link_stat%20WHERE%20url='{$url}'";
        
        redirect($redirect_url);
    }

}
