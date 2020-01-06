<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Files extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }

    function index_get() {
        $books = array();
        $this->set_response([
            'status' => TRUE,
            'response' => $books,
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
    }

    function profile_post() {
        $this->upload();
    }
    
    function kyc_post() {
        $this->upload("kyc");
    }

    private function upload($path = "upload/profile") {
        $user = $this->_user ? $this->_user->id : null;
        $config['upload_path'] = "./{$path}/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload("file")) {
            $this->set_response([
                'status' => FALSE,
                'message' => $this->upload->display_errors(),
                    ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $filename = $this->upload->data('file_name');
        $url = site_url($path . '/' . $filename);


        $this->set_response([
            'status' => TRUE,
            'message' => "File uploaded successfully",
            'response' => [
                "url" => $url
            ],
                ], REST_Controller::HTTP_CREATED);
    }

    private function generateThumbnail($source, $filename = "", $width = 0, $height = 0) {
        $data = file_get_contents($source);
        /* store image in server */
        $new = "thumb-" . $height . 'x' . $width . '-' . $filename;
        /* Write the contents back to a new file */
//        file_put_contents($new, $data);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = FCPATH . "uploads/" . $new;
        $config['thumb_marker'] = '';
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();


        return array(
            "filepath" => $config['new_image'],
            "url" => site_url("uploads/" . $new)
        );
    }

}
