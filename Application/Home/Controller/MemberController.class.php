<?php
    namespace Home\Controller;
    use Think\Controller;

class MemberController extends SystemController{

    private $qqCallback;
    private $wbCallback;
    
    public function __construct(){
        parent::__construct();
        $this->qqCallback = rtrim($_SERVER['SERVER_NAME'],'/').U('/qqCallback');
        $this->wbCallback = rtrim($_SERVER['SERVER_NAME'],'/').U('/wbCallback');
    }
    //登录验证
    public function login(){
        if(IS_AJAX){
            $status = D('Member')->CheckLogin();
            if($status == true && is_bool($status)){
				if($_SESSION['login_url'] == null){
					$url = __ROOT__.'/Member';
				}else{
					$url = $_SESSION['login_url'];
				}
                $this->ajaxReturn(array('status'=>1,'info'=>'登陆成功!','url'=>$url));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>$status));
                exit();
            }
        }else{
            $this->display();
        }
    }

    //注册验证
    public function register(){
        if(IS_AJAX){
            if(empty($_POST['info'])){
                if(I('post.email') == null){
                    if(empty($_POST['phone'])){
                        $this->ajaxReturn(array('status'=>0,'info'=>'请输入您的手机号码!'));
                        exit;
                    }

                    if(M('Member')->where("phone = '{$_POST['phone']}'")->getField('phone') != null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'该手机号已经注册过,请登录!'));
                        exit;
                    }
                    $status = D('Member')->phone_checkcode();
                    $this->ajaxReturn($status);
                }else{
                    if(empty($_POST['email'])){
                        $this->ajaxReturn(array('status'=>0,'info'=>'请输入您的邮箱地址!'));
                        exit;
                    }

                    if(M('Member')->where("email = '{$_POST['email']}'")->find() != null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'该邮箱已经注册过,请登录!'));
                        exit;
                    }
                    $status = D('Member')->email_checkcode();
                    if($status == false){
                        $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                    }else{
                        $this->ajaxReturn($status);
                    }
                }
                exit;
            }else{
                if(IS_POST){
                    $status = D('Member')->CheckReg();
                    if($status && !is_string($status)){
                        unset($_SESSION['check_code']);
                        $this->ajaxReturn(array('status'=>1,'info'=>'注册成功!','url'=>U('/Login')));
                        exit();
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>$status));
                        exit();
                    }
                }
            }
        }else{
            $this->display();
        }
    }
    //退出验证
    public function logout(){
        $status = D('Member')->CheckLogout();
        if(IS_AJAX){
            if($status == true && is_bool($status)){
                $this->ajaxReturn(1);
                exit();
            }
        }
    }
    //忘记密码邮箱与手机验证
    public function getCheckLose_pass(){
        if(IS_POST){
            if(IS_AJAX){
                if(I('post.email_phone') != null){
                    if(usedExp(I('post.email_phone'),'emailExp')){
                        $data['email'] = $_POST['email_phone'];
                    }elseif(usedExp(I('post.email_phone'),'phoneExp')){
                        $data['phone'] = $_POST['email_phone'];
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'您输入的邮箱或者手机号是错误的!'));
                        exit();
                    }

                    $check_where['email'] = $data['email'];
                    $check_where['phone'] = $data['phone'];
                    $check_where['_logic'] = 'OR';


                    if(M('Member')->where($check_where)->find() == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'您输入的邮箱或者手机号是不存在的！'));
                        exit();
                    }

                    if($_SESSION['check_code']['number'] != I('post.hash_code') || $_SESSION['check_code']['time'] - time() < 1){
                        $this->ajaxReturn(array('status'=>0,'info'=>'您输入的验证码是无效的!'));
                        exit;
                    }
                    $_SESSION['re_pass'] = 1;
                    if($_SESSION['re_pass'] == 1){
                        unset($_SESSION['check_code']['time']);
                        $_SESSION['check_code']['phone'] = $data['phone'];
                        $_SESSION['check_code']['email'] = $data['email'];
                        $this->ajaxReturn(array('status'=>1,'info'=>'验证码匹配成功!','url'=>U('/Set_pass')));
                    }
                }else{
                    if(I('post.email') == null){
                        if(M('Member')->where("phone = '{$_POST['phone']}'")->find() == null){
                            $this->ajaxReturn(array('status'=>0,'info'=>'您输入的手机号不存在!'));
                            exit;
                        }
                        $status = D('Member')->phone_checkcode();
                        $this->ajaxReturn($status);
                    }else{
                        if(M('Member')->where("email = '{$_POST['email']}'")->find() == null){
                            $this->ajaxReturn(array('status'=>0,'info'=>'您输入的邮箱不存在!'));
                            exit;
                        }
                        $status = D('Member')->email_checkcode();
                        $this->ajaxReturn($status);
                    }
                }
            }
        }else{
            $this->display();
        }
    }

    //执行重设密码
    public function set_pass(){
        if($_SESSION['re_pass'] != 1){
            echo "
            <script>location.href='javascript:history.back()'</script>
            ";
            exit;
        }else{
            if(IS_AJAX){
                $new_pass = I('post.password');
                $re_pass = I('post.password2');
                $check_code = I('post.hash_code');

                if (check_verify($check_code) == false){
                    $this->ajaxReturn(array('status'=>0,'info'=>'验证码输入错误!'));
                    exit();
                }

                if(!preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",$new_pass) || $new_pass == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'您输入的密码不合法!'));
                    exit;
                }

                if($new_pass != $re_pass){
                    $this->ajaxReturn(array('status'=>0,'info'=>'两次输入的密码不一致!'));
                    exit;
                }
                


                $set_where['email'] = $_SESSION['check_code']['email'];
                $set_where['phone'] = $_SESSION['check_code']['phone'];
                $set_where['_logic'] = 'OR';

                if(PassWord($new_pass) == M('Member')->where($set_where)->getField('pwd')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'当前输入的密码与旧密码一致!'));
                    exit();
                }

                if(M('Member')->where($set_where)->setField(array('pwd'=>PassWord($new_pass),'set_pass_time'=>time()))){
                    unset($_SESSION['check_code']);
                    unset($_SESSION['re_pass']);
                    $this->ajaxReturn(array('status'=>1,'info'=>'密码重置成功!','url'=>U('/Login')));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'密码重置失败,请重试!'.M('Member')->_sql()));
                    exit();
                }
            }else{
                $this->display();
            }
        }
    }

	function qqlogin(){
        $scope = 'get_user_info,get_repost_list,add_idol,add_t,del_t,add_pic_t,del_idol';
        $sns = new \Common\Api\QQConnect;
        $sns->login(C('WEIXIN.qq_appid'), $this->qqCallback, $scope);
	}
	function qqCallback(){
        $qq = new \Common\Api\QQConnect;
        $back = $qq->callback(C('WEIXIN.qq_appid'),C('WEIXIN.qq_appkey'),$this->qqCallback);
        if(!empty($back['openid'])){
            $info  = M('Member')->where("qq_login_openid = '".$back['openid']."'")->find();
            if($info['qq_login_openid'] == null){
                $_SESSION['loginInfo']['openType'] = 'qq';
                $_SESSION['loginInfo']['openId'] = $back['openid'];
                header('Location:'.U('/bindUser'));
            }else{
                $data['login_time'] = time();
                $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
                $ipInfo = json_decode(file_get_contents($url));
                $data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
                if(M('Member')->where('uid = '.$info['uid'])->save($data)){
                    $_SESSION['member'] = M('Member')->where('uid = '.$info['uid'])->find();
                    if(empty($_SESSION['member'])){
                        $this->error('获取用户信息失败!',U('/Login'),2);
                        exit;
                    }else{
                        if($_SESSION['login_url'] == null){
                            $callBackUrl = U('/Member');
                        }else{
                            $callBackUrl = $_SESSION['login_url'];
                        }
                        header('Location:'.$callBackUrl);
                        exit;
                    }
                }else{
                    $this->error('更新用户信息失败!',U('/Login'),2);
                    exit;
                }
            }
        }else{
            $this->error('对不起,登陆失败!请重试',U('/Login'),2);
        }
	}

	function aliFastLogin(){
		aliLogin();
	}
	function aliCallback(){
		if(I('get.is_success') == 'T'){
			$data['login_time'] = time();
			$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
            $ipInfo = json_decode(file_get_contents($url));
            $data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
			$info = M('Member')->where("ali_login_uid ='".I('get.user_id')."'")->find();
	      if(empty($info)){
                if(I('get.is_success') == 'T'){
                $_SESSION['loginInfo']['openType'] = 'alilogin';
                $_SESSION['loginInfo']['openId'] = I('get.user_id');
                header('Location:'.U('/bindUser'));
                exit();
                }else{
                    header('Location:'.U('/Login'));
                    exit();
                }
          }else{
			if(M('Member')->where("ali_login_uid = '".I('get.user_id')."'")->save($data)){
				$infos = M('Member')->where("ali_login_uid ='".I('get.user_id')."'")->find();
				$_SESSION['member'] = $infos;
				if(!empty($_SESSION['member'])){
                    if($_SESSION['login_url'] == null){
                        $callBackUrl = U('/Member');
                    }else{
                        $callBackUrl = $_SESSION['login_url'];
                    }
                    header('Location:'.$callBackUrl);
					exit;
				}else{
					$this->error('信息获取失败!',U('/Login'),2);
					exit;
				}
			}else{
				$this->error('数据更新失败!',U('/Login'),2);
			}
          }
		}else{
			$this->error('支付宝快捷登陆失败!',U('/Login'),2);
            exit;
		}
	}

    public function wblogin(){
        C('WEIXIN.wb_appid');
        C('WEIXIN.wb_appkey');
        $sns = new \Common\Api\SaeTOAuthV2(C('WEIXIN.wb_appid'),C('WEIXIN.wb_appkey'));
        $url = $sns->getAuthorizeURL($this->wbCallback);
        header('Location:'.$url);
    }

    public function wbCallback(){
        //dump($_GET);
    }

    public function bindUser(){
        if(empty($_SESSION['loginInfo'])){
            header('Location:'.U('/Login'));
            exit();
        }else{
        	if(IS_AJAX){
				$info = I('post.info');
	            if(!preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",$info['pass'])){
	                $this->ajaxReturn(array('status'=>0,'info'=>'您输入的密码不合法!'));
	                exit;
	            }
                if(usedExp($info['email'],'emailExp')){
                    $data['email'] = $info['email'];
                }elseif(usedExp($info['email'],'phoneExp')){
                    $data['phone'] = $info['email'];
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'手机号码或者邮箱填写不正确!'));
                    exit();
                }
                
                switch ($_SESSION['loginInfo']['openType']) {
                    case 'qq':
                        $data['qq_login_openid'] = $_SESSION['loginInfo']['openId'];
                        break;
                    case 'alilogin':
                        $data['ali_login_uid'] = $_SESSION['loginInfo']['openId'];
                        break;
                }
                switch ($info['type']) {
                    case 'register':
                        if($info['pass'] != $info['repass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'两次输入的密码不一致!'));
                            exit();
                        }
                        $data['nickname'] = 'JFW_'.date('YmdHis').rand(1,9);
                        $data['reg_date'] = time();
                        $data['pwd'] = PassWord($info['pass']);
                        $data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
                        $data['login_time'] = time();
                        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
                        $ipInfo = json_decode(file_get_contents($url));
                        $data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
                        $id = M('Member')->add($data);
                        if($id >= 1){
                            $_SESSION['member'] = M('Member')->where('uid = '.$id)->find();
                            if(!empty($_SESSION['member'])){
                                if($_SESSION['login_url'] == null){
                                    $callBackUrl = U('/Member');
                                }else{
                                    $callBackUrl = $_SESSION['login_url'];
                                }
                                if($callBackUrl!=null){
                                    unset($_SESSION['loginInfo']);
                                    unset($_SESSION['check_code']);
                                    $this->ajaxReturn(array('status'=>1,'info'=>'第三方账号注册成功','url'=>U('/Login')));
                                    exit();
                                }
                                exit();
                            }else{
                                $this->ajaxReturn(array('status'=>0,'info'=>'自动登录失败,即将手动登录!','url'=>U('/Login')));
                                exit();
                            }
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'注册失败,请重试!'));
                            exit();
                        }
                        break;
                    case 'login':
                        if (check_verify($info['code']) == false){
                            $this->ajaxReturn(array('status'=>0,'info'=>'您的验证码输入不正确!'));
                            exit();
                        }
                        if($data['email'] != null){
                            $loginWhere['email'] = array('eq',$data['email']);
                        }else if($data['phone'] != null){
                            $loginWhere['phone'] = array('eq',$data['phone']);
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'对不起,您输入的登录账号验证不通过!'));
                            exit();
                        }
                        $loginWhere['pwd'] = array('eq',PassWord($info['pass']));
                        if(PassWord($info['pass']) == M('Member')->where($loginWhere)->getField('pwd')){
                            $data['login_time'] = time();
                            $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
                            $ipInfo = json_decode(file_get_contents($url));
                            $data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
                            if(M('Member')->where($loginWhere)->save($data)){
                                $_SESSION['member'] = M('Member')->where($loginWhere)->find();
                                if(empty($_SESSION['member'])){
                                    $this->ajaxReturn(array('status'=>0,'info'=>'绑定成功,但自动登录失败!请手动登录','url'=>U('/Login')));
                                    exit();
                                }else{
                                    $this->ajaxReturn(array('status'=>1,'info'=>'绑定成功,已自动登录!','url'=>U('/Member')));
                                    exit();
                                }
                            }else{
                                $this->ajaxReturn(array('status'=>0,'info'=>'第三方账号绑定失败!'));
                                exit();
                            }
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'您输入的密码或者账号错误！'.M('Member')->_sql()));
                            exit();
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status'=>0,'info'=>'很抱歉,我们不能执行您的指令!'));
                        break;
                }
        	}else{
                $this->assign('title','第三方账号绑定');
           		$this->display();
        	}
        }
    }
}