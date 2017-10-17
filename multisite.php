<?php

/*
 * Wyvern multisite hack
 * This will allow us to load different database and use one codebase for multiple sites based on the url
 */

define('WYVERN_SITE', $_SERVER['HTTP_HOST']);

function return_ini_settings() {
    return parse_ini_file(INSTALL_ROOT . 'application/config/multisite/' . strtolower(WYVERN_SITE) . '.ini');
}
