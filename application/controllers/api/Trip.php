<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Trip extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("User_model");
    }
    function userlist_post() {
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

function getAllTripByUserId_post() {
        $error = "";
        $user_id = $this->post('User_Id');
        if($user_id>0){
            $userData=$this->User_model->getCheckUserRoleByUserId($user_id);
            
            if (empty($userData)) {
                $error = "your role not active";
            }
        }
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
            $roleId=$userData[0]->Role_Id;
            switch ($roleId) {
            case "1":
                $roleName = 'Admin';
                
                break;
            case "2":
                $roleName = 'MillUser';
               
                break;
            case "3":
                $roleName = 'Driver';
              
                break;
            case "4":
                $roleName = 'Customer';
                
                break;
            case "5":
                $roleName = 'Owner';
                break;
            }
            if($roleId==2){
                
            $this->set_response([
                'status' => true,
                "data" => array(
                    "upcomingTrips" => $this->Vehicle_model->getAllTripByMillUserApi($user_id,1),
                    "ongoingTrips" => $this->Vehicle_model->getAllTripByMillUserApi($user_id,2),
                    "completedTrips" => $this->Vehicle_model->getAllTripByMillUserApi($user_id,3),
                    "cancelTrips" => $this->Vehicle_model->getAllTripByMillUserApi($user_id,4),
                    ),
                    ], REST_Controller::HTTP_OK);
            }
            if($roleId==3){
            $this->set_response([
                'status' => true,
                "data" => array(
                    "upcomingTrips" => $this->Vehicle_model->getAllTripByDriverApi($user_id,1),
                    "ongoingTrips" => $this->Vehicle_model->getAllTripByDriverApi($user_id,2),
                    "completedTrips" => $this->Vehicle_model->getAllTripByDriverApi($user_id,3),
                    "cancelTrips" => $this->Vehicle_model->getAllTripByDriverApi($user_id,4),
                    ),
                    ], REST_Controller::HTTP_OK);
            }
            if($roleId==4){
            $this->set_response([
                'status' => true,
                "data" => array(
                    "upcomingTrips" => $this->Vehicle_model->getAllTripByCustomerApi($user_id,1),
                    "ongoingTrips" => $this->Vehicle_model->getAllTripByCustomerApi($user_id,2),
                    "completedTrips" => $this->Vehicle_model->getAllTripByCustomerApi($user_id,3),
                    "cancelTrips" => $this->Vehicle_model->getAllTripByCustomerApi($user_id,4),
                    ),
                    ], REST_Controller::HTTP_OK);
            }
            if($roleId==5){
                
            $this->set_response([
                'status' => true,
                "data" => array(
                    "upcomingTrips" => $this->Vehicle_model->getAllTripByOwnerApi($user_id,1),
                    "ongoingTrips" => $this->Vehicle_model->getAllTripByOwnerApi($user_id,2),
                    "completedTrips" => $this->Vehicle_model->getAllTripByOwnerApi($user_id,3),
                    "cancelTrips" => $this->Vehicle_model->getAllTripByOwnerApi($user_id,4),
                    ),
                    ], REST_Controller::HTTP_OK);
            }
        }
    }
function selectYourGoodType_post() {
        $error = "";
        $user_id = $this->post('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("Goodtype_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "typeData" => array("good_type_data" => $this->Goodtype_model->getGoodTypeListApi()),
                    ], REST_Controller::HTTP_OK);
        }
    }
function cancelTripReason_post(){
        $error = "";
        $user_id = $this->post('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("cancel_trip_reason_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("cancelTripReson" => $this->cancel_trip_reason_model->getCancelTripReasonApi()),
                    ], REST_Controller::HTTP_OK);
        }
    }
  

}
