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
                    <div id="morris-area-chart"></div>
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
                    <div id="morris-bar-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">最近两周详细数据</div>
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
                                <tr>
                                    <td>2014-11-03</td>
                                    <td>228514</td>
                                    <td>279</td>
                                    <td>0.122%</td>
                                    <td>&yen;0.00</td>
                                </tr>
                                <tr>
                                    <td>2014-11-03</td>
                                    <td>228514</td>
                                    <td>279</td>
                                    <td>0.122%</td>
                                    <td>&yen;0.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>


    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url();?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris-data.js"></script>
