<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class View extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function init($entity = '') {
        /* Strike A Pose */
        $this->load->model('wyvern_page_model');
        $this->load->model('wyvern_entity_model', $entity)->init($entity);
    }

    function _remap($type, $params) {
        $this->init($type);

        $this->view($type, $params);
    }

    public function view($type, $params) {
        // TODO: Clearer documentation of this piece of shit
        $this->target_id = $params[0];
        $this->multiple = isset($params[1]) ? $params[1] : false;

        if ($this->multiple) {

            $this->binding_entity = isset($params[2]) ? $params[2] : $this->session->userdata('entity_type');
            $this->binding_entity_value = $this->session->userdata($this->binding_entity . "_id");
            $entity_item = $this->{$type}->fetch(array($this->binding_entity . '_id' => $this->binding_entity_value));
        } else {
            $entity_item = $this->{$type}->fetch(array($type . '_id' => $this->target_id));
        }

        $this->wyvern_page_model->render($type, $is_view = true, $entity_item);
    }

}
