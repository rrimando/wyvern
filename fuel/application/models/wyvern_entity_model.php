<?php

/**
 * Description of Wyvern_Entity_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Entity_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        /* Shhh Quiet In The Library */
        $this->load->library('yaml');
    }

    function init($entity = 'entity', $entity_overrides = array()) {
        $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/entities/' . $entity . '.yml';

        $this->entity_name = str_replace(' ', '-', $entity);
        if (!empty($entity_overrides)) {
            $entity_structure = $this->yaml->parse_file($file_path);

            foreach ($entity_overrides as $key => $value) {
                if ($key == 'fields') {
                    foreach ($value as $field => $attributes) {
                        $entity_structure[$entity]['fields'][$field] = $attributes;
                    }
                } else {
                    $entity_structure[$entity][$key] = $value;
                }
            }

            $this->entity_structure = $entity_structure;
        } else {
            $this->entity_structure = $this->yaml->parse_file($file_path);
        }

        $this->entity_id = $this->map_entity_id();
        $this->entity_id_map = $this->map_entity_field_ids();
    }

    /* Single Entity Values */

    function create($entity_data = array()) {

        $next_id = $this->fetch_next_id();

        // nice_dump($next_id);

        $unique_id = $this->generate_unique_id();

        // exit_dump($next_id);

        /* Create The New Entity ID first */
        $newborn_entity = array(
            'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$this->entity_name . '_id']['id'],
            'value' => $next_id,
            'parent_entity_id' => $this->entity_id,
            'unique_id' => $unique_id // For Deleting Purposes
        );
        $this->db->insert(WYVERN_ENTITY_VALUES_TABLE, $newborn_entity);

        foreach ($entity_data as $key => $value) {
            // Filter the blah :D Stuff from forms that aren't in the entity
            if (isset($this->entity_id_map[$this->entity_name]['fields'][$key]['id'])) {
                $newborn_entity_field = array(
                    'unique_id' => $unique_id,
                    'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$key]['id'],
                    'value' => $value,
                    'parent_entity_id' => $this->entity_id
                );
                $this->db->insert(WYVERN_ENTITY_VALUES_TABLE, $newborn_entity_field);
            }// else do NOOOOOTHINNNG
        }

        // POST HOOKS

        if (isset($this->entity_structure[$this->entity_name]['create_post_hook'])) {
            include(INSTALL_ROOT . '/application/hooks/wyvern/' . strtolower(str_replace(" ", "_", WYVERN_SITE_NAME)) . "/" . $this->entity_structure[$this->entity_name]['create_post_hook']) . '.php';
        }

        // TODO:ERR_HANDLING
        return $unique_id;
    }

    function load($entity = array()) {
        $entity_load = array();
        foreach ($entity as $index => $entity_values) {
            $field_slug = $this->fetch_entity_field('entity_field_slug', array('id' => $entity_values['entity_field_id']));
            $entity_load[$field_slug] = $entity_values['value'];
        }
        return $entity_load;
    }

    /* For now this will only accept one filter */

    function fetch($filter = array(), $like = false, $fetch_unique_id = false, $count = false) { // TODO:Dev Searches With Like
        if (!empty($filter)) {
            foreach ($filter as $field => $value) {
                if (isset($this->entity_id_map[$this->entity_name]['fields'][$field])) {
                    $translated_filter = array(
                        'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$field]['id'],
                        'value' => $value // TODO:DEV create 'LIKE' searchability
                    );
                }
                // Filter here by sticking all results in an array and firing away
                // The SQL query should be here
            }
        }

        $translated_filter['parent_entity_id'] = $this->entity_id; // Don't be greedy we just fetch what we needy

        if ($count) {
            $unique_ids = $this->db->distinct()->select('unique_id')->limit($count)->get_where(WYVERN_ENTITY_VALUES_TABLE, $translated_filter);
        } else {
            $unique_ids = $this->db->distinct()->select('unique_id')->get_where(WYVERN_ENTITY_VALUES_TABLE, $translated_filter);
        }

        if ($fetch_unique_id) {
            return $unique_ids->result_array();
        }
        $entities = array();

        foreach ($unique_ids->result_array() as $unique_id) {
            $entity = $this->db->get_where(WYVERN_ENTITY_VALUES_TABLE, array('unique_id' => $unique_id['unique_id']))->result_array();
            $entities[] = $this->load($entity);
        }
        return $entities;
    }

    /* TODO:DEV MULTIPLE FILTERS */

    function filter($filter = array(), $like = false, $fetch_unique_id = false, $override = false) {

        $result_unique_ids = array();

        /* Double check that your field names match the field name on the YAML */
        if (!empty($filter)) {
            foreach ($filter as $field => $value) {

                $temp_unique_ids = array();

                if (isset($this->entity_id_map[$this->entity_name]['fields'][$field])) {
                    $translated_filter = array(
                        'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$field]['id'],
                        'value' => $value // TODO:DEV create 'LIKE' searchability
                    );
                }

                $translated_filter['parent_entity_id'] = $this->entity_id; // Don't be greedy we just fetch what we needy
                // Filter here by sticking all results in an array and firing away
                // The SQL query should be here

                if (defined('WYVERN_FILTER_MODE') && !($override)) {

                    if (WYVERN_FILTER_MODE == 'like') {
                        $results = $this->db->distinct()->select('unique_id')->like($translated_filter)->get(WYVERN_ENTITY_VALUES_TABLE);
                        // Produces: WHERE title LIKE '%match%'
                    }
                } else {

                    $results = $this->db->distinct()->select('unique_id')->get_where(WYVERN_ENTITY_VALUES_TABLE, $translated_filter);
                }

                foreach ($results->result_array() as $result) {
                    $temp_unique_ids[] = $result['unique_id'];
                }

                if (empty($result_unique_ids)) {
                    $result_unique_ids = $temp_unique_ids;
                } else {
                    $result_unique_ids = array_intersect($temp_unique_ids, $result_unique_ids);
                }
            }
        }

        $unique_ids = array();
        foreach ($result_unique_ids as $id) {
            $unique_ids[] = array('unique_id' => $id);
        }

        if ($fetch_unique_id) {
            return $unique_ids;
        }

        $entities = array();

        foreach ($unique_ids as $unique_id) {
            $entity = $this->db->get_where(WYVERN_ENTITY_VALUES_TABLE, array('unique_id' => $unique_id['unique_id']))->result_array();
            $entities[] = $this->load($entity);
        }
        if (isset($filter['is_ajax'])) {

            $this->load->model('wyvern_blocks_model');
            $html = $this->wyvern_blocks_model->render_search_results($entities, $filter['exclude'], $filter['entity'], $filter['form_name']);

            return $response = array(
                'callback' => 'loadResultBlock',
                'params' => $html
            );
        } else {
            return $entities;
        }
    }

    function update($unique_id = '', $entity_data = array()) {

        foreach ($entity_data as $key => $value) {
            // Filter the blah :D Stuff from forms that aren't in the entity
            if (isset($this->entity_id_map[$this->entity_name]['fields'][$key]['id'])) {
                $entity_field_value = array(
                    'unique_id' => $unique_id,
                    'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$key]['id'],
                    'parent_entity_id' => $this->entity_id
                );

                $entity_value_id = $this->check_if_value_exists($entity_field_value);
                if ($entity_value_id) {
                    $this->delete($entity_field_value);
                }
                $entity_field_value['value'] = $value;
                $this->db->insert(WYVERN_ENTITY_VALUES_TABLE, $entity_field_value);
                // nice_dump($entity_field_value);
            }// else do NOOOOOTHINNNG
        }

        // exit_dump($unique_id);

        if (isset($this->entity_structure[$this->entity_name]['update_post_hook'])) {
            include(INSTALL_ROOT . '/application/hooks/wyvern/' . strtolower(str_replace(" ", "_", WYVERN_SITE_NAME)) . "/" . $this->entity_structure[$this->entity_name]['update_post_hook']) . '.php';
        }

        // TODO:ERR_HANDLING
        return true;
    }

    function delete($filter = array()) {
        foreach ($filter as $field => $value) {
            if (isset($this->entity_id_map[$this->entity_name]['fields'][$field])) {
                $translated_filter = array(
                    'parent_entity_id' => $this->entity_id,
                    'entity_field_id' => $this->entity_id_map[$this->entity_name]['fields'][$field]['id'],
                    'value' => $value // TODO:DEV create 'LIKE' searchability
                );
            }
        }

        if (isset($translated_filter)) {
            $unique_ids = $this->db->select('unique_id')->get_where(WYVERN_ENTITY_VALUES_TABLE, $translated_filter)->result_array();

            // TODO:DEV Soft deletes for undo mechanisms

            foreach ($unique_ids as $unique_id) {
                $this->db->where(array('unique_id' => $unique_id['unique_id']))->delete(WYVERN_ENTITY_VALUES_TABLE);
            }
        }

        return;
    }

    function generate_unique_id() {
        return uniqid(WYVERN_SITE_NAME . "_" . time());
    }

    function fetch_next_id() {
        /*
         * This assumes that all entity will have 'id' as their identifying CUSTOM primary key - we assign it
         */

        $entity_field_id = $this->entity_id_map[$this->entity_name]['fields'][$this->entity_name . '_id']['id'];

        $entity_values_table = WYVERN_ENTITY_VALUES_TABLE;

        $query = "SELECT MAX(CONVERT(SUBSTRING_INDEX(value,'-',-1),UNSIGNED INTEGER)) AS value FROM (`{$entity_values_table}`) WHERE `entity_field_id` =  '{$entity_field_id}'";

        $result = $this->db->query($query);



        // echo $this->db->last_query();

        if ($result->num_rows()) {
            $next_id = $result->result_array();
            return abs($next_id[0]['value']) + 1;
        } else {
            return 1;
        }
    }

    function check_if_value_exists($data_array = array()) {
        return $this->db->get_where(WYVERN_ENTITY_VALUES_TABLE, $data_array)->num_rows();
    }

    /* Entities */

    function fetch_entity_field($field, $filter = array()) {
        $entity_field = $this->db->select($field)->get_where(WYVERN_ENTITY_FIELDS_TABLE, $filter)->result_array();
        return $entity_field[0][$field];
    }

    function map_entity_id() {
        $this->entity_exists();

        $entity_id = $this->db->select('id as entity_id')->get_where(WYVERN_ENTITY_TABLE, array('entity_slug' => $this->entity_name))->result_array();

        return $entity_id[0]['entity_id'];
    }

    function map_entity_field_ids() {
        $this->entity_exists();

        $entity_fields_id_map = array();

        foreach ($this->entity_structure[$this->entity_name]['fields'] as $entity_field_name => $entity_field_attributes) {

            // Skip Overrides :D 
            if ($entity_field_attributes['attributes']['type'] == 'hidden') {
                continue;
            }

            // Check if attributes were defined
            if (is_array($entity_field_attributes)) {
                $entity_value_type = $entity_field_attributes['attributes']['type'];
            } else {
                $entity_value_type = $entity_field_attributes;
            }

            $entity_field_slug = str_replace(' ', '_', $entity_field_name);
            $entity_filter = array(
                'entity_field_name' => ucwords($entity_field_name),
                'entity_field_slug' => $entity_field_slug,
                'entity_value_type' => $entity_value_type,
                'parent_id' => $this->entity_id
            );
            $entity_field_id = $this->db->select('id as entity_field_id')->get_where(WYVERN_ENTITY_FIELDS_TABLE, $entity_filter)->result_array();
            // TODO:REFACTOR
            if (is_array($entity_field_attributes)) {
                if (isset($entity_field_id[0]['entity_field_id'])) {
                    $entity_fields_id_map[$entity_field_slug] = array('id' => $entity_field_id[0]['entity_field_id'], 'attributes' => $entity_field_attributes['attributes']);
                } else {
                    //die("An error with the value({$entity_field_slug}) has occured");
                }
            } else {
                $entity_fields_id_map[$entity_field_slug] = array('id' => $entity_field_id[0]['entity_field_id']);
            }
        }

        return array(
            $this->entity_name => array(
                'id' => $this->entity_id,
                'fields' => $entity_fields_id_map
            )
        );
    }

    function entity_exists() {
        if (WYVERN_ENTITY_DEBUG) {
            /* Check if entity exists */
            $entity_exists = $this->db->select('id')->get_where(WYVERN_ENTITY_TABLE, array('entity_slug' => $this->entity_name))->num_rows();
            /* TODO:DEV Check if the field numbers match */

            if ($entity_exists) {
                return true;
            } else {
                if (WYVERN_ENTITY_DEBUG) {
                    $this->create_entity();
                } else {
                    die('This site has not been properly configured'); // TODO:LANG Throw This Into A Lang File
                }
            }
        } else {
            return true;
        }
    }

    function create_entity() {
        /* Entity Table */
        $entity = array(
            'entity_name' => ucwords($this->entity_name),
            'entity_slug' => strtolower($this->entity_name)
        );

        $this->db->insert(WYVERN_ENTITY_TABLE, $entity);

        $entity_table_id = $this->db->insert_id();

        /* Entity Values */
        foreach ($this->entity_structure[$this->entity_name]['fields'] as $entity_field_name => $entity_field_attributes) {

            // Check if attributes were defined
            if (is_array($entity_field_attributes)) {
                $entity_field_type = $entity_field_attributes['attributes']['type'];
            } else {
                $entity_field_type = $entity_field_attributes;
            }

            $entity_field = array(
                'parent_id' => $entity_table_id,
                'entity_field_name' => ucwords($entity_field_name),
                'entity_field_slug' => str_replace(' ', '_', $entity_field_name),
                'entity_value_type' => $entity_field_type
            );
            $this->db->insert(WYVERN_ENTITY_FIELDS_TABLE, $entity_field);
        }
        return true;
    }

    function update_entity() {
        /* TODO:DEV this is for the admin section */
    }

    function delete_entity() {
        /* TODO:DEV this is for the admin section */
    }

    function create_entity_table() {
        /* TODO:DEV this is for the admin section */
    }

    function truncate_entity_table() {
        /* TODO:DEV this is for the admin section */
    }

    /* Collections/Sets of Data */

    /* Maintenance Functions */

    function clear_entity_tables() {
        if (WYVERN_ENTITY_DEBUG) {
            $this->db->truncate(WYVERN_ENTITY_TABLE);
            $this->db->truncate(WYVERN_ENTITY_FIELDS_TABLE);
            $this->db->truncate(WYVERN_ENTITY_VALUES_TABLE);
            // dandy();
        } else {
            randy();
        }
    }

    function reset_entity() {
        if (WYVERN_ENTITY_DEBUG) {
            $this->db->where('id', $this->entity_id)->delete(WYVERN_ENTITY_TABLE);
            $this->db->where('parent_id', $this->entity_id)->delete(WYVERN_ENTITY_FIELDS_TABLE);
            $this->db->where('parent_entity_id', $this->entity_id)->delete(WYVERN_ENTITY_VALUES_TABLE);
            // dandy();
        } else {
            randy();
        }
    }

    /* Maintenance Functions */
}
