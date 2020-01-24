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
    
   
   
    
}
