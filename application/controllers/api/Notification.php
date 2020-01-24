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
class Notification extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("Push_notification_model");
        header('Content-Type: application/json');
        $this->_raw_input_stream = file_get_contents('php://input');
        
        
        
    }
    function sendPushNotification_post() {
        $error = "";
        $reciverId = $this->post('userId');
        $senderId = $this->post('senderId');
        $token = $this->post('token');
       // $token = "/topics/foo-bar";
        $message = $this->post('message');
        
        if (empty($reciverId)) {
            $error = "please provide user id";
        }   else if (empty($token)) {
            $error = "please provide token no";
        }  else if (empty($senderId)) {
            $error = "please provide sender id";
        }   
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("push_notification_model");
            $this->load->model("user_model");
            $userData = $this->user_model->getUserDetailsById($senderId);
//            $saveData = $this->push_notification_model->addPushNotificationApi(array(
//                "p_n_message" => $message,
//                "p_n_sender_id" => $senderId,
//                "p_n_receiver_id" => $reciverId,
//                "p_n_is_read" => 0,
//                "p_n_status" => 1,
//            ));
            $ch = curl_init("https://fcm.googleapis.com/fcm/send");
            $userName = $userData->Name;
            $notification = array('f_type'=>1,'type' =>1 ,'fromName' =>$userName,'gid'=>$reciverId, 'message' => $message,"id"=>$senderId,"push_chat"=>1);
            $arrayToSend = array('to' => $token,"data"=>$notification);
            $json = json_encode($arrayToSend); 
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=AAAA0NUISiU:APA91bEOlomTql-pvaqCRkpleVQC5csQ1glEfsjLKN9mP_Z5Ou9SWWFQItP4qMCLVy0tQ4ML8Lm8ynWFzXHxGisSjG_FObUDWYbCXIkabFCdl9yHtFeoT9zMbCnRWzNOAbnBWKE6MmXN';
                    
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
            curl_exec($ch);
            curl_close($ch);
            
//            if ($saveData) {
////                $this->set_response([
////                    'status' => true,
////                    'message' => 'success',
////                    'id'=>$saveData
////                        ], REST_Controller::HTTP_OK);
//            } else {
//                $this->set_response([
//                    'status' => false,
//                    'message' => "unable to save the reply. please try again",
//                        ], REST_Controller::HTTP_BAD_REQUEST);
//            }
        }
    }
   function registerPushNotification_post() {
        $error = "";
        $userId = $this->post('userId');
        $tokenId = $this->post('tokenId');
        if (empty($userId)) {
            $error = "please provide user id";
        }   else if (empty($tokenId)) {
            $error = "please provide token id";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("fb_token_model");
            $this->load->model("user_model");
            $userData = $this->user_model->getUserDetailsById($userId);
            if($userData){
            $saveData = $this->fb_token_model->addFbTokenApi(array(
                "fb_u_id" => $userId,
                "fb_token_id" => $tokenId,
                "fb_a_date" => date('Y-m-d'),
                "fb_status" => 1,
            ));
            
            
            if ($saveData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            }
            }else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    } 
   
    
}