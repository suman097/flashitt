<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('category_model');
        if (!$this->session->userdata('admin')) {
            redirect('login');
        }
    }

    public function index() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        if (!$this->input->post()) {
            $this->load->view('admin/category/add_category', $data);
        } else {

            $category = $this->input->post('category');
            $parent_category = 0;
            $details = $this->input->post('details');
            $status = $this->input->post('status');

            $create = array(
                'category_name' => $category,
                'category_parent' => $parent_category,
                'category_details' => $details,
                'status' => $status,
                'is_deleted' => "1"
            );
            if ($_FILES['category']['name'] != "") {
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
                if ($this->upload->do_upload('category')) {
                    $create['category_image'] = $this->upload->file_name;
                    $data['create'] = "Successfully updated";
                } else {
                    $data['banner'] = $this->upload->display_errors();
                    $this->session->set_flashdata('error_upload', $data['photo1']);
                }
            }
            $result = $this->db->insert('category', $create);
            redirect("category");
        }
    }
    
    public function editCategory($eid) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['details'] = $this->category_model->viewCategoryDetails($eid);
        //print_r($data['details']); die;
        if (!$this->input->post()) {
            $this->load->view('admin/category/edit_category', $data);
        } else {

            $name = $this->input->post('name');
            $details = $this->input->post('details');
            $status = $this->input->post('status');
            $hid = $this->input->post('hidden_id');
            $update = array(
                'category_name' => $name,
                'category_details' => $details,
                'status' => $status,
            );
            if ($_FILES['category']['name'] != "") {
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
                if ($this->upload->do_upload('category')) {
                    $update['category_image'] = $this->upload->file_name;
                    $data['create'] = "Successfully updated";
                } else {
                    $data['banner'] = $this->upload->display_errors();
                    $this->session->set_flashdata('error_upload', $data['photo1']);
                }
            }
            $this->db->update('category', $update, array('id' => $hid));
            redirect("category/manageCategory");
        }
    }

    public function manageCategory() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['category'] = $this->category_model->showCategoryAdmin();
        $this->load->view('admin/category/view_category', $data);
    }
    
    
    

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */