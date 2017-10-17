<?php

/**
 * Description of Wyvern_Email_Model
 * This handles all object related entities a site might need
 * 
 * 
 * @author Rohan Rimando
 */
class Wyvern_Email_Model extends MY_Model {

    function __construct() {
        parent::__construct();

        $this->init();
    }

    function init() {

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $this->headers = $headers;
    }

    public function send($recipients = array(), $email_data = array()) {

        /* TODO: Design Email Templates */
        
        foreach ($recipients as $recipient) {
            // Additional headers
            $headers = 'To: <' . $recipient . '>' . "\r\n";
            $headers .= 'From: Wyvern<wyvern@pixeljumpstudios.com>' . "\r\n";

            $this->headers .= $headers;

            mail($recipient, $email_data['subject'], nl2br($email_data['message']), $this->headers);
        }
    }

}
