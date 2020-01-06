<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Vehicle extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        
        $this->load->model('admin_models/Vehicle_model', 'vehicle_mdl'); 
        
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Vehicle';
        $data['active_menu'] = 'vehicle';
        $data['active_sub_menu'] = 'vehicle';
        $data['active_sub_sub_menu'] = ''; 
        $data['vehicle_info'] = $this->vehicle_mdl->get_vehicle_info();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/vehicles/manage_vehicle_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_vehicle() { 
        $data = array(); 
        $data['title'] = 'Add Vehicle';
        $data['active_menu'] = 'vehicle';
        $data['active_sub_menu'] = 'vehicle';
        $data['active_sub_sub_menu'] = '';
        $data['vehicle_dropdown'] = $this->vehicle_mdl->get_vehicle_dropdown();
        //echo '<pre>' ;print_r($data['vehicle_dropdown']) ;die;
        
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/vehicles/add_vehicle_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_vehicle() {
        // $imgPath = base_url(). '/assets/backend/img/vehicle/';
        $config = array(
            array(
                'field' => 'v_vehicle_name',
                'label' => 'v_vehicle_name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_detail',
                'label' => 'v_vehicle_detail',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_number',
                'label' => 'v_vehicle_number',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_model_no',
                'label' => 'v_vehicle_model_no',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_driver_id',
                'label' => 'v_vehicle_driver_id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'v_vehicle_Color',
                'label' => 'v_vehicle_Color',
                'rules' => 'trim|required|max_length[250]'
            )

        );
       
        //echo '<pre>' ;print_r($config) ;die;
        $this->form_validation->set_rules($config);
       // $this->load->library('upload', $config);
     
        if ($this->form_validation->run() == FALSE) {
            $this->add_vehicle();
            
        } else {
            $data['v_vehicle_name'] = $this->input->post('v_vehicle_name', TRUE); 
            $data['v_vehicle_detail'] = $this->input->post('v_vehicle_detail', TRUE); 
            $data['v_vehicle_number'] = $this->input->post('v_vehicle_number', TRUE); 
            $data['v_vehicle_model_no'] = $this->input->post('v_vehicle_model_no', TRUE); 
            $data['v_vehicle_driver_id'] = $this->input->post('v_vehicle_driver_id', TRUE); 
            $data['v_vehicle_Color'] = $this->input->post('v_vehicle_Color', TRUE); 
            $data['v_status'] = 1; 
           // $data['Image'] = $this->input->post('Image', TRUE); 
           
            $data['v_owner_id'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            
               //echo '<pre>' ;print_r($data) ;die;
            $insert_id = $this->vehicle_mdl->add_vehicle_data($data); 
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } 
        } 
    }
 
    public function published_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_mdl->published_vehicle_by_id($vehicle_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicle', 'refresh'); 
        } 
    }
 
    public function unpublished_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id);
        if (!empty($vehicle_info)) {
            $result = $this->vehicle_mdl->unpublished_vehicle_by_id($vehicle_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicle', 'refresh'); 
        } 
    }  

    public function edit_vehicle($vehicle_id) { 
        $data = array(); 
        $data['user_data'] = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Vehicle'; 
            $data['active_menu'] = 'vehicle'; 
            $data['active_sub_menu'] = 'vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/vehicles/edit_vehicle_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicle', 'refresh'); 
        } 
    } 

    public function update_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $config = array( 
               array(
                'field' => 'v_vehicle_name',
                'label' => 'v_vehicle_name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_detail',
                'label' => 'v_vehicle_detail',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_number',
                'label' => 'v_vehicle_number',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_model_no',
                'label' => 'v_vehicle_model_no',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'v_vehicle_driver_id',
                'label' => 'v_vehicle_driver_id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'v_vehicle_Color',
                'label' => 'v_vehicle_Color',
                'rules' => 'trim|required|max_length[250]'
            )

        );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_vehicle($vehicle_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Status'] = $this->input->post('Status', TRUE); 
                $data['Role_Id'] = 5; 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['Dob'] = $this->input->post('Dob', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['created_on'] = date('Y-m-d H:i:s');  
                $result = $this->vehicle_mdl->update_vehicle($vehicle_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/vehicle', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/vehicle', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicle', 'refresh'); 
        } 
    } 

    public function remove_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_Vehicle_by_vehicle_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_mdl->remove_vehicle_by_id($vehicle_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicles', 'refresh'); 
        } 
    } 
    
    
    public function view_vehicle($vehicle_id) { 
        $data = array(); 
        $data['user_data'] = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Vehicle'; 
            $data['active_menu'] = 'vehicle'; 
            $data['active_sub_menu'] = 'vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/vehicles/view_vehicle_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicle', 'refresh'); 
        } 
    } 
    
    
    
}
?>