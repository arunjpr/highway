<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax extends CC_Controller {
    /* #********************************************#
      #                   codingmaker             #
      #*********************************************#
      #      Author:     codingmaker              #
      #      Email:      info@codingmaker.com     #
      #      Website:    http://codingmaker.com   #
      #                                             #
      #      Version:    1.0.0                      #
      #      Copyright:  (c) 2018 - codingmaker   #
      #                                             #
      #*********************************************# */
    public function __construct() {
      header('Access-Control-Allow-Origin: *');
      parent::__construct();
      $this->load->model('global_model', 'global_mdl');
    }
    public function index() {
    }
   
} 
?>