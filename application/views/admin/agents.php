<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">代理商</h1>
        </div>
    </div>
    
        <div class="row">
            <div class="col-md-2">
                <div class="form-group input-group">
                    <span class="input-group-addon">日期</span>
                    <input type="text" class="form-control" id="date" data-date-format="yyyy-mm-dd">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group input-group">
                    <span class="input-group-addon">搜索</span>
                    <input type="text" class="form-control">
                </div>
            </div>
            <button class="btn btn-primary">确认</button>
        </div>
        <div class="row">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>切换用户</th>
                    <th>用户</th>
                    <th>广告数量</th>
                    <th>今日展示量</th>
                    <th>今日点击量</th>
                    <th>账户金额</th>
                    <th>广告位数量</th>
                    <th>今日展示量</th>
                    <th>今日点击量</th>
                </tr>
                <tr>
                    <td><a href="#" class="btn btn-default"><i class="fa fa-retweet btn-switch-account"></i></a></td>
                    <td>suran@i8mail.com</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><a href="#" class="btn btn-default"><i class="fa fa-retweet btn-switch-account"></i></a></td>
                    <td>wptad@tom.com</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table> 
    </div>
</div>


    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#date").datepicker();
    </script>
