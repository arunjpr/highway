<?php
class Role_model extends CI_Model {
    public function getroleByUserid($user_id) {
        $this->db->select(array('u.Role_Id','r.Title'))
                ->from("users u")
                ->join('roles r','r.Id=u.Role_id','left')
                ->where(array("u.Id" => $user_id, "u.Status" => 1));
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    
    
    public function geUserDetailsById($user_id) {
        $this->db->select(array('u.Id','u.Name','u.Mobile'))
                ->from("users u")
                ->where(array("u.Id" => $user_id, "u.Status" => 1));
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
