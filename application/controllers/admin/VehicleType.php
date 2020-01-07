<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class VehicleType extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Vehicle_type_model','vehicle_type_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Manage Vehicle Type';
        $data['active_menu'] = 'vehicle type';
        $data['active_sub_menu'] = 'vehicle type';
        $data['active_sub_sub_menu'] = ''; 
        $data['vehicle_info'] = $this->vehicle_type_mdl->get_vehicle_type_info();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/vehicleType/manage_vehicle_type_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    public function add_vehicle_type(){ 
        $data = array(); 
        $data['title'] = 'Add Vehicle Type';
        $data['active_menu'] = 'vehicle type';
        $data['active_sub_menu'] = 'vehicle type';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/vehicleType/add_vehicle_type_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_vehicle_type() {
        $config = array(
            array(
                'field' => 'v_vehicle_name',
                'label' => 'v_vehicle_name',
                'rules' => 'trim|required|max_length[250]'
            )
            );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_vehicle();
            } else {
            $data['v_t_vehicle_name'] = $this->input->post('v_vehicle_name', TRUE); 
            $data['v_t_status'] = 1; 
            $data['v_t_add_by'] = $this->session->userdata('admin_id'); 
            $data['v_t_date'] = date('Y-m-d'); 
            $insert_id = $this->vehicle_type_mdl->add_vehicle_type_data($data); 
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                    redirect('admin/vehicleType', 'refresh'); 
            } 
        } 
    }
   
    public function edit_vehicle_type($vehicle_id) { 
        $data = array(); 
        $data['user_data'] = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicle_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Vehicle Type'; 
            $data['active_menu'] = 'vehicle type'; 
            $data['active_sub_menu'] = 'vehicle type'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/vehicleType/edit_vehicle_type_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicleType', 'refresh'); 
        } 
    } 

    public function update_vehicle_type($vehicle_id) { 
        $vehicle_info = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $config = array( 
               array(
                'field' => 'v_vehicle_name',
                'label' => 'v_vehicle_name',
                'rules' => 'trim|required|max_length[250]'
            ),
        );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_vehicle($vehicle_id); 
            } else { 
                $data['v_t_vehicle_name'] = $this->input->post('v_vehicle_name', TRUE); 
                $data['v_t_status'] = 1;
                $result = $this->vehicle_type_mdl->update_vehicle_type($vehicle_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/vehicleType', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/vehicleType', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicleType', 'refresh'); 
        } 
    } 
    
    public function remove_vehicle_type($vehicle_type_id) { 
       
        $vehicle_info = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicle_type_id); 
         
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_type_mdl->remove_vehicle_by_id($vehicle_type_id); 
//            echo '<pre>' ;print_r($result);die;
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicleType', 'refresh'); 
        } 
    } 
    
     public function active_vehicle_type($vehicle_type_id) { 
        $vehicle_info = $this->vehicle_type_mdl->get_vehicle_inactive_data($vehicle_type_id); 
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_type_mdl->active_vehicle_by_id($vehicle_type_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicleType', 'refresh'); 
        } 
    }
     public function inactive_vehicle_type($vehicle_type_id) { 
         
        $vehicle_info = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicle_type_id);
        
        if (!empty($vehicle_info)) {
            $result = $this->vehicle_type_mdl->inactive_vehicle_by_id($vehicle_type_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/vehicleType', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/vehicleType', 'refresh'); 
        } 
    }  
    
    
}
?>