<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #262628; font-family: '微软雅黑'; color: #333; font-size: 16px; }
.system-message{ padding: 24px 48px; }
.system-message{ line-height: 1.8em; font-size: 36px }
.success,.error{width:100%;height:auto;text-align:center;font:600 30px/40px Arial;color:#B8860B;word-wrap: break-word;overflow:hidden;margin:10px 0;}
#jumpbox {width:600px;height:auto;border:1px solid #999;margin:50px auto}
#jumpbox .jumptitle{width:100%;height:40px;background:#333;border-bottom:1px solid #999;text-align:center;color:#fff;font:bold 18px/40px Arial;letter-spacing:5px;
}
#jumpbox .action_info h1{width:100%;height:220px;border-bottom:1px solid #999;text-align:center;color:#43CD80;font:bold 158px/220px Arial;}
#jumpbox .action_info span{width:100%;height:220px;border-bottom:1px solid #999;text-align:center;color:#8B0000;font:bold 158px/220px Arial;display:block}
</style>
</head>
<body>
<div class="system-message">
<div id="jumpbox">
    <div class="jumptitle">
        本窗口将在<b id="wait"><?php echo($waitSecond); ?></b>秒后<a style="color: #ff3636;text-decoration: none;letter-spacing: 2px;" id="href" href="<?php echo($jumpUrl); ?>">跳转</a>
    </div>
    <div class="action_info">
        <present name="message">
            <h1>⌒_⌒</h1>
            <p class="success"><?php echo($message); ?></p>

            <else/>
            <span>×_×</span>
            <p class="error"><?php echo($error); ?></p>
        </present>
    </div>
</div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
