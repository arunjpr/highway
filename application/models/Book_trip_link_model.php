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
    public function updateBookingStatusApi($data,$bookTripId) {
        $this->db->where(['b_l_t_id'=>$bookTripId,'b_l_t_active_status'=>1]);
        $this->db->update("tbl_book_trip_link", $data);
        if ($bookTripId> 0) {
            return $bookTripId;
        } else {
            return false;
        }
    }
    
    public  function getBookTripDetailsApi($booking_trip_id,$user_id) {
        //echo '<pre>' ;print_r($booking_trip_id);die;
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left')
                ->join('tbl_vehicle_type vt', 'vt.v_t_id=b.b_l_t_vehicle_type','left');
          
        if(isset($booking_trip_id)>0){
             $this->db->where(array(
                    "b.b_l_t_id" => $booking_trip_id,
                    "b.b_l_t_customer_id" => $user_id,
                    "b.b_l_t_active_status" => 1,
                    "b.b_l_t_active_status" => 1,
                    "b.b_l_t_delete" => 0,
                   
                    ));
        }
              
         $query = $this->db->get();
         //$this->db->last_query();die;   
        
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat = array();
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['bookingId']=$row->b_l_t_id ;
                    $cat[$counter]['bookingTripId']=$row->t_trip_id ;
                    $cat[$counter]['customerName']=$row->Name ;
                    $cat[$counter]['customerMobile']=$row->Mobile;
                    $cat[$counter]['tripPickupLocation']=$row->t_source_address;
                    $cat[$counter]['tripDropLocation']=$row->t_destination_address;
                    $cat[$counter]['tripAddDate']=$row->t_add_date;
                    $cat[$counter]['vehicleTypeId']=$row->v_t_id ;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name ;
                    $cat[$counter]['vehicleFare']=$row->v_t_fare;
                    $counter++;
                    
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
    public  function getBookTripDetailsByTripIdApi($bookTripId,$driverId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_vehicle_type vt','b.b_l_t_vehicle_type=vt.v_t_id','left')
                ->join('vehicle v', 'v.v_type_id=vt.v_t_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')
                ->join('users u', 'u.Id=a.a_v_t_d_driver_id','left');
       // $query = $this->db->get();
        //echo  $this->db->last_query();die;
                if(isset($bookTripId)>0){
                $this->db->where(array(
                    "b.b_l_t_id"=>$bookTripId,
                    "b.b_l_t_active_status" =>1,
                    "a.a_v_t_d_driver_id" =>$driverId,
                    "a.a_v_t_d_status" =>1,
                    "ab.a_b_t_status" =>1,
                    ));
                }
        $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['customerId']=$row->b_l_t_customer_id;
                    $cat['driverId']=$row->a_v_t_d_driver_id;
                    $cat['driverName']=$row->Name;
                    $cat['driverName']=$row->Name;
                    $cat['DrivrRating']=3;
                    $cat['DrivrTripCount']=1;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['vehicleId']=$row->v_Id ;
                    $cat['vehicleTypeId']=$row->v_t_id ;
                    $cat['vehicleType']=$row->v_t_vehicle_name ;
                    $cat['vehicleName']= ucwords($row->v_vehicle_name).' '.$row->v_vehicle_number;
                    $cat['tripAcceptStatus']=$row->a_b_t_accept_status;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    public function getBookTripDataById($bookTripId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link");
                if(isset($bookTripId)>0){
                $this->db->where(array("tbl_book_trip_link.b_l_t_id" => $bookTripId, "tbl_book_trip_link.b_l_t_active_status"=> 1));
                }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
   
    public function getBookTripDataByTripId($bookTripId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t','b.b_l_t_trip_id=t.t_id','left');
                if(isset($bookTripId)>0){
                $this->db->where(array("b.b_l_t_trip_id" => $bookTripId, "b.b_l_t_active_status"=> 1));
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
   
    
}
