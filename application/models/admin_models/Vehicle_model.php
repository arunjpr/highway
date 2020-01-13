<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Vehicle_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_vehicle = 'vehicle';  
    
    public function check_login_info() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        $this->db->select('*')
                ->from('users')
                ->where("(Name = '$username_or_email_address' OR Email = '$username_or_email_address')")
                ->where('password', md5($password))
                ->where("(Role_Id = '1' OR Role_Id = '2')")
                ->where('Status', 1)
                ->where('deletion_status', 0)
                ->where('Role_Id <= ', 5);
        $query_result = $this->db->get();
//         echo  $this->db->last_query();die;
        $result = $query_result->row();
        return $result;

    }
    
    public function add_vehicle_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_vehicle, $data); 
        
        return $this->db->insert_id(); 
    }  
	
    public function get_vehicle_info() { 
        
       // echo 'hi'; die;
        $this->db->select('*') 
                ->from('vehicle')
                ->join('tbl_vehicle_type', 'tbl_vehicle_type.v_t_id=vehicle.v_type_id','left')
                ->join('users', 'users.Id=vehicle.v_vehicle_driver_id','left')
                ->where('v_status', 1)
                ;
        $query_result = $this->db->get(); 
       // echo  $this->db->last_query();die;
        $result = $query_result->result_array(); 
        return $result; 
    } 
    
    
    public function get_driver_dropdown() { 
        $this->db->select(array('Id','Name')) 
                ->from('users')
                ->where('Status', 1)
                ->where('Role_Id', 3)
                ;
        $query_result = $this->db->get(); 
       // echo  $this->db->last_query();die;
        $result = $query_result->result_array(); 
        return $result; 
    } 
    
    public function get_vehicle_dropdown() { 
        $this->db->select(array('v_t_id','v_t_vehicle_name')) 
                ->from('tbl_vehicle_type')
                ->where('v_t_status', 1)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Vehicle_by_vehicle_id($vehicle_id) {
        $this->db->select(array("*")) 
                ->from('vehicle')
                ->join('tbl_vehicle_type', 'tbl_vehicle_type.v_t_id=vehicle.v_type_id','left')
                ->where(array('v_Id' => $vehicle_id , 'v_status' => 1,'v_t_status' => 1,'v_delete'=>0,'v_t_delete'=>0))
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->row_array(); 
        return $result ;
        } 

    public function published_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle, array('v_status' => 1), array('v_Id' => $vehicle_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle, array('v_status' => 0), array('v_Id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_vehicle($vehicle_id, $data) { 
        $this->db->update($this->_vehicle, $data, array('v_Id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle, array('v_delete' => 1), array('v_Id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

