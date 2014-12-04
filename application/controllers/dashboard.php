<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashBoard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header("content-type:text/html;charset=utf-8");
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
            if($acc_status == 0) {
                header("content-type:text/html;charset=utf-8");
              //  header("Location:".base_url()."index.php/dashboard/settings"); 
                echo "<script>alert('账户未激活前，无法使用其他功能');location.href='".base_url()."index.php/dashboard/settings';</script>";
            }
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

    public function newcaptcha() {
        $this->load->helper("url");
        echo $this->captcha_model->newCaptcha();
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
        $captcha = strtolower($this->input->post("captcha"));

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
        $captcha = strtolower($this->input->post("captcha"));

        if ( $this->captcha_model->checkCaptcha($captcha) == false ) {
            //echo "<script>alert('验证码错误');location.href=\"".base_url()."index.php/dashboard/login\"</script>";
            echo "<meta charset='utf-8'>";
            echo "<script>alert('验证码错误');history.back()</script>";
        }else{
            $accinfo = $this->dashboard_model->userValidate($accemail, $password);
            if(!empty($accinfo)) {
            //if( $acc_id  > 0 ) {
                $acc_id = $accinfo['acc_id'];
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
                //header("Location:".base_url()."index.php/dashboard/login"); 
                echo "<meta charset='utf-8'>";
                echo "<script>alert('用户名或密码错误');history.back()</script>";
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

    public function download_statitic() {
        $data['acc_id'] = $this->islogined();
        $statiticData = $this->dashboard_model->getStatiticData($data['acc_id'], date("Y-m-d",time() - 86400*14), date("Y-m-d"));
        $filename= "统计数据".date("Y-m-d", time()- 86400*14)."_".date("Y-m-d").".csv";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        echo iconv("utf-8","gb2312","日期,展示量,总点击量,点击率,收入（元）")."\r\n";
        foreach($statiticData as $sdata)  {
            $rate = "0.00%";
            if($sdata['pv'] != 0) {
                $rate = number_format(round($sdata['click']/$sdata['pv']*100, 2),2)."%";
            }
//            echo $sdata['date'].",".$sdata['pv'].",".$sdata['click'].",".$rate.",".$sdata['income']."\r\n";
            echo "{$sdata['date']},{$sdata['pv']},{$sdata['click']},{$rate},".($sdata['income']/100)."\r\n";
        }
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

        echo json_encode(array("xAxis"=>$data['xAxis'],"xAxis1"=>$data['xAxis1'],"yAxis" =>$data['yAxis'],"yAxis1"=>$data['yAxis1'],"title"=>$data['chartTitle']['title'], "subtitle"=>$data['chartTitle']['subtitle']));
/*
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
 */
    }

    public function monthCmp($start, $end) {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $pid = 0;
/*
        $data['end_date'] = date("Y-m-d");
        $data['start_date'] = date("Y-m-d", time() - 86400*7);
        $data['xAxis1'] = $this->dashboard_model->getStartAndInterval($data['start_date'], 'hour');
        $data['yAxis1'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['xAxis'] = $this->dashboard_model->getStartAndInterval($data['end_date'], 'hour');
        $data['yAxis'] = $this->dashboard_model->getSlotHourData($data['end_date'], 0);
 */
        $data['chartTitle'] = array('title'=>'','subtitle'=>'');

        $data['cur_month'] = $end;
        $data['last_month'] = $start;
        $cur_month_start = $end."-01";
        $cur_month_end = date("Y-m-t", strtotime($end));
        $last_month_start = date("Y-m",strtotime($start))."-01";
        $last_month_end = date("Y-m-t", strtotime($start));
        $data['xAxisMonth'] = $this->dashboard_model->getStartAndInterval($cur_month_start, 'day');
        $data['xAxisLastMonth'] = $this->dashboard_model->getStartAndInterval($last_month_start, 'day');
        $data['yAxisMonth'] = $this->dashboard_model->getDayData($cur_month_start, $cur_month_end, $pid, $data['acc_id']);
        $data['yAxisLastMonth'] = $this->dashboard_model->getDayData($last_month_start, $last_month_end, $pid, $data['acc_id']);

        echo json_encode(array("xAxis"=>$data['xAxisMonth'],"xAxis1"=>$data['xAxisLastMonth'],"yAxis" =>$data['yAxisMonth'],"yAxis1"=>$data['yAxisLastMonth'],"title"=>$data['chartTitle']['title'], "subtitle"=>$data['chartTitle']['subtitle']));

/*
        $data['statiticData'] = $this->dashboard_model->getStatiticData($data['acc_id'], date("Y-m-d",time() - 86400*14), date("Y-m-d"));
        $this->load->view('admin/header');
        $this->load->view('admin/navbar',$data);
        $this->load->view('admin/statitic');
        $this->load->view('admin/footer');
 */
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
        //$data['yAxis'] = $this->dashboard_model->getSlotHourData($data['start_date'], 0);
        $data['yAxis'] = $this->dashboard_model->getPidHourData($data['start_date'], $data['end_date'], $pid, $data['acc_id']);
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

    public function pidDetail($pid, $start, $end) {
        $data['acc_id'] = $this->islogined();
        $this->dashboard_model->getPidDataDetail($data['acc_id'], $pid, $start, $end); 
    }

    public function slotdetail($pid, $slot_id, $start, $end) { //Ajax Json return
        $data['acc_id'] = $this->islogined();
        $this->dashboard_model->getSlotDataDetail($data['acc_id'], $pid, $slot_id, $start, $end); 
    }


    public function daySearch() {
        $this->load->helper("url"); 
        $pid = $this->input->get("pid");
        $start = $this->input->get("start");
        $end = $this->input->get("end");
        if( null == $this->input->get("total") ) {
            $total = 0;
        }else{
            $total = $this->input->get("total");
        }

        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['sel_pid'] = $pid;
        $data['total_flag'] = $total;
        $data['start_date'] = $start;
        $data['end_date'] = $end;
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid, $data['acc_id']);
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 

        $pidData = array();
        foreach($data['pidlist'] as $pidinfo) {
            $pidData[$pidinfo['pid_name']] = $this->dashboard_model->getPidData($pidinfo['pid'], $data['start_date'], $data['end_date']);
        }
        $data['pidData'] = $pidData; 


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


    public function daySearch2($pid, $start, $end, $total = 0) {
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

    public function hourSearch() {
        $this->load->helper("url"); 
        $pid = $this->input->get("pid");
        $start = $this->input->get("start");
        $end = $this->input->get("end");

        $data['navbar'] = "3";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");
        $data['sel_pid'] = $pid;
        $data['start_date'] = $start;
        $data['total_flag'] = 0;
        $data['end_date'] = $end;
        $data['slotlist'] = $this->dashboard_model->getSlotList($pid, $data['acc_id']);
        $data['pidlist'] = $this->dashboard_model->getPidList($data['acc_id']); 

        $pidData = array();
        foreach($data['pidlist'] as $pidinfo) {
            $pidData[$pidinfo['pid_name']] = $this->dashboard_model->getPidData($pidinfo['pid'], $data['start_date'], $data['end_date']);
        }
        $data['pidData'] = $pidData; 

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


    public function hourSearch2($pid, $start, $end) {
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
    
    public function download_pidlist() {
        $data['acc_id'] = $this->islogined();
        $pidlist = $this->dashboard_model->getPidList($data['acc_id']); 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pidlist.csv"');
        header('Cache-Control: max-age=0');
        echo iconv("utf-8","gb2312","序号,PID名称,广告位名称,广告位状态,广告类型,广告位置,宽度,高度")."\r\n";
        $index = 1;
        foreach($pidlist as $pidinfo) {
            $slot_arr = $this->dashboard_model->getSlotList($pidinfo['pid'], $data['acc_id']);
            foreach($slot_arr as $slot) {
                $status = iconv("utf-8","gb2312",$slot['status']?"开启":"关闭");
                if($slot['type'] == "fixed") $type = "固定广告"; 
                else if($slot['type'] == "float") $type = "浮动广告"; 
                $type = iconv("utf-8","gb2312", $type);

                if($slot['position'] == "couplet") $position = "对联";
                else if($slot['position'] == "br") $position = "右下角";
                else if($slot['position'] == "bottom") $position = "底栏";
                else if($slot['position'] == "sidebar") $position = "侧栏";
                else if($slot['position'] == "banner") $position = "横幅";
                else if($slot['position'] == "rectangle") $position = "矩形";
                else if($slot['position'] == "custom") $position = "自定义";
                $position = iconv("utf-8", "gb2312", $position);

                echo "{$index},{$pidinfo['pid_name']},".iconv("utf-8","gb2312",$slot['slot_name']).",{$status},{$type},{$position},{$slot['width']},{$slot['height']}\r\n";
                $index++;
            }
        }
    }
    
    public function newpid($pidinfo) {
        $data['acc_id'] = $this->islogined();
        $accemail = $this->session->userdata('accemail');
        $email_arr = explode('@', $accemail);
        $pidinfo = $email_arr[0].'_'.$data['acc_id'].'_'.$pidinfo;
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

            if($this->dashboard_model->slotTypeRepeat($data['acc_id'], $pid, $type, $position, $width, $height)) {
                // Type repeat  
                echo "<meta charset='utf-8'>";
                echo "<script>alert('广告类型重复,无法添加');history.back(-1);</script>";
                return;
            }

            $data_arr['pid'] = $pid;
            if($this->dashboard_model->newSlot($data_arr)) {
                header("Location:".base_url()."index.php/dashboard/pidlist"); 
            }else{
                echo "<meta charset='utf-8'>";
                echo "<script>alert('添加失败,请重试');</script>";
            };

        }else{ // 更新数据

            if($this->dashboard_model->slotTypeRepeat4update($data['acc_id'], $pid, $slot_id, $type, $position, $width, $height)) {
                // Type repeat  
                echo "<meta charset='utf-8'>";
                echo "<script>alert('广告类型重复,无法添加');history.back(-1);</script>";
                return;
            }

            if($this->dashboard_model->updateSlot($data_arr, $slot_id)) {
                header("Location:".base_url()."index.php/dashboard/pidlist"); 
            }
            else{
                header("Location:".base_url()."index.php/dashboard/pidlist"); 
        //        echo "<script>alert('failed');</script>";
            };
        } 
    }

    public function slotTypeRepeat($pid, $type, $position, $width, $height) {

        $data['acc_id'] = $this->islogined();
        if($this->dashboard_model->slotTypeRepeat($data['acc_id'], $pid, $type, $position, $width, $height)) {
            echo "Repeat";  
        }else {
            echo "NoRepeat";  
        }
    }

    public function slotTypeRepeat4update($pid, $slot_id, $type, $position, $width, $height) {
        $data['acc_id'] = $this->islogined();
        if($this->dashboard_model->slotTypeRepeat4update($data['acc_id'], $pid, $slot_id, $type, $position, $width, $height)) {
            echo  "Repeat";
        }else{
            echo  "NoRepeat";
        }
    }

    public function revenue() {
        $this->load->helper("url");
        $this->load->helper("form");
        $data['navbar'] = "4";
        $data['acc_id'] = $this->islogined();
        $data['accemail'] = $this->session->userdata("accemail");

        $start = $this->input->post('startdate');
        $end = $this->input->post('enddate');
        $data['start'] = $start;
        $data['end'] = $end;

        if($start == "" || $end == "") 
            $data['revenue_data'] = $this->dashboard_model->getDayDataForRevenue($data['acc_id']); 
        else
            $data['revenue_data'] = $this->dashboard_model->getDayDataForRevenue($data['acc_id'],$start,$end); 
            
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

        $data['payments'] = $this->dashboard_model->get_payments($data['acc_id']);

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
        $config['mailtype']     = 'html';
        $config['smtp_timeout'] = '5';
        $config['newline'] = "\r\n";
        $this->load->library ('email', $config);
        $this->email->from ('ad@adhouyi.com', '宏聚时代');
        $this->email->to ($to, 'AAA');
        $this->email->subject ('账号激活通知');
        $url = base_url()."index.php/dashboard/activeuser/{$acc_id}/".md5($to)."/";
        $content = "你好<br> 感谢您注册我们的服务，请点击下面的连接激活您的账号<br> <a href='{$url}'>{$url}</a><br>".date("Y-m-d");
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
            echo "<script>alert(\"账号激活成功\");location.href='".base_url()."index.php/dashboard/login'</script>"; 
        }else {
        //active failed
            echo "<script>alert(\"账号激活失败\");</script>"; 
        };  
    }
}

