<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Content_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_content = 'tbl_content';  
    
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
    
    public function add_content_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_content, $data); 
        
        return $this->db->insert_id(); 
    }  
	
    public function get_content_info() { 
        $this->db->select('*') 
                ->from('tbl_content')
                ->where('c_delete', 0)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Content_by_content_id($content_id) { 
        $result = $this->db->get_where($this->_content, array('c_id' => $content_id , 'c_delete' => 0)); 
        return $result->row_array(); 
    } 

    public function published_content_by_id($content_id) { 
        $this->db->update($this->_content, array('c_status' => 1), array('c_id' => $content_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_content_by_id($content_id) { 
        $this->db->update($this->_content, array('c_status' => 0), array('c_id' => $content_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_content($content_id, $data) { 
        $this->db->update($this->_content, $data, array('c_id' => $content_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_content_by_id($content_id) { 
        $this->db->update($this->_content, array('c_delete' => 1), array('c_id' => $content_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

