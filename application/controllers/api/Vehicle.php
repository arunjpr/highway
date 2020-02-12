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
        $vehicle_type_id = $this->post('vehicle_type_id');
        $vehicleNumber = $this->post('vehicleNumber');
        $vehicleDescription = $this->post('vehicleDescription');
        $vehicleModelNo = $this->post('vehicleModelNo');
        $vehicleCapacity = $this->post('vehicleCapacityId');
        $vehicleSize = $this->post('vehicleDimensionSizeId');
        if (empty($owner_id)) {
            $error = "please provide owner id";
        }   else if (empty($vehicleNumber)) {
            $error = "please provide vehicle number";
        }  else if (empty($vehicleModelNo)) {
            $error = "please provide vehicle model no";
        }  else if (empty($vehicleDescription)) {
            $error = "please provide vehicle description";
        } else if (empty($vehicle_type_id)) {
            $error = "please provide vehicle type";  
        }  else if (empty($vehicleCapacity)) {
            $error = "please provide vehicle capacity";
        } else if (empty($vehicleSize)) {
            $error = "please provide vehicle size";
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
                "v_type_id" => $vehicle_type_id,
                "v_vehicle_number" => $vehicleNumber,
                "v_vehicle_model_no" => $vehicleModelNo,
                "v_vehicle_detail" => $vehicleDescription,
                "v_vehicle_capacity" => $vehicleCapacity,
                "v_vehicle_size" => $vehicleSize,
                "v_status" =>1,
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
    function getAllVehicleDetails_post() {
        $error = "";
        $ownerId = $this->post('ownerId');
        if (empty($ownerId)) {
            $error = "please provide vehicle id";
        } 
        $this->load->model("vehicle_model");
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
                "data" => array("vehicle_details" => $this->vehicle_model->getVehicleDetailsApi($ownerId)),
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
    
    function vehicleAssignDropdown_post() {
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
                "vehicleData" => array("vehicle_data_name"=>$this->drive_model->getVehicleDropdownApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function vehicleTypeDropdown_post() {
        $error = "";
        $user_id = $this->post('user_id'); //add by owner
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("vehicle_type_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "data" => array("vehicle_data" => $this->vehicle_type_model->getVehicleDropdownApi()),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function assignDriverToVehicle_post() {
        $error = "";
        $owner_id = $this->post('owner_id');
        $driver_id = $this->post('driver_id');
        $vehicle_id = $this->post('vehicle_id');
        if (empty($owner_id)) {
            $error = "please provide owner id";
        } else if (empty($driver_id)) {
            $error = "please provide driver id";
        } else if (empty($vehicle_id)) {
            $error = "please provide vehicle id";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("assign_vehicle_to_driver_model");
            $saveData = $this->assign_vehicle_to_driver_model->addAssignDataApi(array(
                "a_v_t_d_owner_id" => $owner_id,
                "a_v_t_d_vehicle_id" => $driver_id,
                "a_v_t_d_driver_id" => $vehicle_id,
                "a_v_t_d_status" => 1,
                "a_v_t_d_add_by" => $owner_id,
                "a_v_t_d_date" =>date("Y-m-d"),
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
    
    function bookingVehicleList_post() {
        $error = "";
        $user_id = $this->post('user_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        $this->load->model("vehicle_model");
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
                "vehicleData" => array("vehicle_list" => $this->vehicle_model->getAllVehicleListApi()),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function getVehicleinfo_post() {
        $error = "";
        $user_id = $this->post('user_id');
        $vehicle_id = $this->post('vehicle_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        if (empty($vehicle_id)) {
            $error = "please provide vehicle id";
        } 
        $this->load->model("vehicle_model");
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
                "dataInfo" => array("vehicle_info" => $this->vehicle_model->getVehicleinfoApi($vehicle_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    function vehicleLoadingCapicity_post() {
        $error = "";
        $user_id = $this->post('user_id'); //add by owner
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("vehicle_load_capacity_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "loadCapicityData" => array("load_cacpacity_size_data" => $this->vehicle_load_capacity_model->getVehiclLoadCapacityDropdownApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    
    function vehicleDimensionSize_post() {
        $error = "";
        $user_id = $this->post('user_id'); //add by owner
        if (empty($user_id)) {
            $error = "please provide user id";
        }
        $this->load->model("vehicle_load_capacity_model");
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "dimansionData" => array("dimansion_size_data" => $this->vehicle_load_capacity_model->getVehicleDimensionSizeApi($user_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    function vehiclePointOnMap_post() {
        $error = "";
        $user_id = $this->post('user_id');
        $vehicle_type_id = $this->post('vehicle_type_id');
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        $this->load->model("vehicle_model");
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
                "pointData" => array("vehicle_Point" => $this->vehicle_model->getVehiclePointOnMapApi($vehicle_type_id)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    function vehicleinfo_post() {
        $error = "";
        $user_id = $this->post('user_id');
        
            
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        $this->load->model("vehicle_model");
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
                "vehicle_data" => array("vehicle_info" => $this->vehicle_model->getVehicleinfoDataApi()),
                
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    
   
    
}