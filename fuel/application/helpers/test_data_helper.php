<?php

/* Microphone Check */

function generate_data($type = 'string', $params = 1) {
    switch ($type):
        case 'string':
            $data = generate_string($params);
            break;
        case 'textarea':
            $data = generate_textarea();
            break;
        case 'date':
            $data = generate_date();
            break;
        case 'serial':
            $data = generate_serial();
            break;
        case 'file':
            $data = generate_image();
            break;
        default:
            $data = generate_string($params);
            break;
    endswitch;

    return $data;
}

function generate_image() {
    $images = array(
        'http://imgsv.imaging.nikon.com/lineup/lens/zoom/normalzoom/af-s_dx_18-300mmf_35-56g_ed_vr/img/sample/sample4_l.jpg',
        'http://imgsv.imaging.nikon.com/lineup/lens/zoom/normalzoom/af-s_dx_18-140mmf_35-56g_ed_vr/img/sample/sample1_l.jpg',
        'http://www.ricoh-imaging.co.jp/english/r_dc/r/r8/img/sample_08.jpg',
        'http://www.forkingandcountry.com/sites/g/files/g2000004371/f/sample_03.jpg',
        'http://www.dunbartutoring.com/wp-content/themes/thesis/rotator/sample-1.jpg'
    );
    return $images[rand(0, 4)];
}

function generate_string($word_count = 1) {
    $string = '';
    $count = 0;
    while ($count <= $word_count):
        $string .= random_word() . " ";
        $count++;
    endwhile;

    return trim($string);
}

function generate_textarea($chars = 200) {
    return truncate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', $chars);
}

function generate_date() {
    $day = rand(1, 365);
    $timestamp = abs(time()) - $day * 24 * 60 * 60;
    return date('Y-m-d h:s:i', $timestamp);
}

function generate_serial() {
    return strtoupper(uniqid());
}

function random_word() {
    $rand = rand(0, 37);
    $words = array(
        'Monkey',
        'Girraffe',
        'Lion',
        'Doodle',
        'Pinkerton',
        'Nini',
        'Glass',
        'Cigarette',
        'Boy',
        'Paper',
        'Wire',
        'Gin',
        'Bat',
        'Vader',
        'Jack',
        'Finn',
        'Beemo',
        'Camera',
        'Guy',
        'McDoodlydpp',
        'Van',
        'Dredd',
        'Keys',
        'Brush',
        'Plug',
        'Vandersen',
        'Harddisk',
        'Screen',
        'Toothbrush',
        'Speed',
        'Cartoon',
        'Vehicle',
        'Curly',
        'Hair Doodle',
        'Pencil',
        'Pen',
        'Clock',
        'Coin'
    );

    return $words[$rand];
}
