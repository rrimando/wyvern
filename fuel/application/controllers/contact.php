<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');

        /* Strike A Pose */
        $this->load->model('wyvern_auth_model');
        $this->load->model('wyvern_user_model');
        $this->load->model('wyvern_page_model');

        $this->page = 'home';
    }

    function _remap($method) {
        $param_offset = 2;

        // Default to index
        if (!method_exists($this, $method)) {
            // We need one more param
            $param_offset = 1;
            $method = 'index';
        }

        // Since all we get is $method, load up everything else in the URI
        $params = array_slice($this->uri->rsegment_array(), $param_offset);

        // Call the determined method with all params
        call_user_func_array(array($this, $method), $params);
    }

    public function index($page = 'contact') {
        if (is_logged()) {
            redirect(site_url('user/' . $page));
        }

        $this->wyvern_page_model->render($page);
    }

    public function send() {

        $email_array = array();

        $excludes = array('entity_load', 'entity', 'Success');

        if (!empty($_POST)) {
            $email_array['message'] = '';
            foreach ($_POST as $key => $value) {
                if (!in_array($key, $excludes)) {
                    $email_array['message'] .= "<strong>" . ucwords(str_replace("_", " ", $key)) . "</strong>" . " : " . $this->input->post($key) . "\n";
                }
            }
        } else {
            die('Die Infidel Die!!!!'); // TODO LANG FILE
            exit;
        }

        $this->load->model('wyvern_email_model');

        $url_redirect = $this->input->post('success');

        $email_array['subject'] = "Message from " . WYVERN_SITE_NAME . " contact form";

        if (defined('WYVERN_TESTER_EMAIL')) {
            $emails = explode(',', WYVERN_TESTER_EMAIL);
        }

        $site_owners = explode(',', fetch_site_variable('site_email'));

        foreach ($site_owners as $email) {
            $emails[] = $email;
        }

        if (defined('WYVERN_ADMIN_EMAIL')) {
            $emails[] = WYVERN_ADMIN_EMAIL;
        }

        $emails[] = 'rohanrimando@pixeljump.com.ph';
        $emails[] = 'audwinabellera@pixeljump.com.ph';

        $this->wyvern_email_model->send($emails, $email_array);

        echo json_encode(
                array(
                    'callback' => 'redirect',
                    'params' => $url_redirect
                )
        );
    }

}
