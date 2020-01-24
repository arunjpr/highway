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
}
