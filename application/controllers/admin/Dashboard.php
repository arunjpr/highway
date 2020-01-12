<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    /* #********************************************#
      #                   codingmaker             #
      #*********************************************#
      #      Author:     codingmaker              #
      #      Email:      info@codingmaker.com     #
      #      Website:    http://codingmaker.com   #
      #                                             #
      #      Version:    1.0.0                      #
      #      Copyright:  (c) 2018 - codingmaker   #
      #                                             #
      #*********************************************# */

    public function __construct() {
      parent::__construct();
        // Check Login Status
    //  $this->user_login_authentication();
      
      if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');	
      $this->load->model('admin_models/customer_model', 'customer_mdl'); 
         
    }

    public function index() {
      $data = array();
      $data['title'] = 'Dashboard';
      $data['active_menu'] = 'dashboard';
      $data['active_sub_menu'] = '';
      $data['active_sub_sub_menu'] = '';
	  
      $data['total_listing'] = 1;
      $data['total_users'] = 10;
      $data['total_classified'] = 10;
      $data['total_events'] = 100;
      
      $data['total_categories'] = 200;
      $data['total_cities'] = 3000;
      $data['all_notifications']= 400;
      $data['main_content']='';
      
      $data['customer'] = $this->customer_mdl->newCustomerList(); 
      //echo '<pre>' ;print_r($data['customer']);die;
      
      $data['upcoming'] = $this->dash_mdl->count_total_upcoming_trip(); 
      $data['ongoing'] = $this->dash_mdl->count_total_ongoing_trip(); 
      $data['completed'] = $this->dash_mdl->count_total_completed_trip(); 
      $data['cancel'] = $this->dash_mdl->count_total_cancel_trip(); 
      
      
      
      $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
      $data['main_content'] = $this->load->view('admin_views/dashboard/dashboard_v', '', TRUE);
      $this->load->view('admin_views/admin_master_v', $data);
      
    }		
	
	
   
   
}
