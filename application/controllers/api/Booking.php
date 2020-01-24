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
//        $trip_id = $this->post('trip_id');
        $vehicle_id = $this->post('VehicleId');
        $trip_reciver_id = $this->post('TripRecevirId');
        $goodsType_id = $this->post('GoodsTypeId');
        $start_latitude = $this->post('SourceLat');
        $start_longitude = $this->post('SourceLong');
        $end_latitude = $this->post('DestLat');
        $end_longitude = $this->post('DestLong');
        $start_date = $this->post('STripDate');
        $end_date = $this->post('ETripDate');
        $start_time = $this->post('STripTime');
        $end_time = $this->post('ETripTime');
        $tripFare = $this->post('TripFare');
        $tripStatus = $this->post('TripStatus');
        $couponId = $this->post('CouponId');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($vehicle_id)) {
            $error = "please provide vehicle id";
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
        } else if (empty($start_date)) {
            $error = "please provide start date";
        } else if (empty($end_date)) {
            $error = "please provide end date";
        } else if (empty($start_time)) {
            $error = "please provide start time";
        } else if (empty($end_time)) {
            $error = "please provide end time";
        } else if (empty($tripFare)) {
            $error = "please provide fare";
        } else if (empty($tripStatus)) {
            $error = "please provide status";
        }
        
        $this->load->model("book_trip_link_model");
        $this->load->model("book_trip_fare_model");
        $this->load->model("trip_model");
        $this->load->model("role_model");
        $this->load->model("coupon_model");
        
        $couponData = $this->coupon_model->getCouponByCupanID($couponId);
        // echo '<pre>' ;print_r($couponData[0]->c_id); die;
        if($couponData){
            $cupan_id=$couponData[0]->c_id;
           
        } else {
            $cupan_id =0;
        }
        
        
        
        $userRole = $this->role_model->getroleByUserid($customer_id);
        $roleId=$userRole->Role_Id;
        if($roleId==2){
        $tripType = $this->post('TripType');
            if (empty($tripType)) {
                $error = "please provide trip type";
            }
        }
        if($roleId==4){
          $tripType = 1;
            
        }
        //$roleName=$userRole->Title;
        
       // echo '<pre>' ;print_r($userRole->Title);die;
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            
            if(($roleId==2) or ($roleId==4)){
                $trip_id = $this->trip_model->addTripApi(array(
                "t_user_Id" => $customer_id,
                "t_type" => $tripType,
                //"t_vehicle_id" => $vehicle_id,
                "t_start_latitude"=>$start_latitude,
                "t_start_longitude"=>$start_longitude,
                "t_end_latitude"=>$end_latitude,
                "t_end_longitude"=>$end_longitude,
                "t_status"=>1,
                "t_active_status"=>1,
                "t_start_date"=>$start_date,
                "t_end_date"=>$end_date,
                "t_start_time"=>$start_time,
                "t_end_time"=>$end_time,
                "t_add_by" => $customer_id,
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
                "b_l_t_vehicle_id" => $vehicle_id,
                "b_l_t_goodsType_id" => $goodsType_id,
                "b_l_t_fare_id" => $saveBookFareId,
                "b_l_t_coupon_id" => $cupan_id,
                "b_l_t_status" => 1,
                "b_l_t_active_status" => 1,
                "b_l_t_add_by" => $customer_id,
                "b_l_t_date" =>date("Y-m-d"),
            ));
            if (($saveData) && ($saveBookFareId) && ($trip_id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
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
}