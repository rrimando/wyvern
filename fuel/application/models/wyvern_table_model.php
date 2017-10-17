<?php

/**
 * Description of Wyvern_Table_Model - Table Generation To Be Exact
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Table_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        /* Shhh Quiet In The Library */
        $this->load->library('yaml');

        /* Strike A Pose */
        $this->load->model('wyvern_blocks_model');
    }

    function render($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array()) {
        // Go Through Block Model You Douche!
        $data['table_headers'] = $table_headers;
        $data['table_data'] = $table_data;
        $data['table_controls'] = $table_controls;
        $data['table_entity'] = $table_entity;
        $data['table_attributes'] = $table_attributes;

        return $this->wyvern_blocks_model->render_partial('table', $data, TRUE);
    }
    
    function render_simplified_table($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array()) {
        // Go Through Block Model You Douche!
        $data['table_headers'] = $table_headers;
        $data['table_data'] = $table_data;
        $data['table_controls'] = $table_controls;
        $data['table_entity'] = $table_entity;
        $data['table_attributes'] = $table_attributes;

        return $this->wyvern_blocks_model->render_partial('simplified_table', $data, TRUE);
    }

}
