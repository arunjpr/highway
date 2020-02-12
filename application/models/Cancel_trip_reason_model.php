<?php
class Cancel_trip_reason_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }


      public  function getCancelTripReasonApi() {
        $this->db->select(array("*"))
                ->from("tbl_cancel_trip_reason")
                ->where(array("tbl_cancel_trip_reason.c_t_r_status" => 1,"tbl_cancel_trip_reason.c_t_r_delete" => 0))
                ;
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['cancelId']=$row->c_t_r_id ;
                    $cat[$counter]['cancelReason']=$row->c_t_r_reason ;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
     public function addCancelTripReasonCommentApi($data) {
        $this->db->insert("tbl_cancel_trip_reason_comment", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     public function getCancelTripDataByUser($bookTripId,$userid) {
         if(isset($bookTripId)>0 && $userid>0){
             $this->db->select(array("*"))
                ->from("tbl_cancel_trip_reason_comment c");
             $this->db->where(array("c.c_t_r_c_booking_trip_id" => $bookTripId, "c.c_t_r_c_user_id"=> $userid));
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
    public function updateCancelTripReasonCommentApi($data,$c_t_r_c_id) {
        $this->db->where(['c_t_r_c_id'=>$c_t_r_c_id,' c_t_r_c_status '=>1]);
        $this->db->update("tbl_cancel_trip_reason_comment", $data);
        if ($c_t_r_c_id> 0) {
            return $c_t_r_c_id;
        } else {
            return false;
        }
    }
    
}
