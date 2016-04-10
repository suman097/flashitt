<?php

Class Category_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    function showCategoryAdmin() {
        $sql = "select c.* from category c where c.is_deleted = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function viewCategoryDetails($id) {
        $sql = "select c.* from category c 
        where c.id =  '" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        return $result;
    }
    
    function showCategoryUsers() {
        $sql = "select c.* from category c where c.status = '1'  AND c.is_deleted = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    
    function viewCategoryCheckSearch( $category ) {
        $sql = "select c.id from category c where c.category_name = '".$category."' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->id;
            return $result;
        }else{
            return false;
        }
    }
    
}

?>
