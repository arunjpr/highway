<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacypolicy extends CI_Controller {
    
        public function index()
	{
		$this->load->view('privacy_policy');
        }
        
        
        public function terms()
	{
		$this->load->view('term_service');
        }
        
        public function refund()
	{
		$this->load->view('refund_policy');
        }
          
}
