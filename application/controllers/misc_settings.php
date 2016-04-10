<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    

class Misc_settings extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('posts_model');
        $this->load->model('common_model');
        if (!$this->session->userdata('admin')){ 
            redirect('login');		
        }
    }

    public function bannerImageUpdate() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['banner_image'] = $this->users_model->getContentPage('banner_image');
        if(!$this->input->post()){
            $this->load->view('admin/misc_settings/update_banner_image', $data);
        }else{
            if ($_FILES['banner']['name'] != "") {
                if (!is_dir(FCPATH . '/images/misc')) {
                    mkdir(FCPATH . '/images/misc');
                }

                $config['upload_path'] = 'images/misc/'; // Location to save the image
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                $config['max_size'] = '10000'; // in KB
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('banner')) {
                    $update['content'] = $this->upload->file_name;
                    $this->db->update( 'page', $update, "id = 7" );
                    $data['banner'] = "Successfully updated";
                } else {
                    $data['banner'] = $this->upload->display_errors();
                    $this->session->set_flashdata('error_upload', $data['photo1']);
                }
                redirect("misc_settings/bannerImageUpdate");
            }
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */