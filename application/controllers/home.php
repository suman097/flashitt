<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper("file");
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('category_model');
        $this->load->model('posts_model');
        date_default_timezone_set ( 'Asia/Kolkata' );
    }

    public function index() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['countries'] = $this->users_model->showCountryUsers();
        $data['content'] = $this->users_model->getContentPage('banner_text');
        $data['banner'] = $this->users_model->getContentPage('banner_image');
        $data['heading'] = $this->users_model->getContentPage('slider_text');
        //print_r($data['categories']); die;
        $this->load->view('users/index', $data);
    }

    public function ajaxRegisterUsers() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $rand_verify = rand(1000000000000, 9999999999999);
        $create = array(
            'email' => $email,
            'password' => $password,
            'name' => $name
        );
        $this->db->insert('users', $create);
        $insert_id = $this->db->insert_id();
        $create = array(
            'users_id' => $insert_id,
            'status' => 0,
            'updated_at' => time()
        );
        $this->db->insert('post', $create);
        if ($insert_id) {
            $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $insert_id,
                        'users_name' => $name
            );
            $this->session->set_userdata('users', $newdata);
        }
        if (isset($email)) {
            $subject = "Your Register successfully done.";
            $to = $email;
            $message = "
			<HTML>
			<HEAD>
			<TITLE>Your Register successfully done</TITLE>
			</HEAD>
			<BODY>
			<TABLE>
			<TR>
			<TD>
			Hi,
			</TD>
			</TR>
			<TR>
			<TD>
			

                            Your Registration successfully done on <a href = 'www.flashitt.com'>www.flashitt.com</a>.
			
			
			<br><br>
			-- 
			-- Thanks<BR>

                        Team <BR>
                        Flashitt<BR>

                        <BR>
			<BR><BR>
			============
			<BR><BR>
			
			
			IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE
			
			This electronic communication is intended by the sender only for the access
			and use by the addressee and may contain legally privileged and
			confidential information. If you are not the addressee, you are notified
			that any transmission, disclosure, use, access to, storage or photocopying
			of this e-mail and any attachments is strictly prohibited. The legal
			privilege and confidentiality attached to this e-mail and any attachments
			is not waived, lost or destroyed by reason of a mistaken delivery to you.
			If you have received this e-mail and any attachments in error please
			immediately delete it and all copies from your system and notify the sender
			by e-mail.<BR><BR>
			==================
			<BR><BR>
				
			</TD>
			</TR>
			</TABLE>
			";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            // More headers
            $headers .= 'From: Flashitt<www.flashitt.com>' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
    }

    public function ajaxForgetPassword() {
        $email = $this->input->post('email');
        $result = $this->users_model->checkEmailUser($email);
        if ($result) {
            $genarate_id = (((( $result * 82736 ) - 2534 ) + 87213 ) - 342 );
            $update = array(
                'forget_password' => $genarate_id
            );
            $this->db->update('users', $update, "id = " . $result);
            if (isset($email)) {
                $subject = "Here is your forget password link";
                $to = $email;
                $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>Here is your forget password link</TITLE>
                            </HEAD>
                            <BODY>
                            <TABLE>
                            <TR>
                            <TD>
                            Hi,
                            </TD>
                            </TR>
                            <TR>
                            <TD>


                                To change your password please  <a href = '" . base_url("home/forgetChangePassword") . "/" . $genarate_id . "'>click here</a>.


                            <br><br>
                            -- 
                            -- Thanks<BR>

                            Team <BR>
                            Flashitt<BR><BR>

                            <BR>
                            <BR><BR>
                            ============
                            <BR><BR>


                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                            This electronic communication is intended by the sender only for the access
                            and use by the addressee and may contain legally privileged and
                            confidential information. If you are not the addressee, you are notified
                            that any transmission, disclosure, use, access to, storage or photocopying
                            of this e-mail and any attachments is strictly prohibited. The legal
                            privilege and confidentiality attached to this e-mail and any attachments
                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                            If you have received this e-mail and any attachments in error please
                            immediately delete it and all copies from your system and notify the sender
                            by e-mail.<BR><BR>
                            ==================
                            <BR><BR>

                            </TD>
                            </TR>
                            </TABLE>
                            ";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                // More headers
                $headers .= 'From: Flashitt<www.flashitt.com>' . "\r\n";

                mail($to, $subject, $message, $headers);
            }
            echo "done";
            exit;
        } else {
            echo "not done";
            exit;
        }
    }

    public function ajaxCheckEmail() {
        $email = $this->input->post('email');
        $result = $this->users_model->checkEmailUser($email);
        if ($result) {
            echo "exist";
        } else {
            echo "Done";
        }
    }

    public function ajaxLoginUsers() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->users_model->checkUserLogin($email, $password);
        $reason = $this->users_model->checkUserLoginStatus($email, $password);
        if ($result) {
            $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $result->id,
                        'users_name' => $result->name
            );
            $this->session->set_userdata('users', $newdata);
            echo "done";
        } else if( $reason->status == 0 ){
            echo "block by admin";
        }else {
            echo "error";
        }
    }

    public function logout() {
        $this->session->unset_userdata('users');
        $this->session->sess_destroy();
        redirect('home');
    }

    public function profile() {
        $seesion_details = $this->session->userdata('users');

        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['profile'] = $this->users_model->viewProfileDetails($seesion_details->logged_id);
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
            if (!empty($data['friend_list'])) {
                foreach ($data['friend_list'] as $friend) {
                    if ($seesion_details->logged_id == $friend->profile_id1) {
                        $friend_array[] = $friend->profile_id2;
                    } else {
                        $friend_array[] = $friend->profile_id1;
                    }
                }
            }
            $friend_array[] = $seesion_details->logged_id;
            $friend_in_data = implode(",", $friend_array);
            //$data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
            $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data, 0, 10);
            //print_r($data['posts']); die;
            if (!empty($data['posts'])) {
                foreach ($data['posts'] as $post) {
                    $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                    $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                    $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                    $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                    $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                    $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                    $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                    $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                    $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
                }
            }
            $data['notification'] = $this->users_model->viewNotificationProfile($seesion_details->logged_id);
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            //print_r($data['firework']); die;
            $this->load->view('users/profile', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }
    
    public function ajaxSearchFriends() {
        $search = $this->input->post('search');
        $user_id = ((( $this->input->post('user_id') + 769 ) - 5364 ) / 26 );
        $profile_details = $this->users_model->viewProfileDetails($user_id);
        $data['friend_list'] = $this->users_model->viewFriendsListProfileSearch($user_id, $search, $profile_details->name);
        $data['users_loged_in_id'] = $user_id;
        
        $this->load->view('users/ajax_friend_list_search', $data);
    }

    public function ajaxLikePost() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $post_id = $this->input->post('post');
            $post_status = $this->posts_model->checkPostLike($seesion_details->logged_id, $post_id);
            if ($post_status) {
                $create = array(
                    'post_id' => $post_id,
                    'user_id' => $seesion_details->logged_id,
                    'like_type' => 1,
                    'count_like' => 1
                );

                $this->db->insert('like', $create);
                $post_details = $this->posts_model->viewPostsDeatilsEmail($post_id);
                //print_r($post_details); die;
                //Copy to the another users like as a post copy
                /*$create_like_post = array(
                    'users_id' => $seesion_details->logged_id,
                    'title' => $seesion_details->users_name." loved ".$post_details->name."'s post",
                    'description' => $post_details->title."<br>".$post_details->description,
                    'category' => $post_details->category,
                    'country' => $post_details->country,
                    'city' => $post_details->city
                );
                $this->db->insert('post', $create_like_post);
                $insert_id = $this->db->insert_id();
                $post_contents = $this->posts_model->viewPostsContents($post_details->id);
                if(!empty($post_contents)){
                	foreach($post_contents as $post_content){
                		$create_post_content = array(
		                    'post_id' => $insert_id,
		                    'elements' => $post_content->elements,
		                    'elements_type' => $post_content->elements_type,
		                    'created_at' => $post_content->created_at,
		                );
		                $this->db->insert('posts_content', $create_post_content);
                	}
                }*/
                
                $update_like_post = array(
                    'updated_at' => time()
                );
                $this->db->update('post', $update_like_post, "id = " . $post_id);

                if($post_details->users_id != $seesion_details->logged_id){
                    $create_notifications = array(
                        'user_id' => $post_details->users_id,
                        'notification' => $seesion_details->users_name." wowed your post.",
                        'friend_id' => $seesion_details->logged_id,
                        'link_id' => $post_details->id,
                        'type' => 3,
                        'status' => 1,
                        'created_at' => time()
                    );
                    $this->db->insert('notifications', $create_notifications);
                    if (isset($post_details->email)) {
                        $subject = $seesion_details->users_name." wowed your post";
                        $to = $post_details->email;
                        $message = "
                                    <HTML>
                                    <HEAD>
                                    <TITLE>".$seesion_details->users_name." wowed your post</TITLE>
                                    </HEAD>
                                    <BODY>
                                    <TABLE>
                                    <TR>
                                    <TD>
                                    Hi,
                                    </TD>
                                    </TR>
                                    <TR>
                                    <TD>


                                        ".$seesion_details->users_name." wowed your post.<br>
                                        ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                        Simply post,search,hire or connect with talents around the world.


                                    <br><br>
                                    -- 
                                    -- Thanks<BR>

                                    Team Flashitt  <BR>
                                    <BR>
                                    <BR><BR>
                                    ============
                                    <BR><BR>


                                    IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                    This electronic communication is intended by the sender only for the access
                                    and use by the addressee and may contain legally privileged and
                                    confidential information. If you are not the addressee, you are notified
                                    that any transmission, disclosure, use, access to, storage or photocopying
                                    of this e-mail and any attachments is strictly prohibited. The legal
                                    privilege and confidentiality attached to this e-mail and any attachments
                                    is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                    If you have received this e-mail and any attachments in error please
                                    immediately delete it and all copies from your system and notify the sender
                                    by e-mail.<BR><BR>
                                    ==================
                                    <BR><BR>

                                    </TD>
                                    </TR>
                                    </TABLE>
                                    ";

                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                        // More headers
                        $headers .= 'From: Flashitt' . "\r\n";

                        mail($to, $subject, $message, $headers);
                    }
                }
                $likedPostUsers = $this->posts_model->peopleOfLike($post_id);
                if(!empty($likedPostUsers)){
                    foreach($likedPostUsers as $likedPostUser){
                        if($post_details->users_id != $likedPostUser->user_id && $likedPostUser->user_id != $seesion_details->logged_id){
                            $create_notifications = array(
                                'user_id' => $likedPostUser->user_id,
                                'notification' => $seesion_details->users_name." wowed ".$post_details->name."'s post",
                                'friend_id' => $seesion_details->logged_id,
                                'link_id' => $post_details->id,
                                'type' => 3,
                                'status' => 1,
                                'created_at' => time()
                            );
                            $this->db->insert('notifications', $create_notifications);
                            
                            if (!empty($likedPostUser->email)) {
                                $subject = $seesion_details->users_name." wowed ".$post_details->name."'s post";
                                $to = $likedPostUser->email;
                                $message = "
                                            <HTML>
                                            <HEAD>
                                            <TITLE>".$seesion_details->users_name." wowed ".$post_details->name."'s post</TITLE>
                                            </HEAD>
                                            <BODY>
                                            <TABLE>
                                            <TR>
                                            <TD>
                                            Hi,
                                            </TD>
                                            </TR>
                                            <TR>
                                            <TD>


                                                ".$seesion_details->users_name." wowed ".$post_details->name."'s post.<br>
                                                ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                                Simply post,search,hire or connect with talents around the world.


                                            <br><br>
                                            -- 
                                            -- Thanks<BR>

                                           
                                            Team Flashitt  <BR>
                                            <BR><BR>
                                            ============
                                            <BR><BR>


                                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                            This electronic communication is intended by the sender only for the access
                                            and use by the addressee and may contain legally privileged and
                                            confidential information. If you are not the addressee, you are notified
                                            that any transmission, disclosure, use, access to, storage or photocopying
                                            of this e-mail and any attachments is strictly prohibited. The legal
                                            privilege and confidentiality attached to this e-mail and any attachments
                                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                            If you have received this e-mail and any attachments in error please
                                            immediately delete it and all copies from your system and notify the sender
                                            by e-mail.<BR><BR>
                                            ==================
                                            <BR><BR>

                                            </TD>
                                            </TR>
                                            </TABLE>
                                            ";

                                // Always set content-type when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                                // More headers
                                $headers .= 'From: Flashitt' . "\r\n";

                                mail($to, $subject, $message, $headers);
                            }
                        }
                    }
                }
                $count = $this->posts_model->countPostLike($post_id);
                echo $count;
            } else {
                echo "not done";
            }
        } else {
            echo "not loged in";
        }
    }
    
    
    /* Created by : Suman Maji
    * Modify at : 3rd february, 2016
    * For start firework by ajax
    */
    
    public function ajaxFirePost() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $post_id = $this->input->post('post');
            //$firework_status = $this->posts_model->checkFireWork($post_id);
            $firework_status = $this->posts_model->checkFireWorkWithUsers( $post_id, $seesion_details->logged_id );
            if ($firework_status) {
                $create = array(
                    'post_id' => $post_id,
                    'user_id' => $seesion_details->logged_id,
                    'count_firework' => 1
                );

                $this->db->insert('firework', $create);
                $post_details = $this->posts_model->viewPostsDeatilsEmail($post_id);
                
                $update_like_post = array(
                    'updated_at' => time()
                );
                $this->db->update('post', $update_like_post, "id = " . $post_id);

                if($post_details->users_id != $seesion_details->logged_id){
                    $create_notifications = array(
                        'user_id' => $post_details->users_id,
                        'notification' => $seesion_details->users_name." fireworked your post",
                        'friend_id' => $seesion_details->logged_id,
                        'link_id' => $post_details->id,
                        'type' => 3,
                        'status' => 1,
                        'created_at' => time()
                    );
                    $this->db->insert('notifications', $create_notifications);
                    if (isset($post_details->email)) {
                        $subject = $seesion_details->users_name." fireworked your post";
                        $to = $post_details->email;
                        $message = "
                                    <HTML>
                                    <HEAD>
                                    <TITLE>".$seesion_details->users_name." fireworked your post</TITLE>
                                    </HEAD>
                                    <BODY>
                                    <TABLE>
                                    <TR>
                                    <TD>
                                    Hi,
                                    </TD>
                                    </TR>
                                    <TR>
                                    <TD>


                                        ".$seesion_details->users_name." fireworked your post.<br>
                                        ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                        Simply post,search,hire or connect with talents around the world.


                                    <br><br>
                                    -- 
                                    -- Thanks<BR>

                                    
                                    Team Flashitt  <BR>
                                    <BR><BR>
                                    ============
                                    <BR><BR>


                                    IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                    This electronic communication is intended by the sender only for the access
                                    and use by the addressee and may contain legally privileged and
                                    confidential information. If you are not the addressee, you are notified
                                    that any transmission, disclosure, use, access to, storage or photocopying
                                    of this e-mail and any attachments is strictly prohibited. The legal
                                    privilege and confidentiality attached to this e-mail and any attachments
                                    is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                    If you have received this e-mail and any attachments in error please
                                    immediately delete it and all copies from your system and notify the sender
                                    by e-mail.<BR><BR>
                                    ==================
                                    <BR><BR>

                                    </TD>
                                    </TR>
                                    </TABLE>
                                    ";

                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                        // More headers
                        $headers .= 'From: Flashitt' . "\r\n";

                        mail($to, $subject, $message, $headers);
                    }
                }
                $fireworkPostUsers = $this->posts_model->checkFireWorkBy($post_id);
                if(!empty($fireworkPostUsers)){
                    foreach($fireworkPostUsers as $fireworkedPostUser){
                        if($post_details->users_id != $fireworkedPostUser->user_id && $fireworkedPostUser->user_id != $seesion_details->logged_id){
                            $create_notifications = array(
                                'user_id' => $fireworkedPostUser->user_id,
                                'notification' => $seesion_details->users_name." fireworked ".$post_details->name."'s post",
                                'friend_id' => $seesion_details->logged_id,
                                'link_id' => $post_details->id,
                                'type' => 3,
                                'status' => 1,
                                'created_at' => time()
                            );
                            $this->db->insert('notifications', $create_notifications);
                            
                            if (!empty($fireworkedPostUser->email)) {
                                $subject = $seesion_details->users_name." fireworked ".$post_details->name."'s post";
                                $to = $fireworkedPostUser->email;
                                $message = "
                                            <HTML>
                                            <HEAD>
                                            <TITLE>".$seesion_details->users_name." fireworked ".$post_details->name."'s post</TITLE>
                                            </HEAD>
                                            <BODY>
                                            <TABLE>
                                            <TR>
                                            <TD>
                                            Hi,
                                            </TD>
                                            </TR>
                                            <TR>
                                            <TD>


                                                ".$seesion_details->users_name." fireworked ".$post_details->name."'s post.<br>
                                                ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                                Simply post,search,hire or connect with talents around the world.


                                            <br><br>
                                            -- 
                                            -- Thanks<BR>
 
                                            Team Flashitt  <BR>
                                            <BR><BR>
                                            ============
                                            <BR><BR>


                                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                            This electronic communication is intended by the sender only for the access
                                            and use by the addressee and may contain legally privileged and
                                            confidential information. If you are not the addressee, you are notified
                                            that any transmission, disclosure, use, access to, storage or photocopying
                                            of this e-mail and any attachments is strictly prohibited. The legal
                                            privilege and confidentiality attached to this e-mail and any attachments
                                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                            If you have received this e-mail and any attachments in error please
                                            immediately delete it and all copies from your system and notify the sender
                                            by e-mail.<BR><BR>
                                            ==================
                                            <BR><BR>

                                            </TD>
                                            </TR>
                                            </TABLE>
                                            ";

                                // Always set content-type when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                                // More headers
                                $headers .= 'From: Flashitt' . "\r\n";

                                mail($to, $subject, $message, $headers);
                            }
                        }
                    }
                }
                echo $count_fireworked = $this->posts_model->countFireWorkBy($post_id);
            } else {
                echo "not done";
            }
        } else {
            echo "not loged in";
        }
    }

    
    /* Created by : Suman Maji
    * Modify at : 12th january, 2016
    * For comment of the post by ajax
    */
    
    public function ajaxPostComment() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $post_id = $this->input->post('post_id');
            $post = $this->input->post('post');
            $create = array(
                'post_id' => $post_id,
                'user_id' => $seesion_details->logged_id,
                'comments' => $post,
                'post_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('comment', $create);
            $insert_id = $this->db->insert_id();
            $post_details = $this->posts_model->viewPostsDeatilsEmail($post_id);
            if($post_details->users_id != $seesion_details->logged_id){
                $create_notifications = array(
                    'user_id' => $post_details->users_id,
                    'notification' => $seesion_details->users_name." just commented on your post",
                    'friend_id' => $seesion_details->logged_id,
                    'link_id' => $post_details->id,
                    'type' => 3,
                    'status' => 1,
                    'created_at' => time()
                );
                $this->db->insert('notifications', $create_notifications);
                if (isset($post_details->email)) {
                    $subject = $seesion_details->users_name." just commented on your post";
                    $to = $post_details->email;
                    $message = "
                                <HTML>
                                <HEAD>
                                <TITLE>".$seesion_details->users_name." just commented on your post</TITLE>
                                </HEAD>
                                <BODY>
                                <TABLE>
                                <TR>
                                <TD>
                                Hi,
                                </TD>
                                </TR>
                                <TR>
                                <TD>


                                    ".$seesion_details->users_name." just commented on your post.<br>
                                    ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                        Simply post,search,hire or connect with talents around the world.


                                    <br><br>
                                    -- 
                                    -- Thanks<BR>


                                    Team Flashitt  <BR>
                                <BR><BR>
                                ============
                                <BR><BR>


                                IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                This electronic communication is intended by the sender only for the access
                                and use by the addressee and may contain legally privileged and
                                confidential information. If you are not the addressee, you are notified
                                that any transmission, disclosure, use, access to, storage or photocopying
                                of this e-mail and any attachments is strictly prohibited. The legal
                                privilege and confidentiality attached to this e-mail and any attachments
                                is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                If you have received this e-mail and any attachments in error please
                                immediately delete it and all copies from your system and notify the sender
                                by e-mail.<BR><BR>
                                ==================
                                <BR><BR>

                                </TD>
                                </TR>
                                </TABLE>
                                ";

                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                    // More headers
                    $headers .= 'From: Flashitt<www.flashitt.com>' . "\r\n";

                    mail($to, $subject, $message, $headers);
                }
            }
            
            
            //Block for send mail to all of commented user
            //Start coding block
            
            $commented_users = $this->posts_model->viewUsersOfPostCommented( $post_id, $post_details->users_id );
            if(!empty($commented_users)){
                foreach($commented_users as $commented_user){
                    if($commented_user->user_id != $seesion_details->logged_id){
                        $create_notifications = array(
                            'user_id' => $commented_user->user_id,
                            'notification' => $seesion_details->users_name." just commented on ".$post_details->name."'s post",
                            'friend_id' => $seesion_details->logged_id,
                            'link_id' => $post_details->id,
                            'type' => 3,
                            'status' => 1,
                            'created_at' => time()
                        );
                        $this->db->insert('notifications', $create_notifications);
                        
                        if (isset($commented_user->email)) {
                            $subject = $seesion_details->users_name." just commented on ".$post_details->name."'s post";
                            $to = $commented_user->email;
                            $message = "
                                        <HTML>
                                        <HEAD>
                                        <TITLE>".$seesion_details->users_name." just commented on ".$post_details->name."'s post</TITLE>
                                        </HEAD>
                                        <BODY>
                                        <TABLE>
                                        <TR>
                                        <TD>
                                        Hi,
                                        </TD>
                                        </TR>
                                        <TR>
                                        <TD>


                                            ".$seesion_details->users_name." just commented on ".$post_details->name."'s post.<br>
                                            ​To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                            Simply post,search,hire or connect with talents around the world.


                                        <br><br>
                                        -- 
                                        -- Thanks<BR>


                                        Team Flashitt 

                                        <BR><BR>
                                        ============
                                        <BR><BR>


                                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                        This electronic communication is intended by the sender only for the access
                                        and use by the addressee and may contain legally privileged and
                                        confidential information. If you are not the addressee, you are notified
                                        that any transmission, disclosure, use, access to, storage or photocopying
                                        of this e-mail and any attachments is strictly prohibited. The legal
                                        privilege and confidentiality attached to this e-mail and any attachments
                                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                        If you have received this e-mail and any attachments in error please
                                        immediately delete it and all copies from your system and notify the sender
                                        by e-mail.<BR><BR>
                                        ==================
                                        <BR><BR>

                                        </TD>
                                        </TR>
                                        </TABLE>
                                        ";

                            // Always set content-type when sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                            // More headers
                            $headers .= 'From: Flashitt' . "\r\n";

                            mail($to, $subject, $message, $headers);
                        }
                    }
                }
            }
            
            // Block for send mail to all of commented user
            // End coding block
            
            $data['comments'] = $this->posts_model->fetchAllComment($post_id);
            $this->load->view('users/ajax_post_comment', $data);
        } else {
            echo "not loged in";
        }
    }

    public function submitPostStatus() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);

            $main_post = $this->input->post('status');
            $post_status_explode = explode( " ", $main_post );
            foreach($post_status_explode as $text){
                if (filter_var($text, FILTER_VALIDATE_URL) !== FALSE) {
                    $main_post = str_replace($text, "<a href = '".$text."' target = '_blank'>".$text."</a>", $main_post);
                }
            }

            $create = array(
                'users_id' => $seesion_details->logged_id,
                'title' => $main_post,
                'updated_at' => time()
            );
            $this->db->insert('post', $create);
            $insert_id = $this->db->insert_id();
            $status_message = 1;
            if ($_FILES['upload']['name'] != "") {
                if (!is_dir(FCPATH . '/images/talent')) {
                    mkdir(FCPATH . '/images/talent');
                }

                $config['upload_path'] = 'images/talent/'; // Location to save the image
                $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                $config['max_size'] = '10000'; // in KB
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('upload')) {
                    $extention = strtolower ( end( explode( ".", $_FILES['upload']['name'] ) ) );
                    if( $extention != "mp4" ){
                        $config2['image_library'] = 'gd2';
                        $config2['source_image'] = 'images/talent/'.$this->upload->file_name;
                        $config2['create_thumb'] = false;
                        $config2['maintain_ratio'] = TRUE;
                        $config2['master_dim'] = 'width';					
                        $config2['width'] = 350; // image re-size  properties
                        $config2['height'] = 350; // image re-size  properties 
                        $config2['new_image'] = 'images/talent/'.$this->upload->file_name; // image re-size  properties 
                        $this->load->library('image_lib', $config2); //codeigniter default function
                        $this->image_lib->resize();
                    }
                    
                    $status_message = 2;
                    $posts['post_id'] = $insert_id;
                    $posts['elements'] = $this->upload->file_name;
                    
                    if( $extention == "mp4" ){
                        $posts['elements_type'] = "3";
                    }else{
                        $posts['elements_type'] = "2";
                    }
                    $this->db->insert('posts_content', $posts);
                } else {
                    $data['upload'] = $this->upload->display_errors();
                    $this->db->delete('post', array('id' => $insert_id));
                    $this->session->set_flashdata('error_upload', $data['upload']);
                }
                //print_r($data['upload']); die;
            
            
                $data['friend_list'] = $this->users_model->viewFriendsListProfileEmail($seesion_details->logged_id);
                if (!empty($data['friend_list'])) {
                    foreach ($data['friend_list'] as $friend) {
                        if ($seesion_details->logged_id == $friend->profile_id1) {
                            $friend_id = $friend->profile_id2;
                            $friend_email = $friend->profile_email2;
                        } else {
                            $friend_id = $friend->profile_id1;
                            $friend_email = $friend->profile_email1;
                        }

                        //Send mail and notification
                        if (!empty($friend_email)) {
                        		if($status_message == 2){
                        				$notification_message = $seesion_details->users_name . " has posted a picture";
                        		}else{
                        				$notification_message = $seesion_details->users_name . " has posted a status";
                        		}
                            $create_notifications = array(
                                'user_id' => $friend_id,
                                'notification' => $notification_message,
                                'friend_id' => $seesion_details->logged_id,
                                'link_id' => $insert_id,
                                'type' => 3,
                                'status' => 1,
                                'created_at' => time()
                            );
                            $this->db->insert('notifications', $create_notifications);
                            $subject = $notification_message;
                            $to = $friend_email;
                            $message = "
                                        <HTML>
                                        <HEAD>
                                        <TITLE>" . $notification_message."</TITLE>
                                        </HEAD>
                                        <BODY>
                                        <TABLE>
                                        <TR>
                                        <TD>
                                        Hi,
                                        </TD>
                                        </TR>
                                        <TR>
                                        <TD>


                                            " . $notification_message . ".<br>
                                            To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                            Simply post,search,hire or connect with talents around the world.


                                        <br><br>
                                        -- 
                                        -- Thanks<BR>


                                        Team Flashitt  

                                        <BR><BR>
                                        ============
                                        <BR><BR>


                                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                        This electronic communication is intended by the sender only for the access
                                        and use by the addressee and may contain legally privileged and
                                        confidential information. If you are not the addressee, you are notified
                                        that any transmission, disclosure, use, access to, storage or photocopying
                                        of this e-mail and any attachments is strictly prohibited. The legal
                                        privilege and confidentiality attached to this e-mail and any attachments
                                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                        If you have received this e-mail and any attachments in error please
                                        immediately delete it and all copies from your system and notify the sender
                                        by e-mail.<BR><BR>
                                        ==================
                                        <BR><BR>

                                        </TD>
                                        </TR>
                                        </TABLE>
                                        ";

                            // Always set content-type when sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                            // More headers
                            $headers .= 'From: Flashitt' . "\r\n";

                            mail($to, $subject, $message, $headers);
                        }
                    }
                }
            }
            redirect("home/profile");
        }
    }

    public function ajaxPhotoShow() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        $posts = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post_contents = $this->posts_model->viewPostsContentsWithType($post->id, 2);
                if (!empty($post_contents)) {
                    foreach ($post_contents as $post_content) {
                        $data['post_data'][] = $post_content->elements;
                        $data['post_at'][] = $post_content->created_at;
                        
                        $data['count_like'][] = $this->posts_model->countPostLike($post->id);
                        $data['like_status'][] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                        $data['liked'][] = $this->posts_model->peopleOfLike($post->id);
                        $data['comments'][] = $this->posts_model->fetchAllComment($post->id);
                        $data['count_comments'][] = $this->posts_model->countPostComment($post->id);
                        $data['post'][] = $post->id;
                    }
                }
            }
        }
        $this->load->view('users/ajax_profile_album_photo', $data);
    }

    public function ajaxVideoShow() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        $posts = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post_contents = $this->posts_model->viewPostsContentsWithType($post->id, 3);
                if (!empty($post_contents)) {
                    foreach ($post_contents as $post_content) {
                        $data['post_data'][] = $post_content->elements;
                    }
                }
            }
        }
        $this->load->view('users/ajax_profile_album_video', $data);
    }

    public function ajaxAllShow() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($seesion_details->logged_id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        $friend_array[] = $seesion_details->logged_id;
        $friend_in_data = implode(",", $friend_array);
        //$data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data);
        $data['users_loged_in_id'] = $seesion_details->logged_id;
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }
    
    public function ajaxAllShowLimit() {
        $page = $this->input->post('page');
        $start = $page * 10;
        $seesion_details = $this->session->userdata('users');
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($seesion_details->logged_id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        $friend_array[] = $seesion_details->logged_id;
        $friend_in_data = implode(",", $friend_array);
        //$data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data, $start, 10);
        $data['users_loged_in_id'] = $seesion_details->logged_id;
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
                
                
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }

    public function ajaxPhotoShowFriend() {
        $data = array();
        $id = $this->input->post('id');
        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $posts = $this->posts_model->viewPostsProfile($id);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post_contents = $this->posts_model->viewPostsContentsWithType($post->id, 2);
                if (!empty($post_contents)) {
                    foreach ($post_contents as $post_content) {
                        
                        $data['post_data'][] = $post_content->elements;
                        $data['post_at'][] = $post_content->created_at;
                        
                        $data['count_like'][] = $this->posts_model->countPostLike($post->id);
                        $data['like_status'][] = $this->posts_model->statusPostLike($post->id, $id);
                        $data['liked'][] = $this->posts_model->peopleOfLike($post->id);
                        $data['comments'][] = $this->posts_model->fetchAllComment($post->id);
                        $data['count_comments'][] = $this->posts_model->countPostComment($post->id);
                        $data['post'][] = $post->id;
                    }
                }
            }
        }
        $this->load->view('users/ajax_profile_album_photo', $data);
    }

    public function ajaxVideoShowFriend() {
        $data = array();
        $id = $this->input->post('id');
        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $posts = $this->posts_model->viewPostsProfile($id);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post_contents = $this->posts_model->viewPostsContentsWithType($post->id, 3);
                if (!empty($post_contents)) {
                    foreach ($post_contents as $post_content) {
                        $data['post_data'][] = $post_content->elements;
                    }
                }
            }
        }
        $this->load->view('users/ajax_profile_album_video', $data);
    }

    public function ajaxAllShowFriend() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if(!empty($seesion_details)){
            $data['users_loged_in_id'] = $seesion_details->logged_id;
        }else{
            $data['users_loged_in_id'] = 0;
        }
        $id = $this->input->post('id');
        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        
        $friend_array[] = $id;
        $friend_in_data = implode(",", $friend_array);
        //$data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data);
        //$data['posts'] = $this->posts_model->viewPostsProfile($user_id);
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $data['users_loged_in_id']);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }
    
    public function ajaxAllShowLimitFriend() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if(!empty($seesion_details)){
            $data['users_loged_in_id'] = $seesion_details->logged_id;
        }else{
            $data['users_loged_in_id'] = 0;
        }
        $id = $this->input->post('id');
        $page = $this->input->post('page');
        $start = $page * 10;
        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        
        $friend_array[] = $id;
        $friend_in_data = implode(",", $friend_array);
        //$data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data, $start, 10);
        //$data['posts'] = $this->posts_model->viewPostsProfile($user_id);
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $data['users_loged_in_id']);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }

    public function forgetChangePassword($forget_id) {
        $database_forget_id = (((( $forget_id + 342 ) - 87213 ) + 2534 ) / 82736 );
        $data['profile'] = $this->users_model->viewProfileDetails($database_forget_id);
        $data['categories'] = $this->category_model->showCategoryUsers();
        //print_r($data['profile']); die;
        if ($this->input->post()) {
            $password = md5($this->input->post('password'));
            $id = $this->input->post('profile_id');
            $update = array(
                'password' => $password
            );
            $this->db->update('users', $update, "id = " . $id);
            $this->session->set_flashdata('error_password', "Password successfully changed");
            redirect('home/forgetChangePassword/' . $forget_id);
        } else {
            $this->load->view('users/forget_password', $data);
        }
    }

    public function editProfile() {
        $seesion_details = $this->session->userdata('users');

        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['categories'] = $this->category_model->showCategoryUsers();
            if (!$this->input->post()) {
                $data['profile'] = $this->users_model->viewProfileDetails($data['users_loged_in_id']);
                $data['countries'] = $this->posts_model->viewCountry();
                $this->load->view('users/edit_profile', $data);
            } else {
                //print_r($this->input->post('category')); die;
                $category_post = $this->input->post('category');
                if(!empty($category_post)){
                    $users_category = implode(",", $this->input->post('category'));
                }
                $users_input = array(
                    'name' => $this->input->post('name'),
                    'about_me' => $this->input->post('about'),
                    'profile_type' => $this->input->post('type'),
                    'category' => $users_category,
                    'country' => $this->input->post('country'),
                    'city' => $this->input->post('city')
                );
                if ($_FILES['image']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/users')) {
                        mkdir(FCPATH . '/images/users');
                    }
                    $config['upload_path'] = 'images/users/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) {
                        $users_input['image'] = $this->upload->file_name;
                    } else {
                        $data['image'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['image']);
                    }
                }
                if ($_FILES['banner']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/users')) {
                        mkdir(FCPATH . '/images/users');
                    }
                    $config['upload_path'] = 'images/users/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('banner')) {
                        $users_input['banner'] = $this->upload->file_name;
                    } else {
                        $data['banner'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['image']);
                    }
                }
                $this->db->update('users', $users_input, "id = " . $data['users_loged_in_id']);
                redirect("home/cropBannerImage");
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function cropBannerImage() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['profile'] = $this->users_model->viewProfileDetails($data['users_loged_in_id']);
            if (!$this->input->post()) {
                $this->load->view('users/image_crop', $data);
            } else {
                $this->load->library('image_lib');
                $image_config['image_library'] = 'gd2';
                $image_config['source_image'] = "./images/users/" . $data['profile']->image;
                $image_config['new_image'] = "./images/users/" . $data['profile']->image;
                $image_config['quality'] = "100%";
                $image_config['maintain_ratio'] = FALSE;
                $image_config['width'] = $this->input->post('w');
                $image_config['height'] = $this->input->post('h');
                $image_config['x_axis'] = $this->input->post('x');
                $image_config['y_axis'] = $this->input->post('y');
                //print_r($image_config['source_image']); die;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config);
                
                //print_r($this->input->post()); die;
                $image_config['image_library'] = 'gd2';
                $image_config['source_image'] = "./images/users/" . $data['profile']->banner;
                $image_config['new_image'] = "./images/users/" . $data['profile']->banner;
                $image_config['quality'] = "100%";
                $image_config['maintain_ratio'] = FALSE;
                $image_config['width'] = $this->input->post('w');
                $image_config['height'] = $this->input->post('h');
                $image_config['x_axis'] = $this->input->post('x');
                $image_config['y_axis'] = $this->input->post('y');
                //print_r($image_config['source_image']); die;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config);

                if (!$this->image_lib->crop()) {
                    //echo $this->image_lib->display_errors();
                    redirect("home/cropBannerImage"); //If error, redirect to an error page
                } else {
                    //echo "Done";
                    redirect("home/cropProfileImage");
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }
    
    
    public function cropProfileImage() {
        $data = array();
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['profile'] = $this->users_model->viewProfileDetails($data['users_loged_in_id']);
            if (!$this->input->post()) {
                $this->load->view('users/image_crop_profile', $data);
            } else {
                $this->load->library('image_lib');
                $image_config['image_library'] = 'gd2';
                $image_config['source_image'] = "./images/users/" . $data['profile']->image;
                $image_config['new_image'] = "./images/users/" . $data['profile']->image;
                $image_config['quality'] = "100%";
                $image_config['maintain_ratio'] = FALSE;
                $image_config['width'] = $this->input->post('w');
                $image_config['height'] = $this->input->post('h');
                $image_config['x_axis'] = $this->input->post('x');
                $image_config['y_axis'] = $this->input->post('y');
                //print_r($image_config['source_image']); die;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config);
                
                //print_r($this->input->post()); die;
                $image_config['image_library'] = 'gd2';
                $image_config['source_image'] = "./images/users/" . $data['profile']->image;
                $image_config['new_image'] = "./images/users/" . $data['profile']->image;
                $image_config['quality'] = "100%";
                $image_config['maintain_ratio'] = FALSE;
                $image_config['width'] = $this->input->post('w');
                $image_config['height'] = $this->input->post('h');
                $image_config['x_axis'] = $this->input->post('x');
                $image_config['y_axis'] = $this->input->post('y');
                //print_r($image_config['source_image']); die;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config);

                if (!$this->image_lib->crop()) {
                    //echo $this->image_lib->display_errors();
                    redirect("home/cropProfileImage"); //If error, redirect to an error page
                } else {
                    //echo "Done";
                    redirect("home/profile");
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function talentProfile($id) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $loged_id = $seesion_details->logged_id;
        } else {
            $loged_id = NULL;
        }
        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $data['user_login_id'] = $loged_id;
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['friends'] = $this->users_model->viewProfileDetails($user_id);
        $data['friends_status'] = $this->users_model->viewFriendsProfile($user_id, $loged_id);
        $data['friends_profile_id'] = $user_id;
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($user_id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($user_id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        $friend_array[] = $user_id;
        $friend_in_data = implode(",", $friend_array);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data);
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $loged_id);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
            }
        }
        //print_r($friend_array); die;
        $this->load->view('users/friend_profile', $data);
    }

    public function friendsAction($id) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }

        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['friends'] = $this->users_model->viewProfileDetails($user_id);
        $data['friends_status'] = $this->users_model->viewFriendsProfile($user_id, $seesion_details->logged_id);
        if (!empty($data['friends_status'])) {
            
        } else {
            $create = array(
                'users_id' => $seesion_details->logged_id,
                'friends_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('friends', $create);
            
            $create_notifications = array(
                'user_id' => $user_id,
                'notification' => "You have received Friend request from ".$seesion_details->users_name,
                'friend_id' => $seesion_details->logged_id,
                'link_id' =>  ((( $seesion_details->logged_id * 26 ) + 5364 ) - 769 ),
                'type' => 4,
                'status' => 1,
                'created_at' => time()
            );
            $this->db->insert('notifications', $create_notifications);
                            
            if (isset($data['friends']->email)) {
                $subject = "Friend Request received from ".$seesion_details->users_name;
                $to = $data['friends']->email;
                $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>Friend Request received from ".$seesion_details->users_name."</TITLE>
                            </HEAD>
                            <BODY>
                            <TABLE>
                            <TR>
                            <TD>
                            Hi,
                            </TD>
                            </TR>
                            <TR>
                            <TD>

                                ".$seesion_details->users_name." sent you friend request.<br>
                                To accept log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                Simply post,search,hire or connect with talents around the world.


                            <br><br>
                            -- 
                            -- Thanks<BR>

                     
                            Team Flashitt  

                            <BR><BR>
                            ============
                            <BR><BR>


                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                            This electronic communication is intended by the sender only for the access
                            and use by the addressee and may contain legally privileged and
                            confidential information. If you are not the addressee, you are notified
                            that any transmission, disclosure, use, access to, storage or photocopying
                            of this e-mail and any attachments is strictly prohibited. The legal
                            privilege and confidentiality attached to this e-mail and any attachments
                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                            If you have received this e-mail and any attachments in error please
                            immediately delete it and all copies from your system and notify the sender
                            by e-mail.<BR><BR>
                            ==================
                            <BR><BR>

                            </TD>
                            </TR>
                            </TABLE>
                            ";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                // More headers
                $headers .= 'From: Flashitt' . "\r\n";

                mail($to, $subject, $message, $headers);
            }
        }
        $data['friends_profile_id'] = $id;
        redirect('home/talentProfile/' . $id);
    }

    public function ajaxPostStatusProfile() {
        $seesion_details = $this->session->userdata('users');
        //print_r($seesion_details); die;
        if (!empty($seesion_details)) {
            $create = array(
                'users_id' => $seesion_details->logged_id,
                'title' => $this->input->post('post')
            );
            $this->db->insert('post', $create);
            echo "Your post successfully done";
        }
    }

    public function actionNotification($action, $notification) {
        $seesion_details = $this->session->userdata('users');
        $data['categories'] = $this->category_model->showCategoryUsers();
        $user_id = (((( $notification + 769 ) - 5364 ) / 26 ) - 3453 );
        if ($action == "7892737F9837g87wq872") {
            $update = array(
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $friends_details = $this->users_model->viewFriendsProfileDetails($user_id);
            $user_link_id = ((( $seesion_details->logged_id * 26 ) + 5364 ) - 769 );
            $friends_link_id = ((( $friends_details->profile_id * 26 ) + 5364 ) - 769 );
            $create_post = array(
                'users_id' => $seesion_details->logged_id,
                'title' => "<a href = '".base_url("home/talentProfile")."/".$user_link_id."' style = 'color:#02A6F8;' > ".$seesion_details->users_name."</a> and <a href = '".base_url("home/talentProfile")."/".$friends_link_id."'  style = 'color:#02A6F8;' >".$friends_details->profile_name."</a> are now friends",
                'updated_at' => time()
            );
            $this->db->insert('post', $create_post);
            
            $create_notifications = array(
                'user_id' => $user_id,
                'notification' => "<a href = '".base_url("home/talentProfile")."/".$user_link_id."' style = 'color:#02A6F8;' > ".$seesion_details->users_name."</a> accepted your friend request",
                'friend_id' => $seesion_details->logged_id,
                'link_id' =>  ((( $seesion_details->logged_id * 26 ) + 5364 ) - 769 ),
                'type' => 4,
                'status' => 1,
                'created_at' => time()
            );
            $this->db->insert('notifications', $create_notifications);
            $this->db->update('friends', $update, "id = " . $user_id);        
            if (isset($friends_details->email)) {
                $subject = $seesion_details->users_name." accepted your friend request";
                $to = $friends_details->email;
                $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>".$seesion_details->users_name." accepted your friend request</TITLE>
                            </HEAD>
                            <BODY>
                            <TABLE>
                            <TR>
                            <TD>
                            Hi,
                            </TD>
                            </TR>
                            <TR>
                            <TD>

                                <a href = '".base_url("home/talentProfile")."/".$user_link_id."' style = 'color:#02A6F8;' > ".$seesion_details->users_name."</a> accepted your friend request<br>
                                To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                Simply post,search,hire or connect with talents around the world.


                            <br><br>
                            -- 
                            -- Thanks<BR>


                            Team Flashitt
                            <BR><BR>
                            ============
                            <BR><BR>


                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                            This electronic communication is intended by the sender only for the access
                            and use by the addressee and may contain legally privileged and
                            confidential information. If you are not the addressee, you are notified
                            that any transmission, disclosure, use, access to, storage or photocopying
                            of this e-mail and any attachments is strictly prohibited. The legal
                            privilege and confidentiality attached to this e-mail and any attachments
                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                            If you have received this e-mail and any attachments in error please
                            immediately delete it and all copies from your system and notify the sender
                            by e-mail.<BR><BR>
                            ==================
                            <BR><BR>

                            </TD>
                            </TR>
                            </TABLE>
                            ";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                // More headers
                $headers .= 'From: Flashitt' . "\r\n";

                mail($to, $subject, $message, $headers);
            }
        
        } else if ($action == "2378868ghas897239812fg21871") {
            
            $this->db->delete('friends', array('id' => $user_id));
        }
        
        redirect('home/profile');
    }

    public function ajaxSuggestFriend() {
        
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }else{
            $data['users_name'] = "";
        }
        $category = $this->input->post('category');
        $email = $this->input->post('email');

        $create = array(
            'email' => $email,
            'category' => $category
        );
        $this->db->insert('suggestion', $create);
        $details = $this->category_model->viewCategoryDetails($category);
        if (isset($email)) {
            $subject = "Share your talent !";
            $to = $email;
            $message = "
			<HTML>
			<HEAD>
			<TITLE>Share your talent !</TITLE>
			</HEAD>
			<BODY>
			<TABLE>
			<TR>
			<TD>
			Hi,
			</TD>
			</TR>
			<TR>
			<TD>
			
                            ".$data['users_name']." wants you to showcase your talent on <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                            To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                            Simply post,search,hire or connect with talents around the world.


                            <br><br>
                            -- 
                            -- Thanks<BR>


                            Team Flashitt 

			<BR><BR>
			============
			<BR><BR>
			
			
			IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE
			
			This electronic communication is intended by the sender only for the access
			and use by the addressee and may contain legally privileged and
			confidential information. If you are not the addressee, you are notified
			that any transmission, disclosure, use, access to, storage or photocopying
			of this e-mail and any attachments is strictly prohibited. The legal
			privilege and confidentiality attached to this e-mail and any attachments
			is not waived, lost or destroyed by reason of a mistaken delivery to you.
			If you have received this e-mail and any attachments in error please
			immediately delete it and all copies from your system and notify the sender
			by e-mail.<BR><BR>
			==================
			<BR><BR>
				
			</TD>
			</TR>
			</TABLE>
			";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            // More headers
            $headers .= 'From: Flashitt' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
    }

    public function profileSearch() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $search = $this->input->get('search');
        $data['search_results'] = $this->users_model->searchUsersProfile($search);
        $data['search_category_results'] = $this->users_model->searchUsersProfileWithCategoryCountry($search);
        $data['search'] = $search;
        //print_r($data['search_results']); die;
        $this->load->view('users/search_profile', $data);
        
    }

    public function ajaxSearchFriend() {
        $content = $this->input->post('search_content');
        $city = $this->input->post('search_city');
        $data['search_results'] = $this->users_model->searchUsersProfileAjax($content, $city);
        $this->load->view('users/search_profile_ajax', $data);
    }

    public function postTalent() {
        $seesion_details = $this->session->userdata('users');

        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['countries'] = $this->posts_model->viewCountry();
            //print_r($this->input->post('country')); die;
            if ($this->input->post()) {
                if ($this->input->post('category') == 0) {
                    $return_category = $this->category_model->viewCategoryCheckSearch($this->input->post('others'));
                    //print_r($return_category); die;
                    if ($return_category) {
                        $category_id = $return_category;
                    } else {
                        $create_category = array(
                            'category_name' => $this->input->post('others'),
                            'category_parent' => 0,
                            'status' => 0,
                            'is_deleted' => 1
                        );
                        $this->db->insert('category', $create_category);
                        $category_id = $this->db->insert_id();
                    }
                } else {
                    $category_id = $this->input->post('category');
                }
                $main_post = $this->input->post('title');
                $post_status_explode = explode( " ", $main_post );
                foreach($post_status_explode as $text){
                    if (filter_var($text, FILTER_VALIDATE_URL) !== FALSE) {
                        $main_post = str_replace($text, "<a href = '".$text."' target = '_blank'>".$text."</a>", $main_post);
                    }
                }
                $main_description = $this->input->post('description');
                $post_description_explode = explode( " ", $main_description );
                foreach($post_description_explode as $text){
                    if (filter_var($text, FILTER_VALIDATE_URL) !== FALSE) {
                        $main_description = str_replace($text, "<a href = '".$text."' target = '_blank'>".$text."</a>", $main_description);
                    }
                }
                $create = array(
                    'users_id' => $seesion_details->logged_id,
                    'title' => $main_post,
                    'description' => $main_description,
                    'speciality' => '',
                    'category' => $category_id,
                    'country' => implode(",", $this->input->post('country')),
                    'city' => $this->input->post('city'),
                    'updated_at' => time()
                );
                $this->db->insert('post', $create);
                $insert_id = $this->db->insert_id();
                if ($_FILES['photo1']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('photo1')) {
                        
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "2";
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['photo1'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['photo1']);
                        redirect("home/postTalent");
                    }
                }
                if ($_FILES['photo2']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('photo2')) {
                        
                        
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "2";
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['photo2'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['photo2']);
                        redirect("home/postTalent");
                    }
                }
                if ($_FILES['video']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'mp4';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '100000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('video')) {
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "3";
                        //print_r($posts); die;
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['video'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['video']);
                        redirect("home/postTalent");
                    }
                }

                //Fetch friend list for send notification inbox and mail
                $data['friend_list'] = $this->users_model->viewFriendsListProfileEmail($seesion_details->logged_id);
                if (!empty($data['friend_list'])) {
                    foreach ($data['friend_list'] as $friend) {
                        if ($seesion_details->logged_id == $friend->profile_id1) {
                            $friend_id = $friend->profile_id2;
                            $friend_email = $friend->profile_email2;
                        } else {
                            $friend_id = $friend->profile_id1;
                            $friend_email = $friend->profile_email1;
                        }

                        //Send mail and notification
                        if (!empty($friend_email)) {
                            $create_notifications = array(
                                'user_id' => $friend_id,
                                'notification' => $seesion_details->users_name . " has posted a talent",
                                'friend_id' => $seesion_details->logged_id,
                                'link_id' => $insert_id,
                                'type' => 3,
                                'status' => 1,
                                'created_at' => time()
                            );
                            $this->db->insert('notifications', $create_notifications);
                            $subject = "" . $seesion_details->users_name . " has posted a talent";
                            $to = $friend_email;
                            $message = "
                                        <HTML>
                                        <HEAD>
                                        <TITLE>" . $seesion_details->users_name . " has posted a talent</TITLE>
                                        </HEAD>
                                        <BODY>
                                        <TABLE>
                                        <TR>
                                        <TD>
                                        Hi,
                                        </TD>
                                        </TR>
                                        <TR>
                                        <TD>


                                            " . $seesion_details->users_name . " has posted a talent.<br>
                                            To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                            Simply post,search,hire or connect with talents around the world.


                                            <br><br>
                                            -- 
                                            -- Thanks<BR>


                                            Team Flashitt 

                                        <BR><BR>
                                        ============
                                        <BR><BR>


                                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                        This electronic communication is intended by the sender only for the access
                                        and use by the addressee and may contain legally privileged and
                                        confidential information. If you are not the addressee, you are notified
                                        that any transmission, disclosure, use, access to, storage or photocopying
                                        of this e-mail and any attachments is strictly prohibited. The legal
                                        privilege and confidentiality attached to this e-mail and any attachments
                                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                        If you have received this e-mail and any attachments in error please
                                        immediately delete it and all copies from your system and notify the sender
                                        by e-mail.<BR><BR>
                                        ==================
                                        <BR><BR>

                                        </TD>
                                        </TR>
                                        </TABLE>
                                        ";

                            // Always set content-type when sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                            // More headers
                            $headers .= 'From: Flashitt' . "\r\n";

                            mail($to, $subject, $message, $headers);
                        }
                    }
                }

                //For send email and notification to all friends
                redirect('home/profile');
            } else {
                $this->load->view('users/post_talent', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function postRequirement() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['countries'] = $this->posts_model->viewCountry();
            //print_r($data['countries']); die;
            if ($this->input->post()) {
                $create = array(
                    'users_id' => $seesion_details->logged_id,
                    'category' => $this->input->post('category'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'country' => $this->input->post('country'),
                    'city' => $this->input->post('city'),
                    'created_at' => time()
                );
                $this->db->insert('requirement', $create);
                $insert_id = $this->db->insert_id();
                
                $create = array(
                    'users_id' => $seesion_details->logged_id,
                    'title' => $seesion_details->users_name.' is looking for a talent',
                    'description' => "<b>".$this->input->post('title')."</b><br>".$this->input->post('description'),
                    'updated_at' => time()
                );
                $this->db->insert('post', $create);
                $insert_id_post = $this->db->insert_id();
                $notification_friends_id = ((( $seesion_details->logged_id * 26 ) + 5364 ) - 769 );
                $emails = $this->posts_model->fetchUsersByCountryCity($this->input->post('country'), $this->input->post('city'), $this->input->post('category'));
                $emails_match_category = $this->posts_model->fetchUsersByTabCategory($this->input->post('category'));
                if(!empty($emails)){
                    foreach ($emails as $email) {
                        $send_emails[$email->id] = $email->email;
                    }
                }

                if(!empty($emails_match_category)){
                    foreach ($emails_match_category as $email) {
                        $send_emails[$email->id] = $email->email;
                    }
                }

                if(!empty($send_emails)){
                    foreach ($send_emails as $users_id => $email) {
                        if (isset($email)) {
                            
                            $create_notifications = array(
                                'user_id' => $users_id,
                                'notification' => "<a href = '".base_url("home/talentProfile")."/".$notification_friends_id."'>".$data['users_name'] . "</a> <a href = '".base_url("home/postDetails")."/".$insert_id_post."'>is looking for talent similar to yours</a>",
                                'friend_id' => $seesion_details->logged_id,
                                'link_id' => $insert_id,
                                'type' => 2,
                                'status' => 1,
                                'created_at' => time()
                            );
                            $this->db->insert('notifications', $create_notifications);
                            $subject = "".$data['users_name']." is looking for talent similar to yours";
                            $to = $email;
                            $message = "
                                        <HTML>
                                        <HEAD>
                                        <TITLE>".$data['users_name']." is looking for talent similar to yours</TITLE>
                                        </HEAD>
                                        <BODY>
                                        <TABLE>
                                        <TR>
                                        <TD>
                                        Hi,
                                        </TD>
                                        </TR>
                                        <TR>
                                        <TD>


                                            ".$seesion_details->users_name." is looking for talent similar to yours.<br>
                                            To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                            Simply post,search,hire or connect with talents around the world.


                                            <br><br>
                                            -- 
                                            -- Thanks<BR>


                                            Team Flashitt 

                                        <BR><BR>
                                        ============
                                        <BR><BR>


                                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                        This electronic communication is intended by the sender only for the access
                                        and use by the addressee and may contain legally privileged and
                                        confidential information. If you are not the addressee, you are notified
                                        that any transmission, disclosure, use, access to, storage or photocopying
                                        of this e-mail and any attachments is strictly prohibited. The legal
                                        privilege and confidentiality attached to this e-mail and any attachments
                                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                        If you have received this e-mail and any attachments in error please
                                        immediately delete it and all copies from your system and notify the sender
                                        by e-mail.<BR><BR>
                                        ==================
                                        <BR><BR>

                                        </TD>
                                        </TR>
                                        </TABLE>
                                        ";

                            // Always set content-type when sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                            // More headers
                            $headers .= 'From: Flashitt' . "\r\n";

                            mail($to, $subject, $message, $headers);
                        }
                    }
                }

                $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
		            if (!empty($data['friend_list'])) {
		                foreach ($data['friend_list'] as $friend) {
		                    if ($seesion_details->logged_id == $friend->profile_id1) {
		                        $friend_array = $friend->profile_id2;
		                    } else {
		                        $friend_array = $friend->profile_id1;
		                    }
                        $create_notifications_friend = array(
                            'user_id' => $friend_array,
                            'notification' => "<a href = '".base_url("home/talentProfile")."/".$notification_friends_id."'>".$data['users_name'] . "</a> <a href = '".base_url("home/postDetails")."/".$insert_id_post."'>is looking for a talent</a>",
                            'friend_id' => $seesion_details->logged_id,
                            'link_id' => $insert_id,
                            'type' => 2,
                            'status' => 1,
                            'created_at' => time()
                        );
                        $this->db->insert('notifications', $create_notifications_friend);
		                }
		            }
                //print_r($friend_array); die;
                
                redirect('home/profile');
            } else {
                $this->load->view('users/post_requirement', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function listRequirement() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['countries'] = $this->posts_model->viewCountry();
        //print_r($data['countries']); die;
        $data['requirements'] = $this->posts_model->viewRequirements();
        $this->load->view('users/show_requirements', $data);
    }

    public function requirementDetails($rid) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['countries'] = $this->posts_model->viewCountry();
        //print_r($data['countries']); die;
        $data['requirement'] = $this->posts_model->viewRequirementsDetails($rid);
        $this->load->view('users/show_requirements_details', $data);
    }

    public function searchTalent() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $search_country = $this->input->get('country');
        $search_category = $this->input->get('category');
        $search_content = $this->input->get('search');
        $data['search_country'] = $search_country;
        $data['results'] = $this->posts_model->searchTalent($search_country, $search_content, $search_category);
        $data['countries'] = $this->posts_model->viewCountry();
        if(!empty($search_category)){
            $return_category = $this->category_model->viewCategoryDetails($search_category);
        }
        if(!empty($return_category)){
            $data['get_category'] = $return_category->category_name;
        }else{
            $data['get_category'] = "";
        }
        //print_r($data['results']); die;
        $this->load->view('users/search_talent', $data);
    }

    public function onclickAjaxSearchTalent() {
        $data['categories'] = $this->category_model->showCategoryUsers();
        $search_data['country'] = $this->input->post('country');
        $search_data['city'] = $this->input->post('city');
        $search_data['category'] = $this->input->post('category');
        $search_data['search_content'] = $this->input->post('search_content');

        $data['results'] = $this->posts_model->searchTalentForAjax($search_data);
        $data['countries'] = $this->posts_model->viewCountry();
        
            $this->load->view('users/search_talent_ajax', $data);
        
    }

    public function content($page) {
        $seesion_details = $this->session->userdata('users');
        $data['categories'] = $this->category_model->showCategoryUsers();
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
        }
        $data['content'] = $this->users_model->getContentPage($page);
        $this->load->view('users/page', $data);
    }

    public function submitYourMassage() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            //print_r($this->input->post('friend_profile_id')); die;
            $friend_id = ((( $this->input->post('friend_profile_id') + 769 ) - 5364 ) / 26 );
            $create = array(
                'user_id' => $seesion_details->logged_id,
                'friend_id' => $friend_id,
                'type' => 1,
                'text' => $this->input->post('massage'),
                'created_at' => time()
            );
            $this->db->insert('massage', $create);
            $exist_notification = $this->posts_model->checkForExistingNotification($friend_id, $seesion_details->logged_id);
            if ($exist_notification) {
                $update = array(
                    'status' => 2
                );
                $this->db->update('notifications', $update, "id = " . $exist_notification);
            }
            $create_notifications = array(
                'user_id' => $friend_id,
                'notification' => "Message from " . $seesion_details->users_name,
                'friend_id' => $seesion_details->logged_id,
                'link_id' => $seesion_details->logged_id,
                'type' => 1,
                'status' => 1,
                'created_at' => time()
            );
            $this->db->insert('notifications', $create_notifications);
            $friends_profile = $this->users_model->viewProfileDetails($friend_id);
            if (!empty($friends_profile->email)) {
                $subject = "Message from " . $seesion_details->users_name;
                $to = $friends_profile->email;
                $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>Message from " . $seesion_details->users_name."</TITLE>
                            </HEAD>
                            <BODY>
                            <TABLE>
                            <TR>
                            <TD>
                            Hi,
                            </TD>
                            </TR>
                            <TR>
                            <TD>


                                ".$seesion_details->users_name." sent you a message.<br>
                                To view log into <a href = 'www.flashitt.com'>www.flashitt.com</a>.<br>
                                Simply post,search,hire or connect with talents around the world.


                                <br><br>
                                -- 
                                -- Thanks<BR>


                                Team Flashitt
                            <BR><BR>
                            ============
                            <BR><BR>


                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                            This electronic communication is intended by the sender only for the access
                            and use by the addressee and may contain legally privileged and
                            confidential information. If you are not the addressee, you are notified
                            that any transmission, disclosure, use, access to, storage or photocopying
                            of this e-mail and any attachments is strictly prohibited. The legal
                            privilege and confidentiality attached to this e-mail and any attachments
                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                            If you have received this e-mail and any attachments in error please
                            immediately delete it and all copies from your system and notify the sender
                            by e-mail.<BR><BR>
                            ==================
                            <BR><BR>

                            </TD>
                            </TR>
                            </TABLE>
                            ";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                // More headers
                $headers .= 'From: Flashitt' . "\r\n";

                mail($to, $subject, $message, $headers);
            }
            redirect('home/message/' . $friend_id);
        }
    }

    public function message($friend_id) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $loged_id = $seesion_details->logged_id;
            $data['messages'] = $this->posts_model->showMessagesUsers($loged_id, $friend_id);
            $data['friend_list'] = $this->posts_model->viewFriendsListInbox($loged_id);
            $data['friends_profile_id'] = $friend_id;
            $data['notification_count'] = $this->posts_model->countNewNotification($loged_id);
            $this->load->view('users/message', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function notification() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $loged_id = $seesion_details->logged_id;
            $data['notifications'] = $this->posts_model->showNotification($loged_id);
            $data['friend_list'] = $this->posts_model->viewFriendsListInbox($loged_id);
            $update = array(
                'status' => 2
            );
            $this->db->update('notifications', $update, "status = 1 AND user_id = " . $loged_id);
            $data['notification_count'] = $this->posts_model->countNewNotification($loged_id);
            //print_r($data['notifications']); die;
            $this->load->view('users/notification', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }
    
    public function ajaxPostDelete() {
        $post_id = $this->input->post('post_id');
        $post_content = $this->posts_model->viewPostsContents($post_id);
        if(!empty($post_content)){
            foreach($post_content as $content){
                //$delete_file = unlink(base_url().'images/talent/'.$content->elements);
                $this->db->delete('posts_content', array('id' => $content->id)); 
            }
        }
        $this->db->delete('post', array('id' => $post_id));
        $this->db->delete('firework', array('post_id' => $post_id));
        $this->db->delete('like', array('post_id' => $post_id));
        $seesion_details = $this->session->userdata('users');
        if(!empty($seesion_details)){
            $data['users_loged_in_id'] = $seesion_details->logged_id;
        }
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($seesion_details->logged_id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        $friend_array[] = $seesion_details->logged_id;
        $friend_in_data = implode(",", $friend_array);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data);
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
                
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }
    
    public function ajaxPostContentDelete() {
        
        $content_id = $this->input->post('content_id');
        $this->db->delete('posts_content', array('id' => $content_id));
        $seesion_details = $this->session->userdata('users');
        if(!empty($seesion_details)){
            $data['users_loged_in_id'] = $seesion_details->logged_id;
        }
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
        if (!empty($data['friend_list'])) {
            foreach ($data['friend_list'] as $friend) {
                if ($seesion_details->logged_id == $friend->profile_id1) {
                    $friend_array[] = $friend->profile_id2;
                } else {
                    $friend_array[] = $friend->profile_id1;
                }
            }
        }
        $friend_array[] = $seesion_details->logged_id;
        $friend_in_data = implode(",", $friend_array);
        $data['posts'] = $this->posts_model->viewPostsProfileInData($friend_in_data);
        if (!empty($data['posts'])) {
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                $data['count_like'][$post->id] = $this->posts_model->countPostLike($post->id);
                $data['like_status'][$post->id] = $this->posts_model->statusPostLike($post->id, $seesion_details->logged_id);
                $data['liked'][$post->id] = $this->posts_model->peopleOfLike($post->id);
                $data['comments'][$post->id] = $this->posts_model->fetchAllComment($post->id);
                $data['count_comments'][$post->id] = $this->posts_model->countPostComment($post->id);
                $data['firework'][$post->id] = $this->posts_model->checkFireWork($post->id);
                $data['fireworked'][$post->id] = $this->posts_model->checkFireWorkBy($post->id);
                $data['count_fireworked'][$post->id] = $this->posts_model->countFireWorkBy($post->id);
            }
        }
        $this->load->view('users/ajax_profile_album_All', $data);
    }
    
    public function postDetails( $post_id ) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
            $data['users_loged_in_id'] = $seesion_details->logged_id;
            $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
            if (!empty($data['friend_list'])) {
                foreach ($data['friend_list'] as $friend) {
                    if ($seesion_details->logged_id == $friend->profile_id1) {
                        $friend_array[] = $friend->profile_id2;
                    } else {
                        $friend_array[] = $friend->profile_id1;
                    }
                }
            }
            $friend_array[] = $seesion_details->logged_id;
            $friend_in_data = implode(",", $friend_array);
            $data['post'] = $this->posts_model->viewPostsDeatilsEmail($post_id);
            if(!empty($data['post'])){
                $data['post_contents'] = $this->posts_model->viewPostsContents($data['post']->id);
                $data['count_like'] = $this->posts_model->countPostLike($data['post']->id);
                $data['comments'] = $this->posts_model->fetchAllComment($data['post']->id);
                $data['count_comments'] = $this->posts_model->countPostComment($data['post']->id);
                $data['liked'] = $this->posts_model->peopleOfLike($data['post']->id);
                $data['firework'] = $this->posts_model->checkFireWork($data['post']->id);
                $data['fireworked'] = $this->posts_model->checkFireWorkBy($data['post']->id);
                $data['count_fireworked'] = $this->posts_model->countFireWorkBy($data['post']->id);
            }
                $data['notification'] = $this->users_model->viewNotificationProfile($seesion_details->logged_id);
                $data['notification_count'] = $this->posts_model->countNewNotification($seesion_details->logged_id);
                
            
            $this->load->view('users/post_details', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function submitReport() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $create = array(
                'user_id' => $this->input->post('reported_id'),
                'report' => $this->input->post('report_content'),
                'report_from' => $seesion_details->logged_id,
                'created_at' => time()
            );
            $this->db->insert('reports', $create);
        }
        $talent_profile_id = ((( $this->input->post('reported_id') * 26 ) + 5364 ) - 769 );
        redirect('home/talentProfile/'.$talent_profile_id);

    }

    public function contactUs() {
        $data = array();
        if($this->input->post()){
            $subject = $this->input->post('subject');
            $to = 'hello@flashitt.com';
            //$to = 'bluewaterequip@gmail.com';
            $message = "
                        <HTML>
                        <HEAD>
                        <TITLE>" . $this->input->post('subject')."</TITLE>
                        </HEAD>
                        <BODY>
                        <TABLE>
                        <TR>
                        <TD>
                        </TD>
                        </TR>
                        <TR>
                        <TD>


                            ".$this->input->post('description')."


                            <br><br>
                            -- 
                            -- Thanks<BR>


                            ".$this->input->post('email')."<BR>
                        <BR><BR>
                        ============
                        <BR><BR>


                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                        This electronic communication is intended by the sender only for the access
                        and use by the addressee and may contain legally privileged and
                        confidential information. If you are not the addressee, you are notified
                        that any transmission, disclosure, use, access to, storage or photocopying
                        of this e-mail and any attachments is strictly prohibited. The legal
                        privilege and confidentiality attached to this e-mail and any attachments
                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                        If you have received this e-mail and any attachments in error please
                        immediately delete it and all copies from your system and notify the sender
                        by e-mail.<BR><BR>
                        ==================
                        <BR><BR>

                        </TD>
                        </TR>
                        </TABLE>
                        ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            // More headers
            $headers .= 'From: Flashitt' . "\r\n";

            mail($to, $subject, $message, $headers);
            $this->session->set_flashdata('successfully_msg', 'Message sent');
            redirect('home/contactUs');
        }else{
            $this->load->view('users/contact_us', $data);
        }
    }

    public function test() {
        
        print_r("Suman"); die;

    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */