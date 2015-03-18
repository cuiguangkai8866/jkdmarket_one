<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>登录-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <!-- <link rel="stylesheet" type="text/css" href="/jkdmarket/Public/Min/?f=/jkdmarket/Public/Admin/Css/base.css|/jkdmarket/Public/Js/asyncbox/skins/default.css" />
        <script type="text/javascript" src="/jkdmarket/Public/Min/?f=/jkdmarket/Public/Js/jquery-1.9.0.min.js|/jkdmarket/Public/Js/functions.js|/jkdmarket/Public/Js/jquery.form.js|/jkdmarket/Public/Js/asyncbox/asyncbox.js"></script> -->
        <link rel="stylesheet" href="/jkdmarket/Public/Admin/Css/base.css" />
        <link rel="stylesheet" href="/jkdmarket/Public/Js/asyncbox/skins/default.css" />
        <!-- <link rel="stylesheet" href="/jkdmarket/Public/Js/asyncbox/skins/default.css<?php echo ($addCss); ?>"></script> -->
        <script type="text/javascript" src="/jkdmarket/Public/Js/jquery-1.9.0.min.js"></script>
        <script src="/jkdmarket/Public/Js/jquery-1.9.0.min.js"></script>
        <!-- // <script src="/jkdmarket/Public/Js/jquery.lazyload.js"></script> -->
        <script src="/jkdmarket/Public/Js/functions.js"></script>
        <script src="/jkdmarket/Public/Js/jquery.form.js"></script>
        <script src="/jkdmarket/Public/Js/asyncbox/asyncbox.js<?php echo ($addJs); ?>"></script>
        <!-- // <script src="/jkdmarket/Public/Admin/Js/base.js"></script> -->
    </head>
<body class="loginWeb">
    <div class="loginBox">
        <div class="innerBox">
            <div class="logo" style="text-align: center;"> <img src="/jkdmarket/Public/Admin/Img/logo.png" /></div>
            <form id="form1" action="" method="post">
                <div class="loginInfo">
                    <ul>
                        <li class="row1">登录账号：</li>
                        <li class="row2"><input class="input" name="email" id="email" size="40" type="text" value="" /></li>
                    </ul>
                    <ul>
                        <li class="row1">登录密码：</li>
                        <li class="row2"><input class="input" name="pwd" id="pwd" size="40" type="password" value="" /></li>
                    </ul>
                    <ul>
                        <li class="row1">验证码：</li>
                        <li class="row2"><input class="input" id="verify_code" name="verify_code" type="text" style="width:100px;" /> <img src="<?php echo U('Public/verify_code');?>"  title="看不清？单击此处刷新" onclick="this.src+='?rand='+Math.random();"  style="width:107px;height:35px;cursor: pointer; vertical-align: middle;"/></li>
                    </ul>
                </div>
                <input type="hidden" name="op_type" id="op_type" value="1"/>
            </form>
            <div class="clear"></div>
            <div class="operation"><button class="btn submit">登录</button>   <button class="btn findPwd">忘记密码？</button></div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $(".submit").click(function(){
                $("#op_type").val("1");
                if($("#email").val()==''||$("#pwd").val()==''||$("#verify_code").val()==''){
                    popup.alert("填写完整方可登陆");
                    return false;
                }
                commonAjaxSubmit();
            });
            $(".findPwd").click(function(){
                $("#op_type").val("2");
                if($("#email").val()==''){
                    popup.alert("填写了你的邮箱方可找回密码");
                    return false;
                }
                if($("#verify_code").val()==''){
                    popup.alert("请写验证码方可找回密码");
                    return false;
                }
                commonAjaxSubmit();
            });
        });
    </script>
</body>
</html>