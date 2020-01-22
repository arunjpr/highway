<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Coupan extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Coupan_model','coupan_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Manage Coupan';
        $data['active_menu'] = 'coupan';
        $data['active_sub_menu'] = 'coupan';
        $data['active_sub_sub_menu'] = ''; 
        $data['coupan_info'] = $this->coupan_mdl->get_coupan_info();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/coupan/manage_coupan_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    public function add_coupan(){ 
        $data = array(); 
        $data['title'] = 'Add Coupan';
        $data['active_menu'] = 'coupan';
        $data['active_sub_menu'] = 'coupan';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/coupan/add_coupan_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_coupan() {
        $config = array(
            array(
                'field' => 'c_coupan_code',
                'label' => 'c_coupan_code',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'c_coupan_value',
                'label' => 'c_coupan_value',
                'rules' => 'trim|required|max_length[250]'
            )
            );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_coupan();
            } else {
            $data['c_coupan_code'] = $this->input->post('c_coupan_code', TRUE); 
            $data['c_coupan_value'] = $this->input->post('c_coupan_value', TRUE); 
            $data['c_coupan_status'] = 1; 
            $data['c_coupan_add_by'] = $this->session->userdata('admin_id'); 
            $data['c_date'] = date('Y-m-d'); 
            $insert_id = $this->coupan_mdl->add_coupan_data($data); 
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                    redirect('admin/coupan', 'refresh'); 
            } 
        } 
    }
   
    public function edit_coupan($coupan_id) { 
        $data = array(); 
        $data['user_data'] = $this->coupan_mdl->get_coupan_by_id($coupan_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Coupan'; 
            $data['active_menu'] = 'coupan'; 
            $data['active_sub_menu'] = 'coupan'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/coupan/edit_coupan_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/coupan', 'refresh'); 
        } 
    } 

    public function update_coupan($coupan_id) { 
        $coupan_info = $this->coupan_mdl->get_coupan_by_id($coupan_id); 
        if (!empty($coupan_info)) { 
            $config = array( 
               array(
                'field' => 'c_coupan_code',
                'label' => 'c_coupan_code',
                'rules' => 'trim|required|max_length[250]'
            ),
               array(
                'field' => 'c_coupan_value',
                'label' => 'c_coupan_value',
                'rules' => 'trim|required|max_length[250]'
            )
        );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_coupan($coupan_id); 
            } else { 
                $data['c_coupan_code'] = $this->input->post('c_coupan_code', TRUE); 
                $data['c_coupan_value'] = $this->input->post('c_coupan_value', TRUE); 
                $data['c_coupan_status'] = 1;
                $result = $this->coupan_mdl->update_coupan($coupan_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/coupan', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/coupan', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/coupan', 'refresh'); 
        } 
    } 
    
    public function remove_coupan($coupan_id) { 
       
        $coupan_info = $this->coupan_mdl->get_coupan_by_id($coupan_id); 
         
        if (!empty($coupan_info)) { 
            $result = $this->coupan_mdl->remove_coupan_by_id($coupan_id); 
//            echo '<pre>' ;print_r($result);die;
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/coupan', 'refresh'); 
        } 
    } 
    
     public function active_coupan($coupan_id) { 
        $coupan_info = $this->coupan_mdl->get_coupan_inactive_data($coupan_id); 
        if (!empty($coupan_info)) { 
            $result = $this->coupan_mdl->active_coupan_by_id($coupan_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/coupan', 'refresh'); 
        } 
    }
     public function inactive_coupan($coupan_id) { 
         
        $coupan_info = $this->coupan_mdl->get_coupan_by_id($coupan_id);
        
        if (!empty($coupan_info)) {
            $result = $this->coupan_mdl->inactive_coupan_by_id($coupan_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/coupan', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/coupan', 'refresh'); 
        } 
    }  
    
    
}
?>