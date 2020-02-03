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
class Booking extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("book_trip_link_model");
        header('Content-Type: application/json');
        $this->_raw_input_stream = file_get_contents('php://input');
        
        
        
    }
     
    function confirmBookingApi_post() {
        $error = "";
        $customer_id = $this->post('User_id');
        $vehicleType = $this->post('VehicleId'); // vehicle type ID
        $trip_reciver_id = $this->post('TripRecevirId');
        $goodsType_id = $this->post('GoodsTypeId');
        $start_latitude = $this->post('SourceLat');
        $start_longitude = $this->post('SourceLong');
        $end_latitude = $this->post('DestLat');
        $end_longitude = $this->post('DestLong');
        $tripFare = $this->post('TripFare');
        $couponId = $this->post('CouponId');
        $sourceAddress = $this->post('sourceAddress');
        $destAddress = $this->post('destAddress');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($vehicleType)) {
            $error = "please provide vehicle type";
        } else if (empty($trip_reciver_id)) {
            $error = "please provide trip recvier id";
        }  else if (empty($trip_reciver_id)) {
            $error = "please provide reciver contact";
        } else if (empty($goodsType_id)) {
            $error = "please provide goods type";
        } else if (empty($start_latitude)) {
            $error = "please provide pickup location";
        } else if (empty($start_longitude)) {
            $error = "please provide pickup location";
        } else if (empty($end_latitude)) {
            $error = "please provide drop location";
        } else if (empty($end_longitude)) {
            $error = "please provide drop locatoion";
        }  else if (empty($tripFare)) {
            $error = "please provide fare";
        } else if (empty($sourceAddress)) {
            $error = "please provide source Address";
        } else if (empty($destAddress)) {
            $error = "please provide destination Address";
        }
        
        $this->load->model("book_trip_link_model");
        $this->load->model("book_trip_fare_model");
        $this->load->model("trip_model");
        $this->load->model("role_model");
        $this->load->model("coupon_model");
        $this->load->model("mobile_token_model");
        
        $couponData = $this->coupon_model->getCouponByCupanID($couponId);
        // echo '<pre>' ;print_r($couponData[0]->c_id); die;
        if($couponData){
            $cupan_id=$couponData[0]->c_id;
           
        } else {
            $cupan_id =0;
        }
        
        
        
        $userDetails = $this->role_model->geUserDetailsById($customer_id);
       // echo '<pre>' ;print_r($userDetails->Name);die;
        $userRole = $this->role_model->getroleByUserid($customer_id);
        $roleId=$userRole->Role_Id;
//        if($roleId==2){
//        $tripType = $this->post('TripType');
//            if (empty($tripType)) {
//                $error = "please provide trip type";
//            }
//        }
//        if($roleId==4){
//          $tripType = 1;
//            
//        }
        //$roleName=$userRole->Title;
        
       // echo '<pre>' ;print_r($userRole->Title);die;
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $t_trip_id='#HIG'.rand(1000, 9999);
         
            if(($roleId==2) or ($roleId==4)){
                $trip_id = $this->trip_model->addTripApi(array(
                "t_user_Id" => $customer_id,
                "t_type" => 1,
                "t_trip_id" => $t_trip_id,
                "t_start_latitude"=>$start_latitude,
                "t_start_longitude"=>$start_longitude,
                "t_end_latitude"=>$end_latitude,
                "t_end_longitude"=>$end_longitude,
                "t_status"=>1,
                "t_active_status"=>1,
                "t_add_by" => $customer_id,
                "t_source_address"=>$sourceAddress,
                "t_destination_address" => $destAddress,    
                "t_add_date" =>date("Y-m-d"),
            ));
            $saveBookFareId = $this->book_trip_fare_model->addBookingFareApi(array(
                "b_t_f_trip_id" => $trip_id,
                "b_t_f_user_id" => $customer_id,
                "b_t_f_fare" => $tripFare,
                "b_t_f_status" => 1,
                "b_t_f_add_by" => $customer_id,
                "b_t_f_date" =>date("Y-m-d"),
            ));
            
            $saveData = $this->book_trip_link_model->addConfirmBookingApi(array(
                "b_l_t_trip_id" => $trip_id,
                "b_l_t_customer_id" => $customer_id,
                "b_l_t_reciver_id" => 1,
                "b_l_t_vehicle_type" => $vehicleType,
                "b_l_t_goodsType_id" => $goodsType_id,
                "b_l_t_fare_id" => $saveBookFareId,
                "b_l_t_coupon_id" => $cupan_id,
                "b_l_t_status" => 1,
                "b_l_t_active_status" => 1,
                "b_l_t_add_by" => $customer_id,
                "b_l_t_date" =>date("Y-m-d"),
            ));
            if (($saveData) && ($saveBookFareId) && ($trip_id)) {
                
    //==================push notification start====================// 
        if($userDetails){        
        $this->load->model("mobile_token_model");
        $mobileTokenData = $this->mobile_token_model->getMobileTokenData($vehicleType);
       // echo '<pre>' ;print_r($vehicleType);
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
        'title' => 'Trip Added',
        'body' => array(
                'message' => 'Trip Add By Customer: ',
                'customer' => $userDetails->Name,
                'mobile' => $userDetails->Mobile, 
                'type' => 'TRIP_NEW', 
            )
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
}
//echo $result;
 //==================push notification End====================//               
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$t_trip_id
                        ], REST_Controller::HTTP_OK);
            }
            else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            } else {
                if($roleId!=2){
                $this->set_response([
                    'status' => false,
                    'message' => 'You are not MillUser',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                }
                if($roleId!=4){
                $this->set_response([
                    'status' => false,
                    'message' => 'You are not Customer',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }
    function cancelTripCommentApi_post() {
        $error = "";
        $customer_id = $this->post('user_id');
        $cancel_book_trip_id = $this->post('cancel_book_trip_id');
        $cancel_reason_id = $this->post('cancel_reason_id');
        $cancel_reason_comment = $this->post('cancel_reason_comment');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($cancel_book_trip_id)) {
            $error = "please provide trip id";
        } else if (empty($cancel_reason_id)) {
            $error = "please provide cancel reson id";
        } else if (empty($cancel_reason_comment)) {
            $error = "please provide cancel reason comment";
        }  
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("cancel_trip_reason_model");
            $saveData = $this->cancel_trip_reason_model->addCancelTripReasonCommentApi(array(
                "c_t_r_booking_trip_id" => $cancel_book_trip_id,
                "c_t_r_reason_id" => $cancel_reason_id,
                "c_t_r_reason_comment" => $cancel_reason_comment,
                "c_t_r_status" => 1,
                "c_t_r_add_by" => $customer_id,
                "c_t_r_date" =>date("Y-m-d"),
            ));
            if ($saveData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function bookTripDetails_post() {
        $error = "";
        $user_id = $this->post('user_id');
        $booking_trip_id = $this->post('booking_trip_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        if (empty($booking_trip_id)) {
            $error = "please provide booking id";
        } 
        $this->load->model("book_trip_link_model");
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
                "bookTripData" => array("booking_trip_details" => $this->book_trip_link_model->getBookTripDetailsApi()),
                    ], REST_Controller::HTTP_OK);
        }
    }
}
function applyCoupon_post() {
        $error = "";
        $coupon = $this->post('coupon');
        if (empty($coupon)) {
            $error = "please provide coupon";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("coupon_model");
             $couponData = $this->coupon_model->getCouponData($coupon);
             if($couponData){
             $couponId= $couponData[0]->c_id;
             //echo '<pre>' ;print_r($couponData[0]->c_id);die;
            
            
            $updateData = $this->coupon_model->updateCouponApi(array(
                "c_coupan_status" => 2
                ),$couponId);
            if ($updateData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$updateData
                        ], REST_Controller::HTTP_OK);
            }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "invalid coupon code",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    
    function acceptBookTrip_post() {
        $error = "";
        $bookTripId = $this->post('tripId');
        $userId = $this->post('userId');
        $accepTReject = $this->post('acceptReject'); //acceptReject
        if (empty($bookTripId)) {
            $error = "please provide trip id";
        } else if (empty($userId)) {
            $error = "please provide user id";
        }  else if (empty($accepTReject)) {
            $error = "please provide accept or reject";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
              $this->load->model("book_trip_link_model");
              $this->load->model("accept_booking_trip_model");
              $this->load->model("user_model");
              $this->load->model("assign_vehicle_to_driver_model");
              
              $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
              if($checkRole[0]->Role_Id==3){
              $driverData = $this->assign_vehicle_to_driver_model->geDriverDetailsById($userId); 
              if($driverData){
                $atripData = $this->accept_booking_trip_model->getAcceptTripData($bookTripId,$userId);
            //echo '<pre>' ;print_r($driverData->a_v_t_d_driver_id);die;
            if($atripData){
                $acceptTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $accepTReject,
                "a_b_t_status" => 1,
                ),$bookTripId,$userId);
            }else {
                $acceptTripData = $this->accept_booking_trip_model->getAcceptBookingTripApi(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $accepTReject,    
                "a_b_t_status" => 1,
                "a_b_t_add_by" => $userId,
                "a_b_t_date" => date("Y-m-d")
                )); 
            }
                 
            
if($accepTReject=='TRIP_ACCEPTED'){
            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                "b_l_t_status"=>1,
                "b_l_t_vehicle_id"=>$driverData->a_v_t_d_vehicle_id,
                "b_l_t_driver_id"=>$driverData->a_v_t_d_driver_id,
            ),$bookTripId);
                  
                
                //==================push notification start====================//
$tripData = $this->book_trip_link_model->getBookTripDetailsByTripIdApi($bookTripId,$userId);
    if($tripData){    
        $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($tripData['customerId']);
        //echo '<pre>' ;print_r($customerMobileToken); die;
        $mobileTokenData = $this->mobile_token_model->getMobileTokenData($tripData['vehicleTypeId'],$userId);
 //echo '<pre>' ;print_r($mobileTokenData); die;
//echo $result;
if($customerMobileToken){  
   define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
    $msg = array('message'=> 'here is a message. message','title'=>'This is a title. title','subtitle'=>'This is a subtitle. subtitle','tickerText'=>'Ticker text here...Ticker text here...Ticker text here','vibrate'=>1,'sound'=>1,'largeIcon'=>'large_icon','smallIcon'=>'small_icon');
    

  switch ($accepTReject) {
    case "TRIP_ACCEPTED":
     $fields = array('registration_ids' => $customerMobileToken,'data' => $msg,'priority' => 'high',
    'notification' => array(
        'title' => $accepTReject,
        'body' => array('message' => $accepTReject,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$accepTReject))
        );
    break;
    case "TRIP_ACCEPTED":
    $fields = array('registration_ids' => $mobileTokenData,'data' => $msg,'priority' => 'high',
    'notification' => array(
        'title' => $accepTReject,
        'body' => array('message' => $accepTReject,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$accepTReject))
        );
    break;
    case "TRIP_CANCEL":
        $fields = array('registration_ids' => $mobileTokenData,'data' => $msg,'priority' => 'high',
    'notification' => array(
        'title' => $accepTReject,
        'body' => array('message' => $accepTReject,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$accepTReject))
        );
    case "TRIP_CANCEL":
        $fields = array('registration_ids' => $customerMobileToken,'data' => $msg,'priority' => 'high',
    'notification' => array(
        'title' => $accepTReject,
        'body' => array('message' => $accepTReject,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$accepTReject))
        );
        break;
   }
   
   
    $headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    curl_exec($ch );
    curl_close( $ch );
}
}
}





 //==================push notification End====================// 

        if ($acceptTripData) {
            $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'driverVehicleDetails'=>$tripData
                        ], REST_Controller::HTTP_OK);
            }
             else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
              }
           }else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not a driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function startTripDriver_post() {
        $error = "";
        $userId = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $startTime = $this->post('startTime');
        $startDate = $this->post('startDate');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        } else if (empty($startTime)) {
            $error = "please provide start time";
        } else if (empty($startDate)) {
            $error = "please provide start date";
        } 
        else if (empty($userId)) {
            $error = "please provide user id";
        } else if (empty($tripStatus)) {
            $error = "please provide trip status";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
             $booktrip_id= $bookTripData[0]->b_l_t_id;
             $updateData = $this->accept_booking_trip_model->addStartTripByDriverApi(array(
                "a_b_t_start_time" => $startTime,
                "a_b_t_start_date" => $startDate,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_add_by" => $userId,
                ),$booktrip_id,$userId);
             $driverData = $this->assign_vehicle_to_driver_model->geDriverTripStartData($userId,$bookTripId); 
              if($driverData){
                  $vehicleId=$driverData['vehicleId'];
                  if($tripStatus=='TRIP_START'){
            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                "b_l_t_status"=>2,
                "b_l_t_vehicle_id"=>$vehicleId,
            ),$bookTripId);
                  }
            if (($updateData) && ($bookStatusUpdate)) {
                $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
         if($customerMobileToken){  
        
        
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
    'registration_ids' => $customerMobileToken,
    'data' => $msg,
    'priority' => 'high',
    'notification' => array(
        'title' => $tripStatus,
        'body' => array(
                'message' => $tripStatus,
                'startTime' => $driverData['satrtTime'],
                'startDate' => $driverData['startDate'],
                'driver' => $driverData['driverName'],
                'driver' => $driverData['driverName'],
                'mobile' => $driverData['driverMobile'], 
                'type' => $tripStatus, 
            )
        
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
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'startTripDetails'=>$driverData
                        ], REST_Controller::HTTP_OK);
            }
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
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function endTripDriver_post() {
        $error = "";
        $userId = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $endTime = $this->post('endTime');
        $endDate = $this->post('endDate');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        } else if (empty($endTime)) {
            $error = "please provide end time";
        } else if (empty($endDate)) {
            $error = "please provide end date";
        } 
        else if (empty($userId)) {
            $error = "please provide user id";
        } else if (empty($tripStatus)) {
            $error = "please provide trip status";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
             $booktrip_id= $bookTripData[0]->b_l_t_id;
             $updateData = $this->accept_booking_trip_model->addStartTripByDriverApi(array(
                "a_b_t_end_time" => $endTime,
                "a_b_t_end_date" => $endDate,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_add_by" => $userId,
                ),$booktrip_id,$userId);
             $driverData = $this->assign_vehicle_to_driver_model->geDriverTripEndData($userId,$bookTripId); 
              if($driverData){
            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                "b_l_t_status"=>$tripStatus,
            ),$bookTripId);
            if (($updateData) && ($bookStatusUpdate)) {
                $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
         if($customerMobileToken){  
        
        
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
    'registration_ids' => $customerMobileToken,
    'data' => $msg,
    'priority' => 'high',
    'notification' => array(
        'title' => $tripStatus,
        'body' => array(
                'message' => $tripStatus,
                'endTime' => $driverData['endTime'],
                'endDate' => $driverData['endDate'],
                'driver' => $driverData['driverName'],
                'driver' => $driverData['driverName'],
                'mobile' => $driverData['driverMobile'], 
                'type' => $tripStatus, 
            )
        
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
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'endTripDetails'=>$driverData
                        ], REST_Controller::HTTP_OK);
            }
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
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}