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
     public  function getDriverDetailsApi($user_id) {
        $this->db->select(array("*"))
                ->from("drive_license")
                ->join('users', 'users.Id=drive_license.User_Id')
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
     public  function getDriverDropdownApi($user_id) {
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
    
    public  function getVehicleDropdownApi($user_id) {
        $this->db->where([
                'v_owner_id'=>$user_id,
                'v_status'=>1,
                'v_delete'=>0,
                ]);
        $query =$this->db->get('vehicle');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['VehicleId']='';
                $cat[$counter]['VehicleName']='';
                $cat[$counter]['VehicleId']=$row->v_Id;
                $cat[$counter]['VehicleName']=$row->v_vehicle_name;
                $counter++;
            }
            return $cat;
        }
    }
   
}
