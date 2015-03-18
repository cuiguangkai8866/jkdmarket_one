<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//��֤�Ƿ����ֻ�����
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
if(($ua == '' || preg_match($uachar, $ua)) && $_SERVER['SERVER_NAME'] != 'm.jiufu9.com')
{
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $is_ipad = (strpos($agent, 'ipad')) ? true : false;
    if(!$is_ipad){
        header('Location:http://m.jiufu9.com');
        exit;
    }
}
// Ӧ������ļ�

// ���PHP����
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
ob_start();
ini_set('date.timezone', 'Asia/Shanghai');
// ��������ģʽ ���鿪���׶ο��� ����׶�ע�ͻ�����Ϊfalse
define('APP_DEBUG',true);

// ����Ӧ��Ŀ¼
define('APP_PATH','./Application/');
define("WEB_ROOT", dirname(__FILE__) . "/Application/");
define("DatabaseBackDir", WEB_ROOT . "Database/"); //ϵͳ�������ݿ��ļ����Ŀ¼
define('WEB_CACHE_PATH', WEB_ROOT."Runtime/");
if (!file_exists(WEB_ROOT.'Common/Conf/systemConfig.php')) {
    header("Location: Application/install/");
    exit;
}
// ����ThinkPHP����ļ�
require './include/ThinkPHP.php';

// ��^_^ ���治��Ҫ�κδ����� ������˼�