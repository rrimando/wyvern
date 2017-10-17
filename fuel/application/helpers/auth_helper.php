<?php

/* User Level */

function is_logged() {
    $CI = & get_instance();
    $CI->load->model('wyvern_auth_model');

    return $CI->wyvern_auth_model->is_logged();
}

function is_admin_logged() {
    $CI = & get_instance();
    $CI->load->model('wyvern_auth_model');

    return $CI->wyvern_auth_model->is_admin_logged();
}

/* Admin Level */


