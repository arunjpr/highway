<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Owner extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/useradmin_model', 'useradmin_mdl'); 
        
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Owner';
        $data['active_menu'] = 'owner';
        $data['active_sub_menu'] = 'owner';
        $data['active_sub_sub_menu'] = ''; 
        $data['owner_info'] = $this->useradmin_mdl->get_owner_info();
       // echo '<pre>' ;        print_r($data['owner_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/owners/manage_owner_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_owner() { 
        $data = array(); 
        $data['title'] = 'Add Owner';
        $data['active_menu'] = 'owner';
        $data['active_sub_menu'] = 'owner';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/owners/add_owner_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_owner() {
        // $imgPath = base_url(). '/assets/backend/img/owner/';
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
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_owner();
        } else {
            
            
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Status'] = $this->input->post('Status', TRUE); 
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['Image'] = ""; 
            $data['Role_Id'] = 5; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            
            //echo '<pre>' ;print_r($data) ;die;
            $insert_id = $this->useradmin_mdl->add_owner_data($data); 
            
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $profilePic=$insert_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/owner/profile/" . strtolower($profilePic);
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->useradmin_mdl->update_owner($insert_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
            
            
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } 
    }
 
    public function published_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
            $result = $this->useradmin_mdl->published_owner_by_id($owner_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    }
 
    public function unpublished_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id);
        if (!empty($owner_info)) {
            $result = $this->useradmin_mdl->unpublished_owner_by_id($owner_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    }  

    public function edit_owner($owner_id) { 
        $data = array(); 
        $data['user_data'] = $this->useradmin_mdl->get_owner_by_owner_id($owner_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Owner'; 
            $data['active_menu'] = 'owner'; 
            $data['active_sub_menu'] = 'owner'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/owners/edit_owner_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 

    public function update_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
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
                $this->edit_owner($owner_id); 
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
                $result = $this->useradmin_mdl->update_owner($owner_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/owner', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/owner', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 

    public function remove_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_Owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
            $result = $this->useradmin_mdl->remove_owner_by_id($owner_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owners', 'refresh'); 
        } 
    } 
    
    
    public function view_owner($owner_id) { 
        $data = array(); 
        $data['user_data'] = $this->useradmin_mdl->get_owner_by_owner_id($owner_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Owner'; 
            $data['active_menu'] = 'owner'; 
            $data['active_sub_menu'] = 'owner'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/owners/view_owner_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 
    
    
    
}
?>