<?php
class Assign_vehicle_to_driver_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }

    
    
    function addAssignDataApi($data) {
        $this->db->insert("tbl_assign_vehicle_to_driver", $data);
        if ($this->db->insert_id()> 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
   
    public function geDriverDetailsById($user_id) {
        $this->db->select(array('a.a_v_t_d_driver_id','a_v_t_d_vehicle_id'))
                ->from("tbl_assign_vehicle_to_driver a");
        if(isset($user_id)>0){
               $this->db->where(array("a.a_v_t_d_driver_id" => $user_id, "a.a_v_t_d_status" => 1));
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
    
     public function geDriverTripStartData($userId,$bookTripId) {
        $this->db->select(array('*'))
                ->from("tbl_accept_booking_trip a")
                ->join('tbl_book_trip_link b','b.b_l_t_id=a.a_b_t_booking_trip_id')
                ->join('tbl_trip t','t.t_id=b.b_l_t_trip_id')
                ->join('tbl_assign_vehicle_to_driver av','a.a_b_t_driver_id=av.a_v_t_d_driver_id')
                ->join('users u','u.id=a.a_b_t_driver_id')
                ->join('vehicle v', 'v.v_Id=av.a_v_t_d_vehicle_id','left')
                ->join('tbl_vehicle_type vt', 'vt.v_t_id=b.b_l_t_vehicle_type','left');
        if(isset($userId)>0){
               $this->db->where(array(
                   "a.a_b_t_driver_id" => $userId,
                   "a.a_b_t_booking_trip_id" => $bookTripId,
                   "a.a_b_t_status" => 1,
                   "av.a_v_t_d_status" => 1,
                   ));
        }
         $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['customerId']=$row->b_l_t_customer_id;
                    $cat['tripId']=$row->t_trip_id;
                    $cat['satrtTime']=$row->a_b_t_start_time;
                    $cat['startDate']=$row->a_b_t_start_date;
                    $cat['driverId']=$row->a_v_t_d_driver_id;
                    $cat['driverName']=$row->Name;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['vehicleId']=$row->a_v_t_d_vehicle_id ;
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
     public function geDriverTripEndData($userId,$bookTripId) {
        $this->db->select(array('*'))
                ->from("tbl_accept_booking_trip a")
                ->join('tbl_book_trip_link b','b.b_l_t_id=a.a_b_t_booking_trip_id')
                ->join('tbl_trip t','t.t_id=b.b_l_t_trip_id')
                ->join('tbl_assign_vehicle_to_driver av','a.a_b_t_driver_id=av.a_v_t_d_driver_id')
                ->join('users u','u.id=a.a_b_t_driver_id')
                ->join('vehicle v', 'v.v_Id=av.a_v_t_d_vehicle_id','left')
                ->join('tbl_vehicle_type vt', 'vt.v_t_id=b.b_l_t_vehicle_type','left');
        if(isset($userId)>0){
               $this->db->where(array(
                   "a.a_b_t_driver_id" => $userId,
                   "a.a_b_t_booking_trip_id" => $bookTripId,
                   "a.a_b_t_status" => 1,
                   "av.a_v_t_d_status" => 1,
                   ));
        }
         $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['customerId']=$row->b_l_t_customer_id;
                    $cat['tripId']=$row->t_trip_id;
                    $cat['endTime']=$row->a_b_t_end_time;
                    $cat['endDate']=$row->a_b_t_end_date;
                    $cat['driverId']=$row->a_v_t_d_driver_id;
                    $cat['driverName']=$row->Name;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['vehicleId']=$row->a_v_t_d_vehicle_id ;
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
      
    
    
    
    
   
}
