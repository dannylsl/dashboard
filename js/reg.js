$(document).ready(function() {
    $("#email").blur(email_check);
    $("#password").blur(password_check);
    $("#repassword").blur(repassword_check);
    $("#regbtn").click(form_submit);
});

function email_check() {
    var email  = $("#email").val();
    if(email == "") {
        $("#ret_email").html(""); 
        $("#ret_email").html("<b style='color:red;'> 不能为空</b>"); 
        $("state_email").val(0);
        $("#email").focus();
        return;
    }else{
        var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;  
        if(pattern.test(email)) {
            $.ajax( {
                url: "isUserExist/",
                async: false,
                data: "email="+email,
                type: "post",
                success: function(data, textStatus) {
                    if(data == "0") {
                        $("#ret_email").html(""); 
                        $("#ret_email").html("<b style='color:green;'> 格式正确</b>"); 
                        $("#state_email").val(1);
                        return;     
                    }else if(data == "1") {
                        $("#ret_email").html(""); 
                        $("#ret_email").html("<b style='color:red;'> 已被占用</b>"); 
                        $("#state_email").val(0);
                        $("#email").focus();
                        return; 
                    }
                }
                    
            });
        }else{
            $("#ret_email").html(""); 
            $("#ret_email").html("<b style='color:red;'> 格式不合法</b>"); 
            $("#state_email").val(0);
            $("#email").focus();
            return;     
        }
    }
}

function password_check() {
    var password = $("#password").val();
    if(password == "") {
        $("#ret_password").html("");    
        $("#ret_password").html("<b style='color:red;'> 不能为空</b>");
        $("#state_password").val(0); 
        $("#password").focus();
    }else if(password.length < 6) {
        $("#ret_password").html("");    
        $("#ret_password").html("<b style='color:red;'> 至少6位</b>");
        $("#state_password").val(0); 
        $("#password").focus();
    }else{
        $("#ret_password").html("");    
        $("#ret_password").html("<b style='color:green;'> 格式正确</b>");
    }
}

function repassword_check() {
    var repassword = $("#repassword").val();
    if(repassword == "") {
        $("#ret_repassword").html("");    
        $("#ret_repassword").html("<b style='color:red;'> 不能为空</b>");
        $("#state_password").val(0); 
        $("#repassword").focus();
    }else if(repassword.length < 6) {
        $("#ret_repassword").html("");    
        $("#ret_repassword").html("<b style='color:red;'> 至少6位</b>");
            $("#state_password").val(0); 
        $("#repassword").focus();
    }else{
        var password = $("#password").val();
        if(password == repassword) {
            $("#ret_repassword").html("");    
            $("#ret_repassword").html("<b style='color:green;'> 格式正确</b>");
            $("#state_password").val(1); 
        }else{
            $("#ret_repassword").html("");    
            $("#ret_repassword").html("<b style='color:red;'> 和密码不相同</b>");
            $("#state_password").val(0); 
            $("#repassword").focus();
        }
    }
}

function form_submit() {
    var stat_email = $("#state_email").val();
    if(stat_email == 0) {
        alert("邮箱不符合要求");
        $("#email").focus();
        return;
    } 
    var stat_password = $("#state_password").val();
    if(stat_password == 0) {
        alert("密码不匹配");
        $("#password").focus();
        return;
    } 
    var captcha = $("#captcha").val();
    if(captcha == "") {
        alert("验证码不能为空"); 
        $("#captcha").focus();
        return;
    }else if(captcha.length != 4) {
        alert("验证码长度不为4"); 
        $("#captcha").focus();
        return;
    }
    this.form.submit();
}


