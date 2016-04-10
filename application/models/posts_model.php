<?php

Class Posts_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function searchTalent($search_country, $search_content = NULL, $search_category = NULL) {

        if(!empty($search_category)){
            $sql_cat = "select c.* from category c where c.id =  '" . $search_category . "' ";
            $query_cat = $this->db->query($sql_cat);
            $search_content = $query_cat->first_row()->category_name;

        }

        if (!empty($search_country)) {
            $sql = "select p.*, u.name, u.image, u.id as users_id, u.profile_type, c.category_name, t.country from users u
            LEFT JOIN post p ON p.users_id = u.id
            LEFT JOIN category c ON c.id = p.category
            LEFT JOIN country t ON t.id = p.country
            where p.country = '" . $search_country . "' AND  
            ( c.category_name LIKE '%" . $search_content . "%' OR p.title LIKE '%" . $search_content . "%' OR p.description LIKE '%" . $search_content . "%' OR u.email = '" . $search_content . "' OR u.name LIKE '%" . $search_content . "%'  OR u.about_me LIKE '%".$search_content."%' OR u.category LIKE '%".$search_content."%' OR u.category LIKE '%,".$search_content."%' OR u.category LIKE '%".$search_content.",%' OR u.category LIKE '%,".$search_content.",%' ) ";
            $sql .= " AND p.status = '1'  AND p.is_deleted = '1' group by u.id  ORDER BY u.id DESC";
        } else {
            $sql = "select p.*, u.name, u.image, u.id as users_id, u.profile_type, c.category_name, t.country from post p
            LEFT JOIN users u ON u.id = p.users_id
            LEFT JOIN category c ON c.id = p.category
            LEFT JOIN country t ON t.id = p.country
            where 1";
            if (!empty($search_content)) {
                $sql .= " AND ( c.category_name LIKE '%" . $search_content . "%' OR p.title LIKE '%" . $search_content . "%' OR p.description LIKE '%" . $search_content . "%'  OR u.email = '" . $search_content . "' OR u.name LIKE '%" . $search_content . "%'  OR u.about_me LIKE '%".$search_content."%'  OR u.category LIKE '%".$search_content."%' OR u.category LIKE '%,".$search_content."%' OR u.category LIKE '%".$search_content.",%' OR u.category LIKE '%,".$search_content.",%' ) ";
            }
            if (!empty($search_category)) {
                $sql .= " OR p.category = '" . $search_category . "'";
            }
            $sql .= "  AND p.status = '1'  AND p.is_deleted = '1' group by u.id  ORDER BY u.id DESC";
        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function searchTalentForAjax($search) {

        if(!empty($search['category'])){
            $sql_cat = "select c.* from category c where c.id =  '" . $search['category'] . "' ";
            $query_cat = $this->db->query($sql_cat);
            $search['search_content'] = $query_cat->first_row()->category_name;
        }

        if (!empty($search['country'])) {
            $sql = "select p.*, u.name, u.image, u.id as users_id, u.profile_type, c.category_name, t.country from post p
            LEFT JOIN users u ON u.id = p.users_id
            LEFT JOIN category c ON c.id = p.category
            LEFT JOIN country t ON t.id = p.country
            where p.country = '" . $search['country'] . "' AND  
            ( c.category_name LIKE '%" . $search['search_content'] . "%' OR p.title LIKE '%" . $search['search_content'] . "%' OR p.description LIKE '%" . $search['search_content'] . "%'  OR u.email = '" . $search['search_content'] . "' OR u.name LIKE '%" . $search['search_content'] . "%'  OR u.about_me LIKE '%".$search['search_content']."%'  OR u.category LIKE '%".$search['search_content']."%' OR u.category LIKE '%,".$search['search_content']."%' OR u.category LIKE '%".$search['search_content'].",%' OR u.category LIKE '%,".$search['search_content'].",%'  ) ";
            $sql .= " AND p.city LIKE '%" . $search['city'] . "%' AND p.status = '1'  AND p.is_deleted = '1'  group by u.id  ORDER BY u.id DESC";
        } else {
            $sql = "select p.*, u.name, u.image, u.id as users_id, u.profile_type, c.category_name, t.country from post p
            LEFT JOIN users u ON u.id = p.users_id
            LEFT JOIN category c ON c.id = p.category
            LEFT JOIN country t ON t.id = p.country
            where 1";
            if (!empty($search['search_content'])) {
                $sql .= " AND ( ( c.category_name LIKE '%" . $search['search_content'] . "%' OR p.title LIKE '%" . $search['search_content'] . "%' OR p.description LIKE '%" . $search['search_content'] . "%'  OR u.email = '" . $search['search_content'] . "' OR u.name LIKE '%" . $search['search_content'] . "%'  OR u.about_me LIKE '%".$search['search_content']."%'  OR u.category LIKE '%".$search['search_content']."%' OR u.category LIKE '%,".$search['search_content']."%' OR u.category LIKE '%".$search['search_content'].",%' OR u.category LIKE '%,".$search['search_content'].",%') ";
            }else{
                $sql .= "( ";
            }
            if (!empty($search['category'])) {
                $sql .= " OR p.category = '" . $search['category'] . "' )";
            }else{
                $sql .= ") ";
            }
            $sql .= "  AND p.city LIKE '%" . $search['city'] . "%' AND p.status = '1'  AND p.is_deleted = '1'  group by u.id  ORDER BY u.id DESC";
        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    

    function fetchUsersByTabCategory($category_id) {

        $sql_cat = "select c.* from category c where c.id =  '" . $category_id . "' ";
        $query_cat = $this->db->query($sql_cat);
        $category = $query_cat->first_row()->category_name;

        $sql = "select u.* from users u where ( u.category LIKE '%".$category."%' OR u.category LIKE '%,".$category."%' OR u.category LIKE '%".$category.",%' OR u.category LIKE '%,".$category.",%' ) AND u.status = 1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewCountry() {
        $sql = "select * from country order by id";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsProfile($user) {
        $sql = "select * from post where users_id = '" . $user . "' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function countPostLike($post_id) {
        $sql = "select count(*) as like_count from `like` where post_id = '" . $post_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->like_count;
            return $result;
        }
    }
    
    function statusPostLike($post_id, $user_id) {
        $sql = "select id from `like` where post_id = '" . $post_id . "' AND user_id = '".$user_id."' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return true;
        }else{
            return false;
        }
    }

    function countPostComment($post_id) {
        $sql = "select count(*) as comment_count from `comment` where post_id = '" . $post_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->comment_count;
            return $result;
        }
    }

    function fetchAllComment($post_id) {
        $sql = "select c.*, u.name, u.image from `comment` c
                INNER JOIN users u ON u.id = c.user_id
                where post_id = '" . $post_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsProfileInData( $user, $start=0, $limit=10) {
        $sql = "select p.*, u.name, u.image from post p
                INNER JOIN users u ON p.users_id = u.id
                WHERE p.users_id IN (" . $user . ") AND p.status = 1 order by p.updated_at DESC limit ".$start.",".$limit;
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function viewPostsDeatilsEmail($post_id) {
        $sql = "select p.*, u.name, u.image, u.email, u.profile_type from post p
                INNER JOIN users u ON p.users_id = u.id
                WHERE p.id = '".$post_id."'";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
            return $result;
        }
    }
    
    function viewUsersOfPostCommented($post_id, $post_user) {
        $sql = "select c.id, c.user_id, u.name, u.email from comment c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.post_id = '".$post_id."' AND c.user_id != '".$post_user."' GROUP BY c.user_id";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function peopleOfLike($post_id) {
        $sql = "select l.*,u.name, u.email from `like` l
                LEFT JOIN users u ON u.id = l.user_id
                where l.post_id = '" . $post_id . "' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsContents($post_id) {
        $sql = "select * from posts_content where post_id = '" . $post_id . "' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsContentsWithType($post_id, $type) {
        $sql = "select * from posts_content where post_id = '" . $post_id . "' AND elements_type = '" . $type . "' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewRequirements() {
        $sql = "select r.*, c.country as coun, u.image, u.name, u.id as users_profile_id, u.profile_type, t.category_name from requirement r 
                LEFT JOIN country c ON c.id = r.country
                LEFT JOIN users u ON u.id = r.users_id
                LEFT JOIN category t ON t.id = r.category
                WHERE r.is_deleted = 1 AND r.status = 1 order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function viewRequirementsByUser($user_id) {
        $sql = "select r.*, c.country as coun, u.image, u.name, u.id as users_profile_id, u.profile_type, t.category_name from requirement r 
                LEFT JOIN country c ON c.id = r.country
                LEFT JOIN users u ON u.id = r.users_id
                LEFT JOIN category t ON t.id = r.category
                WHERE r.users_id = '".$user_id."' AND r.is_deleted = 1 AND r.status = 1 order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewRequirementsDetails($rid) {
        $sql = "select r.*, c.country as coun, u.image, u.name, u.profile_type from requirement r 
                LEFT JOIN country c ON c.id = r.country
                LEFT JOIN users u ON u.id = r.users_id
                WHERE r.id = " . $rid . " ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
            return $result;
        }
    }

    function checkPostLike($user_id, $post_id) {
        $sql = "select id from `like` WHERE user_id = " . $user_id . " AND post_id = " . $post_id . " ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return false;
        } else {
            return true;
        }
    }
    
    function checkFireWork( $post_id) {
        $sql = "select id from `firework` WHERE post_id = " . $post_id . " ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return false;
        } else {
            return true;
        }
    }
    
    function checkFireWorkWithUsers( $post_id, $users ) {
        $sql = "select id from `firework` WHERE post_id = " . $post_id . " AND user_id = ".$users." ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return false;
        } else {
            return true;
        }
    }
    
    function checkFireWorkBy( $post_id) {
        $sql = "select f.*,u.name, u.email from `firework` f
                LEFT JOIN users u ON u.id = f.user_id
                where f.post_id = '" . $post_id . "' order by f.id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function countFireWorkBy( $post_id) {
        $sql = "select count(*) as count_firework from `firework`
                where post_id = '" . $post_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->first_row()->count_firework;
        } else {
            return false;
        }
    }

    function fetchUsersByCountryCity($country = NULL, $city = NULL, $category) {
        $sql = "select u.id, u.email from `users` u 
                LEFT JOIN post p ON p.users_id = u.id
                WHERE 1 AND p.category = '".$category."' ";
        /*if (!empty($country)) {
            $sql .= " AND p.country = " . $country . " ";
        }

        if (!empty($city)) {
            $sql .= " AND p.city = '" . $city . "' ";
        }*/
        $sql .= " group by u.id";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function showMessagesUsers($user_id, $friend_id) {
        $sql = "select m.*, u.name, u.image from massage m
                LEFT JOIN users u ON u.id = m.user_id
                WHERE ( m.user_id = '" . $user_id . "' AND m.friend_id = '" . $friend_id . "' )
                OR ( m.friend_id = '" . $user_id . "' AND m.user_id = '" . $friend_id . "' )
                AND m.is_deleted = 1 AND m.status = 1 order by m.id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function showAllMessagesUsers() {
        $sql = "select m.*, u.name, u.image, s.name as receiver_name from massage m
                LEFT JOIN users u ON u.id = m.user_id
                LEFT JOIN users s ON s.id = m.friend_id
                AND m.is_deleted = 1 AND m.status = 1 order by m.id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewFriendsListInbox($user_id) {
        $sql = " SELECT u.id, u.name, u.image FROM users u
        WHERE u.id IN ( SELECT s.user_id FROM massage s WHERE  s.friend_id = '" . $user_id . "' )
        OR u.id IN ( SELECT f.friend_id FROM massage f WHERE  f.user_id = '" . $user_id . "' )";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function countNewNotification($user_id) {
        $sql = "select count(*) as notification from notifications where status = 1 AND user_id = '" . $user_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->notification;
            return $result;
        }
    }

    function showNotification($user_id) {
        $sql = "select n.*,u.image, u.name  from notifications n
    		LEFT JOIN users u ON u.id = n.friend_id
    		where n.user_id = '" . $user_id . "' ORDER BY n.id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function checkForExistingNotification($user_id, $friend_id) {
        $sql = "SELECT id FROM notifications WHERE user_id = '" . $user_id . "' and link_id = '" . $friend_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->id;
            return $result;
        } else {
            return false;
        }
    }
    
    

}

?>
