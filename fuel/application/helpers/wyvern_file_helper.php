<?php

function get_file($id, $url = false) {

    $CI = & get_instance();

    if (!($CI->load->is_model_loaded('wyvern_files_model'))) {
        $CI->load->model('wyvern_files_model');
    }
    $file = $CI->load->model('wyvern_files_model')->fetch(array('id' => $id));


    /* TODO Determine File Type 
     * only works on images for now
     */
    if (!isset($file[0]['filename'])) {
        return false;
    }

    $file_url = WYVERN_ROOT_FOLDER . WYVERN_UPLOADS_PATH . $file[0]['filename'];

    // nice_dump(is_file($file_url));
    // nice_dump($file_url);

    if (!is_file($file_url)) {
        return false;
    }

    if ($url) {
        return base_url() . 'assets/' . strtolower(WYVERN_SITE_NAME) . '/uploads/' . $file[0]['filename'];
    } else {
        if (isset($file[0])) {
            if (exif_imagetype($file_url)) {
                return make_image($file[0]['filename']);
            } else {
                return make_download_link($file[0]['filename']);
            }
        }
    }
}

function make_image($file, $alt = WYVERN_SITE_NAME, $class = 'image', $id = '', $variable = false) {
    $CI = & get_instance();

    if (!($CI->load->is_model_loaded('wyvern_blocks_model'))) {
        $CI->load->model('wyvern_blocks_model');
    }

    $image = array(
        'path' => base_url() . 'assets/' . strtolower(WYVERN_SITE_NAME) . '/uploads/' . $file,
        'alt' => $alt,
        'class' => $class,
        'id' => $id
    );

    return $CI->load->model('wyvern_blocks_model')->__partial('image', $image, $variable);
}

function make_download_link($file, $class = '', $id = '', $variable = false) {
    $CI = & get_instance();

    if (!($CI->load->is_model_loaded('wyvern_blocks_model'))) {
        $CI->load->model('wyvern_blocks_model');
    }

    $file = array(
        'path' => base_url() . 'assets/' . strtolower(WYVERN_SITE_NAME) . '/uploads/' . $file,
        'class' => $class,
        'id' => $id
    );

    return $CI->load->model('wyvern_blocks_model')->__partial('file', $file, $variable);
}
