<?php
class Dashboard_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function userValidate($accemail, $password) {
        $sql = "SELECT count(*) as count FROM `accinfo` WHERE `accemail`= ? AND password = ?"; 
        $binds = array($accemail, $password);
        $query =  $this->db->query($sql, $binds);
        $row = $query->row();
        if($row->count == 0) {
            return false; 
        }else
            return true;
    }
}
