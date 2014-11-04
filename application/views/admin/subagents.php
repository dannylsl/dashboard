<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">二级渠道</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">二级渠道列表</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">起始</span>
                                <input type="text" class="form-control" id="startdate" data-date-format="yyyy-mm-dd">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">终止</span>
                                <input type="text" class="form-control" id="enddate" data-date-format="yyyy-mm-dd">
                            </div>
                        </div>
                        <button class="btn btn-primary">搜索</button>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>序号</th>
                                    <th>日期</th>
                                    <th>展示量</th>
                                    <th>总点击量</th>
                                    <th>点击率</th>
                                    <th>收入(元)</th>
                                </tr>
                                <tr>
                                    <td>1111</td>
                                    <td>2014-11-03</td>
                                    <td>228514</td>
                                    <td>279</td>
                                    <td>0.122%</td>
                                    <td>&yen;0.00</td>
                                </tr>
                                <tr>
                                    <td>1111</td>
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

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datepicker();
        $("#enddate").datepicker();
    </script>
