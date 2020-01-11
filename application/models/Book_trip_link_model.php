<?php
class Book_trip_link_model extends CI_Model {
    
    
    public function insertUserApi($data) {
        $this->db->insert("users", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function update_users($data,$id){
        $this->db->where(['Id'=>$id]);
        $this->db->update('users',$data);
    }
   
    
}
