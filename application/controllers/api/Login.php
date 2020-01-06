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
    
//    function signup_post() {
//        $error = "";
//        $user_id = $this->post('User_Id');
//        $role_id = $this->post('Role_Id');
//        $email = $this->post('Email');
//        $name = $this->post('Name');
//        $address = $this->post('Address');
//        if (empty($user_id)) {
//            $error = "please provide user id";
//        }
//        if (empty($role_id)) {
//            $error = "please provide role id";
//        }
//        if (empty($email)) {
//            $error = "please provide email id";
//        }
//        if (empty($name)) {
//            $error = "please provide name";
//        }
//        if (isset($error) && !empty($error)) {
//            $this->set_response([
//                'status' => false,
//                'message' => $error,
//                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
//            return;
//        } else {
//             $this->load->model("user_model");
//             
////             /echo 'hi';die;
//            $saveData = $this->user_model->update_users(array(
//                "Role_Id" => $role_id,
//                "Email" => $email,
//                "Address" => $address,
//                "Name" => $name
//
//            ),$user_id);
//            
//            $selectDataAfterUpdate = $this->user_model->getUserDataApi($user_id);
//            
//            echo '<pre>' ;print_r($selectDataAfterUpdate);die;
//            if ($selectDataAfterUpdate) {
//                $this->set_response([
//                    'status' => true,
//                    'message' => 'success',
//                    'id'=>$selectDataAfterUpdate
//                        ], REST_Controller::HTTP_OK);
//            } else {
//                $this->set_response([
//                    'status' => false,
//                    'message' => "unable to save the reply. please try again",
//                        ], REST_Controller::HTTP_BAD_REQUEST);
//            }
//        }
//    }
    
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

            ));
            $this->load->model("drive_model");
            $saveDriver = $this->drive_model->insertDriverApi(array(
                "User_Id" => $saveUser,
                "License_Number" => $driverDLNo,
                "Expiry_Date" => $ExpiryDate,
                //"vehicle_id"=>$VehicleId

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
  

}
