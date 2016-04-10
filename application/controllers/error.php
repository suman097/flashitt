<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('image_lib');
    }

    public function index() {
        $data = array();
        $this->load->view('users/404_error', $data);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */