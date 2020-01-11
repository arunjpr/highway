<?php
class Vehicle_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }


    
//    public  function get_users($user_id,$username) {
//        $this->db->where([
//                'Id'=>$user_id,
//                'Name'=>$username
//                ]);
//        $query =$this->db->get('users');
//        return $query->result();
//    }
//    
//    public function create_users($data){
//        $this->db->insert('users',$data);
//    }
//    public function update_users($data,$id){
//        $this->db->where(['Id'=>$id]);
//        $this->db->update('users',$data);
//    }
//    public function delete_user($id){
//        $this->db->where(['Id'=>$id]);
//        $this->db->delete('users');
//    }
//    function getUserList($user_id) {
//        $this->db->select(array("*"))
//                ->from("users")
//                ->where(array("users.Id" => $user_id, "users.Status" => 1));
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result();
//        } else {
//            return array();
//        }
//    }
    
    
    
    function addVehicleApi($data) {
        $this->db->insert("vehicle", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
            //return true;
        } else {
            return false;
        }
    }
    
      public  function getVehicleDetailsApi() {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('drive_license', 'vehicle.v_Id=drive_license.vehicle_id')
                ->join('users', 'users.Id=drive_license.User_Id')
                ->where(array("users.Status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['VehicleName']=$row->v_vehicle_name ;
                    $cat[$counter]['VehicleNumber']=$row->v_vehicle_number ;
                    $cat[$counter]['VehicleModelNo']=$row->v_vehicle_model_no;
                    $cat[$counter]['VehicleDescription']=$row->v_vehicle_detail;
                    $cat[$counter]['DriverId']=$row->Id;
                    $cat[$counter]['DriverName']=$row->Name;
                    $cat[$counter]['Mobile']=$row->Mobile;
                    $cat[$counter]['Email']=$row->Email;
                    $cat[$counter]['DLNumber']=$row->License_Number;
                    $cat[$counter]['ExpiryDate']=$row->Expiry_Date;
                    $cat[$counter]['Address']=$row->Address;
                    $cat[$counter]['Latitude']=$row->Latitude;
                    $cat[$counter]['Longitude']=$row->Longitude;
                    
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByCustomerApi($userId,$status) {
        $this->db->select(array("*"))
                ->from("tbl_trip")
                ->join('vehicle', 'vehicle.v_Id=tbl_trip.t_vehicle_id')
                ->join('users', 'users.Id=vehicle.v_vehicle_driver_id')
                ->join('roles', 'users.Role_Id=roles.Id')
                ->where(array("tbl_trip.t_user_Id" => $userId ,"tbl_trip.t_status" => $status ,"users.Status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_vehicle_number;
                    $cat[$counter]['fare']=$row->t_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    $cat[$counter]['startDate']=$row->t_start_date;
                    $cat[$counter]['endDate']=$row->t_end_date;
                    $cat[$counter]['pickupTime']=$row->t_start_time;
                    $cat[$counter]['dropTime']=$row->t_end_time;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByMillUserApi($userId,$status) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_trip', 'vehicle.v_Id=tbl_trip.t_vehicle_id')
                ->join('users', 'users.Id=tbl_trip.t_user_Id')
                ->join('roles', 'users.Role_Id=roles.Id')
                ->where(array("vehicle.v_owner_id" => $userId ,"vehicle.v_status" => $status ,"users.status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_vehicle_name;
                    $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;
                    $cat[$counter]['fare']=$row->t_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    $cat[$counter]['startDate']=$row->t_start_date;
                    $cat[$counter]['endDate']=$row->t_end_date;
                    $cat[$counter]['pickupTime']=$row->t_start_time;
                    $cat[$counter]['dropTime']=$row->t_end_time;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByDriverApi($userId,$status) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_trip','vehicle.v_Id=tbl_trip.t_vehicle_id')
                ->join('users', 'users.Id=tbl_trip.t_user_Id')
                ->join('roles', 'users.Role_Id=roles.Id')
                ->where(array("vehicle.v_vehicle_driver_id" => $userId ,"vehicle.v_status" => $status ,"users.Status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_vehicle_name;   
                    $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;
                    $cat[$counter]['fare']=$row->t_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    $cat[$counter]['startDate']=$row->t_start_date;
                    $cat[$counter]['endDate']=$row->t_end_date;
                    $cat[$counter]['pickupTime']=$row->t_start_time;
                    $cat[$counter]['dropTime']=$row->t_end_time;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByOwnerApi($userId,$status) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_trip', 'vehicle.v_Id=tbl_trip.t_vehicle_id')
                ->join('users', 'users.Id=tbl_trip.t_user_Id')
                ->join('roles', 'users.Role_Id=roles.Id')
                ->where(array("vehicle.v_owner_id" => $userId ,"tbl_trip.t_status" => $status,"vehicle.v_status" =>1,"users.Status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_vehicle_name;   
                    $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;
                    $cat[$counter]['fare']=$row->t_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    $cat[$counter]['startDate']=$row->t_start_date;
                    $cat[$counter]['endDate']=$row->t_end_date;
                    $cat[$counter]['pickupTime']=$row->t_start_time;
                    $cat[$counter]['dropTime']=$row->t_end_time;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllVehicleListApi() {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_vehicle_type', 'vehicle.v_type_id=tbl_vehicle_type.v_t_id','left')
                ->where(array("vehicle.v_status" => 1,"vehicle.v_delete" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $vehicleImage = base_url()."assets/backend/img/vehicle/vehicleImage/$row->v_vehicle_Image";
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                    $cat[$counter]['VehicleImage']=$vehicleImage ;
                    
                    
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getVehicleinfoApi($vehicle_id) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_vehicle_type', 'vehicle.v_type_id=tbl_vehicle_type.v_t_id','left')
                ->where(array("vehicle.v_status" => 1,"vehicle.v_delete" => 0,"vehicle.v_Id" => $vehicle_id));
        $query = $this->db->get();
       /// echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                
                $this->db->select(array('v_i_information'))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
                $query_result = $this->db->get();
                $vinfo= $query_result->result();
                foreach($data as $row){
                    //$vehicleImage = base_url()."assets/backend/img/vehicle/vehicleImage/$row->v_vehicle_Image";
                    $cat[$counter]['VehicleId']=$row->v_Id ;
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                  //  $cat[$counter]['VehicleImage']=$vehicleImage ;
                    $cat[$counter]['VehicleCapacity']=$row->v_vehicle_capacity ;
                    $cat[$counter]['VehicleSize']=$row->v_vehicle_size;
                    $cat[$counter]['v_info1']=$vinfo[0]->v_i_information;
                    $cat[$counter]['v_info2']=$vinfo[1]->v_i_information;
                    $cat[$counter]['v_info3']=$vinfo[2]->v_i_information;
                    $cat[$counter]['v_info4']=$vinfo[3]->v_i_information;
                    $cat[$counter]['v_info5']=$vinfo[4]->v_i_information;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function vehicleInfoApi() {
        $this->db->select(array("*"))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
        $query = $this->db->get();
        $data= $query->result();
      //  echo '<pre>' ;print_r($data[0]->v_i_information);die;
       //echo  $this->db->last_query();die;
        $cat = array();
         if($query->num_rows() > 0){
                    $cat['v_info1']=$vinfo[0]->v_i_information;
                    $cat['v_info2']=$vinfo[1]->v_i_information;
                    $cat['v_info3']=$vinfo[2]->v_i_information;
                    $cat['v_info4']=$vinfo[3]->v_i_information;
                    $cat['v_info5']=$vinfo[4]->v_i_information;
                    return $cat;
            } else {
            return array();
        }
    }
}
