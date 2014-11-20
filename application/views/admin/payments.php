<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">付款记录</h1>
        </div>
    </div>
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <?php echo $accemail ?> 付款记录
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>日期</th>
                                            <th>发票编号</th>
                                            <th>发票类型</th>
                                            <th>税前收入</th>
                                            <th>代扣税</th>
                                            <th>实际支付金额（税后）</th>
                                            <th>确认付款</th>
                                            <th>付款时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

$i = 0;
foreach($payments as $payinfo) {
    if($i%2) {
        echo "<tr class='even gradeA'>";
    }else{
        echo "<tr class='odd gradeA'>";
    }
    echo "<td>{$payinfo['invoice_date']}</td>";
    echo "<td>{$payinfo['invoice_id']}</td>";
    echo "<td>{$payinfo['invoice_type']}</td>";
    echo "<td>{$payinfo['income']}</td>";
    echo "<td>{$payinfo['tax']}</td>";
    echo "<td>{$payinfo['income_tax']}</td>";
    $status = $payinfo['status']?"已付款":"未付款";
    echo "<td>{$status}</td>";
    echo "<td>{$payinfo['pay_time']}</td>";
    echo "</tr>";
}

                                    ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
</div>

    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url();?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>

