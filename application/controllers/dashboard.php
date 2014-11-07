<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashBoard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("dashboard_model");
        $this->load->model("captcha_model");
    }

    public function islogined() {
        $this->load->helper("url");
        $this->load->library('session');
        $accemail = $this->session->userdata('accemail');
        if( $accemail == "") {
            header("Location:".base_url()."index.php/dashboard/login"); 
        }else{
            return $accemail;
        }
    } 

    public function logout() {
        $this->load->helper("url");
        $this->load->library('session');
        $userdata = array('accemail'=>"", 'email'=>'');
        $this->session->unset_userdata($userdata); 
        header("Location:".base_url());
//        header("Location:".base_url()."index.php/dashboard/login"); 
    }

    public function login() {
        $this->load->helper("url");
        $this->load->helper("form");

        $data['cap'] = $this->captcha_model->getCaptcha();
        $this->load->view('login', $data);

    }


    public function register() {
        $this->load->helper("url"); 
        $this->load->helper("form");

        $data['cap'] = $this->captcha_model->getCaptcha();

        $this->load->view('register',$data);
    }

    public function isUserExist() { // For Ajax 
        $accemail = $this->input->post('email');
        if($this->dashboard_model->isUserExist($accemail) == false) {
            echo "0"; 
        }else {
            echo "1"; 
        } 
    }

    public function newuser() {
        $this->load->helper("url");  
        $this->load->helper("email");  

        $accemail = $this->input->post("email");
        $password = $this->input->post("password");
        $captcha = $this->input->post("captcha");

        header("content-type:text/html;charset=utf-8");
        if ( $this->captcha_model->checkCaptcha($captcha) == false ) {
            echo "<script>alert('验证码错误');history.back(-1);</script>";
        }else {
            if(!valid_email($accemail)) {
                echo "<script>alert('邮箱不合法.');history.back(-1);</script>";
                return; 
            }
            if( $this->dashboard_model->newUser($accemail, $password) ) {
                echo "<script>alert('注册成功');location.href=\'".base_url()."\'</script>";
            }else
                echo "<script>alert('添加失败.');history.back(-1);</script>";
        }
    }

    public function usercheck() {
        $this->load->library('session');
        $this->load->helper("url");
        $accemail = $this->input->post('email'); 
        $password = $this->input->post('password'); 
        $captcha  = $this->input->post('captcha');
/*
        $expiration = time()-7200; // 2小时限制
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration); 

        // 然后再看是否有验证码存在:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0) {
 */
        if ( $this->captcha_model->checkCaptcha($captcha) == false ) {
            header("content-type:text/html;charset=utf-8");
            echo "<script>alert('验证码错误');location.href=\"".base_url()."index.php/dashboard/login\"</script>";
        }else{
            if(true == $this->dashboard_model->userValidate($accemail, $password)) {
                $this->session->set_userdata(array("accemail"=>$accemail));
                //echo base_url();
                header("Location:".base_url()); 
            }else {
                header("Location:".base_url()."index.php/dashboard/login"); 
                //echo base_url()."index.php/dashboard/login";
            };
        }
    }

    public function index()
    {
        $this->load->helper("url");
        $data['navbar'] = "1";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/index');
        $this->load->view('admin/footer');
    }

    public function statitic() {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/statitic');
        $this->load->view('admin/footer');
    }

    public function adpos() {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/adpos');
        $this->load->view('admin/footer');

    }

    public function revenue() {
        $this->load->helper("url");
        $data['navbar'] = "4";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/revenue');
        $this->load->view('admin/footer');

    }

    public function payments() { //付款记录
        $this->load->helper("url");
        $data['navbar'] = "5";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/payments');
        $this->load->view('admin/footer');

    }

    public function subagents() {
        $this->load->helper("url");
        $data['navbar'] = "6";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/subagents');
        $this->load->view('admin/footer');
    }

    public function agents() {
        $this->load->helper("url");
        $data['navbar'] = "7";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/agents');
        $this->load->view('admin/footer');
    }

    public function settings() {
        $this->load->helper("url");
        $data['navbar'] = "8";
        $data['accemail'] = $this->islogined();

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/settings');
        $this->load->view('admin/footer');
    }
}

