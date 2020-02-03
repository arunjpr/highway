<?php
class Mobile_token_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    public function getVehicleTypeData($vehicle_id){
        $this->db->select(array('v_type_id'))
        ->from('vehicle v')
        ->join('tbl_vehicle_type vt', 'v.v_type_id=vt.v_t_id','left');
       if(isset($vehicle_id)>0){
           $this->db->where(array(
               "vt.v_t_status" => 1,
               "vt.v_t_delete" => 0,
               "v.v_Id"=>$vehicle_id,
               "v.v_status"=>1,
                   ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    } 
    public function getMobileTokenData($vehicleTypeId,$userId){
        $this->db->select(array('f.fb_token_id','f.fb_u_id'))
        ->from('tbl_fb_token f')
        ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_driver_id=f.fb_u_id','left')       
        ->join('vehicle v', 'v.v_Id=a.a_v_t_d_vehicle_id','left')
        ->join('users u', 'u.Id=a.a_v_t_d_driver_id','left');
        if(isset($vehicleTypeId)>0){
           $this->db->where(array(
               "f.fb_status" => 1,
               "a.a_v_t_d_status" => 1,
               "a.a_v_t_d_delete" => 0,
               "v.v_type_id"=>$vehicleTypeId,
               "u.Status"=>1,
               "u.deletion_status"=>0,
                   ));
        }
         $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=$ubniqueUser = array();
                foreach($data as $row){
                    if($row->fb_u_id!=$userId){
                        $cat[$counter]=$row->fb_token_id ;
                       
                    }
                    $counter++;
                }
                return $cat;
                
            } else {
            return array();
        }
    }
     public function getCustomerTokenById($userId) {
        $this->db->select(array("fb_token_id"))
                ->from('tbl_fb_token f')
                ->join('users u', 'u.Id=f.fb_u_id','left');
        if(isset($userId)){
                $this->db->where(array(
                    "u.Id" => $userId,
                    "u.Status" => 1,
                    "u.deletion_status" => 0,
                    "f.fb_status" => 1
                    )
                        );
        }
        $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat= array();
                foreach($data as $row){
                    $cat[$counter]=$row->fb_token_id ;
                    $counter++;
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
}
