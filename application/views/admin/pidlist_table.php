<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">PID管理</h1>
        </div>
    </div>

    <div class="row">


    <div class="table-responsive" style="margin-top:10px;">
    <table class="table table-striped">
        <tr> 
            <th>序号</th>
            <th>PID名称</th>
            <th>操作</th>
        </tr>

    <?php
    $pid_index = 1;
    foreach($pidlist as $pidinfo) :
    ?>
        <tr> 
            <th><?php echo $pid_index;$pid_index++;?></th>
            <th><?php echo $pidinfo['pid_name']?></th>
            <th>
            <?php 
            echo "<button class=\"btn btn-sucess btn-sm\"  id=\"expand_btn_{$pidinfo['pid']}\" style=\"margin-right:10px;\" onclick=\"toggleTable({$pidinfo['pid']})\">展开</button>";
            echo "<button class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" role=\"button\" data-target=\"#adDialog\" id=\"btnDialog\" onClick=\"openDialog({$pidinfo['pid']})\"><i class=\"fa fa-plus\"></i> 添加广告位</button>";
            echo "<a href=\"".base_url()."index.php/dashboard/detail/{$pidinfo['pid']}\" class=\"btn btn-default btn-sm\" style=\"margin-left:10px;\">查看详情</a>";
            ?>
            </th>
        </tr>
        <tr><td colspan="3" class="info" id="pid_slot_<?php echo $pidinfo['pid']?>" style="display:none;">
        <?php 
            echo "<div class=\"table-responsive\" style=\"margin-top:10px;\">";
            echo "<table class=\"table table-striped\">";
            echo "<tr>"; 
            echo "<th>序号</th>";
            echo "<th>广告位名称</th>";
            echo "<th>广告位状态</th>";
            echo "<th>广告类型</th>";
            echo "<th>宽度</th>";
            echo "<th>高度</th>";
            echo "<th>操作</th>";
            echo "</tr>";
            $slot_index = 1;
            foreach( $slotlist_arr[$pidinfo['pid_name']] as $slot) {
                echo "<tr><td>{$slot_index}</td>";
                echo "<td>[{$slot['pid_name']}] {$slot['slot_name']}</td>";
                echo "<td>{$slot['status']}</td>";
                echo "<td>{$slot['type']}</td>";
                echo "<td>{$slot['width']}</td>";
                echo "<td>{$slot['height']}</td>";
                echo "<td><a style='cursor:pointer;' onclick='editDialog({$slot['slot_id']})'>修改</a> | <a style='cursor:pointer;' onclick=\"showCode({$slot['slot_id']},'{$pidinfo['pid']}','{$slot['type']}','{$slot['position']}',{$slot['width']},{$slot['height']})\">代码</a></td></tr>";
                $slot_index++;
            }
            echo "</table></div>";
        ?>

        </td></tr>
    <?php
        endforeach;            
        echo "<input type='hidden' id='pid_index' value='{$pid_index}'>";
    ?>
    </table></div>
    <button id="pidbtn" class="btn btn-danger"><i class="fa fa-plus"></i> 添加PID</button>
    <a class="btn btn-success" href="<?php echo base_url();?>index.php/dashboard/download_pidlist"><i class="fa fa-download"></i> 导出数据</a>


        <div class="modal fade" id="adDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:80%; height:90%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">广告面板</h4>
              </div>
             <div class="modal-body">
                 
                <?php echo form_open("dashboard/newSlot");?>
                <div class="row" style="position:absolute;z-index:2;right:50px;">
                    预览:<br>
                    <img id="preview" src="<?php echo base_url();?>images/ads/float/couplet/120_270.png" style="max-width: 800px;">
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-1"><h4>广告名称</h4></div>
                    <div class="col-md-2"><input type="text" class="form-control" id="slotname" name="slotname" placeholder="请输入广告名称"></div>
                    <input type="hidden" value="0" id="pid" name="pid">
                    <input type="hidden" value="0" id="slot_id" name="slot_id">
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-1"><h4>投放开关</h4></div>
                    <div class="col-md-3">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="status" id="adOn" value='1' autocomplete="off" checked>开启 
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="status" id="adOff" value='0' autocomplete="off">关闭
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="pc" style="margin-top:20px;">
                    <div class="col-md-1"><h4>广告形态</h4></div>
                    <div class="col-md-5">
                        <ul class="nav nav-tabs">
                            <li id="type_float"><a href="#ADfloat" data-toggle="tab" aria-expanded="true">浮动广告</a></li>
                            <li id="type_fixed" ><a href="#ADfixed" data-toggle="tab">固定广告</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="ADfloat">
                            <!-- 浮动广告 -->
                                <div class="tab-content"> 
                                    <div class="tab-pane fade" id="couplet"> 

                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_couplet#120_240">120*240
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_couplet#120_270">120*270
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_couplet#120_600">120*600
                                                <div style="width:10px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_couplet#160_600">160*600
                                                <div style="width:11px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade" id="br"> 

                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_br#300_250">300*250
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_br#300_300">300*300
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_br#250_250">250*250
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            -->
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="bottom"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_bottom#95_20">95%*20
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_bottom#95_30">95%*30
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="sidebar"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_sidebar#120_240">120*240
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_sidebar#120_270">120*270
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_sidebar#120_600">120*600
                                                <div style="width:10px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="float_sidebar#160_600">160*600
                                                <div style="width:11px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <ul class="nav nav-pills">
                                    <li id="float_couplet">
                                        <a href="#couplet" data-toggle="tab" aria-expanded="fasle">对联</a>
                                    </li>
                                    <li id="float_br">
                                        <a href="#br" data-toggle="tab" aria-expanded="fasle">右下角</a>
                                    </li>
                                    <li id="float_bottom">
                                        <a href="#bottom" data-toggle="tab" aria-expanded="fasle">底栏</a>
                                    </li>
                                    <li id="float_sidebar">
                                        <a href="#sidebar" data-toggle="tab" aria-expanded="fasle">侧栏</a>
                                    </li>
                                </ul>

                            </div> <!-- 浮动广告 -->
                            <div class="tab-pane fade" id="ADfixed"> <!-- 固定广告 -->
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="banner"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options"  autocomplete="off" value="fixed_banner#760_90">760*90
                                                <div style="width:60px;height:10px;background:#00DD77;margin-bottom:23px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options"  autocomplete="off" value="fixed_banner#728_90">728*90
                                                <div style="width:57px;height:10px;background:#00DD77;margin-bottom:23px"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options"  autocomplete="off" value="fixed_banner#640_60">640*60
                                                <div style="width:60px;height:15px;background:#00DD77;margin-bottom:18px"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options"  autocomplete="off" value="fixed_banner#960_90">960*90
                                                <div style="width:60px;height:8px;background:#00DD77;margin-bottom:25px"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="rectangle"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#300_250">300*250
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#250_250">250*250
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#200_200">200*200
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <!--
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#336_280">336*280
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#125_125">125*125
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            -->
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" autocomplete="off" value="fixed_rectangle#360_300">360*300
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                        </div>
                                    </div>
                               
                                    <div class="tab-pane fade" id="custom"> 
                                           <fieldset style="margin:15px 15px 15px 35px">
                                                <div class="row">
                                                    <div class="col-md-1">宽:</div>
                                                    <div class="col-md-3"><input type="number" name="height" id="cheight" value="300" class="form-control"></div>
                                                    <div class="col-md-3">
                                                        <select style="width:80px;" name="widthunit" class="form-control">
                                                            <option value="px">px</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top:10px;">
                                                    <div class="col-md-1">高:</div>
                                                    <div class="col-md-3"><input type="number" name="width" id="cwidth" value="300" class="form-control"></div>
                                                    <div class="col-md-3">
                                                        <select style="width:80px;" name="widthunit" class="form-control">
                                                            <option value="px">px</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-warning" id="custombtn" onclick="customClick()">确定</button>
                                                    <input type="radio" name="options" id="customRadio" value="" style="display:none;">
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                <ul class="nav nav-pills">
                                    <li id="fixed_banner">
                                        <a href="#banner" data-toggle="tab" aria-expanded="fasle">横幅</a>
                                    </li>
                                    <li id="fixed_rectangle">
                                        <a href="#rectangle" data-toggle="tab" aria-expanded="fasle">矩形</a>
                                    </li>
                                    <li id="fixed_custom">
                                        <a href="#custom" data-toggle="tab" aria-expanded="fasle">自定义</a>
                                    </li>
                                </ul>

                            </div> <!-- 固定广告 -->
                        </div>
                    </div>
                </div> <!-- row 广告形态 -->


                <div class="row" style="margin-top:20px;">
                    <div class="col-md-1"><h4>关键字黑名单</h4></div>
                    <div class="col-md-4"><textarea class="form-control" name="keywords_blacklist" id="keywords_blacklist" style="height: 120px;"></textarea></div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-1"><h4>url黑名单</h4></div>
                    <div class="col-md-4"><textarea class="form-control" name="url_blacklist" id="url_blacklist" style="height: 120px;"></textarea></div>
                </div>
                <div style="height:50px;"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_btn">Save changes</button>
              </div>
            </form>
            </div>
          </div>
        </div>

    <!-- Code -->
        <div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:40%;min-width:900px;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">代码</h4>
              </div>
              <div class="modal-body">
HTML形式
<div class="highlight">
<pre><code>&lt;script&gt;
var ad_param = new Array();
ad_param["pid"] = '<span id="code_pid"></span>';
ad_param["sid"] = '<span id="code_slotid"></span>';
ad_param["adtype"] = '<span id="code_type"></span>';
ad_param["adloc"] = '<span id="code_pos"></span>';
ad_param["iw"] = '<span id="code_width"></span>';
ad_param["ih"] = '<span id="code_height"></span>';
&lt;/script&gt;
&lt;script src="http://adhouyi.com/js/v1/hs.js"&gt;
&lt;/script&gt;
</pre></code>
</div>

JavaScript形式
<div class="highlight">
<pre><code>
var adhouyi = document.createElement('script');

adhouyi.src = 'http://adhouyi.com/js/v1/hs.js';
adhouyi.type = 'text/javascript';
document.body.insertBefore(adhouyi, document.body.children.item(0));

var adhouyi_pars = document.createElement('script');
adhouyi_pars.type = 'text/javascript';
adhouyi_pars.text = 'var ad_param = new Array();';
adhouyi_pars.text += 'ad_param["pid"] = "<span id="jscode_pid"></span>";';
adhouyi_pars.text += 'ad_param["sid"] = "<span id="jscode_slotid"></span>";';
adhouyi_pars.text += 'ad_param["iw"] = "<span id="jscode_type"></span>";';
adhouyi_pars.text += 'ad_param["ih"] = "<span id="jscode_pos"></span>";';
adhouyi_pars.text += 'ad_param["adtype"] = "<span id="jscode_width"></span>";';
adhouyi_pars.text += 'ad_param["adloc"] = "<span id="jscode_height"></span>";';
document.body.insertBefore(adhouyi_pars,      document.body.children.item(0));
</pre></code>
</div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
</div>


<script>

$(document).ready(function() {
    $("#pidbtn").click(function() {
        var index= $("#pid_index").val();
        $.ajax({
            url: "<?php echo base_url();?>index.php/dashboard/newpid/"+index,
            success: function(data) {
                if(data == "1") {
                    location.href="<?php echo base_url();?>index.php/dashboard/pidlist";
                }else if(data == "0") {
                    alert("failed");
                }
            }
        });
    });

    $("label").click(function() {
        var sel_val = $(this).children().val();
        console.log(sel_val);
        if(sel_val.length > 5) {
            var words = sel_val.split('#');
            var type = words[0].split('_')[0];
            var position = words[0].split('_')[1];
            $("#preview").attr('src', "<?php echo base_url();?>images/ads/"+type+"/"+position+"/"+words[1]+".png");

            if($(this).children().attr('name') == "options")
                $("input[name='options']").removeAttr("checked");
            else if($(this).children().attr('name') == "status")
                $("input[name='status']").removeAttr("checked");

            $(this).children().attr("checked","checked");
        }
    });

    $("#save_btn").click( function(){
        if($("#slotname").val() == "") {
            alert("广告名称不能为空");
            $("#slotname").focus();
            return;
        }

        if($("input[name='status']").val() == "") {
            alert("请选择投放开关");
            $("input[name='status']").focus();
            return;
        }

        if($("input[name='options'][checked]").val() == undefined) {
            alert("请选择广告形态");
            return;
        }
        console.log($("input[name='options'][checked]").val());

        $("form").submit();
    });
}); 

function activeClear() {

    $("#adOn").parent().attr("class","btn btn-primary active");
    $("#adOff").parent().attr("class","btn btn-primary");
    $("#adOn").attr("checked","checked");
    
    $("input[name='options']").removeAttr("checked");

    $("#ADfloat").attr("class","tab-pane fade");    
    $("#couplet").attr("class","tab-pane fade");
    $("#br").attr("class","tab-pane fade");
    $("#bottom").attr("class","tab-pane fade");
    $("#sidebar").attr("class","tab-pane fade");
    $("#float_couplet").attr("class","");
    $("#float_br").attr("class","");
    $("#float_bottom").attr("class","");
    $("#float_sidebar").attr("class","");

    $("#ADfixed").attr("class","tab-pane fade");    
    $("#banner").attr("class","tab-pane fade");
    $("#rectangle").attr("class","tab-pane fade");
    $("#custom").attr("class","tab-pane fade");

    $("#fixed_banner").attr("class","");
    $("#fixed_rectangle").attr("class","");
    $("#fixed_custom").attr("class","");

    $("#type_float").attr("class","");
    $("#type_fixed").attr("class","");

    $("input[type='radio'][name='options']").each(function () {
        $(this).parent().attr('class','btn btn-default');
    })

    $("#customRadio").parent().attr('class','row');
}

function openDialog(pid) {
    activeClear();
    $("#pid").val(pid);
    $("#slot_id").val(0);

    $("#type_float").attr("class","active");
    $("#ADfloat").attr("class","tab-pane fade in active");    
    $("#couplet").attr("class","tab-pane fade in active");
    $("#float_couplet").attr("class","active");

    $("#banner").attr("class","tab-pane fade in active");
    $("#fixed_banner").attr("class","active");

    $("ADfixed").attr("class", "active");

}

function editDialog(slot_id) {
    $.ajax({
        url:"<?php echo base_url();?>index.php/dashboard/getSlotInfo/"+slot_id,
        async: false,
        dataType: "json",
        success: function(data) {
            activeClear();
            $("#slot_id").val(slot_id);
            $("#slotname").val(data['slot_name']); 
            if(data['status'] == 0) {
                $("#adOn").parent().attr("class", "btn btn-primary");
                $("#adOff").attr("checked","checked");
                $("#adOff").parent().attr("class","btn btn-primary active");
            }else{
                $("#adOn").attr("checked","checked");
                $("#adOff").parent().attr("class","btn btn-primary");
                $("#adOn").parent().attr("class","btn btn-primary active");
            }
            $("#type_"+data['type']).attr("class", "active");
            $("#AD"+data['type']).attr("class","tab-pane fade active in");
            $("#"+data['position']).attr("class","tab-pane fade active in");
            $("#"+data['type']+'_'+data['position']).attr("class","active");
            var radioValue = data['type'] + '_' + data['position'] + '#' + data['width'] + '_' +data['height'];
            $("#customRadio").val(radioValue);
            $("input[type='radio'][value='"+radioValue+"']").attr("checked","checked");
            $("input[type='radio'][value='"+radioValue+"']").parent().attr("class","btn btn-default active");
            $("#customRadio").parent().attr('class','row');
    
            $("#preview").attr('src', "<?php echo base_url();?>images/ads/"+data['type']+"/"+data['position']+"/"+data['width']+"_"+data['height']+".png");

            if(data['type'] == 'fixed') {
                $("#couplet").attr("class","tab-pane fade in active");
                $("#float_couplet").attr("class","active");
            }else if(data['type'] == 'float') {
                $("#banner").attr("class","tab-pane fade in active");
                $("#fixed_banner").attr("class","active");
            }

            $("#keywords_blacklist").val(data['keywords_blacklist']); 
            $("#url_blacklist").val(data['url_blacklist']); 
            $("#adDialog").modal(); 
        }
    }); 
}

function toggleTable(pid) {
    $("#pid_slot_"+pid).toggle(300);
    if($("#expand_btn_"+pid).html() == "展开") {
        $("#expand_btn_"+pid).html("收缩");
    }else{
        $("#expand_btn_"+pid).html("展开");
    };
}

function showCode(slotId, pid, type, position, width, height) {
    $('#code_pid').html(pid);
    $('#code_slotid').html(slotId);
    $('#code_type').html(type);
    $('#code_pos').html(position);
    $('#code_width').html(width);
    $('#code_height').html(height);

    $('#jscode_pid').html(pid);
    $('#jscode_slotid').html(slotId);
    $('#jscode_type').html(type);
    $('#jscode_pos').html(position);
    $('#jscode_width').html(width);
    $('#jscode_height').html(height);
    $("#codeModal").modal();
}

function customClick() {
    var width = $("#cwidth").val();
    var height = $("#cheight").val();
    $("#customRadio").val("fixed_custom#"+height+"_"+width);
    $("#customRadio").attr("checked", "checked");
    $("#custombtn").attr("disabled", "disabled");
}

</script>
