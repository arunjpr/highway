<?php
class Receiver_user_model extends CI_Model {
    public function insertReceiverApi($data) {
        $this->db->insert("tbl_receiver_user", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function update_receiver_user($data,$id){
        $this->db->where(['r_u_id'=>$id]);
        $this->db->update('tbl_receiver_user',$data);
        if ($id> 0) {
            return $id;
        } else {
            return false;
        }
    }
    function getReceiverById($receive_user_primary_id) {
        $this->db->select(array("*"))
                ->from("tbl_receiver_user")
                ->where(array("tbl_receiver_user.r_u_id" => $receive_user_primary_id, "tbl_receiver_user.r_u_status" => 1,"tbl_receiver_user.r_u_delete" =>0));
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    
    function getCheckReciverData($userId,$reciverUserId) {
        if((isset($userId)>0) && (isset($reciverUserId)>0)){
            $this->db->select(array("*"))
                ->from("tbl_receiver_user")
                ->where(array("tbl_receiver_user.r_u_trip_receiver_user_id " => $reciverUserId, "tbl_receiver_user.r_u_user_id" => $userId, "tbl_receiver_user.r_u_status" => 1,"tbl_receiver_user.r_u_delete" =>0));
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
