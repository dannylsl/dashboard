<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">设置</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    用户设置
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php  echo form_open("dashboard/settings_save");?>
                        <div class="table-reponsive">
                        <table class="table table-striped">
                            <tr>
                                <td><label>账户名</label></td>
                                <td><input class="form-control" name="accname" id="accname" placeholder="账户名" value="<?php echo $settings['accname'];?>"></td>
                            </tr>
                            <tr>
                                <td><label>公司名称/用户名称</label></td>
                                <td><input class="form-control" name="company" id="company" value="<?php echo $settings['company'];?>"></td>
                            </tr>
                            <tr>
                                <td><label>网址/个人网站</label></td>
                                <td><input class="form-control" name="url" id="url" value="<?php echo $settings['url']?>"></td>
                            </tr>
                            <tr>
                                <td><label>媒体流量</label></td>
                                <td><input class="form-control" name="flow" id="flow" value="<?php echo $settings['flow'];?>"></td>
                            </tr>
                            <tr>
                                <td><label>管理员列表</label></td>
                                <td><textarea class="form-control" name="adminlist" id="adminlist" style="height:100px;"><?php echo $settings['adminlist']?></textarea></td>
                            </tr>
                        </table>
                        </div>
                        <div align="right">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- col-lg-6 -->

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">修改密码</div>
                <div class="panel-body">
                <div style="margin-bottom: 10px;">账号状态: <?php echo $userinfo['status']?"<span class='btn btn-success'>已激活</span>":"<span class='btn btn-danger'>未激活</span><button class='btn btn-success' style='margin-left:10px;' onclick='reSendActiveMail({$acc_id})' id='email_btn'>重新发送激活邮件</button>";?></div>
                    <div id="pwd_msg" style="display:none;"></div>
                    <?php  echo form_open("dashboard/password_update");?>
                        <div class="table-reponsive">
                            <table class="table table-striped">
                                <tr>
                                    <td><label>原始密码</label></td>
                                    <td><input class="form-control" type="password" name="src_pwd"></td>
                                </tr>
                                <tr>
                                    <td><label>新密码</label></td>
                                    <td><input class="form-control" type="password" name="new_pwd"></td>
                                </tr>
                                <tr>
                                    <td><label>确认密码</label></td>
                                    <td><input class="form-control" type="password" name="re_pwd"></td>
                                </tr>
                            </table>
                        </div> <!-- table-reponsive -->
                        <div align="right">
                            <button type="button" class="btn btn-primary" onclick="updatePwd()">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function msg(id, content,type) { 
    var div = $("#"+id);
    div.html(content);
    div.attr("class", "alert alert-"+type); 
    div.fadeIn(500,function(){div.fadeOut(2000)});
}

function updatePwd() {
    var src = $("input[name='src_pwd']").val();
    var newpwd = $("input[name='new_pwd']").val();
    var repwd = $("input[name='re_pwd']").val();
    if(src == "") {
        msg('pwd_msg','原始密码不能为空','danger');
        $("input[name ='src_pwd']").focus();
        return;
    }
    if(newpwd == "") {
        msg('pwd_msg','新密码不能为空','danger');
        $("input[name='new_pwd']").focus();
        return;
    }else{
        if(newpwd.length < 6) {
            msg('pwd_msg','新密码长度至少6位','danger');
            $("input[name='new_pwd']").focus();
            return;
        } 
    }
    if(repwd != newpwd) {
        msg('pwd_msg','两次新密码不匹配','danger');
        $("input[name='new_pwd']").focus();
        return;
    }
        
    $.ajax({
        url:"<?php echo base_url();?>index.php/dashboard/update_pwd",
        data:"pwd="+src+"&newpwd="+newpwd+"&repwd="+repwd,
        type:"post",
        success:function(data) {
            if(data == "-2") {
                msg('pwd_msg','两次新密码不匹配','danger');
            }else if(data == "-1") {
                msg('pwd_msg','原始密码错误','danger');
            }else if(data == "0") {
                msg('pwd_msg','没有发生更改','warning');
            }else if(data == "1") {
                msg('pwd_msg','密码更改成功','success');
            }else {
                msg('pwd_msg','未知错误','dannger');
            }
        }   
    });
}

function reSendActiveMail(acc_id) {
    $.ajax({
        url:"<?php echo base_url();?>index.php/dashboard/active_email/"+acc_id,
        async: false
    });
    $('#email_btn').html('邮件已发送，请查收');
    $('#email_btn').attr('disabled', 'disabeld');
}
</script>
