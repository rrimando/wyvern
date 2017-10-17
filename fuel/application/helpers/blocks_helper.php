<?php

function parse_shortcode() {
    // TODO:DEV Enable Shortcodes To Display Blocks
}

function wyvern_clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function truncate($str, $char_length) {
    return substr($str, 0, $char_length);
}
