<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">概况</h1>
        </div>
    </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                近两周数据概况 <a href="<?php echo base_url();?>index.php/dashboard/daySearch/0/<?php echo $start_date.'/'.$end_date.'/1';?>" class="btn btn-primary">查看详情</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="container"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->

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
                text: '总点击率',
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

    </script>
