<?php
class Share_trip_model extends CI_Model {
   
    
    public function insertShareTripApi($data) {
        $this->db->insert("tbl_share_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function getShareUserMobile($mobile) {
        $this->db->select(array("*"))
                ->from("tbl_share_trip")
                ->join('users','users.Id=tbl_share_trip.s_t_share_user_id','left')
                ->where(array("users.Mobile" => $mobile, "users.Status" => 1));
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
