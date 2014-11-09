<?php
class Dashboard_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function userValidate($accemail, $password) {
        $sql = "SELECT * FROM `accinfo` WHERE `accemail`= ? AND password = ?"; 
        $binds = array($accemail, md5($password));
        $query =  $this->db->query($sql, $binds);
        $row = $query->row();
        return $row->acc_id;
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

    public function getPidList($acc_id) {
        $query = $this->db->get_where('accpidmap',array('acc_id' => $acc_id));
        return $query->result_array();
    }

    public function getSlotList($pid) {
        $query = $this->db->get_where('slotlist',array('pid' => $pid));
        return $query->result_array();
    }

    public function newpid($acc_id, $pidinfo) {
        $data = array("acc_id"=>$acc_id, "pid_name"=>$pidinfo);
        $this->db->insert("accpidmap", $data); 
        if($this->db->affected_rows() > 0)
            return true;
        return false;
    }

    public function newSlot($data_arr) {
        $this->db->insert('slotlist', $data_arr); 
        if($this->db->affected_rows() > 0)
            return true;
        return false;
    }

}
