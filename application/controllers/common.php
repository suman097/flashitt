<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('common_model');
        if (!$this->session->userdata('admin')) {
            redirect('login');
        }
    }

    public function isDeleted() {
        $id = $this->uri->segment(3);
        $table = $this->uri->segment(4);
        $controller = $this->uri->segment(4);
        $function = $this->uri->segment(5);
        $update = array(
            'is_deleted' => 0
        );
        $this->db->update($table, $update, "id = " . $id);
        redirect($controller . "/" . $function);
    }
    
    public function ajaxChangeStatus() {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $details = $this->common_model->viewCompanyDetailsOnchange($id, $table);
        if($details->status == 1){
            $update_status = 0;
        }else{
            $update_status = 1;
        }
        $update = array(
            'status' => $update_status
        );
        $this->db->update($table, $update, "id = " . $id);
        if($update_status == 0){
            echo '<img src="'.base_url() . 'images/icons/inactive.png" alt="Inactive" >';
        }else{
            echo '<img src="'.base_url() . 'images/icons/active.gif" alt="Active" >';
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */