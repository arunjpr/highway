<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author Pawan Nagar <pawan.nagar@docquity.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Login extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("User_model");
        header('Content-Type: application/json');
    }
    function userlist_get() {
        $error = "";
        header('Content-Type: application/json');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $user_id = trim($request->User_Id);
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
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
    

    
    function otp_verify_post() {
    
    }
    
   function addDriver_post() {
        $error = "";
        $owner_id = $this->post('owner_id');
        $driverName = $this->post('driverName');
        $driverMobile = $this->post('driverMobile');
        $driverEmail = $this->post('driverEmail');
        $driverDLNo = $this->post('driverDLNo');
        $driverAddress = $this->post('driverAddress');
        $ExpiryDate = $this->post('dlexpiryDate');
       // $VehicleId = $this->post('vehicleId');
        if (empty($owner_id)) {
            $error = "please provide owner id";
        } else if (empty($driverName)) {
            $error = "please provide driver name";
        }  else if (empty($driverMobile)) {
            $error = "please provide driver mobile number";
        }  else if (empty($driverEmail)) {
            $error = "please provide driver email";
        }  else if (empty($driverDLNo)) {
            $error = "please provide driver dl no";
        }  else if (empty($driverAddress)) {
            $error = "please provide driver address";
        
        } else if (empty($ExpiryDate)) {
            $error = "please provide driver license expiry date";
        
        } 
        // else if (empty($VehicleId)) {
        //     $error = "please provide vehicle id";
        
        // }
        $roleId = 5;
        $this->load->model("user_model");
        $data = $this->user_model->getUserData($owner_id,$roleId);
       // echo '<pre>' ;print_r($data);die;
        
        if($data){
            if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            
            
               
            $saveUser = $this->user_model->insertUserApi(array(
                "Role_id" => 3,
                "Name" => $driverName,
                "Email" => $driverEmail,
                "Mobile" => $driverMobile,
                "Address" => $driverAddress,
                "add_by" => $owner_id,

            ));
            $this->load->model("drive_model");
            $saveDriver = $this->drive_model->insertDriverApi(array(
                "User_Id" => $saveUser,
                "License_Number" => $driverDLNo,
                "Expiry_Date" => $ExpiryDate,

            ));
           // echo '' ;print_r($saveUser) ;die;
            if (($saveUser) && ($saveDriver)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveDriver
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
             }
        } else {
                $this->set_response([
                    'status' => false,
                    'message' => "you are not owner",
                        ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
     function getAlldriverDetails_post() {
        $error = "";
        $ownerId = $this->post('ownerId');
        if (empty($ownerId)) {
            $error = "please provide owner id ";
        } 
        $this->load->model("drive_model");
        if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("driver_details" => $this->drive_model->getDriverDetailsApi($ownerId)),
                    ], REST_Controller::HTTP_OK);
            
           
        }
    }
    function updateReceiver_post() { //when user add book trip after user add receiver details
        $error = "";
        $user_id = $this->post('user_id');
        $receiverName = $this->post('receiverName');
        $receiverMobile = $this->post('receiverMobile');
        if (empty($user_id)) {
            $error = "please provide user id";
        } else if (empty($receiverName)) {
            $error = "please receiver name";
        }  else if (empty($receiverMobile)) {
            $error = "please provide receiver mobile number";
        } 
        $this->load->model("user_model");
        $this->load->model("receiver_user_model");
        $data = $this->user_model->getUserDetailsById($user_id);
        $allRole = array(4,5);
        $roleId = $data->Role_Id;
        
        $allmobileData = $this->user_model->getUserDetailsByMobile($receiverMobile);
        //echo '<pre>' ;print_r($data);die;
        if($data){
            if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
           if(in_array($roleId, $allRole)){
            
        if($receiverMobile==$data->Mobile){
            $saveUser = $user_id;
        } else {
            if(!$allmobileData){
            $saveUser = $this->user_model->insertUserApi(array(
                "Name" => $receiverName,
                "Mobile" => $receiverMobile,
                "Status" => 1,
                "Role_id"=>$data->Role_Id,
                "add_by"=>$user_id,
                ));
            } else {
              $saveUser = $allmobileData->Id;  
            }
        }
        $receiveUser = $this->receiver_user_model->insertReceiverApi(array(
                "r_u_user_id" => $user_id,
                "r_u_trip_receiver_user_id" => $saveUser,
                "r_u_status" => 1,
                "r_u_delete" => 0,
                "r_u_add_by" => $user_id,
                "r_u_date" => date("Y-m-d"),
                ));
        
        
        
        if(($saveUser) && ($receiveUser)) {
            $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$receiveUser
                    ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
             }
        }
        } else {
                $this->set_response([
                    'status' => false,
                    'message' => "you are not customer",
                        ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    function confirmReceiver_post() { //when user add book trip after user add receiver details
        $error = "";
        $user_id = $this->post('user_id');
        $receive_user_primary_id = $this->post('receive_user_id');
        $receiverName = $this->post('receiverName');
        $receiverMobile = $this->post('receiverMobile');
        if (empty($user_id)) {
            $error = "please provide user id";
        } else if (empty($receiverName)) {
            $error = "please receiver name";
        }  else if (empty($receiverMobile)) {
            $error = "please provide receiver mobile number";
        
        }  else if (empty($receive_user_primary_id)) {
            $error = "please provide receive user id";
        }
        
        $this->load->model("user_model");
        $data = $this->user_model->getUserAddBy($user_id,$receiverMobile);
        $allRole = array(4,5);
        $roleId = $data->Role_Id;

    

          
        $this->load->model("receiver_user_model");
        $receiverData = $this->receiver_user_model->getReceiverById($receive_user_primary_id);
        $receiverUserId = $receiverData->r_u_trip_receiver_user_id;
  
        
        if($data){
            if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            
        if(in_array($roleId, $allRole)){
            $saveUser = $this->user_model->update_users(array(
                "Name" => $receiverName,
                "Mobile" => $receiverMobile,
                "edit_by"=>$user_id,
            ),$receiverUserId);
            $receiveUser = $this->receiver_user_model->update_receiver_user(array(
                "r_u_user_id" => $user_id,
                "r_u_trip_receiver_user_id" => $receiverUserId,
                "r_u_edit_by" => $user_id,
                ),$receive_user_primary_id);
             //echo '<pre>' ;print_r($receiverUserId) ;die;
        if(($receiveUser) && ($saveUser)) {
            $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$receiveUser
                    ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to Update the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
             }
             
        }
        } else {
                $this->set_response([
                    'status' => false,
                    'message' => "you are not customer",
                        ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
  
}
