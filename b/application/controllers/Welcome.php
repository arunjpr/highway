<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
        }
        public function show()  
        { 
            $user_id =2;
            $username='Ashu Saini';
            $data['user_array'] = $this->user_model->get_users($user_id,$username);
            $this->load->view('user_view',$data);
        }  
       public function insert(){
            $Name = 'raj';
            $email = 'raj@gmail.com';
            $this->user_model->create_users([
                'Name'=>$Name,
                'Role_Id'=>"2",
                'Email'=>$email,
            ]);
            }
        public function update(){
            $id=9;
            $Name = 'amit saini';
            $email = 'raj@gmail.com';
            $this->user_model->update_users([
                'Name'=>$Name,
                'Role_Id'=>"2",
                'Email'=>$email,
            ],$id);
            
        }
        public function delete(){
            $id=8;
            $this->user_model->delete_user($id);
        }
       
    
}
