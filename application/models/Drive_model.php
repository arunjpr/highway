<?php
class Drive_model extends CI_Model {
    
public function insertDriverApi($data) {
        $this->db->insert("drive_license", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
public function getDriverDetailsApi($ownerId) {
        $this->db->select(array("*"))
                ->from("drive_license")
                ->join('vehicle', 'vehicle.v_Id=drive_license.vehicle_id')
                ->join('users', 'users.Id=drive_license.User_Id')
                ->where(array("vehicle.v_owner_id" => $ownerId, "users.Status" => 1,"users.deletion_status" => 0));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['DriverId']=$row->Id;
                    $cat[$counter]['DriverName']=$row->Name;
                    $cat[$counter]['Name']=$row->Name;
                    $cat[$counter]['Mobile']=$row->Mobile;
                    $cat[$counter]['Email']=$row->Email;
                    $cat[$counter]['DLNumber']=$row->License_Number;
                    $cat[$counter]['ExpiryDate']=$row->Expiry_Date;
                    $cat[$counter]['Address']=$row->Address;
                    $cat[$counter]['Latitude']=$row->Latitude;
                    $cat[$counter]['Longitude']=$row->Longitude;
                    $cat[$counter]['VehicleName']=$row->v_vehicle_name ;
                    $cat[$counter]['VehicleName']=$row->v_vehicle_name ;
                    $cat[$counter]['VehicleNumber']=$row->v_vehicle_number ;
                    $cat[$counter]['VehicleModelNo']=$row->v_vehicle_model_no 	 ;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
public function getDriverDropdownApi($user_id) {
         $this->db->select(array("*"))
                ->from("users")
                 ->where(array("users.Id" => $user_id, "users.Status" => 1,'deletion_status'=>0));
        $queryData = $this->db->get();
        if($queryData->num_rows() > 0){
            $this->db->where([
                'Role_Id'=>3,
                'deletion_status'=>0,
                ]);
            $query =$this->db->get('users');
            if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['DriverId']='';
                    $cat[$counter]['DriverName']='';
                    $cat[$counter]['DriverId']=$row->Id;
                    $cat[$counter]['DriverName']=$row->Name;
                    $counter++;
                }
                return $cat;
            }
        
        } else {
            return array();
        }
         
        
    }
public function getVehicleDropdownApi($user_id) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_vehicle_type','vehicle.v_type_id=tbl_vehicle_type.v_t_id')
                ->where(array("vehicle.v_owner_id" => $user_id, "vehicle.v_status" => 1,"vehicle.v_delete" => 0));
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['VehicleId']='';
                $cat[$counter]['VehicleName']='';
                $cat[$counter]['VehicleId']=$row->v_Id;
                $cat[$counter]['VehicleName']=$row->v_t_vehicle_name;
                $counter++;
            }
            return $cat;
        }
    }
}
