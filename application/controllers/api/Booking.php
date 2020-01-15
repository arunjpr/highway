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
        $customer_id = $this->post('user_id');
        $trip_id = $this->post('trip_id');
        $vehicle_id = $this->post('vehicle_id');
        $trip_reciver_id = $this->post('trip_reciver_id');
        $goodsType_id = $this->post('goods_type_id');
        $tripFare = $this->post('tripFare');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($trip_id)) {
            $error = "please provide trip id";
        } else if (empty($vehicle_id)) {
            $error = "please provide vehicle id";
        } else if (empty($trip_reciver_id)) {
            $error = "please provide trip recvier id";
        } else if (empty($tripFare)) {
            $error = "please provide fare id";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("book_trip_fare_model");
            $saveBookFareId = $this->book_trip_fare_model->addBookingFareApi(array(
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
                "b_l_t_status" => 1,
                "b_l_t_active_status" => 1,
                "b_l_t_add_by" => $customer_id,
                "b_l_t_date" =>date("Y-m-d"),
            ));
            if (($saveData) && ($saveBookFareId)) {
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
    
}