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
    
}
