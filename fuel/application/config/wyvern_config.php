<?php

$config['model_map'] = array(
    'auth' => 'wyvern_auth_model',
    'user' => 'wyvern_user_model',
    'entity' => 'wyvern_entity_model'
);

// TODO: DEV This should coincides with the entity so - it might be a site var
// include(WYVERN_SITE/config.php)

$config['fuel_users_structure'] = array( 
    'user_name' => 'email_address',
    'password' => 'password',
    'first_name' => '',
    'last_name' => '',
    'email' => 'email_address',
    'language' => 'english',
    'reset_key' => '',
    'salt' => 'salt',
    'super_admin' => 'no',
    'active' => 'yes',
    'entity' => 'entity'
);
        

$config['fuel_users_table'] = 'fuel_users';

