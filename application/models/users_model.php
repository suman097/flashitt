<?php

Class users_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function login($data) {
        $query = $this->db->get_where('admin', array('email' => $data['user_name'], 'password' => $data['password']));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function checkUserLogin($email, $password) {
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password, 'is_deleted' => 1, 'status' => 1));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }
    
    function checkUserLoginStatus($email, $password) {
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password ));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function viewProfileDetails($id) {

        $sql = 'SELECT u.*, c.country as country_name FROM users u
                LEFT JOIN country c ON c.id = u.country 
                WHERE u.id = "' . $id . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        } else {
            $result = false;
        }
        return $result;
    }

    function viewFriendsProfile($friends_id, $id) {

        $sql = 'SELECT * FROM friends WHERE ( users_id = "' . $id . '"  AND friends_id = "' . $friends_id . '" ) OR ( friends_id = "' . $id . '"  AND users_id = "' . $friends_id . '" ) AND is_deleted = 1 ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        } else {
            $result = false;
        }
        return $result;
    }
    
    function viewFriendsProfileDetails($id) {

        $sql = 'SELECT f.*, u.name as profile_name, u.email, u.id as profile_id, u.image as profile_image FROM friends f
                LEFT JOIN users u ON u.id = f.users_id WHERE f.id = "'.$id.'"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        } else {
            $result = false;
        }
        return $result;
    }

    function viewNotificationProfile($id) {

        $sql = 'SELECT f.*, u.name, u.image FROM friends f
                LEFT JOIN users u ON u.id = f.users_id WHERE f.friends_id = "' . $id . '" AND f.is_deleted = 1 AND f.status = 0 ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }
    
    function viewFriendsListProfile($id) {

        $sql = 'SELECT f.*, u.name as profile_name1, u.id as profile_id1, u.image as profile_image1, p.name as profile_name2, p.id as profile_id2, p.image as profile_image2 FROM friends f
                LEFT JOIN users p ON p.id = f.friends_id
                LEFT JOIN users u ON u.id = f.users_id WHERE ( f.friends_id = "' . $id . '" OR f.users_id = "' . $id . '" ) AND f.is_deleted = 1 AND f.status = 1 ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }

    function viewFriendsListProfileEmail($id) {

        $sql = 'SELECT f.*, u.email as profile_email1, u.id as profile_id1, p.email as profile_email2, p.id as profile_id2 FROM friends f
                LEFT JOIN users p ON p.id = f.friends_id
                LEFT JOIN users u ON u.id = f.users_id WHERE ( f.friends_id = "' . $id . '" OR f.users_id = "' . $id . '" ) AND f.is_deleted = 1 AND f.status = 1 ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }
    
    function viewFriendsListProfileSearch($id, $search, $name) {

        $sql = 'SELECT f.*, u.name as profile_name1, u.id as profile_id1, u.image as profile_image1, p.name as profile_name2, p.id as profile_id2, p.image as profile_image2 FROM friends f
                LEFT JOIN users p ON p.id = f.friends_id
                LEFT JOIN users u ON u.id = f.users_id WHERE ( f.friends_id = "' . $id . '" OR f.users_id = "' . $id . '" ) AND f.is_deleted = 1 AND f.status = 1 AND ( ( u.name LIKE "%'.$search.'%" AND u.name != "'.$name.'" )  OR ( p.name LIKE "%'.$search.'%" AND p.name != "'.$name.'" ) ) ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }

    function checkEmailUser($email) {
        $sql = 'SELECT * FROM users WHERE email = "' . $email . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->first_row()->id;
        } else {
            return false;
        }
    }

    function showCountryUsers() {
        $sql = "select c.* from country c";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function searchUsersProfile($search) {

        $sql = 'SELECT u.*, c.country as country_name FROM users u
                LEFT JOIN country c ON c.id = u.country
                where ( u.email = "' . $search . '" OR u.name LIKE "%' . $search . '%"  OR u.about_me LIKE "%'.$search.'%"
                OR u.id IN ( select p.users_id from post p where p.title LIKE "%'.$search.'%" OR p.description LIKE "%'.$search.'%" ) 
                OR ( u.category LIKE "%'.$search.'%" OR u.category LIKE "%,'.$search.'%" OR u.category LIKE "%'.$search.',%" OR u.category LIKE "%,'.$search.',%" ))
                AND u.status = 1 AND u.is_deleted = 1 ORDER BY u.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function searchUsersProfileAjax( $content, $city ) {

        $sql = 'SELECT u.*, c.country as country_name FROM users u
                LEFT JOIN country c ON c.id = u.country
                where ( u.email = "' . $content . '" OR u.name LIKE "%' . $content . '%" OR u.about_me LIKE "%'.$content.'%"
                     OR u.id IN ( select p.users_id from post p where p.title LIKE "%'.$content.'%" AND p.description LIKE "%'.$content.'%" )
                     OR ( u.category LIKE "%'.$content.'%" OR u.category LIKE "%,'.$content.'%" OR u.category LIKE "%'.$content.',%" OR u.category LIKE "%,'.$content.',%" ) ) 
                AND u.city LIKE "%'.$city.'%"  AND u.status = 1 AND u.is_deleted = 1  ORDER BY u.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function searchUsersProfileWithCategoryCountry($search) {

        $sql = 'SELECT u.*, c.country as country_name FROM users u 
                LEFT JOIN post p ON p.users_id = u.id
                LEFT JOIN category g ON g.id = p.category
                LEFT JOIN country c ON c.id = p.country
                where ( c.country = "' . $search . '" OR g.category_name = "' . $search . '" ) AND u.status = 1 AND u.is_deleted = 1 group by u.id';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function getContentPage($page) {

        $sql = 'SELECT * FROM page where slug = "' . $page . '"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }

    function getPagesWithId($eid) {

        $sql = 'SELECT * FROM page where id = "' . $eid . '"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }
    
    function getPages() {

        $sql = 'SELECT * FROM page where status = 1 AND is_deleted = 1';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }


    function showAllUsers() {

        $sql = 'SELECT * FROM users';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }

    function countUsersReports($uid) {

        $sql = 'SELECT count(*) as count_report FROM reports where user_id = "' . $uid . '"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->count_report;
        }
        return $result;
    }

    function viewAllReports($uid) {

        $sql = 'SELECT r.*, u.name, c.name as reporter FROM reports r 
        LEFT JOIN users u ON u.id = r.user_id
        LEFT JOIN users c ON c.id = r.report_from
        where r.user_id = "' . $uid . '" order by created_at DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }

    
}

?>
