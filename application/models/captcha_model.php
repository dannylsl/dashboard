<?php
class Captcha_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
     
    public function getCaptcha() {
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => dirname(BASEPATH).'/images/captcha/',
            'img_url' => base_url('images/captcha').'/',
            'img_width'=> 60,
            'img_height'=> 30,
        );

        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        return $cap['image'];
    }

    public function checkCaptcha($captcha) {
    
        $expiration = time()-7200; // 2小时限制
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration); 

        // 然后再看是否有验证码存在:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($captcha, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if($row->count == 0)
            return false;
        else
            return true;
    }
}
