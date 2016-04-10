<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    

class User_management extends CI_Controller {
    
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

    public function index() {
        $seesion_details = $this->session->userdata('admin');
    		$data['users_type'] = $seesion_details->users_type;
    		$data['users_nikname'] = $seesion_details->users_nikname;
    		$data['users'] = $this->users_model->showAllUsers();
        foreach($data['users'] as $user){
            $count[$user->id] = $this->users_model->countUsersReports($user->id);
        }
        $data['count'] = $count;
        //print_r($data); die;
        $this->load->view('admin/user_management/user_view_page', $data);
    }

    public function showUsersDetails($user_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['user'] = $this->users_model->viewProfileDetails($user_id);
        $this->load->view('admin/user_management/user_view_page_details', $data);
    }

    public function showUsersPostDetails($user_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['posts'] = $this->posts_model->viewPostsProfile($user_id);
        $this->load->view('admin/user_management/user_view_post', $data);
    }
    
    public function showUsersRequirementDetails($user_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['requirements'] = $this->posts_model->viewRequirementsByUser($user_id);
        $this->load->view('admin/user_management/user_view_requirements', $data);
    }
    
    public function deleteRequirementsUsers( $id, $users_id ) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $update = array(
            'is_deleted' => 0
        );
        $this->db->update('requirement', $update, "id = " . $id);
        redirect('user_management/showUsersRequirementDetails/'.$users_id);
    }

    public function showUsersPostDetailsWithContent($post_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['post'] = $this->posts_model->viewPostsDeatilsEmail($post_id);
        $data['post_contents'] = $this->posts_model->viewPostsContents($post_id);
        $data['count_like'] = $this->posts_model->countPostLike($post_id);
        $data['comments'] = $this->posts_model->fetchAllComment($post_id);
        $data['count_comments'] = $this->posts_model->countPostComment($post_id);
        $data['liked'] = $this->posts_model->peopleOfLike($post_id);
        $this->load->view('admin/user_management/user_view_post_details', $data);
    }
	
    public function showUsersReports($user_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['reports'] = $this->users_model->viewAllReports($user_id);
        //print_r($data); die;
        $this->load->view('admin/user_management/user_reports', $data);
    }
    
    public function deletePostUserManagement($post_id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $update = array(
            'title' => 'post deleted by admin',
            'description' => ''
        );
        $this->db->update('post', $update, "id = " . $post_id);
        $post_contents = $this->posts_model->viewPostsContents($post_id);
        if(!empty($post_contents)){
            foreach($post_contents as $content){
                $this->db->delete('posts_content', array('id' => $content->id));
            }
        }
        redirect('user_management/showUsersPostDetailsWithContent/'.$post_id);
    }

    public function message() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['messages'] = $this->posts_model->showAllMessagesUsers();
        //print_r($data); die;
        $this->load->view('admin/user_management/user_message', $data);
    }

    public function sentMessageToUsers() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['users'] = $this->users_model->showAllUsers();
        if(!$this->input->post()){
            $this->load->view('admin/user_management/sent_message_to_users', $data);
        }else{
            $user_id = $this->input->post('users');
            $message = $this->input->post('message');
            if($user_id == 0){
                $users_message = $this->users_model->showAllUsers();
                foreach( $users_message as $user ){
                    $create = array(
                        'user_id' => "74",
                        'friend_id' => $user->id,
                        'type' => 1,
                        'text' => $message,
                        'created_at' => time()
                    );
                    $this->db->insert('massage', $create);
                    $exist_notification = $this->posts_model->checkForExistingNotification( $user->id, 74 );
                    if ($exist_notification) {
                        $update = array(
                            'status' => 2
                        );
                        $this->db->update('notifications', $update, "id = " . $exist_notification);
                    }
                    $create_notifications = array(
                        'user_id' => $user->id,
                        'notification' => "Message from admin",
                        'friend_id' => 74,
                        'link_id' => 74,
                        'type' => 1,
                        'status' => 1,
                        'created_at' => time()
                    );
                    $this->db->insert('notifications', $create_notifications);
                }
            }else{
                $create = array(
                    'user_id' => "74",
                    'friend_id' => $user_id,
                    'type' => 1,
                    'text' => $message,
                    'created_at' => time()
                );
                $this->db->insert('massage', $create);
                $exist_notification = $this->posts_model->checkForExistingNotification( $user_id, 74 );
                if ($exist_notification) {
                    $update = array(
                        'status' => 2
                    );
                    $this->db->update('notifications', $update, "id = " . $exist_notification);
                }
                $create_notifications = array(
                    'user_id' => $user_id,
                    'notification' => "Message from admin",
                    'friend_id' => 74,
                    'link_id' => 74,
                    'type' => 1,
                    'status' => 1,
                    'created_at' => time()
                );
                $this->db->insert('notifications', $create_notifications);
            }
            redirect('user_management/sentMessageToUsers');
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */