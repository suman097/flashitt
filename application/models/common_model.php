<?php

Class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    function viewCompanyDetailsOnchange($id, $table) {
        $sql = "select * from ".$table." where id =  '" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        return $result;
    }
    
}

?>
