<?php
class Vehicle_type_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_vehicle_type = 'tbl_vehicle_type';  
    
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
    
    public function add_vehicle_type_data($data) { 
        $this->db->insert($this->_vehicle_type, $data); 
        return $this->db->insert_id(); 
    }  
	
    public function get_vehicle_type_info() { 
        $this->db->select('*') 
                ->from('tbl_vehicle_type')
                ->where(array("tbl_vehicle_type.v_t_delete" => 0));
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 
    public function get_vehicle_type_by_id($vehicle_id) { 
        $result = $this->db->get_where($this->_vehicle_type, array('v_t_id' => $vehicle_id , 'v_t_status' => 1)); 
        return $result->row_array(); 
    } 
    public function get_vehicle_inactive_data($vehicle_id) { 
        $result = $this->db->get_where($this->_vehicle_type, array('v_t_id' => $vehicle_id , 'v_t_status' => 0)); 
        return $result->row_array(); 
    } 

    public function active_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle_type, array('v_t_status' => 1), array('v_t_id' => $vehicle_id));  
        return $this->db->affected_rows(); 
    } 

    public function inactive_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle_type, array('v_t_status' => 0), array('v_t_id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_vehicle_type($vehicle_id, $data) { 
        $this->db->update($this->_vehicle_type, $data, array('v_t_id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_vehicle_by_id($vehicle_id) { 
        $this->db->update($this->_vehicle_type, array('v_t_delete' => 1), array('v_t_id' => $vehicle_id)); 
        return $this->db->affected_rows(); 
    }   
}
