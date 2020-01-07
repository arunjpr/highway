<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Content extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/content_model', 'content_mdl'); 
        
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Content';
        $data['active_menu'] = 'content';
        $data['active_sub_menu'] = 'content';
        $data['active_sub_sub_menu'] = ''; 
        $data['content_info'] = $this->content_mdl->get_content_info();
       // echo '<pre>' ;        print_r($data['content_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/contents/manage_content_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_content() { 
        $data = array(); 
        $data['title'] = 'Add Content';
        $data['active_menu'] = 'content';
        $data['active_sub_menu'] = 'content';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/contents/add_content_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_content() {
        $config = array(
            array(
                'field' => 'c_content',
                'label' => 'c_content',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'c_title',
                'label' => 'c_title',
                'rules' => 'trim|required|max_length[250]'
            ),
            
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_content();
        } else {
            $data['c_content'] = $this->input->post('c_content', TRUE); 
            $data['c_title'] = $this->input->post('c_title', TRUE); 
            $data['c_status'] = 1; 
            $data['c_user_Id'] = $this->session->userdata('admin_id'); 
            $data['c_add_by'] = $this->session->userdata('admin_id'); 
            $data['c_date'] = date('Y-m-d H:i:s');  
            $insert_id = $this->content_mdl->add_content_data($data); 
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } 
        } 
    }
 
    public function published_content($content_id) { 
        $content_info = $this->content_mdl->get_content_by_content_id($content_id); 
        if (!empty($content_info)) { 
            $result = $this->content_mdl->published_content_by_id($content_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/content', 'refresh'); 
        } 
    }
 
    public function unpublished_content($content_id) { 
        $content_info = $this->content_mdl->get_content_by_content_id($content_id);
        if (!empty($content_info)) {
            $result = $this->content_mdl->unpublished_content_by_id($content_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/content', 'refresh'); 
        } 
    }  

    public function edit_content($content_id) { 
        $data = array(); 
        $data['user_data'] = $this->content_mdl->get_content_by_content_id($content_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Content'; 
            $data['active_menu'] = 'content'; 
            $data['active_sub_menu'] = 'content'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/contents/edit_content_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/content', 'refresh'); 
        } 
    } 

    public function update_content($content_id) { 
        $content_info = $this->content_mdl->get_content_by_content_id($content_id); 
        if (!empty($content_info)) { 
            $config = array( 
                array(
                'field' => 'c_content',
                'label' => 'c_content',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'c_title',
                'label' => 'c_title',
                'rules' => 'trim|required|max_length[250]'
            ),
            );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_content($content_id); 
            } else { 
                $data['c_content'] = $this->input->post('c_content', TRUE); 
                $data['c_title'] = $this->input->post('c_title', TRUE); 
                $data['c_status'] = 1; 
                $data['c_user_Id'] = $this->session->userdata('admin_id'); 
                $data['c_add_by'] = $this->session->userdata('admin_id'); 
                $data['c_date'] = date('Y-m-d H:i:s');  
                $result = $this->content_mdl->update_content($content_id, $data); 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/content', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/content', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/content', 'refresh'); 
        } 
    } 

    public function remove_content($content_id) { 
        $content_info = $this->content_mdl->get_Content_by_content_id($content_id); 
        if (!empty($content_info)) { 
            $result = $this->content_mdl->remove_content_by_id($content_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/content', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/contents', 'refresh'); 
        } 
    } 
    
    
    public function view_content($content_id) { 
        $data = array(); 
        $data['user_data'] = $this->content_mdl->get_content_by_content_id($content_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Content'; 
            $data['active_menu'] = 'content'; 
            $data['active_sub_menu'] = 'content'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/contents/view_content_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/content', 'refresh'); 
        } 
    } 
    
    
    
}
?>