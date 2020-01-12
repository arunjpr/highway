<?php
class Vehicle_load_capacity_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    public  function getVehiclLoadCapacityDropdownApi() {
        $this->db->where([
               // 'v_l_c_status'=>1,
                'v_l_c_delete'=>0,
                ]);
        $query =$this->db->get('tbl_vehicle_load_capacity');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['vehicleLoadCapacityId']=$row->v_l_c_id;
                $cat[$counter]['vehicleLoadingCapacity']=$row->v_l_c_load_capacity;
                $counter++;
            }
            return $cat;
        }
    } 
    public  function getVehicleDimensionSizeApi() {
        $this->db->where([
                //'v_d_s_status'=>1,
                'v_d_s_delete'=>0,
                ]);
        $query =$this->db->get('tbl_vehicle_dimension_size');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['vehicleDimensionSizeID']=$row->v_d_s_id;
                $cat[$counter]['vehicleDimensionSize']=$row->v_d_s_dimension_size;
                $counter++;
            }
            return $cat;
        }
    } 
}
