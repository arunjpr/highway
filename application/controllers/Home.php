<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
    
    public function __construct() {
    	parent::__construct(); 
    	$this->load->model('frontend_models/Common_model', 'common_mdl'); 
    }
    
    public function index() {		 	 
        $data = array();
        $data['title'] = 'Login';
        $this->load->view('admin_views/admin_login/admin_login_v', $data);
    }
}
