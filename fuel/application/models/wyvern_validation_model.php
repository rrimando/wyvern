<?php

/**
 * Description of Wyvern_User_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
require_once(FUEL_PATH . 'models/fuel_users_model.php');

class Wyvern_Validation_Model extends MY_Model { // Form Validation That Is

    function __construct() {
        parent::__construct();
    }

    function init() {
        
    }

    function _validate($data_array = array()) {
        $valid = true;
        $error = false;
        
        // TODO: DEV fetch Config and the validate per key
        
        foreach ($data_array as $key => $value) {
            if (!isset($value)) {
                $pretty_key = ucwords(str_replace("_", " ", $key));
                $valid = false;
                $error = "{$pretty_key} cannot be blank"; // TODO: LANG
                break;
            }
        }
        return array(
            'valid' => $valid,
            'error' => $error
        );
    }

}
