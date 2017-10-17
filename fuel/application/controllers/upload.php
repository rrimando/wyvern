<?php

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('wyvern_files_model');
        $this->load->helper('url');
    }

    public function index() {
        die("Look behind you... Kill the infidel!");
    }

    public function upload_file() {
        /*
          Uploadify
          Copyright (c) 2012 Reactive Apps, Ronnie Garcia
          Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
         */

        // Define a destination
        $targetFolder = WYVERN_UPLOADS_PATH; // Relative to the root

        if (isset($_POST['timestamp']) && isset($_POST['token'])) {
            $verifyToken = md5('unique_salt' . $_POST['timestamp']);
            if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
                
            } else {
                die("You can't do that :D");
            }
        }

        // File extensions
        $allowedTypes = isset($_POST['allowed_types']) ? explode(",", $_POST['allowed_types']) : array('jpg', 'jpeg', 'gif', 'png');

        $tempFile = $_FILES['Filedata']['tmp_name'];

        if (strpos(WYVERN_BASE_URL, '.local')) {
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/wyvern/" . $targetFolder;
        } else {
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/wyvern/" . $targetFolder;
        }
        // Validate the file type
        $fileParts = pathinfo($_FILES['Filedata']['name']);

        //New Filename 
        $newFileName = strtolower(WYVERN_SITE_NAME) . '_' . time() . '.' . $fileParts['extension'];
        $targetFile = $targetPath . '/' . $newFileName;

        // Multiple Input Identifier
        $identity = isset($_POST['identity']) ? $this->input->post('identity') : '';

        // TODO Better Naming Convention

        if (in_array(strtolower($fileParts['extension']), $allowedTypes)) {
            move_uploaded_file($tempFile, $targetFile);
            $image_id = $this->wyvern_files_model->create($newFileName, $title = 'File:' . WYVERN_SITE_NAME);
            echo json_encode(
                    array(
                        'id' => $image_id,
                        'filename' => $newFileName,
                        'identity' => $identity
                    )
            );
        } else {
            echo json_encode(array(
                'callback' => 'error',
                'params' => 'Invalid file type.'
            ));
        }
    }

    public function check_file_exists() {
        /*
          Uploadify
          Copyright (c) 2012 Reactive Apps, Ronnie Garcia
          Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
         */

        // Define a destination
        $targetFolder = WYVERN_UPLOADS_PATH; // Relative to the root and should match the upload folder in the uploader script

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delete_file($file_id) {
        if ($this->files_model->delete_file($file_id)) {
            $status = 'success';
            $msg = 'File successfully deleted';
        } else {
            $status = 'error';
            $msg = 'Something went wrong when deleteing the file, please try again';
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function generate_token() {
        $str = $this->input->post('tokenize');
        $token = md5('unique_salt' . $str);
        echo json_encode(array('token' => $token));
    }
    
    public function generate_upload_element($id, $value_id) {
        // TODO
    }
}
