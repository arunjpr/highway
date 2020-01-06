<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
    
    public function __construct() {
    	parent::__construct(); 
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
    }
    
    public function index() {		 	 
//    	$data = array();
//    	$data['title'] = 'Home';  
//		
//		$setting_info = $this->common_mdl->get_settings_info();
//		$data['settings_info'] = $setting_info;  
// 
//		 
//		
//		$data['nav_content'] = $this->load->view('frontend_views/nav_content_v', $data, TRUE);
//    	$data['main_content'] = $this->load->view('frontend_views/home_content_v', $data, TRUE); 
//    	$this->load->view('frontend_views/user_master_v', $data);
    }
}
