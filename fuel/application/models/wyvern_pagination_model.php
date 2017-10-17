<?php

/**
 * Description of Wyvern_Table_Model - Table Generation To Be Exact
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Pagination_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        /* Shhh Quiet In The Library */
        $this->load->library('yaml');
    }

    function init($entity = 'entity') {
        $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/entities/' . $entity . '.yml';

        $this->entity_name = str_replace(' ', '-', $entity);
        $this->entity_structure = $this->yaml->parse_file($file_path);

        $this->entity_id = $this->map_entity_id();
        $this->entity_id_map = $this->map_entity_field_ids();
    }

    /* Single Entity Values */

    function paginate($pagination_data = array()) {
        
    }
}
