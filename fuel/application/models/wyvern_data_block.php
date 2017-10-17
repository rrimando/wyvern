<?php

/*
 * Wyvern by Pixeljumpstudios
 * Wyvern was built on FuelCMS/Codeigniter and aims for quick and easy development of sites via Entity, Multiple Site Loading Frameworks
 */

/**
 * Wyvern Data Block
 * 
 * @author Rohan Rimando
 */
class Wyvern_Data_Block extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->init();
    }

    function init() {
        $this->load->model('wyvern_blocks_model');
        $this->load->model('wyvern_table_model');
        $this->data_view_path = '_data'; // TODO: Wyvern Config
    }

    function render($data_parts, $render_into_variable = true) {
        $data_block_parts = array();

        if (isset($this->wyvern_page_model->entity_item)) {
            
            foreach ($this->wyvern_page_model->entity_item as $entity_value) {

                $inner_data_block_parts = array();

                foreach ($data_parts as $data_name => $data_attributes) {

                    $data_attributes['attributes']['label'] = $data_name;
                    if (isset($data_attributes['attributes']['get'])) {
                        $data_attributes['attributes']['value'] = $this->fetch_single_entity_value($data_attributes['attributes']['get'], $data_attributes['attributes']['get_by'], $entity_value[$data_attributes['attributes']['get_with']], $data_attributes['attributes']['get_from']);
                    } else {
                        $data_attributes['attributes']['value'] = isset($entity_value[$data_attributes['attributes']['id']]) ? $entity_value[$data_attributes['attributes']['id']] : '';
                    }

                    switch ($data_attributes['attributes']['display']) {
                        case 'projects':
                            $inner_data_block_parts[$this->wyvern_page_model->entity . "_id"] = $this->load->view($this->data_view_path . '/projects', $entity_value, TRUE);
                            break;
                        case 'services':
                            $inner_data_block_parts[$this->wyvern_page_model->entity . "_id"] = $this->load->view($this->data_view_path . '/services', $entity_value, TRUE);
                            break;
                        case 'gallery':
                            $gallery_inner_block_parts[$this->wyvern_page_model->entity . "_id"] = $this->load->view($this->data_view_path . '/gallery_part', $entity_value, TRUE);
                            break;
                        case 'quote':
                            $inner_data_block_parts[$this->wyvern_page_model->entity . "_id"] = $this->load->view($this->data_view_path . '/quote', $entity_value, TRUE);
                            break;
                        case 'default':
                            $inner_data_block_parts[] = $this->load->view($this->data_view_path . '/default_row', $data_attributes, TRUE);
                            break;
                        default:
                            die("A data type({$data_name}) was not defined properly"); // TODO:LANG
                    }
                }

                switch ($data_attributes['attributes']['display']) {
                    case 'gallery':
                        $gallery_block_parts[] = $this->load->view($this->data_view_path . '/gallery', array('inner_html' => $gallery_inner_block_parts), TRUE);
                        break;
                    default:
                        $data_block_parts[] = $this->load->view($this->data_view_path . '/result_wrap', array('inner_html' => $inner_data_block_parts), TRUE);
                        break;
                }
            }

            if (isset($data_attributes['attributes']['display'])) {
                switch ($data_attributes['attributes']['display']) {
                    case 'gallery':
                        $data['data_parts'] = $gallery_block_parts;
                        $data_block = $this->load->view('_partials/gallery', $data, $render_into_variable);
                        break;
                    default:
                        $data['data_parts'] = $data_block_parts;
                        $data_block = $this->load->view('_partials/data_block', $data, $render_into_variable);
                        break;
                }
            }
        } else {
            $data_block = "No records found"; // Should be made into a partial
        }

        return isset($data_block) ? $data_block : "No records found";
    }

    public function fetch_single_entity_value($get, $get_by, $get_with, $get_from) {

        // TODO: Clean Your Muthafuckin Mess Up!

        $entity_id = $this->db->select('id')->get_where(WYVERN_ENTITY_TABLE, array('entity_slug' => $get_from))->result_array();

        //echo $this->db->last_query();
        //nice_dump($entity_id);

        $entity_field = $this->db->select('id')->get_where(WYVERN_ENTITY_FIELDS_TABLE, array('parent_id' => $entity_id[0]['id'], 'entity_field_slug' => $get_by))->result_array();

        //echo $this->db->last_query();
        //nice_dump($entity_field);
        // The binding glue
        $entity_values = $this->db->select('unique_id')->get_where(WYVERN_ENTITY_VALUES_TABLE, array('parent_entity_id' => $entity_id[0]['id'], 'entity_field_id' => $entity_field[0]['id'], 'value' => $get_with))->result_array();

        //echo $this->db->last_query();
        //nice_dump($entity_values);

        $what_to_get_entity_field = $this->db->select('id')->get_where(WYVERN_ENTITY_FIELDS_TABLE, array('parent_id' => $entity_id[0]['id'], 'entity_field_slug' => $get))->result_array();

        //echo $this->db->last_query();
        //nice_dump($what_to_get_entity_field);

        $entity_return_value = $this->db->select('value')->get_where(WYVERN_ENTITY_VALUES_TABLE, array('unique_id' => $entity_values[0]['unique_id'], 'parent_entity_id' => $entity_id[0]['id'], 'entity_field_id' => $what_to_get_entity_field[0]['id']))->result_array();

        //echo $this->db->last_query();
        //nice_dump($entity_return_value);

        return $entity_return_value[0]['value']; // This was proudly done with hit and miss!
    }

}
