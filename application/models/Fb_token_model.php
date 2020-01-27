<?php
class Fb_token_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
   public function addFbTokenApi($data) {
        $this->db->insert("tbl_fb_token", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }   
   public function updateFbTokenApi($data,$id) {
       $this->db->where(['fb_u_id'=>$id]);
        $this->db->update('tbl_fb_token',$data);
        if ($id> 0) {
            return $id;
        } else {
            return false;
        }
    }
    public function mobileTokenData($user_id){
        $this->db->select(array("*"))
                ->from("tbl_fb_token")
                ->where(array("tbl_fb_token.fb_u_id" => $user_id, "tbl_fb_token.fb_status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
