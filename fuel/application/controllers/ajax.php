<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function init() {
        $this->config->load('wyvern_config');
        $this->model_map = $this->config->item('model_map');

        $this->data = array();
    }

    function _remap($method, $params) {

        // Default to index
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            $this->v1($method, $params);
        }
    }

    public function v1($model = '', $function = '') {

        $this->init();

        // Parse Post Data
        if ($_POST) {
            $multiple_data_key = array();
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'ultiple_input')) { // Cause string pos sucks
                    $this->data[$key] = json_decode($this->input->post($key));
                    $multiple_data_key[] = $key;
                } else {
                    $this->data[$key] = $this->input->post($key);
                }
            }
        }

        /* if ($_GET) {
          foreach ($_GET as $key => $value) {
          $this->data[$key] = $this->input->post($key);
          }
          } */

        // Determine Action
        // We need to map the models 
        // This is the main shebang!
        if (isset($this->data['exit_before_entity']) && $this->data['exit_before_entity'] == true) {
            $response = 'Tada';
        } else {
            if (isset($this->data['entity_load'])) { // Detect if this is from entity management
                $this->load->model($this->model_map[$model], '_model')->init($this->data['entity']);
            } else {
                $this->load->model($this->model_map[$model], '_model');
            }


            if (is_array($function)) {
                $function = $function[0];
            }

            $response = $this->_model->$function($this->data);
        }

        // Process Multiple Data
        if (!empty($multiple_data_key)) {
            foreach ($multiple_data_key as $key) {
                foreach ($this->data[$key] as $values_to_insert) {
                    $entity_array = array();
                    foreach ($values_to_insert as $json_array) {
                        $entity_array[$json_array[0]] = $json_array[1];
                    }

                    if (isset($this->data['binding_field_value'])) {
                        $entity_array[$this->data['binding_field']] = $this->data['binding_field_value'];
                    } else {
                        $entity_array[$entity_array['binding_field']] = $this->session->userdata($entity_array['binding_field']);
                    }

                    $this->load->model($this->model_map['entity'], 'multiple_entry_model')->init($entity_array['multiple_entity']);
                    $this->multiple_entry_model->create($entity_array);
                }
            }
        }
        
        if (isset($this->data['entity_load'])) {
            if (is_array($response)) {
                echo json_encode($response);
            } else {
                echo json_encode(array(
                    'callback' => 'redirect',
                    'params' => site_url('entity/' . $this->data['entity'] . '/view')
                ));
            }
        }
    }

    function fetch_content($entity = '') {
        $this->load->model('wyvern_entity_model', '_model')->init($entity);

        $filters = array();

        foreach ($_POST as $key => $value) {
            // TODO Check if this is a mapped field first
            if ($this->input->post($key)) {
                $filters[$key] = $this->input->post($key);
            }
        }

        if (empty($filters)) {
            $results = $this->_model->fetch();
        } else {
            $results = $this->_model->filter($filters);
        }

        $clean_results = array();

        foreach ($results as $result) {
            foreach ($result as $key => $value) {
                $result[$key] = htmlentities($value);
            }

            $clean_results[] = $result;
        }

        $response = array(
            'total' => count($this->_model->filter($filters)),
            'data' => $clean_results,
            'filters' => $filters
        );


        echo json_encode($response);
    }

    function ajax_get_file($file_id) {
        echo get_file($file_id, true);
    }

}
