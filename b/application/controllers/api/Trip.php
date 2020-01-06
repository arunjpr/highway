<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Trip extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("User_model");
    }
    function userlist_get() {
        $error = "";
        $user_id = $this->get('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("user_list" => $this->User_model->getUserList($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    
    function goodType_post() {
        $error = "";
       // $Data = json_decode(file_get_contents('php://input'),true);
      //  $user_id = $Data['user_id'];
      
      
        $user_id = $this->post('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("good_type_data" => $this->Goodtype_model->getGoodTypeDataApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function approxLoad_post() {
        $error = "";
       // $Data = json_decode(file_get_contents('php://input'),true);
       // $user_id = $Data['user_id'];
        
        
        $user_id = $this->post('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("approx_load_data" => $this->Goodtype_model->getApproxLoadDataApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }

  

}
