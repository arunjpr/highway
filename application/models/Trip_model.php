<?php
class Trip_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    function addTripApi($data) {
        $this->db->insert("tbl_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     
}
