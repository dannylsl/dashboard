<?php
class Dashboard_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function userValidate($accemail, $password) {
        $sql = "SELECT count(*) as count FROM `accinfo` WHERE `accemail`= ? AND password = ?"; 
        $binds = array($accemail, md5($password));
        $query =  $this->db->query($sql, $binds);
        $row = $query->row();
        if($row->count == 0) {
            return false; 
        }else
            return true;
    }

    public function isUserExist($email) {
        $query = $this->db->get_where('accinfo', array('accemail'=>$email));
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function newUser($email, $password) {
        $regtime = date("Y-m-d H:i:s");  
        $md5pwd = md5($password);
        $state = 0; 
        if($this->isUserExist($email) == true)
            return false;

        $sql = "INSERT INTO `accinfo`(`accemail`,`password`, `registertime`,`state`) VALUES('{$email}', '{$md5pwd}', '{$regtime}', '{$state}')";
        $this->db->query($sql);
        if($this->db->affected_rows() == 0) {
            return false; 
        }else {
            return true;
        }
    }


}
