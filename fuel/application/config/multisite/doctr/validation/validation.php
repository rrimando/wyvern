<?php

$validation['registration'] = array(
               array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'passconf', 
                     'label'   => 'Password Confirmation', 
                     'rules'   => 'required'
                  ),   
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'required'
                  )
            );

$this->form_validation->set_rules($config);