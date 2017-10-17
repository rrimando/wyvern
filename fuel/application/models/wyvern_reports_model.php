<?php

/**
 * Description of Wyvern_Page_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Reports_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        /* Shhh Quiet In The Library */
        $this->load->library('yaml');
        $this->load->library('wyvern/wyvern_form_generator', 'wyvern_form_generator');

        /* Strike A Pose */
        $this->load->model('wyvern_data_block');
    }

    function init($page = '', $admin = false, $is_view = false, $entity_items = array()) {

        
    }

    function render($page = '', $is_view = false, $entity_items = array()) {

        $admin = false;

        $this->init($page, $admin, $is_view, $entity_items);

        $this->viewData = $this->fetch_page_data($this->page_structure['data']);

        /* Setting Layout */
        if (defined('WYVERN_THEME')) {
            $this->load->view($this->page_structure['page']['layout'], $this->viewData);
        } else {
            $this->load->view('_layouts/' . $this->page_structure['page']['layout'], $this->viewData);
        }
    }
}
