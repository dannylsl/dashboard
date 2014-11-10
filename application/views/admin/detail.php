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
                    <div class="col-md-12" align="right">
                        <div class="btn btn-primary" style="float:left">所有广告位走势图</div>
                        <div class="col-md-1" style="margin-left:10px;"> 
                            <select style="width:100px;" name="widthunit" class="form-control">
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
                        <button class="btn btn-default" style="float:left;margin-left:5px;">天查询</button>
                        <button class="btn btn-default" style="float:left;margin-left:5px;">时查询</button>
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
                        foreach($slotlist as $slot) {
                            if($slotData[$slot['slot_name']]['sum_pv'] != 0)
                                $clickRate = round($slotData[$slot['slot_name']]['sum_click']/$slotData[$slot['slot_name']]['sum_pv']*100, 2)."%";
                            else 
                                $clickRate = 0;
                            echo "<tr>";
                            echo "<td>{$slot['slot_name']}</td>";
                            echo "<td>{$slotData[$slot['slot_name']]['sum_pv']}</td>";
                            echo "<td>{$slotData[$slot['slot_name']]['sum_click']}</td>";
                            echo "<td>{$clickRate}</td>";
                            echo "<td>&yen;{$slotData[$slot['slot_name']]['sum_income']}</td>";
                            echo "<td><a onClick=\"detailInfo()\" style=\"cursor:pointer;\">每日详细</a></td>";
                            echo "</tr>";
                        }
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
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: [<?php echo $xAxis?>]
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                formatter: function() {
                    return this.value +'°C';
                },
                style: {
                    color: '#89A54E'
                }
            },
            title: {
                text: '总展示量',
                style: {
                    color: '#89A54E'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '总点击量',
                style: {
                    color: '#4572A7'
                }
            },
            labels: {
                formatter: function() {
                    return this.value +' mm';
                },
                style: {
                    color: '#4572A7'
                }
            }

        }, { // Tertiary yAxis
            gridLineWidth: 0,
            title: {
                text: '总点击率',
                style: {
                    color: '#AA4643'
                }
            },
            labels: {
                formatter: function() {
                    return this.value +' mb';
                },
                style: {
                    color: '#AA4643'
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
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
            data: [<?php echo $yAxis['pv']?>],
            tooltip: {
                valueSuffix: ' mm'
            }

        }, {
            name: '总点击量',
            type: 'spline',
            color: '#AA4643',
            yAxis: 2,
            //data: [1016, 1016, 1015.9, 1015.5, 1012.3, 1009.5, 1009.6, 1010.2, 1013.1, 1016.9, 1018.2, 1016.7],
            data: [<?php echo $yAxis['click']?>],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' mb'
            }

        }, {
            name: '总点击率',
            color: '#89A54E',
            type: 'spline',
            //data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            data: [<?php echo $yAxis['rate']?>],
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });
});				

function daySearch() {
    var start = $("#startdate").val();
    var end = $("#enddate").val();
    var pid = $("select").val();

    $.ajax({
        url:"<?php echo base_url();?>index.php/dashboard/daySearch/"+pid+"/"+start+"/"+end, 
        dataType:"json",
        
    });
}
</script>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datepicker();
        $("#enddate").datepicker();

    </script>
