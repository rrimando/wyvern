<?php

/**
 * Description of Wyvern_Blocks_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Blocks_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function init() {
        
    }

    /* Blocks */

    function show_block($view, $data) {
        $this->load->view('_blocks/' . $view, $data);
    }

    /* Partials */

    function show_partial() {
        
    }

    /* Navs and Menus */

    function generate_sidebar($sidebar_data = array(), $sidebar_view = '_entity/_blocks/sidebar') {

        $data['entities'] = $this->fetch_entities();
        $data['reports'] = $this->fetch_reports();
        $data['sidebar_menu'] = $this->generate_menu($data);

        return $this->load->view($sidebar_view, $data, TRUE);
    }

    function generate_menu($menu_data = array(), $direction = 'vertical') {
        return $this->load->view('_partials/' . $direction . '_menu', $menu_data, TRUE);
    }

    function fetch_reports() {

        $reports_folder = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/reports/';

        if (!is_dir($reports_folder)) {
            return false;
        }

        $reports = array();
        $sorted_reports = array();

        if ($handle = opendir($reports_folder)) {

            while (false !== ($report_file = readdir($handle))) {
                if (strpos($report_file, '.yml'))
                    $reports[] = str_replace('.yml', '', $report_file);
            }
            $sorted_reports = natsort($reports);
            closedir($handle);
        }

        return $reports;
    }

    function fetch_entities() {

        $entity_folder = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/entities/';
        $entities = array();
        $sorted_entities = array();

        if ($handle = opendir($entity_folder)) {

            while (false !== ($entity_file = readdir($handle))) {
                if (strpos($entity_file, '.yml'))
                    $entities[] = str_replace('.yml', '', $entity_file);
            }
            $sorted_entities = natsort($entities);
            closedir($handle);
        }

        return $entities;
    }

    function render_partial($partials = '', $data = array(), $render_as_variable = FALSE) { // TODO:REFACTOR move to blocks
        if (is_array($partials)) {
            foreach ($partials as $partial) {
                $this->__partial($partial, $data, $render_as_variable);
            }
        } else {
            return $this->__partial($partials, $data, $render_as_variable);
        }
    }

    function __partial($partial = '', $data = array(), $render_as_variable = FALSE) {
        // detect if this a form
        if (strstr($partial, 'form')) {
            $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $partial . '.yml';
            $form_structure = $this->yaml->parse_file($file_path);

            echo $this->wyvern_form_generator->create_form($form_structure, $data, FALSE);
        } else {
            return $this->load->view('_partials/' . $partial, $data, $render_as_variable);
        }
    }

    function render_footer($data = array()) {
        /* This assumes now that everything is ajax */

        $page_data['page_scripts'] = $this->render_scripts($data);

        $this->load->view('_blocks/footer', $page_data);
    }

    function render_scripts($data = array()) {
        $scripts = array();
        if (isset($data->page_structure)) {
            if (isset($data->page_structure['data']['forms'])) {
                foreach ($data->page_structure['data']['forms'] as $form) {
                    $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $form . '.yml';
                    $form_structure = $this->yaml->parse_file($file_path);
                    $scripts[] = $this->__partial('script', $form_structure, FALSE);
                }
            }

            // Custom Forms
            if (isset($data->page_structure['page']['body']['partials']['advanced_search'])) {
                $scripts[] = $this->__partial('script', $this->page_structure['page']['body']['partials']['advanced_search'], FALSE);
            }
        }
        if (isset($data->entity_structure)) {
            // Entity Scripts
            if (isset($data->entity_structure[$data->entity_name]['form'])) {
                $scripts[] = $this->wyvern_blocks_model->__partial('script', array('form' => $data->entity_structure[$data->entity_name]), FALSE);
            }
        }
        //nice_dump($scripts);
        return $scripts;
    }

    /* Ajax Functions */

    function render_search_results($results, $exclude = array('_id')/* For Tables */, $entity = '', $structure_file = '') { // $exclude will help us remove all unecessary stuff from the frontend
        // Based on the yaml file lest determine the structure of the Results
        if (isset($structure_file)) {
            $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $structure_file . '.yml';
            $structure = $this->yaml->parse_file($file_path);

            // Detect Table Stucture
            if ($structure['form']['results']['type'] == 'table') {

                $this->load->model('wyvern_table_model');

                $table_headers = array();

                if (isset($results[0])) {

                    $_exclude = explode(',', $exclude);

                    foreach ($results[0] as $key => $value) {
                        $include_item = true;

                        foreach ($_exclude as $data_filter) {
                            if (strpos($key, $data_filter)) {
                                $include_item = false;
                            }
                        }
                        if ($include_item) {
                            $table_headers[$key] = array();
                        }
                    }
                }

                // render($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array())
                return $this->wyvern_table_model->render($table_headers, $results, false, $entity, $structure['form']['results']['attributes']);
            }
            // Other structures of results follow here 
        } else {
            $this->load->model('wyvern_table_model');

            $table_headers = array();

            if (isset($results[0])) {

                $_exclude = explode(',', $exclude);

                foreach ($results[0] as $key => $value) {
                    $include_item = true;
                    foreach ($_exclude as $data_filter) {
                        if (strpos($key, $data_filter)) {
                            $include_item = false;
                        }
                    }
                    if ($include_item) {
                        $table_headers[$key] = array();
                    }
                }
            }

            // Fall Back is in table form with no actions
            return $this->wyvern_table_model->render($table_headers, $results);
        }
    }

}
