<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
public function login()
	{
 echo  $this->input->post('username');
 echo  $this->input->post('password');
    }
        
    
    
}
