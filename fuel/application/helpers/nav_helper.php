<?php

/* Top Level */

function get_top_level($str, $delimiter) {
    $exploded = explode($delimiter, $str);
    return end($exploded);
}
