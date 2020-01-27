<?php
class Driver_trip_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    public function addDriverTripDataApi($data) {
        $this->db->insert("tbl_driver_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    } 
    
}
