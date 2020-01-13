<?php
class Assign_vehicle_to_driver_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }

//    public function getAssignUniqeDriverAndVehicleData($user_id) {
//        $this->db->select(array("*"))
//                ->from("tbl_assign_vehicle_to_driver")
//                ->where(array(
//                    "a_v_t_d_owner_id" => $user_id,
////                    "a_v_t_d_vehicle_id" => $vehicle_id,
////                    "a_v_t_d_driver_id" => $driver_id,
//                    "a_v_t_d_status" => 1,
//                    "a_v_t_d_delete" => 0,
//                    ))
//                ;
//        $query = $this->db->get();
//        $result= $query->result_array();
//         if($query->num_rows() > 0){
//                    return $result;
//         } else {
//             return array();
//         }
//}
    
    
    function addAssignDataApi($data) {
        $this->db->insert("tbl_assign_vehicle_to_driver", $data);
        if ($this->db->insert_id()> 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
   
    
      
    
    
    
    
   
}
