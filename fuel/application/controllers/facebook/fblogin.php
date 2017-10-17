<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

require_once 'autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

class FBLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /* Load The Helpful */
        $this->load->helper('debug_helper');
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

    public function index($usertype = WYVERN_DEFAULT_USER_TYPE) {
        if (!is_logged()) {
            // added in v4.0.0
            // start session
            session_start();
            // init app with app id and secret
            FacebookSession::setDefaultApplication(WYVERN_FACEBOOK_APP_ID, WYVERN_FACEBOOK_APP_SECRET);

            // login helper with redirect_uri
            $helper = new FacebookRedirectLoginHelper(site_url('facebook/fblogin/' . $usertype));

            try {
                $session = $helper->getSessionFromRedirect();
            } catch (FacebookRequestException $ex) {
                // When Facebook returns an error
            } catch (Exception $ex) {
                // When validation fails or other local issues
            }

            // see if we have a session
            if (isset($session)) {
                
                $usertype_url_segment = ($this->uri->segment(3))?$this->uri->segment(3):$usertype;
                
                $this->load->model('wyvern_user_model');

                $request = new FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();

                // get response
                $graphObject = $response->getGraphObject();

                $fbid = $graphObject->getProperty('id');           // To Get Facebook ID
                $fbuname = $graphObject->getProperty('username');  // To Get Facebook Username
                $fbfullname = $graphObject->getProperty('name');   // To Get Facebook full name
                $fbemail = $graphObject->getProperty('email');     // To Get Facebook email ID
                $fblink = $graphObject->getProperty('link');

                if ($this->wyvern_user_model->check_if_email_exists($fbid)) {
                    // Login user
                    $this->load->model('wyvern_auth_model');
                    $this->wyvern_auth_model->login(array('username' => $fbid, 'password' => md5($fbid)), false);
                } else {
                    // Create user - password is username MD5'd
                    $this->wyvern_user_model->register(array(
                        'entity' => 'user',
                        'fullname' => $fbfullname,
                        'email_address' => $fbid,
                        'password' => md5($fbid),
                        'user_name' => $fbid,
                        'facebook_link' => $fblink,
                        'facebook_id' => $fbid,
                        'registration_step' => 'create',
                        'next' => 'home',
                        'usertype' => $usertype_url_segment), false
                    );
                }

                // Redirect to home
                redirect(site_url());
            } else {
                // show login url
                redirect($helper->getLoginUrl());
            }
        } else {
            redirect(site_url());
        }
    }

}
