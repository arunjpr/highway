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
        $data['dropdownData'] = $this->vehicle_mdl->get_driver_dropdown();
        $data['vehicleData'] = $this->vehicle_mdl->get_vehicle_dropdown();
        //echo '<pre>' ;print_r($data['vehicleData']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/vehicles/add_vehicle_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_vehicle() {
        // $imgPath = base_url(). '/assets/backend/img/vehicle/';
        $config = array(
            array(
                'field' => 'v_type_id',
                'label' => 'v_type_id',
                'rules' => 'trim|required'
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
            $data['v_type_id'] = $this->input->post('v_type_id', TRUE); 
            $data['v_vehicle_detail'] = $this->input->post('v_vehicle_detail', TRUE); 
            $data['v_vehicle_number'] = $this->input->post('v_vehicle_number', TRUE); 
            $data['v_vehicle_model_no'] = $this->input->post('v_vehicle_model_no', TRUE); 
            $data['v_vehicle_driver_id'] = $this->input->post('v_vehicle_driver_id', TRUE); 
            $data['v_vehicle_Color'] = $this->input->post('v_vehicle_Color', TRUE); 
            $data['v_status'] = 1; 
           // $data['Image'] = $this->input->post('Image', TRUE); 
           
            $data['v_owner_id'] = $this->session->userdata('admin_id'); 
            $data['v_add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            $vehicleTypeId= $data['v_type_id'];
            $this->load->model('admin_models/Vehicle_type_model', 'vehicle_type_mdl');    
            $vehicleTypeData = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicleTypeId); 
            
           
            $insert_id = $this->vehicle_mdl->add_vehicle_data($data); 
            
            
            
            
            
            
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['rcfile']['error'] == 0) {
                    $img = $_FILES['rcfile']['name'];
                    $tmp = $_FILES['rcfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                  
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleRcImage=$insert_id.'_rc_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/vehicle/rcpic/" . $vehicleRcImage;
                        } else {
                            $path ='';
                        }
                            //  echo '<pre>' ;print_r($path) ;die;
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['rcfile'] = $path;
                        }
                    }
                    if (file_exists($path)){
                    $dataUpdate['v_vehicle_rc']=$vehicleRcImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                } 
                }
               // echo '<pre>' ;print_r($Name) ;die;
                if ($_FILES['vimagefile']['error'] == 0) {
                    $imgv = $_FILES['vimagefile']['name'];
                    $tmpv = $_FILES['vimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleImage=$insert_id.'_vimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleImage/" .$vehicleImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_vehicle_Image']=$vehicleImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
               
                
               
               // echo '<pre>' ;print_r($pathv);die;
            //=============profile upload end===============//
            
            
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
        //echo '<pre>' ;print_r($data['user_data']);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Vehicle'; 
            $data['active_menu'] = 'vehicle'; 
            $data['active_sub_menu'] = 'vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['dropdownData'] = $this->vehicle_mdl->get_driver_dropdown();
            $data['vehicleData'] = $this->vehicle_mdl->get_vehicle_dropdown();
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
                'field' => 'v_type_id',
                'label' => 'v_type_id',
                'rules' => 'trim|required'
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
                $data['v_type_id'] = $this->input->post('v_type_id', TRUE); 
                $data['v_vehicle_detail'] = $this->input->post('v_vehicle_detail', TRUE); 
                $data['v_vehicle_number'] = $this->input->post('v_vehicle_number', TRUE); 
                $data['v_vehicle_model_no'] = $this->input->post('v_vehicle_model_no', TRUE); 
                $data['v_vehicle_driver_id'] = $this->input->post('v_vehicle_driver_id', TRUE); 
                $data['v_vehicle_Color'] = $this->input->post('v_vehicle_Color', TRUE); 
                $data['v_status'] = 1; 
                $data['v_add_by'] = $this->session->userdata('admin_id');
                $data['v_date'] = date('Y-m-d H:i:s');  
                
                $vehicleTypeId= $data['v_type_id'];
                $this->load->model('admin_models/Vehicle_type_model', 'vehicle_type_mdl');    
                $vehicleTypeData = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicleTypeId); 
                $result = $this->vehicle_mdl->update_vehicle($vehicle_id, $data); 
                
                
                //=============profile upload===============//
                $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['rcfile']['error'] == 0) {
                    $img = $_FILES['rcfile']['name'];
                    $tmp = $_FILES['rcfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleRcImage=$vehicle_id.'_rc_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/vehicle/rcpic/" . $vehicleRcImage;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['rcfile'] = $path;
                        }
                    }
                    if (file_exists($path)){
                    $dataUpdate['v_vehicle_rc']=$vehicleRcImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                    } 
                }
                if ($_FILES['vimagefile']['error'] == 0) {
                    $imgv = $_FILES['vimagefile']['name'];
                    $tmpv = $_FILES['vimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleImage=$vehicle_id.'_vimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleImage/" . $vehicleImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_vehicle_Image']=$vehicleImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
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
        
        $data['vehicle_data'] = $this->vehicle_mdl->get_vehicle_by_vehicle_id($vehicle_id);
//        echo '<pre>' ;print_r($data['vehicle_data']) ;die;
        if (!empty($data['vehicle_data'])) { 
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