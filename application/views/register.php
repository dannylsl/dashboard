<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">用户注册</h3>
                    </div>
                    <div class="panel-body">
                        <?php  echo form_open("c=dashboard&m=newuser");?>
                            <fieldset>

                                <div class="form-group">
                                    <label>邮箱<span id="ret_email"></span><input type="hidden" id="state_email" value='0'></label>
                                    <input class="form-control" placeholder="请输入邮箱" name="email" id="email" type="email" autofocus>
                                </div>

                                <div class="form-group">
                                    <label>密码<span id="ret_password"></span><input type="hidden" id="state_password" value='0'></label>
                                    <input class="form-control" placeholder="请输入密码" name="password" id="password" type="password" value="">
                                </div>

                                <div class="form-group">
                                    <label>确认密码<span id="ret_repassword"></span></label>
                                    <input class="form-control" placeholder="请输入密码" name="repassword" id="repassword" type="password" value="">
                                </div>

                                <div class="form-group">
                                    <div>验证码</div>
                                    <input class="form-control"  name="captcha" id="captcha" style= "width:120px;float:left;margin-right:10px;" placeholder="" value="" >
                                    <?php echo $cap; ?>
                                </div>

                            <!-- 
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                            -->

                                <!-- Change this to a button or input when using this as a form -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="regbtn" class="btn btn-lg btn-success btn-block">注册</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url();?>index.php/dashboard/login" class="btn btn-lg btn-default btn-block">登录</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>

    <script src="<?php echo base_url();?>js/reg.js"></script>

</body>
</html>


