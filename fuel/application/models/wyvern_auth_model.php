<?php

/**
 * Description of Wyvern_Auth_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Auth_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->init();
    }

    function init() {
        $this->load->model('wyvern_user_model');
    }

    public function login($data = array(), $echo_json = true) {

        // Form Validation With Codeigniter
        $username = $data['username'];
        $password = $data['password'];
        $site_url = site_url();

        $moderator = $this->moderator_login($username, $password);
        $admin = $this->admin_login($username, $password);

        // Try admin log in
        if ($admin) {
            $response = array(
                'auth' => 'Admin',
                'callback' => 'redirect',
                'params' => $site_url
            );
        } elseif ($moderator) {
            $response = array(
                'auth' => 'Moderator',
                'callback' => 'redirect',
                'params' => $site_url
            );
        } else {
            $response = $this->wyvern_user_model->login($username, $password, $echo_json);
        }


        if (!is_array($response)) {
            if ($response) {
                $login_response = array(
                    'auth' => $response,
                    'callback' => 'redirect',
                    'params' => $site_url
                );
            } else {
                // TODO:DEV Error Handling
                $error = "There was an error logging you in!";

                $login_response = array(
                    'auth' => $response,
                    'callback' => 'error',
                    'params' => $error
                );
            }
        } else {
            $login_response = $response;
        }

        if ($echo_json) {
            echo json_encode($login_response);
        } else {
            return $login_response['auth'];
        }
    }

    function admin_login($username = '', $password = '') {
        $response = false;

        if (defined('WYVERN_ADMIN_USERNAME') && defined('WYVERN_ADMIN_PASSWORD')) {
            if ($username = WYVERN_ADMIN_USERNAME && $password == WYVERN_ADMIN_PASSWORD) {
                $response = $this->wyvern_user_model->admin_login($username, $password);
            }
        }

        return $response;
    }

    function moderator_login($username = '', $password = '') {
        $response = false;

        if (defined('WYVERN_MODERATOR_USERNAME') && defined('WYVERN_MODERATOR_PASSWORD')) {
            if ($username = WYVERN_MODERATOR_USERNAME && $password == WYVERN_MODERATOR_PASSWORD) {
                $response = $this->wyvern_user_model->moderator_login($username, $password);
            }
        }

        return $response;
    }

    function is_logged() {
        return $this->wyvern_user_model->is_logged_in();
    }

    function is_admin_logged() {
        return $this->wyvern_user_model->is_admin_logged_in();
    }

    function logout() {
        $this->wyvern_user_model->logout();

        redirect(site_url());
    }

    /* Check Session */

    //This function checks your session 
    function check_session() {
        if (defined('WYVERN_SESSION_CHECK') && (WYVERN_SESSION_CHECK)) {
            $id = $this->session->userdata('fuel_user_id');
            if ($id) {
                // nice_dump($this->session->userdata);
                echo 1;
            } else {
                echo 0; //redirect from here or you can redirect in the ajax response
            }
        } else {
            echo 1;
        }
    }

}
