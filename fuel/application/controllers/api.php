<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

require_once(WYVERN_PATH . 'controllers/wyvern_api.php');

class API extends Wyvern_api {

    public function __construct() {
        parent::__construct();
    }
    
    public function docs() {
        
    }
}
