<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Wyvern_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Test Success";
    }

}
