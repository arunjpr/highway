<?php
class Assign_vehicle_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_assign_vehicle = 'tbl_assign_vehicle_to_driver';  
    
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
    
    public function get_vehicle_dropdown() { 
        $this->db->order_by('v_vehicle_name','ASC');
        $this->db->select(array('v_Id','v_vehicle_name','v_vehicle_number')) 
                ->from('vehicle')
                ->where(array('v_status' => 1,'v_delete'=>0));
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
    } 
    
    public function get_driver_dropdown() { 
        $this->db->order_by('Name','ASC');
        $this->db->select(array('Id','Name')) 
                ->from('users')
                ->where('Status', 1)
                ->where('deletion_status', 0)
                ->where('Role_Id', 3)
                ;
         $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
    } 
    public function add_assign_vehicle_data($data) { 
        $this->db->insert($this->_assign_vehicle, $data); 
        return $this->db->insert_id(); 
    }  
	
    public function get_assign_vehicle_info() { 
        $this->db->select('*') 
                ->from('tbl_assign_vehicle_to_driver')
                ->where(array("tbl_assign_vehicle_to_driver.a_v_t_d_delete" => 0));
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 
    public function get_assign_vehicle_by_id($assign_vehicle_id) { 
        $result = $this->db->get_where($this->_assign_vehicle, array('a_v_t_d_id' => $assign_vehicle_id , ' a_v_t_d_status' => 1)); 
        return $result->row_array(); 
    } 
    public function get_vehicle_inactive_data($assign_vehicle_id) { 
        $result = $this->db->get_where($this->_assign_vehicle, array('a_v_t_d_id' => $assign_vehicle_id , ' a_v_t_d_status' => 0)); 
        return $result->row_array(); 
    } 

    public function active_vehicle_by_id($assign_vehicle_id) { 
        $this->db->update($this->_assign_vehicle, array(' a_v_t_d_status' => 1), array('a_v_t_d_id' => $assign_vehicle_id));  
        return $this->db->affected_rows(); 
    } 

    public function inactive_vehicle_by_id($assign_vehicle_id) { 
        $this->db->update($this->_assign_vehicle, array(' a_v_t_d_status' => 0), array('a_v_t_d_id' => $assign_vehicle_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_assign_vehicle($assign_vehicle_id, $data) { 
        $this->db->update($this->_assign_vehicle, $data, array('a_v_t_d_id' => $assign_vehicle_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_vehicle_by_id($assign_vehicle_id) { 
        $this->db->update($this->_assign_vehicle, array('a_v_t_d_delete' => 1), array('a_v_t_d_id' => $assign_vehicle_id)); 
        return $this->db->affected_rows(); 
    }   
}
