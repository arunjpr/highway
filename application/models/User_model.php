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
       // echo '<pre>' ; print_r($id);die;
        $this->db->where(['Id'=>$id]);
        $this->db->update('users',$data);
        if ($id> 0) {
            return $id;
        } else {
            return false;
        }
    }
    public function delete_user($id){
        $this->db->where(['Id'=>$id]);
        $this->db->delete('users');
    }
    public function getUserList($user_id) {
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
    public function getCheckUserRoleByUserId($user_id) {
        $this->db->select(array("Role_Id"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
   public function getUserDetailsById($user_id) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    public function getUserAddBy($add_by,$receiverMobile) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.add_by" => $add_by,"users.Mobile" => $receiverMobile, "users.Status" => 1));
        
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    public function getUserDetailsByMobile($mobile_id) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Mobile" => $mobile_id, "users.Status" => 1));
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
