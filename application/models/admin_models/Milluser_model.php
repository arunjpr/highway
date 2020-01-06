<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Milluser_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_users = 'users';  
    
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
    
    public function add_milluser_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_users, $data); 
        
        return $this->db->insert_id(); 
    }  
	
    public function get_milluser_info() { 
        $this->db->select('*') 
                ->from('users')
                ->where('Role_Id', 2)
                ->where('deletion_status', 0)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Milluser_by_milluser_id($milluser_id) { 
        $result = $this->db->get_where($this->_users, array('Id' => $milluser_id , 'deletion_status' => 0)); 
        return $result->row_array(); 
    } 

    public function published_milluser_by_id($milluser_id) { 
        $this->db->update($this->_users, array('Status' => 1), array('Id' => $milluser_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_milluser_by_id($milluser_id) { 
        $this->db->update($this->_users, array('Status' => 0), array('Id' => $milluser_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_milluser($milluser_id, $data) { 
        $this->db->update($this->_users, $data, array('Id' => $milluser_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_milluser_by_id($milluser_id) { 
        $this->db->update($this->_users, array('deletion_status' => 1), array('Id' => $milluser_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

