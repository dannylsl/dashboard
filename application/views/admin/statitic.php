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
                        <input type="text" class="form-control" id="startdate" data-date-format="yyyy-mm-dd" value="<?php echo $start_date;?>">
                    </div>
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">终止</span>
                        <input type="text" class="form-control" id="enddate" data-date-format="yyyy-mm-dd" value="<?php echo $end_date;?>">
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
                        <input type="text" class="form-control" id="startMonth" data-date-format="yyyy-mm-dd" value="<?php echo $last_month;?>">
                    </div>
                    <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                        <span class="input-group-addon">终止</span>
                        <input type="text" class="form-control" id="endMonth" data-date-format="yyyy-mm-dd" value="<?php echo $cur_month;?>">
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
                <div class="panel-heading">最近两周详细数据

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
                                foreach( $statiticData as $detail) {
                                    echo "<tr>";
                                    echo "<td>{$detail['date']}</td>";
                                    echo "<td>{$detail['pv']}</td>";
                                    echo "<td>{$detail['click']}</td>";
                                    $rate = "0.00%";
                                    if($detail['pv'] != 0)
                                        $rate = round($detail['click']/$detail['pv']*100, 2)."%";
                                    echo "<td>{$rate}</td>";
                                    echo "<td>&yen;{$detail['income']}</td>";
                                    echo "</tr>";
                                    $total_pv += $detail['pv'];
                                    $total_click += $detail['click'];
                                    $total_income += $detail['income'];
                                } 
                                echo "<tr class='info'>";
                                echo "<td>小计</td>";
                                echo "<td>{$total_pv}</td>";
                                echo "<td>{$total_click}</td>";
                                $rate = "0.00%";
                                if($total_pv != 0)
                                    $rate = round($total_click/$total_pv * 100, 2)."%";
                                echo "<td>{$rate}</td>";
                                echo "<td>&yen;{$total_income}</td>";
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
            xDateFormat:'%Y-%m-%d %H 时',
            shared: true,
        },
        yAxis: [{ // Primary yAxis
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
        }],
        tooltip: {
            xDateFormat:'%Y-%m-%d %H 时',
            shared: true,
        },
        yAxis: [{ // Primary yAxis
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

function weekCmp() {
    var start = $("#startdate").val();
    var end = $("#enddate").val();

    location.href = "<?php echo base_url();?>index.php/dashboard/weekCmp/"+start+"/"+end;
}

function monthCmp() {
    var start = $("#startMonth").val();
    var end = $("#endMonth").val();

    location.href = "<?php echo base_url();?>index.php/dashboard/monthCmp/"+start+"/"+end;
}
    </script>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datepicker();
        $("#enddate").datepicker();
        $("#startMonth").datepicker({format:"yyyy-mm"});
        $("#endMonth").datepicker({format:"yyyy-mm"});
    </script>
    
