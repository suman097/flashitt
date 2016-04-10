<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        if (!$this->session->userdata('admin')) {
            redirect('login');
        }
    }

    public function index() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $this->load->view('admin/dashboard/home', $data);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */