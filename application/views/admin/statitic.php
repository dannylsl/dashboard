<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">统计信息</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    本周与上周数据相比 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">起始</span>
                        <input type="text" class="form-control" id="startdate" data-date-format="YYYY-MM-DD" value="<?php echo $start_date;?>">
                    </div>
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">终止</span>
                        <input type="text" class="form-control" id="enddate" data-date-format="YYYY-MM-DD" value="<?php echo $end_date;?>">
                    </div>
                    <button class="btn btn-default" style="float:left;margin-left:5px;" OnClick="weekCmp()">查询</button>
                    <div id="container"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    本月与上月数据相比 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">起始</span>
                        <input type="text" class="form-control" id="startMonth" data-date-format="YYYY-MM" value="<?php echo $last_month;?>">
                    </div>
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">终止</span>
                        <input type="text" class="form-control" id="endMonth" data-date-format="YYYY-MM" value="<?php echo $cur_month;?>">
                    </div>
                    <button class="btn btn-default" style="float:left;margin-left:5px;" OnClick="monthCmp()">查询</button>
                    <div id="container2"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow:auto">最近两周详细数据
                <a style="float:right" class="btn btn-primary btn-sm" href="<?php echo base_url();?>index.php/dashboard/download_statitic"><i class="fa fa-download"></i> 下载数据</a>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>日期</th>
                                    <th>展示量</th>
                                    <th>总点击量</th>
                                    <th>点击率</th>
                                    <th>收入(元)</th>
                                </tr>
                                <?php
                                $total_pv = 0;
                                $total_click = 0;
                                $total_rate = 0;
                                $total_income = 0;
                                $week_arr = array("周日","周一","周二","周三","周四","周五","周六");
                                foreach( $statiticData as $detail) {
                                    echo "<tr>";
                                    echo "<td>".$detail['date'].' '.$week_arr[date('w', strtotime($detail['date']))]."</td>";
                                    echo "<td>".number_format($detail['pv'])."</td>";
                                    echo "<td>".number_format($detail['click'])."</td>";
                                    $rate = "0.00%";
                                    if($detail['pv'] != 0)
                                        $rate = number_format(round($detail['click']/$detail['pv']*100, 2),2)."%";
                                    echo "<td>{$rate}</td>";
                                    echo "<td>&yen;".number_format($detail['income']/100, 2)."</td>";
                                    echo "</tr>";
                                    $total_pv += $detail['pv'];
                                    $total_click += $detail['click'];
                                    $total_income += $detail['income'];
                                } 
                                echo "<tr class='info'>";
                                echo "<td>小计</td>";
                                echo "<td>".number_format($total_pv)."</td>";
                                echo "<td>".number_format($total_click)."</td>";
                                $rate = "0.00%";
                                if($total_pv != 0)
                                    $rate = number_format(round($total_click/$total_pv * 100, 2),2)."%";
                                echo "<td>{$rate}</td>";
                                echo "<td>&yen;".number_format($total_income,2)."</td>";
                                echo "</tr>";

                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>


    <!-- high charts -->
    <script src="<?php echo base_url();?>js/highcharts.js"></script>
    <script>

$(document).ready(function(){

    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();
    $("#enddate").data('DateTimePicker').setMinDate(new Date(startdate));
    $("#startdate").data('DateTimePicker').setMaxDate(new Date(enddate));
    var startMonth = $("#startMonth").val(); 
    var endMonth = $("#endMonth").val(); 
    $("#endMonth").data('DateTimePicker').setMinDate(new Date(startMonth+"-01"));
    $("#startMonth").data('DateTimePicker').setMaxDate(new Date(endMonth+"-30"));
    
    $("#startdate").change(function() {
        var startdate = $("#startdate").val();
        $("#enddate").data('DateTimePicker').setMinDate(new Date(startdate));
    });

    $("#enddate").change(function() {
        var enddate = $("#enddate").val();
        $("#startdate").data('DateTimePicker').setMaxDate(new Date(enddate));
    });

    $("#startMonth").change(function() {
        var startMonth = $("#startMonth").val(); 
        $("#endMonth").data('DateTimePicker').setMinDate(new Date(startMonth+"-01"));
    });

    $("#endMonth").change(function() {
        var endMonth = $("#endMonth").val(); 
        $("#startMonth").data('DateTimePicker').setMaxDate(new Date(endMonth+"-01"));
    });
});

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
            dateTimeLabelFormats: { 
                day: '%m-%d',
                week: '%m-%d',
                month: '%m-%d',
            }
        }],
        tooltip: {
            xDateFormat:'%Y-%m-%d %H 时',
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
                text: '',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
           //     text: '总点击量',
                text: '',
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
          //      text: '总展示量',
                text: '',
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
            layout: 'horizontal',
            align: 'left',
            x: 0,
            verticalAlign: 'top',
            y: 0,
            floating: true,
            backgroundColor: '#FFFFFF'
        },
        series: [
        {
            name: '<?php echo $end_date;?> 总展示量',
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
            name: '<?php echo $start_date;?> 总展示量',
            color: '#cccccc',
            type: 'column',
            yAxis: 1,
            pointInterval: <?php echo $xAxis['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxis['start'][0];?>,<?php echo $xAxis['start'][1] - 1;?>,<?php echo $xAxis['start'][2];?>),
            data: [<?php echo $yAxis1['pv']?>],
            tooltip: {
                valueSuffix: ''
            }

        }, {
            name: '<?php echo $end_date;?> 总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
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
            name: '<?php echo $start_date;?> 总点击量',
            type: 'spline',
            color: '#89A54E',
            yAxis: 2,
            pointInterval: <?php echo $xAxis['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxis['start'][0];?>,<?php echo $xAxis['start'][1] - 1;?>,<?php echo $xAxis['start'][2];?>),
            data: [<?php echo $yAxis1['click']?>],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' '
            }

         }]
    });
});				

$(function () {
    $('#container2').highcharts({
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
            dateTimeLabelFormats: { 
                day: '%m-%d',
            }
        }],
        tooltip: {
            xDateFormat:'%Y-%m-%d %H 时',
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
                text: '',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
           //     text: '总点击量',
                text: '',
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
          //      text: '总展示量',
                text: '',
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
            layout: 'horizontal',
            align: 'left',
            x: 0,
            verticalAlign: 'top',
            y: 0,
            floating: true,
            backgroundColor: '#FFFFFF'
        },
        series: [
        {
            name: '<?php echo $cur_month;?> 总展示量',
            color: '#4572A7',
            type: 'column',
            yAxis: 1,
            pointInterval: <?php echo $xAxisMonth['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxisMonth['start'][0];?>,<?php echo $xAxisMonth['start'][1] - 1;?>,<?php echo $xAxisMonth['start'][2];?>),
            data: [<?php echo $yAxisMonth['pv']?>],
            tooltip: {
                valueSuffix: ''
            }
        }, {
            name: '<?php echo $last_month;?> 总展示量',
            color: '#cccccc',
            type: 'column',
            yAxis: 1,
            pointInterval: <?php echo $xAxisMonth['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxisMonth['start'][0];?>,<?php echo $xAxisMonth['start'][1] - 1;?>,<?php echo $xAxisMonth['start'][2];?>),
            data: [<?php echo $yAxisLastMonth['pv']?>],
            tooltip: {
                valueSuffix: ''
            }

        }, {
            name: '<?php echo $cur_month;?> 总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
            pointInterval: <?php echo $xAxisMonth['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxisMonth['start'][0];?>,<?php echo $xAxisMonth['start'][1] - 1;?>,<?php echo $xAxisMonth['start'][2];?>),
            data: [<?php echo $yAxisMonth['click']?>],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' '
            }

         }, {
            name: '<?php echo $last_month;?> 总点击量',
            type: 'spline',
            color: '#89A54E',
            yAxis: 2,
            pointInterval: <?php echo $xAxisMonth['interval']?>,
            pointStart: Date.UTC(<?php echo $xAxisMonth['start'][0];?>,<?php echo $xAxisMonth['start'][1] - 1;?>,<?php echo $xAxisMonth['start'][2];?>),
            data: [<?php echo $yAxisLastMonth['click']?>],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' '
            }

         }]
    });
});				

function showChart(container, title, subtitle, xAxisData, xAxisData1, pvData, pvData1, clickData, clickData1) {
    $('#'+container).highcharts({
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
            dateTimeLabelFormats: { 
                day: '%m-%d',
                week: '%m-%d',
                month: '%m-%d',
            }
        }],
        tooltip: {
            xDateFormat:'%Y-%m-%d %H 时',
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
                text: '',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true
        }, { // Secondary yAxis
            min:0,
            gridLineWidth: 0,
            title: {
                text: '',
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
                text: '',
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
        legend: {
            layout: 'horizontal',
            align: 'left',
            x: 0,
            verticalAlign: 'top',
            y: 0,
            floating: true,
            backgroundColor: '#FFFFFF'
        },
        series: [
        {
            name: xAxisData['start'][0]+'-'+xAxisData['start'][1]+'-'+xAxisData['start'][2]+'总展示量',
            color: '#4572A7',
            type: 'column',
            yAxis: 1,
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  pvData ,
            tooltip: {
                valueSuffix: ''
            }
        },{
            name: xAxisData1['start'][0]+'-'+xAxisData1['start'][1]+'-'+xAxisData1['start'][2]+'总展示量',
            color: '#cccccc',
            type: 'column',
            yAxis: 1,
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  pvData1 ,
            tooltip: {
                valueSuffix: ''
            }
    },{
            name: xAxisData['start'][0]+'-'+xAxisData['start'][1]+'-'+xAxisData['start'][2]+'总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  clickData ,
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ''
            }

        },{
            name: xAxisData1['start'][0]+'-'+xAxisData1['start'][1]+'-'+xAxisData1['start'][2]+'总点击量',
            type: 'spline',
            color: '#89A54E',
            yAxis: 2,
            pointInterval: xAxisData['interval'],
            pointStart: Date.UTC(xAxisData['start'][0], xAxisData['start'][1] - 1,xAxisData['start'][2]),
            data:  clickData1 ,
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ''
            }
    }]
    })
}


function weekCmp() {
    var start = $("#startdate").val();
    var end = $("#enddate").val();

    $.ajax({
        url: "<?php echo base_url();?>index.php/dashboard/weekCmp/"+start+"/"+end, 
        dataType:"json",
        success:function(data) {
            showChart("container",data['title'],data['subtitle'], data['xAxis'], data['xAxis1'],data['yAxis']['pv_arr'], data['yAxis1']['pv_arr'], data['yAxis']['click_arr'], data['yAxis1']['click_arr']);
        }
    });
}

function monthCmp() {
    var start = $("#startMonth").val();
    var end = $("#endMonth").val();

//    location.href = "<?php echo base_url();?>index.php/dashboard/monthCmp/"+start+"/"+end;
    $.ajax({
        url: "<?php echo base_url();?>index.php/dashboard/monthCmp/"+start+"/"+end, 
        dataType:"json",
        success:function(data) {
            showChart("container2",data['title'],data['subtitle'], data['xAxis'], data['xAxis1'],data['yAxis']['pv_arr'], data['yAxis1']['pv_arr'], data['yAxis']['click_arr'], data['yAxis1']['click_arr']);
        }
    });
}

function download() {
    $.ajax({
        url:"<?php echo base_url();?>index.php/dashboard/download_statitic",
    }); 
}

    </script>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/moment.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});
        $("#enddate").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});
        $("#startMonth").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});
        $("#endMonth").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});
    </script>
    
