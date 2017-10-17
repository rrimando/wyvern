<?php

// TODO: DEV


/* For Fetch Site Variables */
function fetch_site_variable($variable = 'all', $entity = 'site') {
    $entity = defined('WYVERN_SITE_SETTINGS') ? WYVERN_SITE_SETTINGS : $entity;
    // TODO THROW THIS INTO THE CONSTANTS

    $CI = & get_instance();
    // Blog Specific 

    if (!isset($CI->{$entity})) {
        $CI->load->model('wyvern_entity_model', $entity)->init($entity);
    }
    $values = $CI->{$entity}->fetch();

    if ($variable == 'all') {
        return $values;
    }

    if (isset($values[0][$variable])) {
        return $values[0][$variable];
    } else {
        return false;
    }
}

/* For Fetch Site Variables */

function fetch_page_content($page_name, $page_part, $entity = 'page') {

    // TODO THROW THIS INTO THE CONSTANTS

    $ci = & get_instance();
    $ci->load->model('wyvern_entity_model', $entity)->init($entity);
    $values = $ci->{$entity}->fetch(array('page_slug' => $page_name));

    if (isset($values[0][$page_part])) {
        return $values[0][$page_part];
    } else {
        return false;
    }
}

// Just incase we make a different kind of "Page"
function fetch_blog_page_content($page_slug, $entity = 'page') {
    // TODO THROW THIS INTO THE CONSTANTS

    $ci = & get_instance();
    $ci->load->model('wyvern_entity_model', $entity)->init($entity);
    $values = $ci->{$entity}->fetch(array('page_slug' => $page_slug));

    if (isset($values[0]['page_slug'])) {
        return $values[0];
    } else {
        return false;
    }
}
