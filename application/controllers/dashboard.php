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
        $acc_status = $this->session->userdata('status'); 
            
        if( $acc_id <= 0) {
            header("Location:".base_url()."index.php/dashboard/login"); 
            return;
        }else{
            if($acc_status == 0)
                header("Location:".base_url()."index.php/dashboard/settings"); 
            return $acc_id;
        }
    } 

    public function logout() {
        $this->load->helper("url");
        $this->load->library('session');
        $userdata = array('acc_id'=>"",'accemail'=>"", 'email'=>'');
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

        //header("content-type:text/html;charset=utf-8");
        echo "<meta charset='utf-8'>";
        if ( $this->captcha_model->checkCaptcha($captcha) == false ) {
            echo "<script>alert('验证码错误');history.back(-1);</script>";
        }else {
            if(!valid_email($accemail)) {
                echo "<script>alert('邮箱不合法.');history.back(-1);</script>";
                return; 
            }
            if( $acc_id = $this->dashboard_model->newUser($accemail, $password) ) {
                $this->active_email($acc_id);
                echo "<script>alert('注册成功,账号激活邮件已发送到您的邮箱');location.href='".base_url()."'</script>";
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
            $accinfo = $this->dashboard_model->userValidate($accemail, $password);
            $acc_id = $accinfo['acc_id'];
            if( $acc_id  > 0 ) {
                $info = array(
                    "accemail" => $accemail,
                    "acc_id" => $acc_id,
                    "password" => md5($password),
                    "status" => $accinfo['status'],
                );
                $this->session->set_userdata($info);
                $this->dashboard_model->userlogin($acc_id);
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

    public function overview()
    {
        $this->load->helper("url");
        $data['navbar'] = "1";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        
        $pid = 0;
        $data['end_date'] = date("Y-m-d");
        $data['start_date'] = date("Y-m-d", time() - 86400*14);

        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'day');
        $data['yAxis'] = $this->dashboard_model->getDayData($data['start_date'], $data['end_date'], $pid, $data['acc_id']);
        $data['chartTitle'] = $this->dashboard_model->getChartTitle($data['acc_id'], $pid, 0, $data['start_date'], $data['end_date'],"day");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/overview');
        $this->load->view('admin/footer');
    }



    public function statitic() {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $pid = 0;
        $data['end_date'] = date("Y-m-d");
        $data['start_date'] = date("Y-m-d", time() - 86400*7);

        $data['xAxis1'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis1'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['end_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getSlotHourData($data['end_date'], 0);
        $data['chartTitle'] = array('title'=>'','subtitle'=>'');

        $data['cur_month'] = date("Y-m");
        $data['last_month'] = date("Y-m",strtotime('-1 month'));
        $cur_month_start = date("Y-m")."-01";
        $cur_month_end = date("Y-m-t");
        $last_month_start = date("Y-m",strtotime('-1 month'))."-01";
        $last_month_end = date("Y-m-t", strtotime('-1 month'));
        $data['xAxisMonth'] = $this->dashboard_model->getStartAndInterval($cur_month_start, 'day');
        $data['yAxisMonth'] = $this->dashboard_model->getDayData($cur_month_start, $cur_month_end, $pid, $data['acc_id']);
        $data['yAxisLastMonth'] = $this->dashboard_model->getDayData($last_month_start, $last_month_end, $pid, $data['acc_id']);

        $data['statiticData'] = $this->dashboard_model->getStatiticData($data['acc_id'], date("Y-m-d",time() - 86400*14), $data['end_date']);

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/statitic');
        $this->load->view('admin/footer');
    }

    public function weekCmp($start, $end) {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $pid = 0;
        $data['end_date'] = $end; //date("Y-m-d");
        $data['start_date'] = $start; //date("Y-m-d", time() - 86400*7);

        $data['xAxis1'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis1'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['end_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getSlotHourData($data['end_date'], 0);
        $data['chartTitle'] = array('title'=>'','subtitle'=>'');

        $data['cur_month'] = date("Y-m");
        $data['last_month'] = date("Y-m",strtotime('-1 month'));
        $cur_month_start = date("Y-m")."-01";
        $cur_month_end = date("Y-m-t");
        $last_month_start = date("Y-m",strtotime('-1 month'))."-01";
        $last_month_end = date("Y-m-t", strtotime('-1 month'));
        $data['xAxisMonth'] = $this->dashboard_model->getStartAndInterval($cur_month_start, 'day');
        $data['yAxisMonth'] = $this->dashboard_model->getDayData($cur_month_start, $cur_month_end, $pid, $data['acc_id']);
        $data['yAxisLastMonth'] = $this->dashboard_model->getDayData($last_month_start, $last_month_end, $pid, $data['acc_id']);

        $data['statiticData'] = $this->dashboard_model->getStatiticData($data['acc_id'], date("Y-m-d",time() - 86400*14), date("Y-m-d"));

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/statitic');
        $this->load->view('admin/footer');
    }

    public function monthCmp($start, $end) {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $pid = 0;
        $data['end_date'] = date("Y-m-d");
        $data['start_date'] = date("Y-m-d", time() - 86400*7);

        $data['xAxis1'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis1'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['end_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getSlotHourData($data['end_date'], 0);
        $data['chartTitle'] = array('title'=>'','subtitle'=>'');

        $data['cur_month'] = $end;
        $data['last_month'] = $start;
        $cur_month_start = $end."-01";
        $cur_month_end = date("Y-m-t", strtotime($end));
        $last_month_start = date("Y-m",strtotime($start))."-01";
        $last_month_end = date("Y-m-t", strtotime($start));
        $data['xAxisMonth'] = $this->dashboard_model->getStartAndInterval($cur_month_start, 'day');
        $data['yAxisMonth'] = $this->dashboard_model->getDayData($cur_month_start, $cur_month_end, $pid, $data['acc_id']);
        $data['yAxisLastMonth'] = $this->dashboard_model->getDayData($last_month_start, $last_month_end, $pid, $data['acc_id']);

        $data['statiticData'] = $this->dashboard_model->getStatiticData($data['acc_id'], date("Y-m-d",time() - 86400*14), date("Y-m-d"));

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
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid, $data['acc_id']);
        $data['total_flag'] = 0;
        
        $slotData = array();
        foreach($data['slotlist'] as $slot) {
            $slotData[$slot['slot_name']] = $this->dashboard_model->getSlotData($slot['slot_id'],  $data['start_date'], $data['end_date']); 
        }
        $data['slotData'] = $slotData;
        //$data['xAxis'] = $this->dashboard_model->getXAxisHour($data['start_date']);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['chartTitle'] = $this->dashboard_model->getChartTitle($data['acc_id'], $pid, 0, $data['start_date'], $data['end_date'],"hour");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/detail',$data);
        $this->load->view('admin/footer');

    }

    public function getSlotInfo($slot_id) {
        $data['acc_id'] = $this->islogined();
        $slotinfo = $this->dashboard_model->getSlotInfo($data['acc_id'], $slot_id);
        if($slotinfo != false) {
            echo json_encode($slotinfo);
        }
    }

    public function slotdetail($pid, $slot_id, $start, $end) { //Ajax Json return
        $data['acc_id'] = $this->islogined();
        $this->dashboard_model->getSlotDataDetail($data['acc_id'], $pid, $slot_id, $start, $end); 
    }

    public function daySearch($pid, $start, $end, $total = 0) {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['sel_pid'] = $pid;
        $data['total_flag'] = $total;
        $data['start_date'] = $start;
        $data['end_date'] = $end;
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid, $data['acc_id']);
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 

        $slotData = array();
        foreach($data['slotlist'] as $slot) {
            $slotData[$slot['slot_name']] = $this->dashboard_model->getSlotData($slot['slot_id'],  $data['start_date'], $data['end_date']); 
        }
        $data['slotData'] = $slotData;
    //  $data['xAxis'] = $this->dashboard_model->getXAxisDay($data['start_date'], $data['end_date']);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'day');
        $data['yAxis'] = $this->dashboard_model->getDayData($data['start_date'], $data['end_date'], $pid, $data['acc_id']);
        $data['chartTitle'] = $this->dashboard_model->getChartTitle($data['acc_id'], $pid, 0, $data['start_date'], $data['end_date'],"day");

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/detail',$data);
        $this->load->view('admin/footer');
        
    }

    public function hourSearch($pid, $start, $end) {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['sel_pid'] = $pid;
        $data['start_date'] = $start;
        $data['total_flag'] = 0;
        $data['end_date'] = $end;
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid, $data['acc_id']);
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 
        
        $slotData = array();
        foreach($data['slotlist'] as $slot) {
            $slotData[$slot['slot_name']] = $this->dashboard_model->getSlotData($slot['slot_id'],  $data['start_date'], $data['end_date']); 
        }
        $data['slotData'] = $slotData;
        //$data['xAxis'] = $this->dashboard_model->getXAxisDayHours($data['start_date'], $data['end_date']);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getPidHourData($data['start_date'], $data['end_date'], $pid, $data['acc_id']);
        $data['chartTitle'] = $this->dashboard_model->getChartTitle($data['acc_id'], $pid, 0, $data['start_date'], $data['end_date'],"hour");

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
            $slotlist_arr[$pidinfo['pid_name']] = $this->dashboard_model->getSlotList($pidinfo['pid'], $data['acc_id']);
        } 
        $data['pidlist'] = $pidlist;
        $data['slotlist_arr'] = $slotlist_arr;

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/pidlist_table',$data);
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
        $slot_id = $this->input->post('slot_id'); 

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
            'slot_name'=> $slotname,
            'status'=> $status,
            'type'=>$type,
            'position'=>$position,
            'height'=> $height,
            'width'=> $width,
            'keywords_blacklist'=> $keywords_blacklist,
            'url_blacklist'=> $url_blacklist,
        );

        if($slot_id == 0) { //插入新数据
            $data_arr['pid'] = $pid;
            if($this->dashboard_model->newSlot($data_arr)) {
                header("Location:".base_url()."index.php/dashboard/pidlist"); 
            }else{
                echo "<script>alert('failed');</script>";
            };

        }else{ // 更新数据
            if($this->dashboard_model->updateSlot($data_arr, $slot_id)) {
                header("Location:".base_url()."index.php/dashboard/pidlist"); 
            }else{
                echo "<script>alert('failed');</script>";
            };
              
        } 
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
        $this->load->helper("form");
        $data['navbar'] = "8";
//        $data['acc_id'] = $this->islogined();
        $this->load->library('session');
        $data['acc_id'] = $this->session->userdata('acc_id');
        $data['accemail'] = $this->session->userdata("accemail");
        $data['settings'] = $this->dashboard_model->get_settings($data['acc_id']);
        $data['userinfo'] = $this->dashboard_model->userinfo($data['acc_id']);

        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/settings');
        $this->load->view('admin/footer');
    }

    public function settings_save() {
        $acc_id = $this->islogined();
        $this->load->helper("url");
        $settings['accname'] = $this->input->post('accname');
        $settings['company'] = $this->input->post('company');
        $settings['url'] = $this->input->post('url');
        $settings['flow'] = $this->input->post('flow');
        $settings['adminlist'] = $this->input->post('adminlist');
        $this->dashboard_model->update_settings($acc_id, $settings);

        header("Location:".base_url()."index.php/dashboard/settings");
    }

    public function update_pwd() {
        $this->load->helper("url");
        $acc_id = $this->islogined();
        $pwd = md5($this->input->post("pwd"));
        $newpwd = $this->input->post("newpwd");
        $repwd = $this->input->post("repwd");
        if($pwd != $this->session->userdata("password")) {
            echo "-1"; // 原始密码错误 
        }else {
            if($newpwd != $repwd) {
                echo "-2";// 两次新密码不匹配
            }else {
                if($this->dashboard_model->update_pwd($acc_id, md5($newpwd))) {
                    $this->session->set_userdata("password", md5($newpwd)); 
                    echo "1"; //更新成功
                }
                else
                    echo "0"; //没有变化
            }
        }
    }

    public function active_email($acc_id) {
        $this->load->helper("url");
        $userinfo = $this->dashboard_model->userinfo($acc_id);
        $to = $userinfo['accemail'];
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.exmail.qq.com';
        $config['smtp_user']    = 'ad@adhouyi.com';
        $config['smtp_pass']    = 'ad123456';
        $config['smtp_port']    = '465';
        $config['charset']      = 'utf-8';
        $config['mailtype']     = 'text';
        $config['smtp_timeout'] = '5';
        $config['newline'] = "\r\n";
        $this->load->library ('email', $config);
        $this->email->from ('ad@adhouyi.com', '宏聚时代');
        $this->email->to ($to, 'AAA');
        $this->email->subject ('账号激活通知');
        $content = "你好\r\n 感谢您注册我们的服务，请点击下面的连接激活您的账号\r\n".base_url()."index.php/dashboard/activeuser/{$acc_id}/".md5($to)."/\r\n\r\n".date("Y-m-d");
        $this->email->message ($content);
        $this->email->send (); 

        //echo $this->email->print_debugger();
    }

    public function activeuser($acc_id, $email_md5) {
        $this->load->helper("url");
        $this->load->library('session');
        echo "<meta charset='utf-8'>";
        if($this->dashboard_model->activeuser($acc_id, $email_md5)) {
        //active success
            $this->session->set_userdata('status',1);
            echo "<script>alert(\"账号激活成功\");location.href='".base_url()."index.php/dashboard/settings'</script>"; 
        }else {
        //active failed
            echo "<script>alert(\"账号激活失败\");</script>"; 
        };  
    }
}

