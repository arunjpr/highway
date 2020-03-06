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
    
     function login_register_post() {
        $error = "";
            $Mobile = $this->post('Mobile');
            $RoleId = $this->post('RoleId');
        if (empty($Mobile)) {
            $error = "Please Enter your valid Mobile";
        }
         if (empty($RoleId)) {
            $error = "plese provided user roleId";
        }
        $Otp=rand(10000, 99999);
        $this->load->model("user_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        
        } else {
            $checkUserRole = $this->user_model->getCheckUserRole($Mobile);
        if($checkUserRole){
            if(($Mobile==$checkUserRole->Mobile) && ($RoleId==$checkUserRole->Role_Id)){
                $updateUser = $this->user_model->update_users_mobile(array(
                "Otp" => $Otp,
                "Otp_Status" => 0,
            ),$Mobile,$RoleId);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms24.infonetservices.in/API/WebSMS/Http/v1.0a/index.php?username=medeg&password=631616&sender=DNAAPP&to=$Mobile&message=Please+enter+your+otp:+$Otp+for+verify+your+mobile+number.&reqid=1&format={json|text}&route_id=197");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);  
            if ($updateUser) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Otp sent successfully on your mobile number',
                    'Mobile'=>$updateUser
                        ], REST_Controller::HTTP_OK);
                
                
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            
            } 
                
                    
        } 
            if(($Mobile==$checkUserRole->Mobile) && ($RoleId!=$checkUserRole->Role_Id)){
                $this->set_response([
                    'status' => false,
                    'message' => "You Are allready register with $checkUserRole->Title",
                        ], REST_Controller::HTTP_BAD_REQUEST);
                }
        }
        else{
            $insertMobile = $this->user_model->insertUserApi(array(
                "Mobile" => $Mobile,
                "Role_Id" => $RoleId,
                "Otp" => $Otp,
                "u_date" => date("Y-m-d")
               
            ));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://sms24.infonetservices.in/API/WebSMS/Http/v1.0a/index.php?username=medeg&password=631616&sender=DNAAPP&to=$Mobile&message=Please+enter+your+otp:+$Otp+for+verify+your+mobile+number.&reqid=1&format={json|text}&route_id=197");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            if($insertMobile) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Otp sent successfully on your mobile number',
                    'id'=>$insertMobile
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        } 
            
        
        }
    }
    
    
    function otp_verify_post() {
        $error = "";
            $Mobile = $this->post('Mobile');
           // $Mobile = $this->post('Mobile');
            
            $Otp = $this->post('Otp');
        if (empty($Mobile)) {
            $error = "Please Enter your valid Mobile";
        }
        if (empty($Otp)) {
            $error = "Please Enter your valid otp";
        }
        $this->load->model("user_model");
        $data = $this->user_model->getOtpData($Mobile);
        $otpStatus = $data[0]->Otp_Status;
        $otpData = $data[0]->Otp;
       // echo '<pre>' ;print_r($data);die;
       
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
           
            if($otpStatus==1){
             $this->set_response([
                    'status' => false,
                    'message' => "Your Otp expired",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            
            
            } 
            
            else if($otpData==$Otp){
                $updateUser = $this->user_model->update_otp_status(array(
                "Otp_Status" => 1,
                //"Status" => 1,
            ),$Mobile,$Otp);
            
              
            if ($updateUser) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Otp Verified',
                    'user'=>$this->user_model->getUserOtpDataApi($Mobile),
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
                } 
             
            
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "Your otp is not valid",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            
            
            }
           
        }
    }
    
    function signup_post() {
        $error = "";
        $user_id = $this->post('User_Id');
      //  $Role_Id = $this->post('Role_Id');
        $Email = $this->post('Email');
        $Name = $this->post('Name');
       // $Address = $this->post('Address');
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        // if (empty($Role_Id)) {
        //     $error = "please provide role id";
        // } 
        if (empty($Email)) {
            $error = "please provide email";
        } 
        if (empty($Name)) {
            $error = "please provide name";
        } 
        // if (empty($Address)) {
        //     $error = "please provide address";
        // } 
        $this->load->model("user_model");
        if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $updateUser = $this->user_model->update_signup_data(array(
               // "Role_Id" => $Role_Id,
                "Name" => $Name,
                "Email" => $Email,
                //"Address" => $Address,
                "Status" => 1,
                 "u_date"=>date("Y-m-d")
            ),$user_id);
            
              
            if ($updateUser) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Successfully Signup',
                    'user'=>$this->user_model->getSignupDataApi($user_id),
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
                } 
            
            
          
            
        }
    }
  
}
