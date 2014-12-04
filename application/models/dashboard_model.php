<?php
class Dashboard_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function userValidate($accemail, $password) {
        $sql = "SELECT * FROM `accinfo` WHERE `accemail`= ? AND password = ?"; 
        $binds = array($accemail, md5($password));
        $query =  $this->db->query($sql, $binds);
        $row = $query->row_array();
//        return $row->acc_id;
        return $row;
    }

    public function isUserExist($email) {
        $query = $this->db->get_where('accinfo', array('accemail'=>$email));
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function userInfo($acc_id) {
        $query = $this->db->get_where('accinfo', array('acc_id'=>$acc_id)); 
        return $query->row_array(); 
    }

    public function activeuser($acc_id, $md5_email) {
        $userinfo = $this->userinfo($acc_id);
        if( $md5_email != md5($userinfo['accemail']) ) {
            return false; 
        }else{
            $this->db->where("acc_id", $acc_id);
            $this->db->update("accinfo", array("status" => 1));    
            if($this->db->affected_rows() > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    public function userlogin($acc_id) {
        $ip = $this->input->ip_address();
        $logindate = date("Y-m-d H:i:s");
        $this->db->where('acc_id', $acc_id);
        $this->db->update("accinfo", array("lastentryip"=>$ip,"lastentrytime"=>$logindate));
    }

    public function newUser($email, $password) {
        $regtime = date("Y-m-d H:i:s");  
        $md5pwd = md5($password);
        $state = 0; 
        if($this->isUserExist($email) == true)
            return false;

        $sql = "INSERT INTO `accinfo`(`accemail`,`password`, `registertime`,`status`) VALUES('{$email}', '{$md5pwd}', '{$regtime}', '{$state}')";
        $this->db->query($sql);
        return $this->db->insert_id(); 
/*
        if($this->db->insert_id() == 0) {
            return false; 
        }else {
            return insert;
        }
 */
    }

    public function getPidList($acc_id) {
        $query = $this->db->get_where('accpidmap',array('acc_id' => $acc_id));
        return $query->result_array();
    }

    public function getPidData($pid, $start, $end) {
        $sql = "SELECT date, sum(pv) as sum_pv, sum(click) as sum_click, sum(income) as sum_income FROM `stat` WHERE date>='{$start}' AND date <= '{$end}' AND `pid`='{$pid}' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getSlotList($pid, $acc_id) {
        if($pid != 0) {
            $sql = "SELECT slotlist.*, accpidmap.pid_name FROM `slotlist` LEFT JOIN `accpidmap` ON slotlist.pid = accpidmap.pid WHERE slotlist.pid='{$pid}'";
            //$query = $this->db->get_where('slotlist',array('pid' => $pid));
        }else {
            $sql = "SELECT slotlist.*, accpidmap.pid_name FROM `slotlist` LEFT JOIN `accpidmap` ON slotlist.pid = accpidmap.pid WHERE slotlist.acc_id='{$acc_id}'";
//            $query = $this->db->get_where('slotlist',array('acc_id'=>$acc_id));
        }
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function newpid($acc_id, $pidinfo) {
        $data = array("acc_id"=>$acc_id, "pid_name"=>$pidinfo);
        $this->db->insert("accpidmap", $data); 
        if($this->db->affected_rows() > 0)
            return true;
        return false;
    }

    public function slotTypeRepeat($acc_id, $pid, $type, $position, $width,$height ) {
        $query = $this->db->get_where('slotlist', array('acc_id'=>$acc_id, 'pid'=>$pid, 'type'=>$type, 'position'=>$position, 'width'=> $width, 'height'=>$height ));
        //echo $this->db->last_query();
        if($query->num_rows() > 0) {
        //    echo "TRUE";
            return true;
        }else{
        //    echo "FALSE";
            return false;
        }
    }


    public function slotTypeRepeat4update($acc_id, $pid, $slot_id, $type, $position, $width,$height ) {
        $query = $this->db->get_where('slotlist',array('slot_id'=>$slot_id));    
        $slotinfo = $query->row_array(); 
        //print_r($slotinfo);
        if( $type == $slotinfo['type'] && $position == $slotinfo['position'] && $width == $slotinfo['width'] && $height == $slotinfo['height']) {
            return false; 
        }else{
            $query = $this->db->get_where('slotlist', array('acc_id'=>$acc_id, 'pid'=>$pid, 'type'=>$type, 'position'=>$position, 'width'=> $width, 'height'=>$height ));
         //   print_r($query->row_array());
            if($query->num_rows() > 0) {
                return true;
            }  
            return false;
        }
    }

    public function newSlot($data_arr) {
        $this->db->insert('slotlist', $data_arr); 
        if($this->db->affected_rows() > 0)
            return true;
        return false;
    }

    public function updateSlot($data_arr, $slot_id) {
        $this->db->where('slot_id', $slot_id); 
        $this->db->update("slotlist", $data_arr);    
        if($this->db->affected_rows() > 0) 
            return true;
        return false;
    }

    public function getSlotDataByDay($pid, $start, $end) {
        $sql = "SELECT stat.slot_id,date,time,pv,click,income, slot_name FROM `stat` LEFT JOIN `slotlist` ON stat.slot_id = slotlist.slot_id WHERE `date`>='{$start}' AND `date` <= '{$end}' AND stat.pid = '{$pid}' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getSlotInfo($acc_id, $slot_id) {
        $query = $this->db->get_where('slotlist', array('acc_id'=>$acc_id, 'slot_id'=>$slot_id));
        if($query->num_rows() > 0) {
            return $query->row_array(); 
        }else{
            return false; 
        }
    }

    public function getSlotData($slot_id, $start, $end) {
        $sql = "SELECT SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `slot_id`='{$slot_id}'"; 
        $query = $this->db->query($sql);
        $row = $query->row_array();
        foreach($row as $k=>$v) {
            if($v == "") {
                $row[$k] = 0;
            } 
        }
        return $row;
    }

    public function getStatiticData($acc_id,$start,$end) {
        $sql = "SELECT date as date, sum(pv) as pv, sum(click) as click, sum(income) as income FROM `stat` WHERE `date` >='{$start}' AND `date` <= '{$end}' AND `acc_id`='{$acc_id}' GROUP BY date ORDER BY date DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPidDataDetail($acc_id, $pid, $start, $end) {
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `pid`='{$pid}' GROUP BY `date` ";
            $query = $this->db->query($sql);
            $arr = $query->result_array();
            $obj_start = date_create($start);
            $obj_end = date_create($end);
            $size = $obj_start->diff($obj_end)->days + 1;
            $pv_arr = array_fill(0,$size, 0);
            $click_arr = array_fill(0, $size, 0);
            $rate_arr = array_fill(0, $size, 0);


            foreach( $arr as $v) {
                $obj_date = date_create($v['date']); 
                $index = $obj_start->diff($obj_date)->days;
                $pv_arr[$index] = (int)$v['sum_pv'];
                $click_arr[$index] = (int)$v['sum_click'];

                if($pv_arr[$index] != 0) {
                    $rate_arr[$index] = round($click_arr[$index]/$pv_arr[$index] * 100, 2);   
                }else {
                    $rate_arr[$index] = 0;   
                } 
            }

            $date_arr = $this->getXAxisDayJSON($start,$end);
            $tableHtml  = "<div class='table-responsive'>";
            $tableHtml .= "<div align='right'><i class='fa fa-times' onclick='closeInfo({$pid})' style='cursor:pointer'></i></div>";
            $tableHtml .= "<table class='table table-hover'><tr><th>日期 时间</th><th>展示量</th><th>点击量</th><th>点击率</th></tr>";
            $week_arr = array("周日","周一","周二","周三","周四","周五","周六");
            for($i=$size-1; $i >= 0; $i--) {
                $tableHtml .= "<tr>";
                $tableHtml .= "<td>{$date_arr[$i]} ".$week_arr[date('w', strtotime($date_arr[$i]))]."</td>";
                $tableHtml .= "<td>".number_format($pv_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($click_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($rate_arr[$i], 2)."%</td>";
                $tableHtml .= "</tr>";
            };
            $tableHtml .= "</table></div>";

            $title = $this->getChartTitle($acc_id, $pid, 0, $start, $end, "day");
            echo json_encode(array("xAxis"=>$this->getStartAndInterval($start,'day'),"pv" =>$pv_arr,"click" => $click_arr, "rate"=>$rate_arr, "title" =>$title['title'] ,  "subtitle"=>$title['subtitle'], "table"=>$tableHtml));

    }

    public function getSlotDataDetail($acc_id, $pid, $slot_id, $start, $end) {
        //if($start == $end) { //HOUR
        if(false) {
            $sql = "SELECT hour(time) as hour,sum(pv) as pv,sum(click) as click, sum(income) as income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `slot_id`='{$slot_id}' GROUP BY hour(time)"; 
            $query = $this->db->query($sql);
            $arr = $query->result_array();
            $pv_arr = array_fill(0,24, 0);
            $click_arr = array_fill(0,24, 0);
            $rate_arr = array_fill(0,24, 0);
            foreach($arr as $v) {
                $time_arr[0] = $v['hour'];
                $pv_arr[$time_arr[0]] = (int)$v['pv'];
                $click_arr[$time_arr[0]] = (int)$v['click'];

                if($pv_arr[$time_arr[0]] != 0)
                    $rate_arr[$time_arr[0]] = round($click_arr[$time_arr[0]]/$pv_arr[$time_arr[0]]*100,2);
                else
                    $rate_arr[$time_arr[0]] = 0;
            }
            $tableHtml = "<div align='right'><i class='fa fa-times' onclick='closeInfo({$slot_id})' style='cursor:pointer'></i></div>";
            $tableHtml  .= "<div class='table-responsive'><table class='table table-hover'><tr><th>日期 时间</th><th>展示量</th><th>点击量</th><th>点击率</th></tr>";
            for($i=0; $i < 24; $i++) {
                $tableHtml .= "<tr>";

                $tableHtml .= "<td>{$start} {$i}:00</td>";
                $tableHtml .= "<td>".number_format($pv_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($click_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($rate_arr[$i],2)."%</td>";
                
                $tableHtml .= "</tr>";
            };
            $tableHtml .= "</table></div>";

            $title = $this->getChartTitle($acc_id, $pid, $slot_id, $start, $end, "hour");
            echo json_encode(array("xAxis"=>$this->getStartAndInterval($start,'hour'),"pv" =>$pv_arr,"click" => $click_arr, "rate"=>$rate_arr ,"title"=>$title['title'], "subtitle"=>$title['subtitle'], "table"=>$tableHtml));
        }
        else { //DAY
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `slot_id`='{$slot_id}' GROUP BY `date` ";
            $query = $this->db->query($sql);
            $arr = $query->result_array();
            $obj_start = date_create($start);
            $obj_end = date_create($end);
            $size = $obj_start->diff($obj_end)->days + 1;
            $pv_arr = array_fill(0,$size, 0);
            $click_arr = array_fill(0, $size, 0);
            $rate_arr = array_fill(0, $size, 0);


            foreach( $arr as $v) {
                $obj_date = date_create($v['date']); 
                $index = $obj_start->diff($obj_date)->days;
                $pv_arr[$index] = (int)$v['sum_pv'];
                $click_arr[$index] = (int)$v['sum_click'];

                if($pv_arr[$index] != 0) {
                    $rate_arr[$index] = round($click_arr[$index]/$pv_arr[$index] * 100, 2);   
                }else {
                    $rate_arr[$index] = 0;   
                } 
            }

            $date_arr = $this->getXAxisDayJSON($start,$end);
            $tableHtml  = "<div class='table-responsive'>";
            $tableHtml .= "<div align='right'><i class='fa fa-times' onclick='closeInfo({$slot_id})' style='cursor:pointer'></i></div>";
            $tableHtml .= "<table class='table table-hover'><tr><th>日期 时间</th><th>展示量</th><th>点击量</th><th>点击率</th></tr>";
            $week_arr = array("周日","周一","周二","周三","周四","周五","周六");
            for($i=$size-1; $i >= 0; $i--) {
                $tableHtml .= "<tr>";
                $tableHtml .= "<td>{$date_arr[$i]} ".$week_arr[date('w', strtotime($date_arr[$i]))]."</td>";
                $tableHtml .= "<td>".number_format($pv_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($click_arr[$i])."</td>";
                $tableHtml .= "<td>".number_format($rate_arr[$i], 2)."%</td>";
                $tableHtml .= "</tr>";
            };
            $tableHtml .= "</table></div>";

            $title = $this->getChartTitle($acc_id, $pid, $slot_id, $start, $end, "day");
            echo json_encode(array("xAxis"=>$this->getStartAndInterval($start,'day'),"pv" =>$pv_arr,"click" => $click_arr, "rate"=>$rate_arr, "title" =>$title['title'] ,  "subtitle"=>$title['subtitle'], "table"=>$tableHtml));

        } 
    }

    public function getChartTitle($acc_id, $pid, $slot_id, $start, $end, $dayOrHour="day") {
        if($pid != 0) {
            $query = $this->db->get_where('accpidmap', array('pid'=>$pid));
            $pidinfo = $query->row_array();
            if($slot_id != 0) {
                $query = $this->db->get_where('slotlist', array('slot_id'=>$slot_id));
                $slotinfo = $query->row_array();
            }else{
                $slotinfo['slot_name'] = "所有广告位";
            } 
        }else{
            $pidinfo['pid_name'] = "所有广告位"; 
            $slotinfo['slot_name'] = "";
        }

        if($dayOrHour == "day")
            $scale = "天查询";
        else if($dayOrHour == "hour")
            $scale = "时查询";

        return array('title'=>$pidinfo['pid_name']." ".$slotinfo['slot_name']." ".$scale,'subtitle'=>$start."至".$end);
    }

    public function getStartAndInterval($start, $dayOrHour) {
        if($dayOrHour == "day") {
            $start_arr = explode('-', $start);
            return array("start"=>$start_arr, "interval"=>24*3600*1000);
        }else if($dayOrHour == "hour") {
            $start_arr = explode('-', $start);
            return array("start"=>$start_arr, "interval"=>3600*1000);
        }
    }

    public function getXAxisDayJSON($start, $end) {
        $dt_start = strtotime($start);
        $dt_end   = strtotime($end);
        $res = array();
        $index = 0;
        do {
            $res[$index] = date("Y-m-d", $dt_start);
            $index ++;
        }while(($dt_start += 86400) <= $dt_end);
        return $res;
    }

    public function getXAxisDay($start, $end) {
        $dt_start = strtotime($start);
        $dt_end   = strtotime($end);
        $res = array();
        $index = 0;
        do {
            $res[$index] = "'".date("Y-m-d", $dt_start)."'";
            $index ++;
        }while(($dt_start += 86400) <= $dt_end);
        return implode(',',$res);
    }

    public function getXAxisHourJSON($sel_date) {
        $arr = array();
        $arr[0] = $sel_date;
        for($i = 1; $i < 24; $i++) {
             $arr[$i] = $i.":00";
        }
        return $arr;
    }

    public function getXAxisHour($sel_date) {
        $arr = array();
        $arr[0] = "'".$sel_date."'";
        for($i = 1; $i < 24; $i++) {
             $arr[$i] = "'".$i.":00'";
        }
        return implode(',',$arr);
    }

    public function getXAxisDayHours($start, $end) {

        $dt_start = strtotime($start);
        $dt_end   = strtotime($end);
        $res = array();
        $index = 0;
        do {
            $res[$index*24] = "'".date("Y-m-d", $dt_start)."'";
            $index ++;
            for($i = 1; $i < 24; $i++) {
                $res[$index*24 + $i] = "' '";
            }
        }while(($dt_start += 86400) <= $dt_end);
        return implode(',', $res); 
    }

    public function getDayData($start, $end, $pid, $acc_id) {
        if($pid != 0)
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `pid`='{$pid}'  AND `acc_id` = '{$acc_id}' GROUP BY `date` ";
        else
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `acc_id` = '{$acc_id}' GROUP BY `date` ";

        $query = $this->db->query($sql);
        $arr = $query->result_array();
        $obj_start = date_create($start);
        $obj_end = date_create($end);
        $size = $obj_start->diff($obj_end)->days + 1;
        $pv_arr = array_fill(0,$size, 0);
        $click_arr = array_fill(0, $size, 0);
        $rate_arr = array_fill(0, $size, 0);

        foreach( $arr as $v) {
            $obj_date = date_create($v['date']); 
            $index = $obj_start->diff($obj_date)->days;
            $pv_arr[$index] = (int)$v['sum_pv'];
            $click_arr[$index] = (int)$v['sum_click'];

            if($pv_arr[$index] != 0) {
                $rate_arr[$index] = round($click_arr[$index]/$pv_arr[$index] * 100, 2);   
            }else {
                $rate_arr[$index] = 0;   
            } 
        }
        return array("pv" => implode(',',$pv_arr),"click" => implode(',',$click_arr), "rate"=>implode(',',$rate_arr),"pv_arr"=>$pv_arr, "click_arr"=>$click_arr, "rate_arr"=>$rate_arr);
    }

    public function getPidHourData($start, $end, $pid, $acc_id) {
        if($pid != 0)
            $sql = "SELECT date, hour(time) as hour, sum(pv) as sum_pv, sum(click) as sum_click, sum(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `pid`='{$pid}' AND `acc_id`='{$acc_id}' GROUP BY date, hour(time) ";
        else
            $sql = "SELECT date, hour(time) as hour, sum(pv) as sum_pv, sum(click) as sum_click, sum(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `acc_id`='{$acc_id}' GROUP BY date, hour(time) ";
        $query = $this->db->query($sql);
        $arr = $query->result_array();
        //print_r($arr);
        $obj_start = date_create($start);
        $obj_end = date_create($end);
        $size = $obj_start->diff($obj_end)->days + 1;
        $pv_arr = array_fill(0, $size*24, 0);
        $click_arr = array_fill(0, $size*24, 0);
        $rate_arr = array_fill(0, $size*24, 0);
        
        foreach($arr as $v) {
            $obj_date = date_create($v['date']); 
            $day_index = $obj_start->diff($obj_date)->days;
//            $time_arr = explode(':', $v['time']); 
//            $time_index = (int)$time_arr[0];
            $time_index = (int)$v['hour'];
            $index = $day_index*24+$time_index;
            $pv_arr[$index] = $v['sum_pv'];
            $click_arr[$index] = $v['sum_click'];
            if($pv_arr[$index] != 0)
                $rate_arr[$index] = round($click_arr[$index]/$pv_arr[$index] * 100, 2);
            else
                $rate_arr[$index] = 0;
        }

        return array("pv" => implode(',',$pv_arr),"click" => implode(',',$click_arr), "rate"=>implode(',',$rate_arr));
    }

    public function getSlotHourData($sel_date,$slot_id = 0) {
        $acc_id = $this->session->userdata('acc_id');

        if($slot_id != 0)
            $sql = "SELECT hour(time) as hour, pv, click FROM `stat` WHERE `date`='{$sel_date}' AND `slot_id`='{$slot_id}' AND `acc_id` = '{$acc_id}' GROUP BY date,time ORDER BY time"; 
        else
            $sql = "SELECT hour(time) as hour, sum(pv) as pv, sum(click) as click FROM `stat` WHERE `date`='{$sel_date}' AND `acc_id`='{$acc_id}' GROUP BY date,hour(time) ORDER BY time"; 

        $query = $this->db->query($sql);
        $arr = $query->result_array();
        $pv_arr = array_fill(0,24, 0);
        $click_arr = array_fill(0,24, 0);
        $rate_arr = array_fill(0,24, 0);

        foreach($arr as $v) {
//            $time_arr = explode(':', $v['time']);
//            $time_arr[0] = intval($time_arr[0]);
            $time_arr[0] = (int)$v['hour'];
            $pv_arr[$time_arr[0]] = (int)$v['pv'];
            $click_arr[$time_arr[0]] = (int)$v['click'];

            if($pv_arr[$time_arr[0]] != 0)
                $rate_arr[$time_arr[0]] = round($click_arr[$time_arr[0]]/$pv_arr[$time_arr[0]]*100,2);
            else
                $rate_arr[$time_arr[0]] = 0;
        }
        return array("pv" => implode(',',$pv_arr),"click" => implode(',',$click_arr), "rate"=>implode(',',$rate_arr),
                    "pv_arr"=>$pv_arr, "click_arr"=>$click_arr, "rate_arr"=>$rate_arr);
    }

    public function get_settings($acc_id) {
        $query = $this->db->get_where('accinfo', array('acc_id'=>$acc_id)); 
        return $query->row_array();
    }

    public function update_settings($acc_id, $settings) {
        $this->db->where('acc_id', $acc_id); 
        $this->db->update('accinfo', $settings);
    }

    public function update_pwd($acc_id, $password) {
        $this->db->where('acc_id', $acc_id);
        $this->db->update('accinfo', array("password"=>$password));
        if( $this->db->affected_rows() > 0) {
            return true; 
        }else {
            return false; 
        }
    }

    public function get_payments($acc_id) {
        $query = $this->db->get_where('payment', array("acc_id"=>$acc_id));
        return $query->result_array();
    } 

    public function getDayDataForRevenue($acc_id, $start = 0, $end = 0 ) {
        if($start != 0 && $end != 0) {
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `acc_id` = '{$acc_id}' GROUP BY `date` ";
        }else {
            $sql = "SELECT date,SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `acc_id` = '{$acc_id}' GROUP BY `date` ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
