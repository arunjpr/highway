<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Driver_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_users = 'users'; 
    private $_drive_license = 'drive_license'; 
    
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
    
    public function add_driver_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_users, $data); 
        
        return $this->db->insert_id(); 
    }  
    
    public function add_driver_licence_data($dataDriver) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_drive_license, $dataDriver); 
        
        return $this->db->insert_id(); 
    } 
    public function get_dropdownData() { 
        $this->db->select(array('*')) 
                ->from('tbl_vehicle_type')
                ->join('vehicle', 'vehicle.v_Id=tbl_vehicle_type.v_t_id')
                ->where('v_t_status', 1);
        $query_result = $this->db->get(); 
        $result = $query_result->result(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
            
    }
	
    public function get_driver_info() { 
        $this->db->select('*') 
                ->from('users')
                ->where('Role_Id', 3)
                ->where('deletion_status', 0)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Driver_by_driver_id($driver_id) { 
        $result = $this->db->get_where($this->_users, array('Id' => $driver_id , 'deletion_status' => 0)); 
        return $result->row_array(); 
    } 

    public function published_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('Status' => 1), array('Id' => $driver_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('Status' => 0), array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_driver($driver_id, $data) { 
        $this->db->update($this->_users, $data, array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('deletion_status' => 1), array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

