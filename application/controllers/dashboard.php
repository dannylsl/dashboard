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
        $acc_id = $this->session->userdata('acc_id');
        if( $acc_id <= 0) {
            header("Location:".base_url()."index.php/dashboard/login"); 
        }else{
            return $acc_id;
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

        if ( $this->captcha_model->checkCaptcha($captcha) == false ) {
            header("content-type:text/html;charset=utf-8");
            echo "<script>alert('验证码错误');location.href=\"".base_url()."index.php/dashboard/login\"</script>";
        }else{
            $acc_id = $this->dashboard_model->userValidate($accemail, $password);
            if( $acc_id  > 0 ) {
                $this->session->set_userdata(array("accemail"=>$accemail));
                $this->session->set_userdata(array("acc_id"=>$acc_id));
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
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/index');
        $this->load->view('admin/footer');
    }

    public function statitic() {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/statitic');
        $this->load->view('admin/footer');
    }

    public function adpos() {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/adpos', $data);
        $this->load->view('admin/footer');

    }

    public function detail($pid) {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['sel_pid'] = $pid;
        $data['start_date'] = date("Y-m-d");
        $data['end_date'] = date("Y-m-d");
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid);
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 
//        $data['slotData'] = $this->dashboard_model->getSlotDataByDay($pid, $data['start_date'],$data['end_date']);
        
        $slotData = array();
        foreach($data['slotlist'] as $slot) {
            $slotData[$slot['slot_name']] = $this->dashboard_model->getSlotData($slot['slot_id'],  $data['start_date'], $data['end_date']); 
        }
        $data['slotData'] = $slotData;

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/detail',$data);
        $this->load->view('admin/footer');
    }


    public function pidlist() {
        $this->load->helper("url");
        $this->load->helper("form");
        $data['navbar'] = "6";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $pidlist = $this->dashboard_model->getPidList($data['acc_id']); 

        $slotlist_arr = array();
        foreach($pidlist as $pidinfo) {
            $slotlist_arr[$pidinfo['pid_name']] = $this->dashboard_model->getSlotList($pidinfo['pid']);
        } 
        $data['pidlist'] = $pidlist;
        $data['slotlist_arr'] = $slotlist_arr;

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/pidlist');
        $this->load->view('admin/footer');

    }

    public function newpid($pidinfo) {
        $data['acc_id'] = $this->islogined();
        $accemail = $this->session->userdata('accemail');
        $email_arr = explode('@', $accemail);
        $pidinfo = $email_arr[0].'_'.$pidinfo;
        if($this->dashboard_model->newpid($data['acc_id'], $pidinfo)) {
            echo "1";
        }else {
            echo "0";
        };
    }

    public function newSlot() {
        $data['acc_id'] = $this->islogined();
        $pid = $this->input->post('pid'); 

        $slotname = $this->input->post('slotname');
        $status = $this->input->post('status');
        $options = $this->input->post('options');
        $keywords_blacklist = $this->input->post('keywords_blacklist');
        $url_blacklist = $this->input->post('url_blacklist');

        $opt_arr = explode('#', $options);
        $type_pos = explode('_', $opt_arr[0]);
        $type = $type_pos[0];
        $position = $type_pos[1];
        $width_height = explode('_', $opt_arr[1]);
        $width = $width_height[0];
        $height = $width_height[1];

        $data_arr = array(
            'acc_id'=>$data['acc_id'],
            'pid'=>$pid,
            'slot_name'=> $slotname,
            'status'=> $status,
            'type'=>$type,
            'position'=>$position,
            'height'=> $height,
            'width'=> $width,
            'keywords_blacklist'=> $keywords_blacklist,
            'url_blacklist'=> $url_blacklist,
        );

        if($this->dashboard_model->newSlot($data_arr)) {
            header("Location:".base_url()."index.php/dashboard/pidlist"); 
        }else{
            echo "<script>alert('failed');</script>";
        };
         
    }

    public function revenue() {
        $this->load->helper("url");
        $data['navbar'] = "4";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/revenue');
        $this->load->view('admin/footer');

    }

    public function payments() { //付款记录
        $this->load->helper("url");
        $data['navbar'] = "5";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/payments');
        $this->load->view('admin/footer');

    }

    public function subagents() {
        $this->load->helper("url");
        $data['navbar'] = "6";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/subagents');
        $this->load->view('admin/footer');
    }

    public function agents() {
        $this->load->helper("url");
        $data['navbar'] = "7";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/agents');
        $this->load->view('admin/footer');
    }

    public function settings() {
        $this->load->helper("url");
        $data['navbar'] = "8";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/settings');
        $this->load->view('admin/footer');
    }

}

