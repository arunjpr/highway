<?php
class Assign_vehicle_to_driver_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }

    
    
    function addAssignDataApi($data) {
        $this->db->insert("tbl_assign_vehicle_to_driver", $data);
        if ($this->db->insert_id()> 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
   
    public function geDriverDetailsById($user_id) {
        $this->db->select(array('a.a_v_t_d_driver_id'))
                ->from("tbl_assign_vehicle_to_driver a");
        if(isset($user_id)>0){
               $this->db->where(array("a.a_v_t_d_driver_id" => $user_id, "a.a_v_t_d_status" => 1));
        }
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
      
    
    
    
    
   
}
