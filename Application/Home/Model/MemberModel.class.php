<?php
    namespace Home\Model;
    use Think\Model;
    header("content-type:text/html;charset=utf-8");
class MemberModel extends SystemModel{
    public function __construct(){
        parent::__construct();
    }
    //注册验证
    public function CheckReg(){
        if(IS_POST){
            $data = I('post.info');
            if (check_verify($_POST['info']['hash_code']) == false){
                return '验证码输入错误!';
                exit;
            }

            if($data['subscribe'] == 'on'){
                $data['subscribe'] = 1;
            }
            if($_SESSION['check_code']['email'] != null){
                if(!preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",$data['email'])){
                    return '邮箱格式不合法!';
                    exit;
                }
                if(($data['email_code'] != $_SESSION['check_code']['number']) || ($_SESSION['check_code']['time'] - time() <=1)){
                    return '邮箱验证码验证失败!';
                    exit;
                }
                $reg_data['email'] = $data['email'];
            }else if($_SESSION['check_code']['phone'] != null){
                if(!usedExp($data['phone'],'phoneExp')){
                    return '手机格式不合法!';
                    exit;
                }
                if(($data['email_code'] != $_SESSION['check_code']['number']) || ($_SESSION['check_code']['time'] - time() <=1)){
                    return '手机验证码验证失败!';
                    exit;
                }
                $reg_data['phone'] = $data['phone'];

            }

            if(!preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",$data['password'])){
                return '您输入的密码不合法!';
                exit;
            }
            if($data['password'] != $data['password2']){
                return '二次密码不一致!';
                exit;
            }

            if($_SESSION['check_code']['email'] != $data['email']){
                return '您输入的邮箱与获取验证码的邮箱不一致!';
                exit;
            }

            if(M('Member')->where("email = '{$data['email']}'")->getField('email') != null){
                return '您输入的邮箱已经存在!';
                exit;
            }

            $reg_data['pwd'] = PassWord($data['password']);
            $reg_data['nickname'] = 'JFW_'.date('Ymdhis').mt_rand(1,9);
            $reg_data['reg_date'] = time();
            $reg_data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
            unset($data);
            if(M('Member')->add($reg_data)){
                return true;
            }else{
                return '注册失败,请重新尝试!';
                exit;
            }
        }
    }

    //登录验证
    public function CheckLogin(){
        if(IS_POST){
            $data = I('post.info');
            if(empty($data['password']) || !preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",$data['password'])){
                return '登录密码格式不正确!';
                exit;
            }

            $login_where['email'] = $data['login_name'];
            $login_where['phone'] = $data['login_name'];
            $login_where['_logic'] = 'OR';

            $old_pass = M('Member')->where($login_where)->getField('pwd');
            $now_pass = PassWord($data['password']);
            if($old_pass == $now_pass){
                if($data['auto_login'] == 'on'){
                    cookie('name',$data['login_name']);
                    cookie('pass',$data['password']);
                    cookie('loginStatus',1);
                }else{
                    cookie('name',null);
                    cookie('pass',null);
                    cookie('loginStatus',null);
                }
                $login_data['login_time'] = time();
                $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
                $ipInfo = json_decode(file_get_contents($url));
                $login_data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
                if(M('Member')->where($login_where)->save($login_data)){
                    $_SESSION['member'] = M('Member')->where($login_where)->find();
                    return true;
                }else{
                    return '登录失败,请重试!';
                }
            }else{
                return '密码错误,请重试!';
            }
        }else{
            return '非法登录!';
        }
    }

    //退出验证
    public function CheckLogout(){
        $logout['last_login_time'] = time();
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
        $ipInfo = json_decode(file_get_contents($url));
        $logout['last_login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);

        if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->save($logout)){
            unset($_SESSION['member']);
            return true;
        }else{
            return '操作失败,请重试!';
        }
    }

    //获取邮箱验证码
    public function email_checkcode(){
        if(!IS_POST){
            return (array('status'=>0,'info'=>'非法提交,已经拦截!'));
            exit;
        }

        if(empty($_POST['email'])){
            return (array('status'=>0,'info'=>'请输入您的邮箱地址!'));
            exit;
        }

        return send_email(I('post.email'));
    }

    public function phone_checkcode(){

        if(!IS_POST){
            return (array('status'=>0,'info'=>'非法提交,已经拦截!'));
            exit;
        }

        if(empty($_POST['phone'])){
            return (array('status'=>0,'info'=>'请输入您的手机号码!'));
            exit;
        }

        return send_sms(I('post.phone'));
    }
}