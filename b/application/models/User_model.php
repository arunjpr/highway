<?php
class User_model extends CI_Model {
    
    public  function get_users($user_id,$username) {
        $this->db->where([
                'Id'=>$user_id,
                'Name'=>$username,
                'Status'=>1
                ]);
        $query =$this->db->get('users');
        return $query->result();
    }
     public  function getUserData($user_id,$roleId) {
        $this->db->where([
                'Id'=>$user_id,
                'Role_id'=>$roleId,
                'Status'=>1,
                ]);
        $query =$this->db->get('users');
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
    public function create_users($data){
        $this->db->insert('users',$data);
    }
    
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
    public function delete_user($id){
        $this->db->where(['Id'=>$id]);
        $this->db->delete('users');
    }
    function getUserList($user_id) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
