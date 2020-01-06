<?php
class Vehicle_type_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    public  function getVehicleDropdownApi() {
        $this->db->where([
                'v_t_status'=>1,
                'v_t_delete'=>0,
                ]);
        $query =$this->db->get('tbl_vehicle_type');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['VehicleTypeId']=$row->v_t_id;
                $cat[$counter]['VehicleName']=$row->v_t_vehicle_name;
                $counter++;
            }
            return $cat;
        }
    }   
}
