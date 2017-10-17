<?php

/**
 * Description of Wyvern_User_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
require_once(FUEL_PATH . 'models/fuel_users_model.php');

class Wyvern_TestData_Model {

    function __construct() {
        parent::__construct();

        /* Ssshhh Quiet In The Library */
        $this->load->library('fuel_auth');

        /* Strike A Pose */
        $this->init();
    }

    function init() {
        $this->config->load('wyvern_config');
    }

}
