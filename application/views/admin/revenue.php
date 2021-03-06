<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">收益优化报告</h1>
        </div>
    </div>

    <div class="row"> 
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">收益优化报表</div>
                <div class="panel-body">
                    <div class="row">
                        <?php echo form_open("c=dashboard&m=revenue");?>
                        <div class="col-md-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">起始</span>
                                <input type="text" class="form-control" id="startdate" name="startdate" data-date-format="YYYY-MM-DD" value="<?php echo $start;?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group input-group">
                                <span class="input-group-addon">终止</span>
                                <input type="text" class="form-control" id="enddate" name="enddate" data-date-format="YYYY-MM-DD" value="<?php echo $end;?>">
                            </div>
                        </div>
                        <button class="btn btn-primary">搜索</button>
                        </form>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>序号</th>
                                    <th>日期</th>
                                    <th>展示量</th>
                                    <th>总点击量</th>
                                    <th>点击率</th>
                                    <th>收入(元)</th>
                                </tr>
                                <?php
                                    $index = 1;
                                    foreach($revenue_data as $data) {
                                        echo "<tr>";
                                            echo "<td>{$index}</td>";
                                            echo "<td>{$data['date']}</td>";
                                            echo "<td>".number_format($data['sum_pv'])."</td>";
                                            echo "<td>".number_format($data['sum_click'])."</td>";
                                            $rate = "0.00%";
                                            if($data['sum_pv'] != 0)
                                                $rate = number_format(round($data['sum_click']/$data['sum_pv']*100, 2),2)."%";
                                            echo "<td>{$rate}</td>";
                                            echo "<td>&yen;".number_format($data['sum_income']/100,2)."</td>";
                                        echo "</tr>";
                                        $index ++;
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/moment.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>

    $("#startdate").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});
    $("#enddate").datetimepicker({pickTime:false,maxDate:'<?php echo date('Y-m-d')?>'});

    $(document).ready(function(){
        $("#startdate").change(function() {
            var startdate = $("#startdate").val();
            $("#enddate").data('DateTimePicker').setMinDate(new Date(startdate));
        });

        $("#enddate").change(function() {
            var enddate = $("#enddate").val();
            $("#startdate").data('DateTimePicker').setMaxDate(new Date(enddate));
        });

    });

    </script>
