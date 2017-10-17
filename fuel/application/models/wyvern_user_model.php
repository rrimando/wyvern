<?php

/**
 * Description of Wyvern_User_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
require_once(FUEL_PATH . 'models/fuel_users_model.php');

class Wyvern_User_Model extends Fuel_users_model {

    function __construct() {
        parent::__construct();

        /* Ssshhh Quiet In The Library */
        $this->load->library('fuel_auth');

        /* Strike A Pose */
        $this->load->model('wyvern_validation_model');

        $this->init();
    }

    function init() {
        $this->config->load('wyvern_config');
        $this->fuel_user_structure = $this->config->item('fuel_users_structure');
        $this->fuel_user_table = $this->config->item('fuel_users_table');
    }

    function admin_login($username = '', $password = '') {
        $set_data = array(
            'username' => $username,
            'user_level' => 'Administrator',
            'is_super_admin' => true
        );

        return $this->load_user_into_session($set_data);
    }

    function moderator_login($username = '', $password = '') {
        $set_data = array(
            'username' => $username,
            'user_level' => 'Moderator',
            'is_super_admin' => true
        );

        return $this->load_user_into_session($set_data);
    }

    function login($username = '', $password = '') {
        $response = $this->fuel_auth->login($username, $password);

        if ($response) {
            $session_key = $this->fuel->auth->get_session_namespace();
            $fuel_user = $this->session->userdata($session_key);
            if (!$this->load_wyvern_user($fuel_user['id'])) {
                $reponse = array(
                    'callback' => 'error',
                    'params' => 'User does not exist' // TODO: LANG File
                );
            }
        }

        return $response;
    }

    function logout() {

        if (is_admin_logged()) {
            $this->unload_user_from_session(array('username' => '', 'is_super_admin' => ''));

            return $this->fuel_auth->logout();
        }

        if (is_logged()) {
            $session_key = $this->fuel->auth->get_session_namespace();
            $fuel_user = $this->session->userdata($session_key);
            if (isset($fuel_user['id'])) {
                $this->unload_wyvern_user($fuel_user['id']);
            }
            return $this->fuel_auth->logout();
        }
    }

    function register($registration_data = array(), $echo_json = true) {

        // TODO Clean This Shit Up!
        if (isset($registration_data['email_address'])) {
            if ($this->check_if_email_exists($registration_data['email_address'])) {
                echo json_encode(array(
                    'callback' => 'error',
                    'params' => 'That email address has been registered, please login instead.'
                ));
                exit;
            }
        }
        
        // nice_dump($registration_data);

        $valid = $this->wyvern_validation_model->_validate($registration_data);
        
        // nice_dump($valid);

        if (isset($valid['valid']) && ($valid['valid'])) {
            $entity = $registration_data['entity'];
            $this->load->model('wyvern_entity_model', $entity)->init($entity);
            // Create User Or Update User

            if ($registration_data['registration_step'] == 'create') {

                // Create User On Fuel
                $status = $this->create_fuel_user($registration_data);

                $unsalted_password = $registration_data['password']; // This must be bland!

                if ($status) {
                    // Create User On Wyvern
                    $registration_data['password'] = $status['password'];
                    $registration_data['fuel_user_id'] = $status['fuel_id'];
                    $status = $registration_data['wyvern_unique_id'] = $this->{$entity}->create($registration_data);
                }

                if ($status) {

                    // Login User 
                    $response = $this->login($registration_data['email_address'], $unsalted_password);

                    // Prep next step
                    $next_step_url = isset($registration_data['next_step']) ? site_url($registration_data['next_step']) : site_url('register/next');

                    $response = array(
                        'callback' => 'redirect',
                        'params' => $next_step_url
                    );
                } else {
                    $response = array(
                        'callback' => 'error',
                        'params' => 'Could not create user'
                    );
                }
            } else {
                $update_response = $this->{$entity}->update($this->session->userdata('wyvern_unique_id'), $registration_data);
                
                /* Check last registration step I guess - we need a more precise way to do this */
                if ($update_response) {
                    $registration_data['next_step'] = site_url($registration_data['next_step']);

                    $next_step_url = site_url($registration_data['next_step']);

                    $response = array(
                        'callback' => 'redirect',
                        'params' => $next_step_url
                    );
                }
            }
        } else {
            $response = array(
                'callback' => 'error',
                'params' => $valid['error']
            );
        }

        $this->load_user_into_session($registration_data);

        if ($echo_json) {
            echo json_encode($response);
        } else {
            return;
        }
    }

    function create_fuel_user($user_data = array()) {

        $password = $user_data['password'];
        $user_data['salt'] = substr($this->salt(), 0, 32);
        $user_data['password'] = $this->salted_password_hash($password, $user_data['salt']);

        $new_fuel_user = array();

        // Prepare Values
        foreach ($this->fuel_user_structure as $key => $value) {
            $new_fuel_user[$key] = isset($user_data[$value]) ? ($user_data[$value]) : $value;
        }

        $this->db->insert($this->fuel_user_table, $new_fuel_user);
        $fuel_user_id = $this->db->insert_id();
        if ($fuel_user_id) {
            return array(
                'fuel_id' => $fuel_user_id,
                'salt' => $user_data['salt'],
                'password' => $user_data['password']
            );
        } else {
            return array(
                'auth' => false,
                'callback' => 'error',
                'params' => 'Could not create fuel user'
            );
        }
    }

    function load_wyvern_user($fuel_id) {
        $entity = $this->get_entity_type($fuel_id);
        if ($entity != 'n/a') { // No Entity Was Setup As A User
            $entity_table_data = $this->get_entity($entity, array('fuel_user_id' => $fuel_id));

            if (isset($entity_table_data[0])) {
                // Attach Unique ID
                $entity_table_data[0]['entity_type'] = $entity;
                $entity_table_data[0]['wyvern_unique_id'] = $this->fetch_unique_id($enity_id = $this->{$entity}->entity_id, $field_slug = 'fuel_user_id', $fuel_id);
                return $this->load_user_into_session($entity_table_data[0]);
            } else {
                return array(
                    'auth' => false,
                    'callback' => 'error',
                    'params' => 'User does not exist'
                );
            }
        }
    }

    function unload_wyvern_user($fuel_id = '') {
        if (isset($fuel_id)) {
            $entity = $this->get_entity_type($fuel_id);
            if ($entity != 'n/a') { // No Entity Was Setup As A User
                $entity_table_data = $this->get_entity($entity, array('fuel_user_id' => $fuel_id));
                $this->unload_user_from_session($entity_table_data[0]);
            }
        }
    }

    function load_user_into_session($userdata) {
        // TODO: DEV Maybe this should be based on the entity structure?
        if ($userdata) {
            foreach ($userdata as $key => $value) {
                $this->session->set_userdata($key, $value);
            }
            return true;
        } else {
            return false;
        }
    }

    function unload_user_from_session($userdata) {
        // TODO: DEV Maybe this should be based on the entity structure?
        foreach ($userdata as $key => $value) {
            $this->session->unset_userdata($key);
        }
    }

    function check_if_email_exists($email = '') {
        $result = $this->db->select('user_name')->get_where($this->fuel_user_table, array('user_name' => $email))->num_rows();
        return $result;
    }

    function get_entity($entity = false, $filter = array()) {
        if ($entity) {

            $this->load->model('wyvern_entity_model', $entity)->init($entity);
            $entity = $this->{$entity}->fetch($filter);
            return $entity;
        } else {
            return false;
        }
    }

    function get_entity_type($fuel_id = '') {
        $parent_entity = $this->db->select('entity')->get_where($this->fuel_user_table, array('id' => $fuel_id))->result_array();

        return $parent_entity[0]['entity'];
    }

    function is_logged_in() {
        return $this->fuel_auth->is_logged_in();
    }

    function is_admin_logged_in() {
        return ($this->session->userdata('is_super_admin')) ? true : false;
    }

    public function fetch_unique_id($entity_id = '', $field_slug = 'fuel_user_id', $fuel_user_id = '') {

        $entity_field = $this->db->select('id')->get_where(WYVERN_ENTITY_FIELDS_TABLE, array('parent_id' => $entity_id, 'entity_field_slug' => $field_slug))->result_array();

        // nice_dump($entity_field);
        // The binding glue
        $entity_values = $this->db->select('unique_id')->get_where(WYVERN_ENTITY_VALUES_TABLE, array('parent_entity_id' => $entity_id, 'entity_field_id' => $entity_field[0]['id'], 'value' => $fuel_user_id))->result_array();
        // exit_dump($entity_values);

        if (WYVERN_ENTITY_DEBUG) {
            if (!isset($entity_field[0]['id'])) {
                echo $field_slug . " is a culprit";
            }
        }

        return $entity_values[0]['unique_id']; // This was proudly done with hit and miss!
    }

}
