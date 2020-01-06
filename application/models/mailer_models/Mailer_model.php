<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* #********************************************#
  #                 codingmaker               #
  #*********************************************#
  #      Author:     codingmaker              #
  #      Email:      info@codingmaker.com     #
  #      Website:    http://codingmaker.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2016 - codingmaker   #
  #                                             #
  #*********************************************# */
class Mailer_model extends CI_Model {
	private $_settings = 'tbl_settings';
	private $_email = 'dir_email';

	// for sending basic email,registratin,forget password emails
	function sendEmail($data, $templateName) {
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from("info@codingmaker.com", "codingmaker");
		$this->email->to($data['to_address']);				
		if(isset($data['cc_mail'])){ 		  		 
			$this->email->cc("info@codingmaker.com");	 		
		}  
		if (isset($data['subject'])){
			$this->email->subject($data['subject']);          
		}
		else
		{
			$this->email->subject("Welcome to codingmaker"); 
		} 
		$body = $this->load->view('mailer_views/' . $templateName, $data, true);
		$this->email->message($body);
		$this->email->send();
		$this->email->clear();
	}

	// for getting settings from table
	public function get_settings_info() {
		$result = $this->db->get_where($this->_settings);
		return $result->row_array();
	}

	// for getting dynamic content for email
	public function get_email_content($templateName){
		$this->db->select('dir_email.*')
		->from('dir_email') 
		->where('template_name', $templateName);
		$query_result = $this->db->get();
		$result = $query_result->result_array();
		return $result; 
	}
	// for sending email whose content comes form database
	function contentEmail($data, $templateName) {
		$this->load->library('email');
		//$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from("info@codingmaker.com", "codingmaker");
		$this->email->to($data['to_address']);				
		if(isset($data['cc_mail'])){ 		  		 
			$this->email->cc("info@codingmaker.com");	 		
		}  
		if (isset($data['subject'])){
			$this->email->subject($data['subject']);          
		}
		else
		{
			$this->email->subject("Welcome to codingmaker"); 
		} 
		$body = $this->load->view('mailer_views/' . $templateName, $data, true);
		$this->email->message($body);
		
		$this->email->send();
		$this->email->clear();
	}
}
?>