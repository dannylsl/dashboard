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

    public function newSlot($data_arr) {
        $this->db->insert('slotlist', $data_arr); 
        if($this->db->affected_rows() > 0)
            return true;
        return false;
    }

    public function getSlotDataByDay($pid, $start, $end) {
        $sql = "SELECT stat.slot_id,date,time,pv,click,income, slot_name FROM `stat` LEFT JOIN `slotlist` ON stat.slot_id = slotlist.slot_id WHERE `date`>='{$start}' AND `date` <= '{$end}' AND stat.pid = '{$pid}' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getSlotData($slot_id, $start, $end) {
        $sql = "SELECT SUM(pv) as sum_pv, SUM(click) as sum_click, SUM(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `slot_id`='{$slot_id}'"; 
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getSlotDataDetail($slot_id, $start, $end) {
        if($start == $end) { //HOUR
            $sql = "SELECT time,pv,click,income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `slot_id`='{$slot_id}'"; 
            $query = $this->db->query($sql);
            $arr = $query->result_array();
            $pv_arr = array_fill(0,24, 0);
            $click_arr = array_fill(0,24, 0);
            $rate_arr = array_fill(0,24, 0);
            foreach($arr as $v) {
                $time_arr = explode(':', $v['time']);
                $pv_arr[$time_arr[0]] = (int)$v['pv'];
                $click_arr[$time_arr[0]] = (int)$v['click'];

                if($pv_arr[$time_arr[0]] != 0)
                    $rate_arr[$time_arr[0]] = round($click_arr[$time_arr[0]]/$pv_arr[$time_arr[0]]*100,2);
                else
                    $rate_arr[$time_arr[0]] = 0;
            }
            $tableHtml  = "<div class='table-responsive'><table class='table table-hover'><tr><th>日期 时间</th><th>展示量</th><th>点击量</th><th>点击率</th></tr>";
            for($i=0; $i < 24; $i++) {
                $tableHtml .= "<tr>";

                $tableHtml .= "<td>{$start} {$i}:00</td>";
                $tableHtml .= "<td>{$pv_arr[$i]}</td>";
                $tableHtml .= "<td>{$click_arr[$i]}</td>";
                $tableHtml .= "<td>{$rate_arr[$i]}</td>";
                
                $tableHtml .= "</tr>";
            };
            $tableHtml .= "</table></div>";
            echo json_encode(array("xAxis"=>$this->getStartAndInterval($start,'hour'),"pv" =>$pv_arr,"click" => $click_arr, "rate"=>$rate_arr , "table"=>$tableHtml));
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
             $tableHtml  = "<div class='table-responsive'><table class='table table-hover'><tr><th>日期 时间</th><th>展示量</th><th>点击量</th><th>点击率</th></tr>";
            for($i=0; $i < $size; $i++) {
                $tableHtml .= "<tr>";

                $tableHtml .= "<td>{$date_arr[$i]} </td>";
                $tableHtml .= "<td>{$pv_arr[$i]}</td>";
                $tableHtml .= "<td>{$click_arr[$i]}</td>";
                $tableHtml .= "<td>{$rate_arr[$i]}</td>";
                
                $tableHtml .= "</tr>";
            };
            $tableHtml .= "</table></div>";

            echo json_encode(array("xAxis"=>$this->getStartAndInterval($start,'day'),"pv" =>$pv_arr,"click" => $click_arr, "rate"=>$rate_arr , "table"=>$tableHtml));


        } 
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
            $pv_arr[$index] = $v['sum_pv'];
            $click_arr[$index] = $v['sum_click'];

            if($pv_arr[$index] != 0) {
                $rate_arr[$index] = round($click_arr[$index]/$pv_arr[$index] * 100, 2);   
            }else {
                $rate_arr[$index] = 0;   
            } 
        }
        return array("pv" => implode(',',$pv_arr),"click" => implode(',',$click_arr), "rate"=>implode(',',$rate_arr));
    }

    public function getPidHourData($start, $end, $pid, $acc_id) {
        if($pid != 0)
            $sql = "SELECT date, time, sum(pv) as sum_pv, sum(click) as sum_click, sum(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `pid`='{$pid}' AND `acc_id`='{$acc_id}' GROUP BY date, time ";
        else
            $sql = "SELECT date, time, sum(pv) as sum_pv, sum(click) as sum_click, sum(income) as sum_income FROM `stat` WHERE `date`>='{$start}' AND `date`<='{$end}' AND `acc_id`='{$acc_id}' GROUP BY date, time ";
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
            $time_arr = explode(':', $v['time']); 
            $time_index = (int)$time_arr[0];
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
        $sql = "SELECT time, pv, click FROM `stat` WHERE `date`='{$sel_date}' AND `slot_id`='{$slot_id}' ORDER BY time"; ; 
        $query = $this->db->query($sql);
        $arr = $query->result_array();
        $pv_arr = array_fill(0,24, 0);
        $click_arr = array_fill(0,24, 0);
        $rate_arr = array_fill(0,24, 0);

        foreach($arr as $v) {
            $time_arr = explode(':', $v['time']);
            $pv_arr[$time_arr[0]] = $v['pv'];
            $click_arr[$time_arr[0]] = $v['click'];

            if($pv_arr[$time_arr[0]] != 0)
                $rate_arr[$time_arr[0]] = round($click_arr[$time_arr[0]]/$pv_arr[$time_arr[0]]*100,2);
            else
                $rate_arr[$time_arr[0]] = 0;
        }
        return array("pv" => implode(',',$pv_arr),"click" => implode(',',$click_arr), "rate"=>implode(',',$rate_arr),
                    "pv_arr"=>$pv_arr, "click_arr"=>$click_arr, "rate_arr"=>$rate_arr);
    }

}
