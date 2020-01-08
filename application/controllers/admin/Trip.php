<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Trip extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/trip_model', 'trip_mdl'); 
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Trip';
        $data['active_menu'] = 'trip';
        $data['active_sub_menu'] = 'trip';
        $data['active_sub_sub_menu'] = ''; 
        $data['trip_info'] = $this->trip_mdl->get_trip_info();
       // echo '<pre>' ;        print_r($data['trip_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/trips/manage_trip_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

   
    public function active_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_by_trip_id($trip_id); 
        if (!empty($trip_info)) { 
            $result = $this->trip_mdl->active_trip_by_id($trip_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/trip', 'refresh'); 
        } 
    }
 
    public function inactive_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_by_trip_id($trip_id);
        if (!empty($trip_info)) {
            $result = $this->trip_mdl->inactive_trip_by_id($trip_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/trip', 'refresh'); 
        } 
    }  

    public function edit_trip($trip_id) { 
        $data = array(); 
        $data['tripData'] = $this->trip_mdl->get_trip_data_by_id($trip_id);  
       // echo '<pre>' ;print_r($data['tripData']);die;
        if (!empty($data['tripData'])) { 
            $data['title'] = 'Edit Trip'; 
            $data['active_menu'] = 'trip'; 
            $data['active_sub_menu'] = 'trip'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/trips/edit_trip_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/trip', 'refresh'); 
        } 
    } 

    public function update_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_data_by_id($trip_id); 
        if (!empty($trip_info)) { 
            $config = array( 
                array(
                'field' => 't_start_latitude',
                'label' => 't_start_latitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_start_longitude',
                'label' => 't_start_longitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_end_latitude',
                'label' => 't_end_latitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_start_longitude',
                'label' => 't_start_longitude',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_start_date',
                'label' => 't_start_date',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_end_date',
                'label' => 't_end_date',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_start_time',
                'label' => 't_start_time',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_end_time',
                'label' => 't_end_time',
                'rules' => 'trim|required|max_length[250]'
            ),
            );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_trip($trip_id); 
            } else { 
                $data['t_start_latitude'] = $this->input->post('t_start_latitude', TRUE); 
                $data['t_start_longitude'] = $this->input->post('t_start_longitude', TRUE); 
                $data['t_end_latitude'] = $this->input->post('t_end_latitude', TRUE); 
                $data['t_end_longitude'] = $this->input->post('t_end_longitude', TRUE); 
                $data['t_start_date'] = $this->input->post('t_start_date', TRUE); 
                $data['t_end_date'] = $this->input->post('t_end_date', TRUE); 
                $data['t_start_time'] = $this->input->post('t_start_time', TRUE); 
                $data['t_end_time'] = $this->input->post('t_end_time', TRUE); 
                $result = $this->trip_mdl->update_trip($trip_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/trip', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/trip', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/trip', 'refresh'); 
        } 
    } 

    public function remove_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_Trip_by_trip_id($trip_id); 
        if (!empty($trip_info)) { 
            $result = $this->trip_mdl->remove_trip_by_id($trip_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/trip', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/trips', 'refresh'); 
        } 
    } 
    
    
    public function view_trip($trip_id) { 
        $data = array(); 
        $data['user_data'] = $this->trip_mdl->get_trip_view_data($trip_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Trip'; 
            $data['active_menu'] = 'trip'; 
            $data['active_sub_menu'] = 'trip'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/trips/view_trip_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/trip', 'refresh'); 
        } 
    } 
    
     public function trip_by_status($tstatus) {
        $data = array();
        $data['title'] = 'Manage Trip';
        $data['active_menu'] = 'trip';
        $data['trip_data'] = $this->trip_mdl->get_trip_data_by_status($tstatus);
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/trips/trip_by_status_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    
    
    
}
?>