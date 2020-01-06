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
class Vehicle extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("Vehicle_model");
        header('Content-Type: application/json');
        $this->_raw_input_stream = file_get_contents('php://input');
        
        
        
    }
   function addVehicle_post() {
        $error = "";
        $owner_id = $this->post('owner_id');
        $vehicle_name = $this->post('vehicleName');
        $vehicleNumber = $this->post('vehicleNumber');
        $vehicleDescription = $this->post('vehicleDescription');
        $vehicleModelNo = $this->post('vehicleModelNo');
        if (empty($owner_id)) {
            $error = "please provide owner id";
        } else if (empty($vehicle_name)) {
            $error = "please provide vehicle name";
        }  else if (empty($vehicleNumber)) {
            $error = "please provide vehicle number";
        }  else if (empty($vehicleModelNo)) {
            $error = "please provide vehicle model no";
        }  else if (empty($vehicleDescription)) {
            $error = "please provide vehicle description";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
             $this->load->model("vehicle_model");
            $saveUserAnswer = $this->vehicle_model->addVehicleApi(array(
                "v_owner_id" => $owner_id,
                "v_vehicle_name" => $vehicle_name,
                "v_vehicle_number" => $vehicleNumber,
                "v_vehicle_model_no" => $vehicleModelNo,
                "v_vehicle_detail" => $vehicleDescription,

            ));
            if ($saveUserAnswer) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveUserAnswer
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
   
     function vehicleDetails_get() {
        $error = "";
        $Data = json_decode(file_get_contents('php://input'),true);
        $vehicleId = $Data['vehicleId'];
        if (empty($vehicleId)) {
            $error = "please provide vehicle id";
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
                "data" => array("vehicle_details" => $this->vehicle_model->getVehicleDetailsApi($vehicleId)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    function driverDropdown_post() {
        $error = "";
        $user_id = $this->post('user_id'); //add by owner
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("drive_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("driver_data" => $this->drive_model->getDriverDropdownApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function vehicleDropdown_post() {
        $error = "";
        $user_id = $this->post('user_id'); //add by owner
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("drive_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("vehicle_data" => $this->drive_model->getVehicleDropdownApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
}