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
    
      public  function getVehicleDetailsApi($user_id) {
        $this->db->where([
                'v_Id'=>$user_id
                ]);
        $query =$this->db->get('vehicle');
        //        echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
}
