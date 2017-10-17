<?php

/*
 * Wyvern by Pixeljumpstudios
 * Wyvern was built on FuelCMS/Codeigniter and aims for quick and easy development of sites via Entity, Multiple Site Loading Frameworks
 */

/**
 * Wyvern Files Model
 * 
 * @author Rohan Rimando
 */
class Wyvern_Files_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->init();
    }

    function init() {
        
    }

    public function create($filename, $title) {
        $data = array(
            'filename' => $filename,
            'title' => $title
        );
        $this->db->insert(WYVERN_FILES_DATABASE, $data);
        return $this->db->insert_id();
    }

    public function fetch($filter = array()) {
        return $this->db->select()
                        ->get_where(WYVERN_FILES_DATABASE, $filter)
                        ->result_array();
    }

    public function get() {
        return $this->db->select()
                        ->from(WYVERN_FILES_DATABASE)
                        ->get()
                        ->result();
    }

}
