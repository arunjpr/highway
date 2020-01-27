<?php
class Book_trip_link_model extends CI_Model {
    
    public function addConfirmBookingApi($data) {
        $this->db->insert("tbl_book_trip_link", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public  function getBookTripDetailsApi() {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=t.t_user_Id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.=t.t_user_Id','left')
                ->join('vehicle v', 'v.v_Id=a.a_v_t_d_vehicle_id','left')
                ->join('tbl_vehicle_type vt', 'v.v_type_id=vt.v_t_id','left')
                
                ->where(array("a.a_v_t_d_status" => 1,"a.a_v_t_d_delete" => 0));
        $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=$ubniqueUser = array();
                foreach($data as $row){
                
                    $cat[$counter]['VehicleId']=$row->a_v_t_d_vehicle_id ;
                    $cat[$counter]['VehicleTypeId']=$row->v_type_id ;
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                    $cat[$counter]['VehicleFare']=$row->v_t_fare;
                    $counter++;
                    
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
    public  function getBookTripDetailsByTripIdApi($bookTripId,$driverName,$driverMobile) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('vehicle v', 'v.v_Id=b.b_l_t_vehicle_id','left')
                ->join('tbl_vehicle_type vt', 'v.v_type_id=vt.v_t_id','left');
                if(isset($bookTripId)>0){
                $this->db->where(array("b.b_l_t_id"=>$bookTripId,"b.b_l_t_active_status" =>1));
                }
        $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                
                $cat=$ubniqueUser = array();
                foreach($data as $row){
                    $cat['driverName']=$driverName ;
                    $cat['driverMobile']=$driverMobile ;
                    $cat['vehicleId']=$row->v_Id ;
                    $cat['vehicleName']=$row->v_t_vehicle_name ;
                   // $cat['vehicleNumber']=$row->v_vehicle_number ;
                   // $cat['vehicleModelNo']=$row->v_vehicle_model_no ;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    public function getBookTripDataById($bookTripId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link")
                ->where(array("tbl_book_trip_link.b_l_t_id" => $bookTripId, "tbl_book_trip_link.b_l_t_active_status"=> 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
   
    
}
