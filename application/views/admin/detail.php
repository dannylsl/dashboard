<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">广告位置</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:auto;">
                    <div class="col-md-10" align="right">
                        <div class="btn btn-primary" style="float:left;cursor:pointer;" OnClick="daySearch()">所有广告位走势图</div>
                        <div class="col-md-1" style="margin-left:10px;"> 
                            <select style="width:100px;" name="widthunit" class="form-control">
                                <option value="0">ALL</option>
                            <?php
                            foreach($pidlist as $pidinfo) {
                                echo "<option value=\"{$pidinfo['pid']}\"";
                                if($pidinfo['pid'] == $sel_pid)
                                    echo "selected='selected'";
                                echo ">{$pidinfo['pid_name']}</option>";
                            }    
                            ?>
                            </select>
                        </div>
                        <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                            <span class="input-group-addon">起始</span>
                            <input type="text" class="form-control" id="startdate" data-date-format="yyyy-mm-dd" value="<?php echo $start_date;?>">
                        </div>
                        <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                            <span class="input-group-addon">终止</span>
                            <input type="text" class="form-control" id="enddate" data-date-format="yyyy-mm-dd" value="<?php echo $end_date;?>">
                        </div>
                        <button class="btn btn-default" style="float:left;margin-left:5px;" OnClick="daySearch()">天查询</button>
                        <button class="btn btn-default" style="float:left;margin-left:5px;" Onclick="hourSearch()">时查询</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="container"></div>
<!--                    <div id="morris-area-chart"></div>
                    <div id="morris-bar-chart" style="display:none;"></div>
-->
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>名称</th>
                            <th>展示量</th>
                            <th>总点击量</th>
                            <th>点击率</th>
                            <th>收入(元)</th>
                            <th>操作</th>
                        </tr>
                        <?php
//                        print_r($slotData);
                        $total_pv = 0;
                        $total_click = 0;
                        $total_income = 0;
                        $total_rate = "0.00%";

                        foreach($slotlist as $slot) {
                            if($slotData[$slot['slot_name']]['sum_pv'] != 0)
                                $clickRate = round($slotData[$slot['slot_name']]['sum_click']/$slotData[$slot['slot_name']]['sum_pv']*100, 2)."%";
                            else 
                                $clickRate = 0;
                            echo "<tr>";
                            echo "<td>[{$slot['pid_name']}] {$slot['slot_name']}</td>";
                            echo "<td>{$slotData[$slot['slot_name']]['sum_pv']}</td>";
                            echo "<td>{$slotData[$slot['slot_name']]['sum_click']}</td>";
                            echo "<td>{$clickRate}</td>";
                            echo "<td>&yen;{$slotData[$slot['slot_name']]['sum_income']}</td>";
                            echo "<td><a onClick=\"detailInfo({$slot['pid']},{$slot['slot_id']}, '{$start_date}', '{$end_date}')\" style=\"cursor:pointer;\">每日详细</a> ";
                            echo " | <a onClick=\"closeInfo({$slot['slot_id']})\" style=\"cursor:pointer\">关闭</a></td>";
                            echo "</tr>";
                            echo "<tr><td colspan='6' class='warning' style='display:none;' id='slotTable_{$slot['slot_id']}'></td></tr>";
                            $total_pv += $slotData[$slot['slot_name']]['sum_pv'];
                            $total_click += $slotData[$slot['slot_name']]['sum_click'];
                            $total_income += $slotData[$slot['slot_name']]['sum_income'];

                            if($total_pv != 0)
                                $total_rate = round($total_click/$total_pv*100,2)."%";
                        }
                        if($total_flag)
                            echo "<tr class='success'><td>小计</td><td>{$total_pv}</td><td>{$total_click}</td><td>{$total_rate}</td><td>&yen;{$total_income}</td><td></td></tr>";
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
    </div> <!-- page-wrapper -->


    <!-- high charts -->
    <script src="<?php echo base_url();?>js/highcharts.js"></script>
    <script>
$(function () {
    $('#container').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: '<?php echo $chartTitle['title'];?>'
        },
        subtitle: {
            text: '<?php echo $chartTitle['subtitle'];?>'
        },
        xAxis: [{
            type: 'datetime', 
        }],
        tooltip: {
            xDateFormat:'%Y-%m-%d %H',
            shared: true,
        },
        yAxis: [{ // Primary yAxis
            min:0,
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +' %';
                },
                style: {
                    color: '#89A54E'
                }
            },
            title: {
                text: '总点击率',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
                text: '总点击量',
                style: {
                    color: '#4572A7'
                }
            },
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +' ';
                },
                style: {
                    color: '#4572A7'
                }
            }

        }, { // Tertiary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
                text: '总展示量',
                style: {
                    color: '#AA4643',
                }
            },
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +' ';
                },
                style: {
                    color: '#AA4643'
                }
            },
            opposite: true
        }],
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 80,
            floating: true,
            backgroundColor: '#FFFFFF'
        },
        series: [{
            name: '总展示量',
            color: '#4572A7',
            type: 'column',
            yAxis: 1,
            pointInterval: <?php echo $xAxis['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxis['start'][0];?>,<?php echo $xAxis['start'][1] - 1;?>,<?php echo $xAxis['start'][2];?>),
            data: [<?php echo $yAxis['pv']?>],
            tooltip: {
                valueSuffix: ''
            }

        }, {
            name: '总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
            //data: [1016, 1016, 1015.9, 1015.5, 1012.3, 1009.5, 1009.6, 1010.2, 1013.1, 1016.9, 1018.2, 1016.7],
            pointInterval: <?php echo $xAxis['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxis['start'][0];?>,<?php echo $xAxis['start'][1] - 1;?>,<?php echo $xAxis['start'][2];?>),
            data: [<?php echo $yAxis['click']?>],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' '
            }

        }, {
            name: '总点击率',
            color: '#89A54E',
            type: 'spline',
            //data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            pointInterval: <?php echo $xAxis['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxis['start'][0];?>,<?php echo $xAxis['start'][1] - 1;?>,<?php echo $xAxis['start'][2];?>),
            data: [<?php echo $yAxis['rate']?>],
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });
});				

function showChart(title, subtitle, xAxisData, pvData, clickData, rateData) {
    $('#container').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        xAxis: [{
            type: 'datetime', 
//            categories:  xAxisData ,
        }],
        yAxis: [{ // Primary yAxis
            min:0,
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +' %';
                },
                style: {
                    color: '#89A54E'
                }
            },
            title: {
                text: '总点击率',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true
        }, { // Secondary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
                text: '总点击量',
                style: {
                    color: '#4572A7'
                }
            },
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +'';
                },
                style: {
                    color: '#4572A7'
                }
            }

        }, { // Tertiary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
                text: '总展示量',
                style: {
                    color: '#AA4643'
                }
            },
            labels: {
                enabled:false,
                formatter: function() {
                    return this.value +' ';
                },
                style: {
                    color: '#AA4643'
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true,
            xDateFormat: '%Y-%m-%d %H'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 80,
            floating: true,
            backgroundColor: '#FFFFFF'
        },
        series: [{
            name: '总展示量',
            color: '#4572A7',
            type: 'column',
            yAxis: 1,
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  pvData ,
            tooltip: {
                valueSuffix: ' pv'
            }

        }, {
            name: '总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
            //data: [1016, 1016, 1015.9, 1015.5, 1012.3, 1009.5, 1009.6, 1010.2, 1013.1, 1016.9, 1018.2, 1016.7],
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  clickData ,
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' '
            }

        }, {
            name: '总点击率',
            color: '#89A54E',
            type: 'spline',
            //data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  rateData ,
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    })
}

function daySearch() {
    var start = $("#startdate").val();
    var end = $("#enddate").val();
    var pid = $("select").val();

    location.href="<?php echo base_url();?>index.php/dashboard/daySearch/"+pid+"/"+start+"/"+end; 
}

function hourSearch() {
    var start = $("#startdate").val();
    var end = $("#enddate").val();
    var pid = $("select").val();

    location.href="<?php echo base_url();?>index.php/dashboard/hourSearch/"+pid+"/"+start+"/"+end; 
}

function detailInfo(pid, slot_id, start,end) {
    $.ajax({
        url:"<?php echo base_url()?>index.php/dashboard/slotdetail/"+pid+"/"+slot_id+"/"+start+"/"+end,
        dataType:"json",
        success:function(data) {
            showChart(data['title'],data['subtitle'], data['xAxis'], data['pv'], data['click'], data['rate']);
            $("#slotTable_"+slot_id).html(data['table']);
            $("#slotTable_"+slot_id).fadeIn();
        }
    });
}

function closeInfo(slot_id) {
    $("#slotTable_"+slot_id).fadeOut();
    $("#slotTable_"+slot_id).html();
}
</script>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datepicker();
        $("#enddate").datepicker();
    </script>
