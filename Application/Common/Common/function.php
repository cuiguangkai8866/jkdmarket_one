<?php
header('content-type:text/html;charset=utf-8');
/**
  +----------------------------------------------------------
 * 原样输出print_r的内容
  +----------------------------------------------------------
 * @param string    $content   待print_r的内容
  +----------------------------------------------------------
 */
function pre($content) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}

/**
 * 验证验证码
 * @param $code
 * @param string $id
 * @return bool
 */
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function set_config($name, $value='', $path=DATA_PATH) {
    static $_cache  = array();
    $filename       = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
        } else {
            // 缓存数据
            $dir            =   dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
            $_cache[$name]  =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value          =   include $filename;
        $_cache[$name]  =   $value;
    } else {
        $value          =   false;
    }
    return $value;
}

/**
  +----------------------------------------------------------
 * 加密密码
  +----------------------------------------------------------
 * @param string    $data   待加密字符串
  +----------------------------------------------------------
 * @return string 返回加密后的字符串
 */
function encrypt($data) {
    return md5(C("AUTH_CODE") . md5($data));
}

/**
  +----------------------------------------------------------
 * 将一个字符串转换成数组，支持中文
  +----------------------------------------------------------
 * @param string    $string   待转换成数组的字符串
  +----------------------------------------------------------
 * @return string   转换后的数组
  +----------------------------------------------------------
 */
function strToArray($string) {
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string, 0, 1, "utf8");
        $string = mb_substr($string, 1, $strlen, "utf8");
        $strlen = mb_strlen($string);
    }
    return $array;
}

/**
  +----------------------------------------------------------
 * 生成随机字符串
  +----------------------------------------------------------
 * @param int       $length  要生成的随机字符串长度
 * @param string    $type    随机码类型：0，数字+大写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function randCode($length = 5, $type = 0) {
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
    $code='';
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } else if ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str[$i] = $string[rand(0, $count)];
        $code .= $str[$i];
    }
    return $code;
}

/**
  +-----------------------------------------------------------------------------------------
 * 删除目录及目录下所有文件或删除指定文件
  +-----------------------------------------------------------------------------------------
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
  +-----------------------------------------------------------------------------------------
 * @return bool 返回删除状态
  +-----------------------------------------------------------------------------------------
 */
function delDirAndFile($path, $delDir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}

/**
  +----------------------------------------------------------
 * 将一个字符串部分字符用*替代隐藏
  +----------------------------------------------------------
 * @param string    $string   待转换的字符串
 * @param int       $bengin   起始位置，从0开始计数，当$type=4时，表示左侧保留长度
 * @param int       $len      需要转换成*的字符个数，当$type=4时，表示右侧保留长度
 * @param int       $type     转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
 * @param string    $glue     分割符
  +----------------------------------------------------------
 * @return string   处理后的字符串
  +----------------------------------------------------------
 */
function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@") {
    if (empty($string))
        return false;
    $array = array();
    if ($type == 0 || $type == 1 || $type == 4) {
        $strlen = $length = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "utf8");
            $string = mb_substr($string, 1, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }
    }
    switch ($type) {
        case 1:
            $array = array_reverse($array);
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", array_reverse($array));
            break;
        case 2:
            $array = explode($glue, $string);
            $array[0] = hideStr($array[0], $bengin, $len, 1);
            $string = implode($glue, $array);
            break;
        case 3:
            $array = explode($glue, $string);
            $array[1] = hideStr($array[1], $bengin, $len, 0);
            $string = implode($glue, $array);
            break;
        case 4:
            $left = $bengin;
            $right = $len;
            $tem = array();
            for ($i = 0; $i < ($length - $right); $i++) {
                if (isset($array[$i]))
                    $tem[] = $i >= $left ? "*" : $array[$i];
            }
            $array = array_chunk(array_reverse($array), $right);
            $array = array_reverse($array[0]);
            for ($i = 0; $i < $right; $i++) {
                $tem[] = $array[$i];
            }
            $string = implode("", $tem);
            break;
        default:
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", $array);
            break;
    }
    return $string;
}

/**
  +----------------------------------------------------------
 * 功能：字符串截取指定长度
 * leo.li hengqin2008@qq.com
  +----------------------------------------------------------
 * @param string    $string      待截取的字符串
 * @param int       $len         截取的长度
 * @param int       $start       从第几个字符开始截取
 * @param boolean   $suffix      是否在截取后的字符串后跟上省略号
  +----------------------------------------------------------
 * @return string               返回截取后的字符串
  +----------------------------------------------------------
 */
function cutStr($str, $len = 100, $start = 0, $suffix = 1) {
    $str = strip_tags(trim(strip_tags($str)));
    $str = str_replace(array("\n", "\t"), "", $str);
    $strlen = mb_strlen($str);
    while ($strlen) {
        $array[] = mb_substr($str, 0, 1, "utf8");
        $str = mb_substr($str, 1, $strlen, "utf8");
        $strlen = mb_strlen($str);
    }
    $end = $len + $start;
    $str = '';
    for ($i = $start; $i < $end; $i++) {
        $str.=$array[$i];
    }
    return count($array) > $len ? ($suffix == 1 ? $str . "&hellip;" : $str) : $str;
}

/**
  +----------------------------------------------------------
 * 功能：检测一个目录是否存在，不存在则创建它
  +----------------------------------------------------------
 * @param string    $path      待检测的目录
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function makeDir($path) {
    return is_dir($path) or (makeDir(dirname($path)) and @mkdir($path, 0777));
}

/**
  +----------------------------------------------------------
 * 功能：检测一个字符串是否是邮件地址格式
  +----------------------------------------------------------
 * @param string $value    待检测字符串
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function is_email($value) {
    return preg_match("/^[0-9a-zA-Z]+(?:[\_\.\-][a-z0-9\-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i", $value);
}

/**
  +----------------------------------------------------------
 * 功能：系统邮件发送函数
  +----------------------------------------------------------
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表namespace Org\Util\PHPMailer;
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function send_mail($to, $name, $subject = '', $body = '', $attachment = null, $config = '') {
    $config = is_array($config) ? $config : C('SYSTEM_EMAIL');
    //import('PHPMailer.phpmailer', VENDOR_PATH);         //从PHPMailer目录导class.phpmailer.php类文件
    $mail = new \Org\Util\PHPMailer\PHPMailer();                           //PHPMailer对象
    $mail->CharSet = 'UTF-8';                         //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                                   // 设定使用SMTP服务
//    $mail->IsHTML(true);
    $mail->SMTPDebug = 0;                             // 关闭SMTP调试功能 1 = errors and messages2 = messages only
    $mail->SMTPAuth = true;                           // 启用 SMTP 验证功能
    if ($config['smtp_port'] == 465)
        $mail->SMTPSecure = 'ssl';                    // 使用安全协议
    $mail->Host = $config['smtp_host'];                // SMTP 服务器
    $mail->Port = $config['smtp_port'];                // SMTP服务器的端口号
    $mail->Username = $config['smtp_user'];           // SMTP服务器用户名
    $mail->Password = $config['smtp_pass'];           // SMTP服务器密码
    $mail->SetFrom($config['from_email'], $config['from_name']);
    $replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['reply_email'];
    $replyName = $config['reply_name'] ? $config['reply_name'] : $config['reply_name'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            if (is_array($file)) {
                is_file($file['path']) && $mail->AddAttachment($file['path'], $file['name']);
            } else {
                is_file($file) && $mail->AddAttachment($file);
            }
        }
    } else {
        is_file($attachment) && $mail->AddAttachment($attachment);
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
  +----------------------------------------------------------
 * 功能：剔除危险的字符信息
  +----------------------------------------------------------
 * @param string $val
  +----------------------------------------------------------
 * @return string 返回处理后的字符串
  +----------------------------------------------------------
 */
function remove_xss($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
        // @ @ search for the hex values
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        // @ @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}

/**
  +----------------------------------------------------------
 * 功能：计算文件大小
  +----------------------------------------------------------
 * @param int $bytes
  +----------------------------------------------------------
 * @return string 转换后的字符串
  +----------------------------------------------------------
 */
function byteFormat($bytes) {
    $sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
}

function checkCharset($string, $charset = "UTF-8") {
    if ($string == '')
        return;
    $check = preg_match('%^(?:
                                [\x09\x0A\x0D\x20-\x7E] # ASCII
                                | [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
                                | \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
                                | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
                                | \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
                                | \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
                                | [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
                                | \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
                                )*$%xs', $string);

    return $charset == "UTF-8" ? ($check == 1 ? $string : iconv('gb2312', 'utf-8', $string)) : ($check == 0 ? $string : iconv('utf-8', 'gb2312', $string));
}

/**
 *  正则匹配常用方法
*/
function usedExp($str = '',$type = ''){
    $match = new \Org\Util\Match();
    return $match->$type($str);
}

/**
 * 发送短信验证码
*/
function send_sms($phone){
    $sms = new \Org\Util\PHPSms\PHPSms();
    if(empty($_SESSION['check_code']['time'])){
        $check_code = mt_rand(100000,999999);
        $_SESSION['check_code']['number'] = $check_code;
        $_SESSION['check_code']['time'] = time() + 300;
        $_SESSION['check_code']['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['check_code']['phone'] = $phone;
        if(!empty($_SESSION['check_code']['time']) && !empty($_SESSION['check_code']['number'])){
            $mail_status = $sms->sendSMS($phone,'您在'.date('Y年m月d日,H时i分s秒').'申请酒富网手机验证码,本次验证码:'.$check_code.' &nbsp;验证码有效期为两分钟。请尽快验证！');
            if($mail_status == 1){

                return (array('status'=>1,'info'=>'验证码已经成功发送到您的手机！'));
                exit;
            }else{
				$_SESSION['check_code']['time'] = null;
                return (array('status'=>0,'info'=>'验证码获取失败!'));
                exit;
            }
        }else{
			$_SESSION['check_code']['time'] = null;
            return (array('status'=>0,'info'=>'验证码发送失败!'));
            exit;
        }
    }

    if(($_SESSION['check_code']['time'] - time()) >=1 && $phone == $_SESSION['check_code']['phone']){
        return (array('status'=>0,'info'=>'您已申请过验证码,请过'.($_SESSION['check_code']['time'] - time()).'秒再试!'));
        exit;
    }else{
        $check_code = mt_rand(100000,999999);
        $mail_status = $sms->sendSMS($phone,'您在'.date('Y年m月d日,H时i分s秒').'申请酒富网手机验证码,本次验证码:'.$check_code.' &nbsp;验证码有效期为两分钟。请尽快验证！');
        if($mail_status == 1){
            $_SESSION['check_code']['number'] = $check_code;
            $_SESSION['check_code']['time'] = time()+300;
            $_SESSION['check_code']['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['check_code']['phone'] = $phone;
            return (array('status'=>1,'info'=>'验证码已经成功发送到您的手机！'));
            exit;
        }else{
			$_SESSION['check_code']['time'] = null;
            return (array('status'=>0,'info'=>'验证码获取失败!'));
            exit;
        }
    }
}

/**
 * 密码公共处理方法
 * 默认使用md5_sha1_rand 加密方式
 * 默认返回字符串32位密钥
 * 失败返回false
 * $pass 未加密的密码可以多次加密
 * $type 密码加密的类型
 * $number 密码返回的密钥位数
 */
function PassWord($pass,$type,$number){
    if(!is_string($pass) || empty($pass)){
        return false;
    }else{
        if($type == null){
            $type = 'md5_sha1_rand';
        }
        if($number == null){
            $number = 32;
        }
        switch($type){
            case 'md5':
                return mb_substr(md5($pass),0,$number,'utf-8');
                break;
            case 'sha1':
                return mb_substr(sha1($pass),0,$number,'utf-8');
            case 'md5_rand':
                return mb_substr(md5(md5($pass).'access'),0,$number,'utf-8');
                break;
            case 'sha1_rand':
                return mb_substr(sha1(sha1($pass).'access'),0,$number,'utf-8');
                break;
            case 'md5_sha1':
                return mb_substr(md5(sha1($pass)),0,$number,'utf-8');
                break;
            case 'md5_sha1_rand':
                return mb_substr(md5(sha1($pass).'access'),0,$number,'utf-8');
                break;
            default:
                return false;
                break;
        }
    }
}

/**
 * 发送邮箱验证码
 */
function send_email($email){
    if(empty($_SESSION['check_code']['time'])){
        $check_code = mt_rand(100000,999999);
        $_SESSION['check_code']['number'] = $check_code;
        $_SESSION['check_code']['time'] = time() + 300;
        $_SESSION['check_code']['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['check_code']['email'] = $email;
        if(!empty($_SESSION['check_code']['time']) && !empty($_SESSION['check_code']['number'])){
            $mail_status = send_mail($email,'','酒富网验证邮件','您在'.date('Y-m-d,H:i:s').'申请酒富网邮箱验证码,本次验证码:'.$check_code.' &nbsp;验证码有效期为5分钟。请尽快验证！','');
            if($mail_status == 1 ){

                return (array('status'=>1,'info'=>'验证码已经成功发送到您的邮箱！'));
                exit;
            }else{
                return (array('status'=>0,'info'=>'邮件验证码获取失败!'));
                exit;
            }
        }else{
            return (array('status'=>0,'info'=>'邮件发送失败!'));
            exit;
        }

    }

    if(($_SESSION['check_code']['time'] - time()) >=1 && $email == $_SESSION['check_code']['email']){
        return (array('status'=>0,'info'=>'您已申请过验证码,请过'.($_SESSION['check_code']['time'] - time()).'秒再试!'));
        exit;
    }else{
        $check_code = mt_rand(100000,999999);
        $mail_status = send_mail($email,'','酒富网验证邮件','您在'.date('Y-m-d,H:i:s').'申请酒富网邮箱验证码,本次验证码:'.$check_code.' &nbsp;验证码有效期为5分钟。请尽快验证！','');
        if($mail_status == 1){
            $_SESSION['check_code']['number'] = $check_code;
            $_SESSION['check_code']['time'] = time() + 300;
            $_SESSION['check_code']['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['check_code']['email'] = $email;
            return (array('status'=>1,'info'=>'验证码已经成功发送到您的邮箱！'));
            exit;
        }else{
            return (array('status'=>0,'info'=>'邮件验证码获取失败'));
            exit;
        }
    }
}
/**
 * 图片上传处理
 * 配合Flash
 * */
function upload_img($save_path){
    $result = array();
    $result['success'] = false;
    $successNum = 0;
//定义一个变量用以储存当前头像的序号
    $avatarNumber = 1;
    $i = 0;
    $msg = '';
//上传目录
    $dir = __ROOT__."/Uploads".$save_path;
//遍历所有文件域
    while (list($key, $val) = each($_FILES))
    {
        if ( $_FILES[$key]['error'] > 0)
        {
            $msg .= $_FILES[$key]['error'];
        }
        else
        {
            $fileName = date("YmdHis").'_'.floor(microtime() * 1000).'_'.createRandomCode(8);
            //处理原始图片（默认的 file 域的名称是__source，可在插件配置参数中自定义。参数名：src_field_name）
            //如果在插件中定义可以上传原始图片的话，可在此处理，否则可以忽略。
            if ($key == '__source')
            {
                //当前头像基于原图的初始化参数，用于修改头像时保证界面的视图跟保存头像时一致。帮助提升用户体验度。修改头像时设置默认加载的原图的url为此图片的url+该参数即可。
                $initParams = $_POST["__initParams"];
                $virtualPath = "$dir/php_source_$fileName.jpg";
                $result['sourceUrl'] = '/' . $virtualPath.$initParams;
                move_uploaded_file($_FILES[$key]["tmp_name"], $virtualPath);
                /*
                    可在此将 $result['sourceUrl'] 储存到数据库
                */
                $successNum++;
            }
            //处理头像图片(默认的 file 域的名称：__avatar1,2,3...，可在插件配置参数中自定义，参数名：avatar_field_names)
            else if (strpos($key, '__avatar') === 0)
            {
                $virtualPath = "$dir/php_avatar" . $avatarNumber . "_$fileName.jpg";
                $result['avatarUrls'][$i] = '/' . $virtualPath;
                move_uploaded_file($_FILES[$key]["tmp_name"], $virtualPath);
                /*
                    可在此将 $result['avatarUrls'][$i] 储存到数据库
                */
                $successNum++;
                $i++;
            }
            /*
            else
            {
                如下代码在上传接口upload.php中定义了一个user=xxx的参数：
                var swf = new fullAvatarEditor("swf", {
                    id: "swf",
                    upload_url: "Upload.php?user=xxx"
                });
                在此即可用$_POST["user"]获取xxx。
            }
            */
        }
    }
    $result['msg'] = $msg;
    if ($successNum > 0)
    {
        $result['success'] = true;
    }
//返回图片的保存结果（返回内容为json字符串）
   return ($result);
}
/**************************************************************
 *  生成指定长度的随机码。
 *  @param int $length 随机码的长度。
 *  @access public
 **************************************************************/
function createRandomCode($length)
{
    $randomCode = "";
    $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++)
    {
        $randomCode .= $randomChars { mt_rand(0, 35) };
    }
    return $randomCode;
}

function dbAlipay($orderInfo){
        if(!is_array($orderInfo)){
            return '传入的参数有误!';
            exit;
        }
        require_once(VENDOR_PATH."Alipay/dbAlipay/alipay.config.php");
        require_once(VENDOR_PATH."Alipay/dbAlipay/lib/alipay_submit.class.php");

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/')."/notifyPay.html";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/')."/returnPay.html";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户
        $seller_email = C('WEIXIN.alipay_app');
        //必填

        //商户订单号
        $out_trade_no = $orderInfo['orderId'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = $orderInfo['orderName'];
        //必填

        //付款金额
        $price = $orderInfo['orderMoney'];
        //必填

        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        //物流费用
        $logistics_fee = $orderInfo['orderFee'];
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = $orderInfo['orderFee'] != 0 ? "BUYER_PAY":"SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述

        $body = $orderInfo['orderContent'];
        //商品展示地址
        $show_url = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html

        //收货人姓名
        $receive_name = $orderInfo['orderUsername'];
        //如：张三

        //收货人地址
        $receive_address = $orderInfo['orderAddress'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

        //收货人邮编
        $receive_zip = $orderInfo['orderPostcode'];
        //如：123456

        //收货人电话号码
        $receive_phone = C('SITE_INFO.tel');
        //如：0571-88158090

        //收货人手机号码
        $receive_mobile = $orderInfo['orderPhone'];
        //如：13312341234


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
    "service" => "create_partner_trade_by_buyer",
    "partner" => trim($alipay_config['partner']),
    "payment_type"	=> $payment_type,
    "notify_url"	=> $notify_url,
    "return_url"	=> $return_url,
    "seller_email"	=> $seller_email,
    "out_trade_no"	=> $out_trade_no,
    "subject"	=> $subject,
    "price"	=> $price,
    "quantity"	=> $quantity,
    "logistics_fee"	=> $logistics_fee,
    "logistics_type"	=> $logistics_type,
    "logistics_payment"	=> $logistics_payment,
    "body"	=> $body,
    "show_url"	=> $show_url,
    "receive_name"	=> $receive_name,
    "receive_address"	=> $receive_address,
    "receive_zip"	=> $receive_zip,
    "receive_phone"	=> $receive_phone,
    "receive_mobile"	=> $receive_mobile,
    "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;
}

function alipayReturnPay(){

    require_once(VENDOR_PATH."Alipay/dbAlipay/alipay.config.php");
    require_once(VENDOR_PATH."Alipay/dbAlipay/lib/alipay_notify.class.php");

    $alipayNotify = new AlipayNotify($alipay_config);
    $verify_result = $alipayNotify->verifyReturn();
    if($verify_result) {//验证成功
        if($_GET['is_success'] == 'T'){
            if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
                return true;
            }else{
                return 'nowOrderStatusError';
            }
        }else{
            return 'nowPayActionError';
        }
   }else{
        return "nowPayOutDate";
   }
}

function alipayNotifyPay(){

    require_once(VENDOR_PATH."Alipay/dbAlipay/alipay.config.php");
    require_once(VENDOR_PATH."Alipay/dbAlipay/lib/alipay_notify.class.php");

    //计算得出通知验证结果
    $alipayNotify = new AlipayNotify($alipay_config);
    $verify_result = $alipayNotify->verifyNotify();

    if($verify_result) {
        if($_POST['trade_status'] != null){
            $status = payTradeStatus($_POST['trade_status']);
            echo "success";
        }
        if($status != null){
            $order['alipay_id'] = $_POST['trade_no'];
            $order['payway'] = payWay('dbalipay');
            $order['status'] = $status;
            $order['update_time'] = strtotime($_POST['gmt_payment']);
            M('Product_order')->where("oid = '{$_POST['out_trade_no']}'")->save($order);
        }
    }else{
        return false;
    }
}

function dbReallyAlipay($alipayId,$feeName,$feeKid){
    require_once(VENDOR_PATH."Alipay/dbReallyAlipay/alipay.config.php");
    require_once(VENDOR_PATH."Alipay/dbReallyAlipay/lib/alipay_submit.class.php");

    $trade_no = $alipayId;
    $logistics_name = $feeName;
    $invoice_no = $feeKid;
    $transport_type = 'EXPRESS';

    $parameter = array(
        "service" => "send_goods_confirm_by_platform",
        "partner" => trim($alipay_config['partner']),
        "trade_no"	=> $trade_no,
        "logistics_name"	=> $logistics_name,
        "invoice_no"	=> $invoice_no,
        "transport_type"	=> $transport_type,
        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
    );

//建立请求
    $alipaySubmit = new AlipaySubmit($alipay_config);
    $html_text = $alipaySubmit->buildRequestHttp($parameter);
    $doc = new DOMDocument();
    $doc->loadXML($html_text);

    if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
        return $alipay = $doc->getElementsByTagName( "is_success" )->item(0)->nodeValue;
    }
}

function payWay($obj){
    switch($obj){
        case 'dbalipay':
            return '支付宝担保交易';
        break;
        default:
            return '支付宝平台';
        break;
    }
}

function payTradeStatus($object){
    switch($object){
        case 'WAIT_BUYER_PAY': //等待买家付款
            $status = 0;
            break;
        case 'WAIT_SELLER_SEND_GOODS': //买家已付款等待发货
            $status = 2;
            $proWhere['id'] = array('IN',implode(',',M('Product_order')->where('oid = '."'".$_POST['out_trade_no']."'")->getField('cart_id',true)));
            $proWhere['status'] = 1;
            $proList = M('Product_cart')->where($proWhere)->field('pro_id,num')->select();
            foreach($proList as $k=>$v){
                M('Product')->where('id = '.$v['pro_id'])->setDec('stock',$v['num']);
                M('Product')->where('id = '.$v['pro_id'])->setInc('buy_num',1);
				M('Product')->where('id = '.$v['pro_id'])->setDec('people',1);
            }
            break;
        case 'WAIT_BUYER_CONFIRM_GOODS': //卖家已发货等待确认收货
            $status = 3;
            break;
        case 'TRADE_FINISHED': //交易成功
            $status = 5;
            break;
        case 'TRADE_CLOSED': //交易中途关闭 交易结束
            $status = 7;
            break;
    }
    return $status;
}

/**
 * 快递接口
*/
function getKdInfo($code,$oid){
    $url ='http://api.kuaidi100.com/api?id='.C('WEIXIN.kd_appkey').'&com='.$code.'&nu='.$oid.'&show=0&muti=1&order=desc';
    if (function_exists('curl_init') == 1){
      $curl = curl_init();
      curl_setopt ($curl, CURLOPT_URL, $url);
      curl_setopt ($curl, CURLOPT_HEADER,0);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
      curl_setopt ($curl, CURLOPT_TIMEOUT,5);
      $get_content = curl_exec($curl);
      curl_close ($curl);
    }else{
      include(VENDOR_PATH."kd100/snoopy.php");
      $snoopy = new snoopy();
      $snoopy->referer = 'http://www.google.com/';
      $snoopy->fetch($url);
      $get_content = $snoopy->results;
    }
    return json_decode($get_content);
}

/*
 * QQ
*/
 function startQqLogin(){
		require_once(VENDOR_PATH."QQSDK/qqConnectAPI.php");
		$qc = new QC();
		return $qc->qq_login();
 }

 function getQqOpenId(){
     require_once(VENDOR_PATH."QQSDK/qqConnectAPI.php");
     $qc = new QC();
     $qc->qq_callback();
     return $qc->get_openid();
 }

 function aliLogin(){
	require_once(VENDOR_PATH."Alipay/alipay.config.php");
	require_once(VENDOR_PATH."Alipay/lib/alipay_submit.class.php");

	/**************************请求参数**************************/

			//目标服务地址
			$target_service = "user.auth.quick.login";
			//必填
			//必填，页面跳转同步通知页面路径
			$return_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/')."/aliCallback.html";
			//需http://格式的完整路径，不允许加?id=123这类自定义参数
			//防钓鱼时间戳
			$anti_phishing_key = "";
			//若要使用请调用类文件submit中的query_timestamp函数
			//客户端的IP地址
			$exter_invoke_ip = "";
			//非局域网的外网IP地址，如：221.0.0.1


	/************************************************************/

	//构造要请求的参数数组，无需改动
	$parameter = array(
			"service" => "alipay.auth.authorize",
			"partner" => trim($alipay_config['partner']),
			"target_service"	=> $target_service,
			"return_url"	=> $return_url,
			"anti_phishing_key"	=> $anti_phishing_key,
			"exter_invoke_ip"	=> $exter_invoke_ip,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
	);

	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	echo $html_text;
 }
?>
