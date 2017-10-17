<?php

/*
 *
 */

/**
 * Debug Helper for Developers
 *
 * @author Rohan Rimando
 */
function display_constants() {
    echo "<pre>";
    var_dump(get_defined_constants(true));
    echo "</pre>";
}

function nice_dump($array = array()) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}

function _lq() {
    $CI = & get_instance();
    echo $CI->db->last_query();
}

function exit_dump($array = array()) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
    exit;
}


function session_dump($array = array()) {
    $ci = & get_instance();
    
    echo "<pre>";
    var_dump($ci->session->userdata);
    echo "</pre>";
}

function json_dump($array = array()) {
    echo json_encode($array);
}

function dandy() {
    echo "We are dandy =)";
}

function randy() {
    echo "We are not dandy =(";
}
