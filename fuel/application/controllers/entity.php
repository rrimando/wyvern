<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Entity extends CI_Controller {

    public function __construct() {

        parent::__construct();
    }

    function init($entity = '', $entity_overrides = array()) {

        /* Load The Helpful */
        $this->load->helper('debug');

        /* Shhhhh... Quiet In The Library */
        $this->load->library('wyvern/wyvern_form_generator', 'wyvern_form_generator');

        /* Strike A Pose */
        $this->load->model('wyvern_entity_model', $entity)->init($entity, $entity_overrides);
        $this->load->model('wyvern_blocks_model');
        $this->load->model('wyvern_table_model');

        $this->entity = $entity;

        $this->viewData = array();

        $this->mainView = (defined('WYVERN_ENTITY_VIEW')) ? WYVERN_ENTITY_VIEW : '_entity/main';
    }

    function _remap($method, $params) {

        // Default to index
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            $this->v1($method, $params);
        }
    }

    function v1($entity = '', $action = '') {

        $this->init($entity);

        if (is_array($action)) {
            $action = $action[0];
        }

        if (method_exists($this, $action)) {
            $this->{$action}();
        }
    }

    function define() {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }

        $this->viewData['content'] = nice_dump($this->{$this->entity}->entity_id_map[$this->entity]['fields'], true);
        $this->viewData['sidebar'] = $this->wyvern_blocks_model->generate_sidebar();

        $this->load->view($this->mainView, $this->viewData);
    }

    function create() {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }

        /* Display Mode */

        /* Let us generate the sidebar */
        $this->viewData['sidebar'] = $this->wyvern_blocks_model->generate_sidebar();
        $this->viewData['form'] = $this->wyvern_form_generator->create_form($this->{$this->entity});

        $this->load->view($this->mainView, $this->viewData);
    }

    // We have to obfuscate the IDs
    function edit($entity = '', $entity_id = '') {

        if (!is_admin_logged() && !is_logged()) {
            redirect(site_url('login'));
        }

        if (defined('WYVERN_OBFUSCATE') && (WYVERN_OBFUSCATE)) {
            $entity = base64_decode(rawurldecode($entity));
            $entity_id = base64_decode(rawurldecode($entity_id));
        }

        $entity_override = array(
            'ajax' => array(
                'url' => 'entity/update',
            ),
            'submit' => array(
                'label' => 'Update',
                'id' => 'update',
                'class' => 'full-width'
            ),
            'fields' => array(
                'entity' => array(
                    'attributes' => array(
                        'type' => 'hidden',
                        'name' => 'entity',
                        'id' => 'entity',
                        'value' => $entity
                    )
                ),
                $entity . '_id' => array(
                    'attributes' => array(
                        'type' => 'hidden',
                        'name' => $entity . '_id',
                        'id' => $entity . '_id',
                        'value' => $entity_id
                    )
                ),
                'entity_load' => array(
                    'attributes' => array(
                        'type' => 'hidden',
                        'name' => 'entity_load',
                        'id' => 'entity_load',
                        'value' => '1'
                    )
                )
            )
        );

        $this->init($entity, $entity_override);

        $singleton = $this->{$entity}->fetch(array($entity . '_id' => $entity_id));

        /* Display Mode */
        /* Let us generate the sidebar */
        $this->viewData['sidebar'] = $this->wyvern_blocks_model->generate_sidebar();
        /* Show Form */
        if (isset($singleton[0])) {
            $this->viewData['form'] = $this->wyvern_form_generator->create_form($this->{$this->entity}, $singleton[0]);
        } else {
            if (is_admin_logged()) {
                redirect(site_url("entity/{$entity}/view"));
            } else {
                die('Forbidden!');
            }
        }

        $this->load->view($this->mainView, $this->viewData);
    }

    function update() {

        $update_data = array();

        foreach ($_POST as $key => $value) {
            $update_data[$key] = $this->input->post($key);
        }

        $this->load->model('wyvern_entity_model', $update_data['entity'])->init($update_data['entity']);

        $unique_id = $this->{$update_data['entity']}->fetch($update_data, false, $fetch_unique_id = true);

        $this->{$update_data['entity']}->update($unique_id[0]['unique_id'], $update_data);

        if (is_admin_logged()) {
            $redirect_url = site_url("entity/{$update_data['entity']}/view");
        }

        if (is_logged()) {
            $redirect_url = $update_data['previous_page'];
        }

        echo json_encode(
                array(
                    'callback' => 'redirect',
                    'params' => $redirect_url
                )
        );
    }

    function view() {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }

        $entity_fields = $this->{$this->entity}->entity_id_map[$this->entity]['fields'];

// Check if this is a single value entity - something like settings
        if (isset($this->{$this->entity}->entity_structure[$this->entity]['attributes']['is_single_value']) && ($this->{$this->entity}->entity_structure[$this->entity]['attributes']['is_single_value'])) {
            $singleton = $this->{$this->entity}->fetch(array($this->entity . '_id' => 1));
// Check if the first value has been initialized
            if (isset($singleton[0])) {
// If it is there edit
                redirect(site_url("entity/edit/{$this->entity}/1"));
            } else {
// If it is not there then create the first value
                redirect(site_url("entity/{$this->entity}/create"));
            }
        }

        $table_attributes = array(
            'table_id' => str_replace(" ", "_", $this->entity) . "_table"
        );

        $this->viewData['content'] = $this->wyvern_table_model->render($entity_fields, $this->{$this->entity}->fetch(array()), $table_controls = true, $this->entity, $table_attributes);
        $this->viewData['sidebar'] = $this->wyvern_blocks_model->generate_sidebar();
        $this->load->view($this->mainView, $this->viewData);
    }

    function delete() {

        if (!is_admin_logged() && !is_logged()) {
            redirect(site_url('login'));
        }

        $entity_id = $this->input->post('entity_id');

        $this->{$this->entity}->delete(array($this->entity . "_id" => $entity_id));

        if (is_admin_logged()) {
            $redirect_url = site_url("entity/{$this->entity}/view");
        }

        if (is_logged()) {
            $redirect_url = $this->input->post('return_url');
        }

        echo json_encode(array(
            'callback' => 'redirect',
            'params' => $redirect_url
        ));
    }

    /* Maintenance Actions */

    function clear_entity_tables() {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }

// TODO: ADD SECURITY
        if (WYVERN_ENTITY_DEBUG) {
            $this->{$this->entity}->clear_entity_tables();
            redirect(site_url('entity/' . $this->entity . '/view'));
        }
    }

    function reset_entity() {

        if (!is_admin_logged()) {
            redirect(site_url('login'));
        }

// TODO: ADD SECURITY
        if (WYVERN_ENTITY_DEBUG) {
            $this->{$this->entity}->reset_entity();
            redirect(site_url('entity/' . $this->entity . '/view'));
        }
    }

    /* Quality Assurance and Testing Function */

    function create_test_data() {
        if (WYVERN_ENTITY_DEBUG) {
            $this->load->helper('test_data');

            if (defined('WYVERN_TESTDATA_BATCHLIMIT')) {
                $limit = WYVERN_TESTDATA_BATCHLIMIT;
            } else {
                $limit = 10;
            }
// TODO: Wire related tables
            $count = 0;
            while ($count < $limit):
                $dummy_data = array();
                $entity_map = $this->{$this->entity}->entity_id_map;
                foreach ($entity_map[$this->entity]['fields'] as $field) {
                    if (!strpos($field['attributes']['name'], 'id')) {
                        $dummy_data[$field['attributes']['name']] = generate_data($field['attributes']['type']);
                    }
                }
                $this->{$this->entity}->create($dummy_data);
                $count++;
            endwhile;

            redirect(site_url('entity/' . $this->entity . '/view'));
        } else {
            die('Die mofo die!!!');
        }
    }

}
