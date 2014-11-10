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
                    <div class="col-md-3">
                    （所有广告位）图表
                    </div>
                    <div class="col-md-9" align="right">
                        <div class="btn btn-primary" style="float:left">所有广告位走势图</div>
                        <div class="col-md-1" style="margin-left:10px;"> 
                            <select style="width:80px;" name="widthunit" class="form-control">
                            <?php
                            foreach($pidlist as $pidinfo) {
                                echo "<option value=\"{$pidinfo['pid_name']}\">{$pidinfo['pid_name']}</option>";
                            }    
                            ?>
                            </select>
                        </div>
                        <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                            <span class="input-group-addon">起始</span>
                            <input type="text" class="form-control" id="startdate" data-date-format="yyyy-mm-dd">
                        </div>
                        <div class="form-group input-group" style="width:150px;float:left;margin: 0px 3px;">
                            <span class="input-group-addon">终止</span>
                            <input type="text" class="form-control" id="enddate" data-date-format="yyyy-mm-dd">
                        </div>
                        <button class="btn btn-default" style="float:left">天查询</button>
                        <button class="btn btn-default" style="float:left">时查询</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                    <div id="morris-bar-chart" style="display:none;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-primary" data-toggle="modal" role="button" data-target="#adDialog" ><i class="fa fa-plus"></i> 添加广告位</button>
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
                                    <th>操作</th>
                                </tr>
                                <tr>
                                    <td>2014-11-03</td>
                                    <td>228514</td>
                                    <td>279</td>
                                    <td>0.122%</td>
                                    <td>&yen;0.00</td>
                                    <td>每日详细</td>
                                </tr>
                                <tr>
                                    <td>2014-11-03</td>
                                    <td>228514</td>
                                    <td>279</td>
                                    <td>0.122%</td>
                                    <td>&yen;0.00</td>
                                    <td>每日详细</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="adDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:80%; height:90%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">广告面板</h4>
              </div>
             <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"><h4>广告名称</h4></div>
                    <div class="col-md-2"><input type="text" class="form-control" value placeholder="请输入广告名称"></div>
                </div>

                <div class="row">
                    <div class="col-md-1"><h4>投放开关</h4></div>
                    <div class="col-md-3">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>开启 
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options" id="adOff" autocomplete="off">关闭
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1"><h4>投放平台</h4></div>
                    <div class="col-md-3">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>PC网页
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>移动网页
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="pc">
                    <div class="col-md-1"><h4>广告形态</h4></div>
                    <div class="col-md-5">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#ADfloat" data-toggle="tab" aria-expanded="true">浮动广告</a></li>
                            <li><a href="#ADfixed" data-toggle="tab">固定广告</a></li>
                            <li><a href="#ADimg" data-toggle="tab">图+</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="ADfloat">
                            <!-- 浮动广告 -->
                                <div class="tab-content"> 
                                    <div class="tab-pane fade active in" id="duilian"> 

                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>120*240
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>120*270
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>120*600
                                                <div style="width:10px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>160*600
                                                <div style="width:11px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade" id="youxiajiao"> 

                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>300*250
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>300*300
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>250*250
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="dilan"> 
 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>95%*20
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>95%*30
                                                <div style="width:40px;height:31px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="celan"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>120*240
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>120*270
                                                <div style="width:17px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>120*600
                                                <div style="width:10px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>160*600
                                                <div style="width:11px;height:32px;background:#00DD77;margin-left:20px;"></div>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#duilian" data-toggle="tab" aria-expanded="fasle">对联</a>
                                    </li>
                                    <li>
                                        <a href="#youxiajiao" data-toggle="tab" aria-expanded="fasle">右下角</a>
                                    </li>
                                    <li>
                                        <a href="#dilan" data-toggle="tab" aria-expanded="fasle">底栏</a>
                                    </li>
                                    <li>
                                        <a href="#celan" data-toggle="tab" aria-expanded="fasle">侧栏</a>
                                    </li>
                                </ul>

                            </div> <!-- 浮动广告 -->
                            <div class="tab-pane fade" id="ADfixed"> <!-- 固定广告 -->
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="hengfu"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>760*90
                                                <div style="width:60px;height:10px;background:#00DD77;margin-bottom:23px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off"  checked>728*90
                                                <div style="width:57px;height:10px;background:#00DD77;margin-bottom:23px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked >640*60
                                                <div style="width:60px;height:15px;background:#00DD77;margin-bottom:18px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked >960*90
                                                <div style="width:60px;height:8px;background:#00DD77;margin-bottom:25px"></div>
                                            </label>
                                        </div>
                                    </div>

     
                                    <div class="tab-pane fade" id="juxing"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>320*250
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>250*250
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>200*200
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>336*280
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>125*125
                                                <div style="width:32px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>360*300
                                                <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                            </label>
                                        </div>
                                    </div>
                               
                                    <div class="tab-pane fade" id="zidingyi"> 
                                           <fieldset style="margin:15px 15px 15px 35px">
                                                <div class="row">
                                                    <div class="col-md-1">宽:</div>
                                                    <div class="col-md-3"><input type="number" name="width" value="300" class="form-control"></div>
                                                    <div class="col-md-3">
                                                        <select style="width:80px;" name="widthunit" class="form-control">
                                                            <option value="px">px</option>
                                                            <option value="%">%</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top:10px;">
                                                    <div class="col-md-1">高:</div>
                                                    <div class="col-md-3"><input type="number" name="width" value="300" class="form-control"></div>
                                                    <div class="col-md-3">
                                                        <select style="width:80px;" name="widthunit" class="form-control">
                                                            <option value="px">px</option>
                                                            <option value="%">%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#hengfu" data-toggle="tab" aria-expanded="fasle">横幅</a>
                                    </li>
                                    <li>
                                        <a href="#juxing" data-toggle="tab" aria-expanded="fasle">矩形</a>
                                    </li>
                                    <li>
                                        <a href="#zidingyi" data-toggle="tab" aria-expanded="fasle">自定义</a>
                                    </li>
                                </ul>

                            </div> <!-- 固定广告 -->
                            <div class="tab-pane fade " id="ADimg"> <!-- 图片广告 -->
                                 <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                    <label class="btn btn-default">
                                        <input type="radio" name="options" id="adOff" autocomplete="off" checked>300*250
                                        <div style="width:40px;height:32px;background:#00DD77;margin-bottom:1px;margin-left:9px"></div>
                                    </label>
                                </div>
                            </div> <!-- 图片广告 -->

                        </div>
                    </div>
                </div> <!-- row 广告形态 -->


                <!-- FOR MOBILE -->
                <div class="row" id="mobile">
                    <div class="col-md-1"><h4>广告形态</h4></div>
                    <div class="col-md-5">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#ADfloat_mobile" data-toggle="tab" aria-expanded="true">浮动广告</a></li>
                            <li><a href="#ADfixed_mobile" data-toggle="tab">固定广告</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="ADfloat_mobile">
                            <!-- 浮动广告 -->
                                <div class="tab-content"> 
                                    <div class="tab-pane fade active in" id="dinglan_mobile"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>20:3
                                                <div style="background: rgb(0, 221, 119); width: 60px; height: 10px; margin-bottom: 23px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>100*70
                                                <div style=" width: 60px; height: 10px; margin-bottom: 23px;">自定义</div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="dilan_mobile"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>20:3
                                                <div style="background: rgb(0, 221, 119); width: 60px; height: 10px; margin-bottom: 23px;"></div>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOff" autocomplete="off" checked>100*70
                                                <div style=" width: 60px; height: 10px; margin-bottom: 23px;">自定义</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#dinglan_mobile" data-toggle="tab" aria-expanded="fasle">顶栏</a>
                                    </li>
                                    <li>
                                        <a href="#dilan_mobile" data-toggle="tab" aria-expanded="fasle">底栏</a>
                                    </li>
                                </ul>

                            </div> <!-- 浮动广告 -->

                            <div class="tab-pane fade" id="ADfixed_mobile"> <!-- 固定广告 -->
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="gudingbili_mobile"> 
                                        <div class="btn-group" data-toggle="buttons" style="margin: 10px;">
                                            <label class="btn btn-default">
                                                <input type="radio" name="options" id="adOn" autocomplete="off" checked>20:3
                                                <div style="width:60px;height:10px;background:#00DD77;margin-bottom:23px"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="zidingyi_mobile"> 
                                       <fieldset style="margin:15px 15px 15px 35px">
                                            <div class="row">
                                                <div class="col-md-1">宽:</div>
                                                <div class="col-md-3"><input type="number" name="width" value="300" class="form-control"></div>
                                                <div class="col-md-3">
                                                    <select style="width:80px;" name="widthunit" class="form-control">
                                                        <option value="px">px</option>
                                                        <option value="%">%</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-md-1">高:</div>
                                                <div class="col-md-3"><input type="number" name="width" value="300" class="form-control"></div>
                                                <div class="col-md-3">
                                                    <select style="width:80px;" name="widthunit" class="form-control">
                                                        <option value="px">px</option>
                                                        <option value="%">%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <ul class="nav nav-pills">
                                        <li class="active">
                                            <a href="#gudingbili_mobile" data-toggle="tab" aria-expanded="fasle">固定比例</a>
                                        </li>
                                        <li>
                                            <a href="#zidingyi_mobile" data-toggle="tab" aria-expanded="fasle">自定义</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> <!-- 固定广告 -->
                        </div>
                    </div>
                </div> <!-- row 广告形态 -->

                <!-- MOBILE END --> 

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-1"><h4>配置效果</h4></div>
                    <div class="col-md-5">
                        <div style="margin-left:10px;margin-top:10px">
                            <strong style="font-size:14px">广告类型:</strong>
                            <div class="row-fluid" style="margin-bottom:10px;margin-top:10px">
                                 <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox1" value="option1"> 文本
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox2" value="option2"> 图像
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox3" value="option3"> 文字链
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1"><h4>关键字黑名单</h4></div>
                    <div class="col-md-4"><textarea class="form-control"></textarea></div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-1"><h4>url黑名单</h4></div>
                    <div class="col-md-4"><textarea class="form-control"></textarea></div>
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>>

    </div> <!-- page-wrapper -->

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url();?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url();?>js/plugins/morris/morris-data.js"></script>

    <!-- Datepicker JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script>
        $("#startdate").datepicker();
        $("#enddate").datepicker();
    </script>
