<?php
class Assign_vehicle_to_driver_model extends CI_Model {
    
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
    
    
    
    function addAssignDataApi($data) {
        $this->db->insert("tbl_assign_vehicle_to_driver", $data);
        if ($this->db->insert_id()> 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
   
    
      
    
    
    
    
   
}
