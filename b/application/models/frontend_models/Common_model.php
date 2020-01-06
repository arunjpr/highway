<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    } 
	private $_settings = 'tbl_settings';
	private $_users = 'users'; 
	
	public function get_settings_info(){

        $result = $this->db->get($this->_settings);
        return $result->row_array();

    }
//	public function get_userinfo_by_id($user_id) { 
//	
//         $result = $this->db->join('tbl_state state','state.zipcode = '.$this->_users.'.zipcode', 'left')->get_where($this->_users, array('user_id' => $user_id,'deletion_status' => 0));
//        return $result->row_array(); 
//    }
	
	
}
?>