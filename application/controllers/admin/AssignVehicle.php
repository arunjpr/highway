<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class AssignVehicle extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Assign_Vehicle_model','assign_vehicle_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Manage Assign Vehicle';
        $data['active_menu'] = 'assign vehicle';
        $data['active_sub_menu'] = 'assign vehicle';
        $data['active_sub_sub_menu'] = ''; 
        $data['vehicle_info'] = $this->assign_vehicle_mdl->get_assign_vehicle_info();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/assignVehicle/manage_assign_vehicle_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    public function add_assign_vehicle(){ 
        $data = array(); 
        $data['title'] = 'Add Assign Vehicle';
        $data['active_menu'] = 'assign vehicle';
        $data['active_sub_menu'] = 'assign vehicle';
        $data['active_sub_sub_menu'] = '';
        $data['vehicleData'] = $this->assign_vehicle_mdl->get_vehicle_dropdown();
        $data['driverData'] = $this->assign_vehicle_mdl->get_driver_dropdown();
       // echo '<pre>' ;print_r($data);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/assignVehicle/add_assign_vehicle_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_assign_vehicle() {
        $config = array(
            array(
                'field' => 'vehicle',
                'label' => 'vehicle',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'driver',
                'label' => 'driver',
                'rules' => 'trim|required'
            ),
            );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_vehicle();
            } else {
            $data['a_v_t_d_vehicle_id'] = $this->input->post('vehicle', TRUE); 
            $data['a_v_t_d_driver_id'] = $this->input->post('driver', TRUE); 
            $data['a_v_t_d_status'] = 1; 
            $data['a_v_t_d_owner_id'] = $this->session->userdata('admin_id'); 
            $data['a_v_t_d_add_by'] = $this->session->userdata('admin_id'); 
            $data['a_v_t_d_date'] = date('Y-m-d'); 
            $insert_id = $this->assign_vehicle_mdl->add_assign_vehicle_data($data); 
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                    redirect('admin/assignVehicle', 'refresh'); 
            } 
        } 
    }
   
    public function edit_assign_vehicle($assign_vehicle_id) { 
        $data = array(); 
        $data['user_data'] = $this->assign_vehicle_mdl->get_assign_vehicle_by_id($assign_vehicle_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Assign Vehicle'; 
            $data['active_menu'] = 'assign vehicle'; 
            $data['active_sub_menu'] = 'assign vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['vehicleData'] = $this->assign_vehicle_mdl->get_vehicle_dropdown();
            $data['driverData'] = $this->get_driver_dropdown->get_vehicle_dropdown();
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/assignVehicle/edit_assign_vehicle_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/assignVehicle', 'refresh'); 
        } 
    } 

    public function update_assign_vehicle($assign_vehicle_id) { 
        $vehicle_info = $this->assign_vehicle_mdl->get_assign_vehicle_by_id($assign_vehicle_id); 
        if (!empty($vehicle_info)) { 
            $config = array( 
              array(
                'field' => 'vehicle',
                'label' => 'vehicle',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'driver',
                'label' => 'driver',
                'rules' => 'trim|required'
            ),
        );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_vehicle($assign_vehicle_id); 
            } else { 
                $data['a_v_t_d_vehicle_id'] = $this->input->post('vehicle', TRUE); 
                $data['a_v_t_d_driver_id'] = $this->input->post('driver', TRUE); 
                $data['a_v_t_d_status'] = 1; 
                $data['a_v_t_d_owner_id'] = $this->session->userdata('admin_id'); 
                $data['a_v_t_d_add_by'] = $this->session->userdata('admin_id'); 
                $data['a_v_t_d_e_date'] = date('Y-m-d'); 
                $result = $this->assign_vehicle_mdl->update_assign_vehicle($assign_vehicle_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/assignVehicle', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/assignVehicle', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/assignVehicle', 'refresh'); 
        } 
    } 
    
    public function remove_assign_vehicle($assign_vehicle_id) { 
       
        $vehicle_info = $this->assign_vehicle_mdl->get_assign_vehicle_by_id($assign_vehicle_id); 
         
        if (!empty($vehicle_info)) { 
            $result = $this->assign_vehicle_mdl->remove_vehicle_by_id($assign_vehicle_id); 
//            echo '<pre>' ;print_r($result);die;
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/assignVehicle', 'refresh'); 
        } 
    } 
    
     public function active_assign_vehicle($assign_vehicle_id) { 
        $vehicle_info = $this->assign_vehicle_mdl->get_vehicle_inactive_data($assign_vehicle_id); 
        if (!empty($vehicle_info)) { 
            $result = $this->assign_vehicle_mdl->active_vehicle_by_id($assign_vehicle_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/assignVehicle', 'refresh'); 
        } 
    }
     public function inactive_assign_vehicle($assign_vehicle_id) { 
         
        $vehicle_info = $this->assign_vehicle_mdl->get_assign_vehicle_by_id($assign_vehicle_id);
        
        if (!empty($vehicle_info)) {
            $result = $this->assign_vehicle_mdl->inactive_vehicle_by_id($assign_vehicle_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/assignVehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/assignVehicle', 'refresh'); 
        } 
    }  
    
    
}
?>