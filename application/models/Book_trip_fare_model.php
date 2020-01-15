<?php
class Book_trip_fare_model extends CI_Model {
    
    public function addBookingFareApi($data) {
        $this->db->insert("tbl_book_trip_fare", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    
   
    
}
