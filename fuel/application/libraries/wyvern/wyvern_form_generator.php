<?php

/*
 * Wyvern by Pixeljumpstudios
 * Wyvern was built on FuelCMS/Codeigniter and aims for quick and easy development of sites via Entity, Multiple Site Loading Frameworks
 */

/**
 * Wyvern Form Generator
 *  http://getbootstrap.com/css/#forms
 * 
 * @author Rohan Rimando
 */
class Wyvern_Form_Generator {

    function __construct() {
        
    }

    function init($entity = array(), $values = false) {
        $this->entity = $entity;
        // Catch Direct Form Generation
        if (isset($this->entity->entity_name)) {
            $this->entity_name = $this->entity->entity_name;
            $this->entity_fields = $this->entity->entity_structure[$this->entity_name]['fields'];
            $this->entity_submit = $this->entity->entity_structure[$this->entity_name]['submit'];
            $this->entity_attributes = $this->entity->entity_structure[$this->entity_name]['form']['attributes']; // Defined to know what action to give the form
            $this->entity_ajax = array(); // TODO:DEV
            $this->entity->values = $values;
        } else {
            $this->entity_name = 'form';
            $this->entity_fields = $this->entity['form']['fields'];
            $this->entity_submit = $this->entity['form']['submit'];
            $this->entity_attributes = $this->entity['form']['attributes'];
            $this->entity_ajax = $this->entity['form']['ajax'];
        }
        $this->values = $values;
        $this->CI = & get_instance();
        $this->form_view_path = WYVERN_FORMS_VIEW_FOLDER . '/_forms/';

        $this->CI->load->model('wyvern_blocks_model');
    }

    function render($render_into_variable = true) {
        $form_fields = array();
        foreach ($this->entity_fields as $field_name => $field_attributes) {
            if (isset($field_attributes['attributes']['admin_hide']) && ($field_attributes['attributes']['admin_hide'])) {
                $form_fields[] = "<span class='hidden'>Field Hidden</span>";
            } else {
                if (is_array($field_attributes)) {
                    $field_type = $field_attributes['attributes']['type'];
                } else {
                    $field_type = $field_attributes;
                }

                $submit_attributes = $this->entity_submit;
                $ajax_attributes = $this->entity_ajax;

                $_field_attributes = isset($field_attributes['attributes']) ? $field_attributes['attributes'] : array('name' => $field_name, 'type' => $field_attributes);

                // Set Values
                if (isset($this->values[strtolower(str_replace(" ", "_", $field_name))])) {
                    $_field_attributes['value'] = $this->values[strtolower(str_replace(" ", "_", $field_name))];
                }

                if (isset($field_attributes['attributes']['value']) && is_array($field_attributes['attributes']['value'])) {
                    if ($field_attributes['attributes']['value']['source'] == 'view') {
                        $_field_attributes['value'] = $this->CI->{$field_attributes['attributes']['value']['target']};
                    }

                    if ($field_attributes['attributes']['value']['source'] == 'session') {
                        $_field_attributes['value'] = $this->CI->session->userdata($field_attributes['attributes']['value']['target']);
                    }
                }

                switch ($field_type) {
                    case 'header':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'header', $_field_attributes, TRUE);
                        break;
                    case 'text':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'text', $_field_attributes, TRUE);
                        break;
                    case 'password':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'password', $_field_attributes, TRUE);
                        break;
                    case 'email':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'email', $_field_attributes, TRUE);
                        break;
                    case 'string':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'text', $_field_attributes, TRUE);
                        break;
                    case 'number': //TODO/REFACTOR cleanup -- redundancy
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'number', $_field_attributes, TRUE);
                        break;
                    case 'textarea':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'textarea', $_field_attributes, TRUE);
                        break;
                    case 'integer':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'number', $_field_attributes, TRUE);
                        break;
                    case 'date':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'datepicker', $_field_attributes, TRUE);
                        break;
                    case 'select':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'select', $_field_attributes, TRUE);
                        break;
                    case 'enumeration':

                        if (is_array($_field_attributes['options'])) {

                            $_options_entity = $_field_attributes['options']['attributes']['entity'];
                            $this->CI->load->model('wyvern_entity_model', $_options_entity)->init($_options_entity);


                            if (isset($_field_attributes['options']['attributes']['filters'])) {

                                $filters = array();

                                // TODO MULTILPLE FILTERS

                                switch ($_field_attributes['options']['attributes']['filters']['source']) {
                                    case 'session':
                                        $equals = $this->CI->session->userdata($_field_attributes['options']['attributes']['filters']['equals']);
                                        break;
                                    // Other sources go here
                                    default:
                                        break;
                                }

                                $filters = array(
                                    $_field_attributes['options']['attributes']['filters']['where'] => $equals
                                );

                                $entity_values = $this->CI->{$_options_entity}->filter($filters);
                            } else {
                                $entity_values = $this->CI->{$_options_entity}->fetch();
                            }

                            $_field_attributes['options'] = $this->create_entity_options($entity_values, $_field_attributes['options']);
                        }

                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'enumeration', $_field_attributes, TRUE);
                        break;
                    case 'file':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'fileinput', $_field_attributes, TRUE);
                        break;
                    case 'video':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'fileinput', $_field_attributes, TRUE);
                        break;
                    case 'document':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'fileinput', $_field_attributes, TRUE);
                        break;
                    case 'hidden':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'hidden', $_field_attributes, TRUE);
                        break;
                    case 'csrf':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'csrf', $_field_attributes, TRUE);
                        break;
                    case 'message':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'message', $_field_attributes, TRUE);
                        break;
                    case 'multiple_inputs':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'multiple_inputs', $_field_attributes, TRUE);
                        break;
                    case 'content_block':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'content', $_field_attributes, TRUE);
                        break;
                    case 'custom_submit':
                        $form_fields[] = $this->CI->load->view($this->form_view_path . 'custom_submit', $_field_attributes, TRUE);
                        break;
                    case 'partial':
                        $form_fields[] = $this->CI->wyvern_blocks_model->__partial($_field_attributes['partial'], $_field_attributes, TRUE);
                        break;
                    default:
                        die("A form field({$field_type}) was not defined properly"); // TODO:LANG
                }

                /* Clean Up */
                foreach ($_field_attributes as $key => $value) {
                    unset($_field_attributes[$key]);
                }
            }
        }

        $this->viewData['form_fields'] = $form_fields;
        $this->viewData['form_attr'] = $this->entity_attributes;
        $this->viewData['form_submit'] = $this->CI->load->view($this->form_view_path . 'submit', $submit_attributes, TRUE);

        $form = $this->CI->load->view($this->form_view_path . 'form', $this->viewData, $render_into_variable);

        return $form;
    }

    public function create_entity_options($entity_values, $option_attributes) {
        $entity_options = array();

        foreach ($entity_values as $option => $option_array) {
            $entity_options[$option_array[$option_attributes['attributes']['value']]] = $option_array[$option_attributes['attributes']['label']];
        }

        return $entity_options;
    }

    public function create_form($entity = array(), $values = false, $render_to_variable = TRUE) {
        $this->init($entity, $values);

        return $this->render($render_to_variable);
    }

    function render_scripts($entity = array()) { // TODO: DEV This also resides in wyvern page model - have to merge them
        $scripts = array();
        if (!empty($entity->entity_structure['data']['forms'])) {
            foreach ($entity->entity_structure['data']['forms'] as $form) {
                $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $form . '.yml';
                $form_structure = $this->yaml->parse_file($file_path);
                $scripts[] = $this->CI->wyvern_blocks_model->__partial('script', $form_structure, FALSE);
            }
        }
        // Custom Forms
        if (isset($entity->entity_structure['page']['body']['partials']['advanced_search'])) {
            $scripts[] = $this->CI->wyvern_blocks_model->__partial('script', $entity['page']['body']['partials']['advanced_search'], FALSE);
        }
        // Entity Scripts
        if (isset($entity->entity_structure[$entity->entity_name]['form'])) {
            $scripts[] = $this->CI->wyvern_blocks_model->__partial('script', array('form' => $entity->entity_structure[$entity->entity_name]), FALSE);
        }

        return $scripts;
    }

    /* Field Elements */

    function render_element($field_type = '', $_field_attributes = array()) {
        switch ($field_type) {
            case 'header':
                $form_element = $this->CI->load->view($this->form_view_path . 'header', $_field_attributes, TRUE);
                break;
            case 'text':
                $form_element = $this->CI->load->view($this->form_view_path . 'text', $_field_attributes, TRUE);
                break;
            case 'password':
                $form_element = $this->CI->load->view($this->form_view_path . 'password', $_field_attributes, TRUE);
                break;
            case 'email':
                $form_element = $this->CI->load->view($this->form_view_path . 'email', $_field_attributes, TRUE);
                break;
            case 'string':
                $form_element = $this->CI->load->view($this->form_view_path . 'text', $_field_attributes, TRUE);
                break;
            case 'number': //TODO/REFACTOR cleanup -- redundancy
                $form_element = $this->CI->load->view($this->form_view_path . 'number', $_field_attributes, TRUE);
                break;
            case 'textarea':
                $form_element = $this->CI->load->view($this->form_view_path . 'textarea', $_field_attributes, TRUE);
                break;
            case 'integer':
                $form_element = $this->CI->load->view($this->form_view_path . 'number', $_field_attributes, TRUE);
                break;
            case 'date':
                $form_element = $this->CI->load->view($this->form_view_path . 'datepicker', $_field_attributes, TRUE);
                break;
            case 'select':
                $form_element = $this->CI->load->view($this->form_view_path . 'select', $_field_attributes, TRUE);
                break;
            case 'enumeration':

                if (is_array($_field_attributes['options'])) {

                    $_options_entity = $_field_attributes['options']['attributes']['entity'];
                    $this->CI->load->model('wyvern_entity_model', $_options_entity)->init($_options_entity);


                    if (isset($_field_attributes['options']['attributes']['filters'])) {

                        $filters = array();

                        // TODO MULTILPLE FILTERS

                        switch ($_field_attributes['options']['attributes']['filters']['source']) {
                            case 'session':
                                $equals = $this->CI->session->userdata($_field_attributes['options']['attributes']['filters']['equals']);
                                break;
                            // Other sources go here
                            default:
                                break;
                        }

                        $filters = array(
                            $_field_attributes['options']['attributes']['filters']['where'] => $equals
                        );

                        $entity_values = $this->CI->{$_options_entity}->filter($filters);
                    } else {
                        $entity_values = $this->CI->{$_options_entity}->fetch();
                    }

                    $_field_attributes['options'] = $this->create_entity_options($entity_values, $_field_attributes['options']);
                }

                $form_element = $this->CI->load->view($this->form_view_path . 'enumeration', $_field_attributes, TRUE);
                break;
            case 'file':
                $form_element = $this->CI->load->view($this->form_view_path . 'fileinput', $_field_attributes, TRUE);
                break;
            case 'document':
                $form_element = $this->CI->load->view($this->form_view_path . 'fileinput', $_field_attributes, TRUE);
                break;
            case 'hidden':
                $form_element = $this->CI->load->view($this->form_view_path . 'hidden', $_field_attributes, TRUE);
                break;
            case 'csrf':
                $form_element = $this->CI->load->view($this->form_view_path . 'csrf', $_field_attributes, TRUE);
                break;
            case 'message':
                $form_element = $this->CI->load->view($this->form_view_path . 'message', $_field_attributes, TRUE);
                break;
            case 'multiple_inputs':
                $form_element = $this->CI->load->view($this->form_view_path . 'multiple_inputs', $_field_attributes, TRUE);
                break;
            case 'content_block':
                $form_element = $this->CI->load->view($this->form_view_path . 'content', $_field_attributes, TRUE);
                break;
            case 'custom_submit':
                $form_element = $this->CI->load->view($this->form_view_path . 'custom_submit', $_field_attributes, TRUE);
                break;
            case 'partial':
                $form_element = $this->CI->wyvern_blocks_model->__partial($_field_attributes['partial'], $_field_attributes, TRUE);
                break;
            default:
                die("A form field({$field_type}) was not defined properly"); // TODO:LANG
        }

        return $form_element;
    }

    /* End Field Elements */
}
