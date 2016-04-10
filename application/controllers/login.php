<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
    }

    public function index() {
        if (!$this->input->post()) {
            $this->load->view('admin/dashboard/login');
        } else {
            $logindata['user_name'] = $this->input->post('username');
            $logindata['password'] = md5($this->input->post('password'));
            $result = $this->users_model->login($logindata);
            if ($result) {
                if ($result->users_type == '1') {
                    $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $result->id,
                        'users_type' => $result->users_type,
                        'users_nikname' => $result->nikname
                    );
                    $this->session->set_userdata('admin', $newdata);
                    redirect('dashboard');
                } else {
                    $data['login_error'] = true;
                    $this->load->view('admin/dashboard/login', $data);
                }
            } else {
                $data['login_error'] = true;
                $this->load->view('admin/dashboard/login', $data);
            }
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */