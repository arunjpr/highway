<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Driver extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/driver_model', 'driver_mdl'); 
        
//         $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
        $data = array();
        $data['title'] = 'Manage Driver';
        $data['active_menu'] = 'driver';
        $data['active_sub_menu'] = 'driver';
        $data['active_sub_sub_menu'] = ''; 
        $data['driver_info'] = $this->driver_mdl->get_driver_info();
       // echo '<pre>' ;        print_r($data['driver_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/drivers/manage_driver_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_driver() { 
        $data = array(); 
        $data['title'] = 'Add Driver';
        $data['active_menu'] = 'driver';
        $data['active_sub_menu'] = 'driver';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/drivers/add_driver_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_driver() {
        // $imgPath = base_url(). '/assets/backend/img/driver/';
        $config = array(
            array(
                'field' => 'Name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Mobile',
                'label' => 'Mobile',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Status',
                'label' => 'Status',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'Dob',
                'label' => 'Dob',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'License_Number',
                'label' => 'License_Number',
                'rules' => 'trim|required|max_length[250]'
            ),
//            array(
//                'upload_path' => $imgPath,
//                'allowed_types' => 'gif|jpg|png',
//                'max_size' => 100,
//                'max_width' => 1024,
//                'max_height' => 768,
//            )
        );
       
        //echo '<pre>' ;print_r($config) ;die;
        $this->form_validation->set_rules($config);
       // $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_driver();
        } else {
            
            
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Status'] = $this->input->post('Status', TRUE); 
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['Dob'] = $this->input->post('Dob', TRUE); 
           // $data['Image'] = $this->input->post('Image', TRUE); 
            $data['Role_Id'] = 3; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            
            
            $insert_id = $this->driver_mdl->add_driver_data($data);  // Insert in user table
            $dataDriver['License_Number'] = $this->input->post('License_Number', TRUE); 
            $dataDriver['User_Id'] = $insert_id; 
            $dataDriver['Status'] = 1; 
            $insert_driverid = $this->driver_mdl->add_driver_licence_data($dataDriver);  // Insert in drive_license table
            if (!empty($insert_id) && (!empty($insert_driverid))) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } 
        } 
    }
 
    public function published_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_driver_by_driver_id($driver_id); 
        if (!empty($driver_info)) { 
            $result = $this->driver_mdl->published_driver_by_id($driver_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/driver', 'refresh'); 
        } 
    }
 
    public function unpublished_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_driver_by_driver_id($driver_id);
        if (!empty($driver_info)) {
            $result = $this->driver_mdl->unpublished_driver_by_id($driver_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/driver', 'refresh'); 
        } 
    }  

    public function edit_driver($driver_id) { 
        $data = array(); 
        $data['user_data'] = $this->driver_mdl->get_driver_by_driver_id($driver_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Driver'; 
            $data['active_menu'] = 'driver'; 
            $data['active_sub_menu'] = 'driver'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/drivers/edit_driver_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/driver', 'refresh'); 
        } 
    } 

    public function update_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_driver_by_driver_id($driver_id); 
        if (!empty($driver_info)) { 
            $config = array( 
                array(
                'field' => 'Name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Mobile',
                'label' => 'Mobile',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Status',
                'label' => 'Status',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'Dob',
                'label' => 'Dob',
                'rules' => 'trim|required|max_length[250]'
            )
            );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_driver($driver_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Status'] = $this->input->post('Status', TRUE); 
                $data['Role_Id'] = 3; 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['Dob'] = $this->input->post('Dob', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['created_on'] = date('Y-m-d H:i:s');  
                $result = $this->driver_mdl->update_driver($driver_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/driver', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/driver', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/driver', 'refresh'); 
        } 
    } 

    public function remove_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_Driver_by_driver_id($driver_id); 
        if (!empty($driver_info)) { 
            $result = $this->driver_mdl->remove_driver_by_id($driver_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/drivers', 'refresh'); 
        } 
    } 
    
    public function view_driver($driver_id) { 
        $data = array(); 
        $data['user_data'] = $this->driver_mdl->get_driver_by_driver_id($driver_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Driver'; 
            $data['active_menu'] = 'driver'; 
            $data['active_sub_menu'] = 'driver'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/drivers/view_driver_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/driver', 'refresh'); 
        } 
    } 
}
?>