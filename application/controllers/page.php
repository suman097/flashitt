<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    

class Page extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('common_model');
        if (!$this->session->userdata('admin')){ 
            redirect('login');		
        }
    }

    public function index() {
        $seesion_details = $this->session->userdata('admin');
		$data['users_type'] = $seesion_details->users_type;
		$data['users_nikname'] = $seesion_details->users_nikname;
		$data['pages'] = $this->users_model->getPages();
        $this->load->view('admin/page/view_page', $data);
    }
	
	public function managepage($eid) {
        $seesion_details = $this->session->userdata('admin');
		$data['users_type'] = $seesion_details->users_type;
		$data['users_nikname'] = $seesion_details->users_nikname;
		
		if($this->input->post()){
			$uid = $this->input->post('hid_page_id');
			$update = array(
                'content' => $this->input->post('page_content')
            );
			$this->db->where('id', $uid);
			$this->db->update('page', $update);
		}
		$data['pages'] = $this->users_model->getPagesWithId($eid);
        $this->load->view('admin/page/edit_page', $data);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */