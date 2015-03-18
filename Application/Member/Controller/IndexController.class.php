<?php
    namespace Member\Controller;
    use Think\Controller;
    header('content-type:text/html;charset=utf-8');
class IndexController extends CommonController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SESSION['member']['login_ip'];
        $url2 = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SESSION['member']['last_login_ip'];
        $ipInfo = json_decode(file_get_contents($url));
        $ipInfo2 = json_decode(file_get_contents($url2));
        $this->loginCity = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city).'-IP:'.$ipInfo->data->ip;
        $this->laseLoginCity = (($ipInfo2->data->region == '') ?'未知省':$ipInfo2->data->region).'-'.(($ipInfo2->data->city == '') ?'未知市':$ipInfo2->data->city).'-IP:'.$ipInfo->data->ip;
        $this->assign('title','会员中心');
        $this->display('system');

    }

    public function safe_index(){
        $this->display();
    }
}