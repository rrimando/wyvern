<?php

/**
 * Description of Wyvern_Page_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Page_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        /* Shhh Quiet In The Library */
        $this->load->library('yaml');
        $this->load->library('wyvern/wyvern_form_generator', 'wyvern_form_generator');

        /* Strike A Pose */
        $this->load->model('wyvern_data_block');
    }

    function init($page = '', $admin = false, $is_view = false, $entity_items = array()) {

        if ($admin) {
            $page .= 'admin/' . $page;
        }

        if ($is_view) {
            $repository = 'views';
        } else {
            $repository = 'pages';
        }

        $this->page = $page;

        $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/' . $repository . '/' . $page . '.yml';
        $this->page_structure = $this->yaml->parse_file($file_path);

        // FOR THE STRANGEST REASONS WE MAY HAVE TO HIDE BASIC PAGES
        if (isset($this->page_structure['force_redirect'])) {
            redirect(site_url($this->page_structure['force_redirect']['url']));
        }

        $this->theme = $this->page_structure['theme'];
        $this->page_title = $this->page_structure['page_title'];
        $this->login_required = isset($this->page_structure['login_required']) ? $this->page_structure['login_required'] : false;


        // This is for direct loading of entity values on pages NOT views configs
        if ($is_view || isset($this->page_structure['data']['custom_entity_view'])) {
            $this->entity_item_view = $this->page_structure['data']['custom_entity_view']['fields'];
            $this->entity = $this->page_structure['data']['custom_entity_view']['entity'];
            $this->entity_item_count = isset($this->page_structure['data']['custom_entity_view']['count']) ? $this->page_structure['data']['custom_entity_view']['count'] : false;
            $this->load->model('wyvern_entity_model', $this->entity)->init($this->entity);
            // Prepare filters
            if (isset($this->page_structure['data']['custom_entity_view']['filters']['source'])) {
                switch ($this->page_structure['data']['custom_entity_view']['filters']['source']) {
                    case 'session':

                        $filters = array();

                        // TODO MULTILPLE FILTERS
                        switch ($this->page_structure['data']['custom_entity_view']['filters']['source']) {
                            case 'session':
                                $equals = $this->session->userdata($this->page_structure['data']['custom_entity_view']['filters']['equals']);
                                break;
                            // Other sources go here
                            default:
                                break;
                        }

                        $filters = array(
                            $this->page_structure['data']['custom_entity_view']['filters']['where'] => $equals
                        );

                        $this->entity_item = $this->{$this->entity}->fetch($filters, false, false, $this->entity_item_count);
                        break;
                    default:
                        $this->entity_item = $this->{$this->entity}->fetch($this->page_structure['data']['custom_entity_view']['filters'], false, false, $this->entity_item_count);
                        break;
                }
            } else {
                $this->entity_item = $this->{$this->entity}->fetch($this->page_structure['data']['custom_entity_view']['filters'], false, false, $this->entity_item_count);
            }
        }

        if (!empty($entity_items)) {
            $this->entity_item = $entity_items;
        }

        // TODO:PAGE META
    }

    function render($page = '', $is_view = false, $entity_items = array()) {

        /* For Fixing */
        $admin = false;

        $this->init($page, $admin, $is_view, $entity_items);

        $admin = isset($this->page_structure['is_admin']) ? $this->page_structure['is_admin'] : false;

        $this->viewData = $this->fetch_page_data($this->page_structure['data']);

        /* Setting Layout */
        if (defined('WYVERN_THEME') && (!$admin)) {
            $this->load->view($this->page_structure['page']['layout'], $this->viewData);
        } else {
            // Catch Template Sites - Blog, Store Etc
            /* BLOG */
            if (defined('WYVERN_BLOG_THEME') && (!$this->page_structure['is_admin'])) {
                $this->load->view($this->page_structure['page']['layout'], $this->viewData);
                /* STORE */
                /* LISTING SITE */
            } else {
                $this->load->view('_layouts/' . $this->page_structure['page']['layout'], $this->viewData);
            }
        }
    }

    /* Pages from database */

    function render_blog_page($page_slug = '', $is_view = false, $entity_items = array()) {
        /* TODO Cleanup/For Fixing */
        /* For Fixing */
        $admin = false;

        $this->init('page', $admin, $is_view, $entity_items);

        $admin = isset($this->page_structure['is_admin']) ? $this->page_structure['is_admin'] : false;

        $this->viewData = $this->fetch_blog_page_data($page_slug);

        /* Setting Layout */
        if (defined('WYVERN_THEME') && (!$admin)) {
            $this->load->view($this->page_structure['page']['layout'], $this->viewData);
        } else {
            // Catch Template Sites - Blog, Store Etc
            /* BLOG */
            if (defined('WYVERN_BLOG_THEME') && (!$this->page_structure['is_admin'])) {
                $this->load->view($this->page_structure['page']['layout'], $this->viewData);
                /* STORE */
                /* LISTING SITE */
            } else {
                $this->load->view('_layouts/' . $this->page_structure['page']['layout'], $this->viewData);
            }
        }
    }

    function render_footer() {
        /* This assumes now that everything is ajax */
        if (isset($this->page_structure['page']['footer']['partials'])) {
            $this->viewData['partials'] = $this->page_structure['page']['footer']['partials'];
        }
        
        $this->viewData['page_scripts'] = $this->render_scripts();

        $this->load->view('_blocks/footer', $this->viewData);
    }

    function render_scripts() {
        $scripts = array();
        if (isset($this->page_structure['data']['forms'])) {
            foreach ($this->page_structure['data']['forms'] as $form) {
                $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $form . '.yml';
                $form_structure = $this->yaml->parse_file($file_path);
                $scripts[] = $this->__partial('script', $form_structure, FALSE);
            }
        }
        // Custom Forms
        if (isset($this->page_structure['page']['body']['partials']['advanced_search'])) {
            $scripts[] = $this->__partial('script', $this->page_structure['page']['body']['partials']['advanced_search'], FALSE);
        }

        // Entity Scripts
        if (isset($this->entity_structure)) {
            if (isset($this->entity_structure[$entity->entity_name]['form'])) {
                $scripts[] = $this->CI->wyvern_blocks_model->__partial('script', array('form' => $this->entity_structure[$this->entity_name]), FALSE);
            }
        }
        //nice_dump($scripts);
        return $scripts;
    }

    function render_block($block = array(), $data = array(), $render_as_variable = FALSE) { // TODO:REFACTOR move to blocks'
        if (!empty($this->page_structure['page'][$block]['partials'])) {
            foreach ($this->page_structure['page'][$block]['partials'] as $partial => $attributes) {
                if (is_array($attributes) && count($attributes)) {
                    foreach ($attributes as $attribute => $value) {
                        $data[$attribute] = $value;
                    }
                } else {
                    if ($attributes) {
                        $partial = $attributes;
                    }
                }
                $this->render_partial($partial, $data, $render_as_variable);
            }
        }
    }

    function render_partial($partials = '', $data = array(), $render_as_variable = FALSE) { // TODO:REFACTOR move to blocks
        if (is_array($partials)) {
            foreach ($partials as $partial) {
                if (empty($partial)) {
                    echo 'You made a big mistake with this batch of hooligans';
                    nice_dump($partials);
                }
                $this->__partial($partial, $data, $render_as_variable);
            }
        } else {
            $this->__partial($partials, $data, $render_as_variable);
        }
    }

    function __partial($partial = '', $data = array(), $render_as_variable = FALSE) {
        // detect if this a form
        if (strstr($partial, 'form')) {
            $file_path = INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE_NAME) . '/forms/' . $partial . '.yml';
            if (is_file($file_path)) {
                $form_structure = $this->yaml->parse_file($file_path);
                echo $this->wyvern_form_generator->create_form($form_structure, FALSE, FALSE);
            } else {
                echo "Something went wrong($file_path)";
            }
        } else {
            if ($partial) {
                $this->load->view('_partials/' . $partial, $data, $render_as_variable);
            } else {
                echo "What did you mean by? {$partial}=>";
                nice_dump($data);
            }
        }
    }

    function fetch_page_data() {

        $page_data = array();

        $page_data['page_title'] = $this->page_title;
        $page_data['body_id'] = isset($this->page_structure['body_id']) ? $this->page_structure['body_id'] : $this->body_id;
        // $page_data['page_scripts'] = $this->render_scripts();
        // TODO:DEV
        $page_data['page_keywords'] = '';
        $page_data['page_description'] = '';

        return $page_data;
    }

    function fetch_blog_page_data($page_slug) {
        return fetch_blog_page_content($page_slug);
    }

}
