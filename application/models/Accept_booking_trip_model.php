<?php
class Accept_booking_trip_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    public  function getAcceptBookingTripApi($data) {
        $this->db->insert("tbl_accept_booking_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }   
    
    public function getAcceptTripData($tripId,$userId) {
        $this->db->select(array("*"))
                ->from("tbl_accept_booking_trip a")
                ->where(array("a.a_b_t_booking_trip_id" => $tripId, "a.a_b_t_driver_id" => $userId ,'a_b_t_status'=>1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function updateAcceptBooking($data,$tripId,$userId){
        //echo '<pre>' ; print_r($tripId);die;
        $this->db->where(['a_b_t_booking_trip_id'=>$tripId,'a_b_t_driver_id'=>$userId,'a_b_t_status'=>1]);
        $this->db->update('tbl_accept_booking_trip',$data);
        if ($tripId> 0) {
            return $tripId;
        } else {
            return false;
        }
    }
    public function addStartTripByDriverApi($data,$tripId,$userId){
        if(isset($tripId)>0 && ($userId)>0){
        $this->db->where(['a_b_t_booking_trip_id'=>$tripId,'a_b_t_driver_id'=>$userId,'a_b_t_status'=>1]);
        }
        $this->db->update('tbl_accept_booking_trip',$data);
        if ($tripId> 0) {
            return $tripId;
        } else {
            return false;
        }
    }
}
