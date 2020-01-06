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
                ->join('users', 'users.Id=vehicle.v_vehicle_driver_id')
                ->where('v_status', 1)
                ;
        $query_result = $this->db->get(); 
       // echo  $this->db->last_query();die;
        $result = $query_result->result_array(); 
        return $result; 
    } 
    
    
    public function get_vehicle_dropdown() { 
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

    public function get_Vehicle_by_vehicle_id($vehicle_id) { 
        $result = $this->db->get_where($this->_vehicle, array('v_Id' => $vehicle_id , 'v_status' => 1)); 
        return $result->row_array(); 
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

