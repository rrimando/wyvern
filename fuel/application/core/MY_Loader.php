<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require FUEL_PATH . "core/Loader.php";

class MY_Loader extends Fuel_Loader {

    function __construct() {
        parent::__construct();

        $this->_module = CI::$APP->router->fetch_module();

        //Change this property to match your new path
        if (defined('WYVERN_THEME')) {
            if (WYVERN_THEME != 'default') {
                $this->theme_path = APPPATH . 'third_party/themes/' . WYVERN_THEME . '/views/';
                define('THEME_PATH', $this->theme_path);
            }
        }
    }

    /** Load a module view * */
    public function view($view, $vars = array(), $return = FALSE, $scope = NULL, $module = NULL) {
        if (isset($this->theme_path) && is_file($this->theme_path . $view . '.php')) {
            $this->_ci_view_path = $this->theme_path;
        } else {
            list($path, $view) = Modules::find($view, $this->_module, 'views/');
            $this->_ci_view_path = $path;
        }
        
        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }

    public function is_model_loaded($name) {
        return in_array($name, $this->_ci_models, TRUE);
    }

}
