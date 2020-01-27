<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author Arun Saini <arunsaini230290@gmail.com>
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
//    function sendPushNotification_post() {
//        $error = "";
//        $reciverId = $this->post('userId');
//        $senderId = $this->post('senderId');
//        $token = $this->post('token');
//       // $token = "/topics/foo-bar";
//        $message = $this->post('message');
//        
//        if (empty($reciverId)) {
//            $error = "please provide user id";
//        }   else if (empty($token)) {
//            $error = "please provide token no";
//        }  else if (empty($senderId)) {
//            $error = "please provide sender id";
//        }   
//        if (isset($error) && !empty($error)) {
//            $this->set_response([
//                'status' => false,
//                'message' => $error,
//                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
//            return;
//        } else {
//            $this->load->model("push_notification_model");
//            $this->load->model("user_model");
//          //  $userData = $this->user_model->getUserDetailsById($senderId);
////            $saveData = $this->push_notification_model->addPushNotificationApi(array(
////                "p_n_message" => $message,
////                "p_n_sender_id" => $senderId,
////                "p_n_receiver_id" => $reciverId,
////                "p_n_is_read" => 0,
////                "p_n_status" => 1,
////            ));
//            $ch = curl_init("https://fcm.googleapis.com/fcm/send");
//            //$userName = $userData->Name;
//            $notification = array('f_type'=>1,'type' =>1 ,'gid'=>$reciverId, 'message' => $message,"id"=>$senderId,"push_chat"=>1);
//            $arrayToSend = array('to' => $token,"data"=>$notification);
//            $json = json_encode($arrayToSend); 
//            $headers = array();
//            $headers[] = 'Content-Type: application/json';
//            $headers[] = 'Authorization: key=AAAA0NUISiU:APA91bEOlomTql-pvaqCRkpleVQC5csQ1glEfsjLKN9mP_Z5Ou9SWWFQItP4qMCLVy0tQ4ML8Lm8ynWFzXHxGisSjG_FObUDWYbCXIkabFCdl9yHtFeoT9zMbCnRWzNOAbnBWKE6MmXN';
//                    
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
//            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
//            curl_exec($ch);
//            curl_close($ch);
//            
////            if ($saveData) {
//////                $this->set_response([
//////                    'status' => true,
//////                    'message' => 'success',
//////                    'id'=>$saveData
//////                        ], REST_Controller::HTTP_OK);
////            } else {
////                $this->set_response([
////                    'status' => false,
////                    'message' => "unable to save the reply. please try again",
////                        ], REST_Controller::HTTP_BAD_REQUEST);
////            }
//        }
//    }
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
            $tokenData = $this->fb_token_model->mobileTokenData($userId);
            if($tokenData){
            $saveData = $this->fb_token_model->updateFbTokenApi(array(
                "fb_u_id" => $userId,
                "fb_token_id" => $tokenId
            ),$userId);
            } else { 
            $saveData = $this->fb_token_model->addFbTokenApi(array(
                "fb_u_id" => $userId,
                "fb_token_id" => $tokenId,
                "fb_a_date" => date('Y-m-d'),
                "fb_status" => 1,
            ));
            }
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
   
//    function send_post() {
//        $error = "";
//        $reciverId = $this->post('userId');
//        $senderId = $this->post('senderId');
//        $token = $this->post('token');
//       // $token = "/topics/foo-bar";
//        //$message = $this->post('message');
//        
//        if (empty($reciverId)) {
//            $error = "please provide user id";
//        }   else if (empty($token)) {
//            $error = "please provide token no";
//        }  else if (empty($senderId)) {
//            $error = "please provide sender id";
//        }   
//        if (isset($error) && !empty($error)) {
//            $this->set_response([
//                'status' => false,
//                'message' => $error,
//                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
//            return;
//        } else {
//            
//
//            
//            
//            
//            $to = '';
//            $data = array();
//            $apiKey='AIzaSyBoH1bdpkcHbaWMhAncynbIbpgqS2F-6t8';
//              $fields =array('to'=>$to,'notification'=>$data);  
//              $headers=array('Authorization: key='.$apiKey,'Content-Type: application/json');
//              $url ="https://fcm.googleapis.com/fcm/send";
//              $ch=curl_int();
//              curl_setopt($ch, CURLOPT_URL, $url);
//              curl_setopt($ch, CURLOPT_POST, true);
//              curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//              
//              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//              $result = curl_exec($ch);
//              curl_close($ch);
//              return json_decode($result, true);
//            
//            
//            
//            
//        
//        }
//        
//        $to ='eWa4F5Ps0mM:APA91bErd8PMQUW7web7H7eQ18saP3SLrdHWl93L6uXW48F1T5BKWT21Qif2gszU7LKEpWe_zZwyCRZwll_UM2KKWmomX6Qu0ABIUeMsoGZbQHMG3IkmQuZ8l-kX6h73MGsxK8ui1o3e';
//        
//        $data= array(
//            'body'=>'test by arun'
//        );
//        print_r(send($to,$data));
//    }
//    
    function sendPush_post(){
        $this->load->model("mobile_token_model");
        $vehicleType = $this->mobile_token_model->getVehicleTypeData(1);
        $vtypeId = $vehicleType[0]->v_type_id;
        $mobileTokenData = $this->mobile_token_model->getMobileTokenData($vtypeId);
      //  echo '<pre>' ;print_r($mobileTokenData);
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
   $msg = array
(
	'message' 	=> 'here is a message. message',
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);
$fields = array
(
    'registration_ids' => $mobileTokenData,
    'data' => $msg,
    'priority' => 'high',
    'notification' => array(
        'title' => 'This is title',
        'body' => 'This is body'
    )
);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
//echo $result; 
    }
    
}