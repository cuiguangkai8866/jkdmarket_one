<?php
    namespace Wap\Controller;
    use Think\Controller;
    header('content-type:text/html;charset=utf-8');
class CommonController extends BaseController{
    public function __construct(){
        parent::__construct();
        //设置登录之后跳转的页面
        if($_SESSION['member'] == null && ACTION_NAME != 'login' && ACTION_NAME != 'register' && MODULE_NAME != 'Common'){
            $_SESSION['login_url'] = $_SERVER['REQUEST_URI'];
            if(preg_match('/forGetPass/',$_SESSION['login_url'])){
            	unset($_SESSION['login_url']);
            }
        }
        if(($_SESSION['member'] != null && ACTION_NAME == 'login') || ($_SESSION['member'] != null && ACTION_NAME =='register')){
            header('Location:'.U('/wapUser'));
        }

        switch(ACTION_NAME){
            case 'wapDetail':
                $id = $_GET['Gid'];
                $seo = M('Product')->where('id = '.$id)->field('keywords,description')->find();
                break;
            case 'wapShop':
                if($id = $_GET['Mid']){
                    $seo = M('Nav')->where('guide = '.$id)->field('keywords,description')->find();
                }else{
                    $seo = M('Nav')->order('sort')->limit(1)->field('keywords,description')->find();
                }
                break;
            default:
                $seo['keywords'] = C('SITE_INFO.keyword');
                $seo['description'] = C('SITE_INFO.description');
                break;
        }
        $this->assign('seo',$seo);
    }


    /**
     * 图片组合公共方法
     */
    protected function s_images($image,$type = false,$obj = false){
        if(empty($image) || !is_array($image)){
            return false;
            exit;
        }
        if($obj){
            foreach($image as $k=>$v){
                if($k == 'image_id'){
                    $img_where['id'] = array('IN',$v);
                    if($v != null){
                        $img_arr = M('images')->where($img_where)->Field('savepath')->select();
                        if($img_arr == null){
                            $img_arr[0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }
                    }
                }
            }
            if(empty($img_arr)){
                if($type == false){
                    $image['savepath'] = '/Public/Home/images/no_goods.jpg';
                }else{
                    $image['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                }
            }else{
                if($type == false){
                    $image['savepath'] = $img_arr[0]['savepath'];
                }else{
                    $image['savepath'] = $img_arr;
                }
            }
        }else{
            foreach($image as $k=>$v){
                if($image[$k]['image_id'] != $v['image_id']){
                    $this->s_images($v);
                }else{
                    if($v['image_id'] == null){
                        if($type==false){
                            $image[$k]['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }else{
                            $image[$k]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }
                    }else{
                        $img_where['id'] = array('IN',$v['image_id']);
                        $img_arr = M('images')->where($img_where)->Field('savepath')->select();
                        if($img_arr == null){

                            $image[$k]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }else{
                            $image[$k]['savepath'] = $type == true ? $img_arr[0]['savepath']:$img_arr;
                        }
                    }
                }
            }
        }
        return $image;
    }

    protected function s_shopPage($where,$order,$int,$field){
        $sql = M('Product');
        $count = $sql->where($where)->count();
        $Page = new \Think\wapShopPage($count,$int);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%UP_PAGE% %NOW_PAGE% %DOWN_PAGE%');
        $show = $Page->show();
        if($field == null){
            $list = $sql->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $list = $sql->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();

        }
        return array('show'=>$show,'list'=>$list);
    }

    public function login(){
        if($_SESSION['member'] != null){
            header('Location:'.__ROOT__.U('/wapUser'));
            exit;
        }
        if(IS_POST){
            $user = I('post.user');
            $pwd = I('post.pwd');
            if(empty($pwd) || !preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",$pwd)){
                $this->ajaxReturn(array('status'=>0,'info'=>'密码存在特殊字符!'));
                exit;
            }

            $login_where['email'] = $user;
            $login_where['phone'] = $user;
            $login_where['_logic'] = 'OR';

            $old_pass = M('Member')->where($login_where)->getField('pwd');
            $now_pass = PassWord($pwd);
            if($old_pass == $now_pass){
                $login_data['login_time'] = time();
                $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
                $ipInfo = json_decode(file_get_contents($url));
                $login_data['login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);
                if(M('Member')->where($login_where)->save($login_data)){
                    $_SESSION['member'] = M('Member')->where($login_where)->find();
                    $this->ajaxReturn(array('status'=>1,'info'=>'登陆成功,正在跳转...','url'=>($_SESSION['login_url'] == null) ? U('/wapUser'):$_SESSION['login_url']));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'登陆失败,请重试!'));
                    exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'密码错误,请重试!'));
                exit;
            }
        }else{
            $this->assign('headName','会员登陆');
            $this->assign('title','会员登陆');
            $this->display();
        }
    }

    public function logout(){
        $logout['last_login_time'] = time();
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
        $ipInfo = json_decode(file_get_contents($url));
        $logout['last_login_ip'] = (($ipInfo->data->region == '') ?'未知省':$ipInfo->data->region).'-'.(($ipInfo->data->city == '') ?'未知市':$ipInfo->data->city);

        if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->save($logout)){
            unset($_SESSION['member']);
            $this->ajaxReturn(array('status'=>1,'info'=>'您已安全退出!','url'=>U('/login')));
            exit;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'退出失败!'));
            exit;
        }
    }

    public function notifyPay(){
        alipayNotifyPay();
    }

    public function register(){
        if(IS_POST){
            if((I('post.username') == null) || (I('post.username') == '')){
                $this->ajaxReturn(array('status'=>0,'info'=>'输入的登录账号不合法!'));
                exit;
            }
            if((I('post.pass') == null) || (I('post.pass') == '')){
                $this->ajaxReturn(array('status'=>0,'info'=>'输入的密码不合法!'));
                exit;
            }
            if((I('post.rePass') == null) || (I('post.rePass') == '')){
                $this->ajaxReturn(array('status'=>0,'info'=>'重复密码不合法!'));
                exit;
            }

            if((I('post.reCheck') == null) || (I('post.reCheck') != $_SESSION['check_code']['number'])){
            	$this->ajaxReturn(array('status'=>0,'info'=>'输入的验证码不匹配!'));
            	exit;
            }

            if(usedExp(I('post.username'),'phoneExp')){
                if($status = M('Member')->where("phone = '".I('post.username')."'")->getField('uid') == null){
                	if(preg_match('/forGetPass/',basename($_SERVER['PHP_SELF']))){
            			$this->ajaxReturn(array('status'=>0,'info'=>'您输入的账号不存在!'));
                    	exit;
            		}else{
                    	$data['phone'] = I('post.username');
            		}
                }else{
                	if(!preg_match('/forGetPass/',basename($_SERVER['PHP_SELF']))){
	                    $this->ajaxReturn(array('status'=>0,'info'=>'您输入的账号已存在!'));
	                    exit;
                	}
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'输入的登录账号不合法!'));
                exit;
            }
            if(!preg_match("/^[a-zA-Z]+[a-zA-z0-9\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\`]{5,11}$/",I('post.pass'))){
                $this->ajaxReturn(array('status'=>0,'info'=>'输入的密码不合法!'));
                exit;
            }else{
                if(I('post.pass') == I('post.rePass')){
                    $data['pwd'] = PassWord(I('post.pass'));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'两次输入的密码不一致!'));
                    exit;
                }
            }
            if(preg_match('/forGetPass/',basename($_SERVER['PHP_SELF']))){
            	if(M('Member')->where("phone = '".I('post.username')."'")->setField('pwd',PassWord(I('post.pass')))){
            		$this->ajaxReturn(array('status'=>1,'info'=>'密码重置成功!','url'=>U('/login')));
            	}else{
            		$this->ajaxReturn(array('status'=>0,'info'=>'密码重置失败!'));
            		exit;
            	}
            }else{
            	$data['nickname'] = 'JFW_'.date('Ymdhis').mt_rand(1,9);
	            $data['reg_date'] = time();
	            $data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
	            if($id = M('Member')->add($data)){
	                $_SESSION['member'] = M('Member')->where('uid = '.$id)->find();
	                if(!empty($_SESSION['member'])){
	                    $this->ajaxReturn(array('status'=>1,'info'=>'注册成功!','url'=>U('/wapUser')));
	                    exit;
	                }else{
	                    $this->ajaxReturn(array('status'=>0,'info'=>'自动登录失败,请手动登录!'));
	                    exit;
	                }
	            }else{
	                $this->ajaxReturn(array('status'=>0,'info'=>'注册失败!'));
	                exit;
	            }
            }
            
        }else{
			if(preg_match('/forGetPass/',basename($_SERVER['PHP_SELF']))){
				$this->assign('headName','找回密码');
				$this->assign('title','找回密码');
			}else{
				$this->assign('headName','免费注册');
				$this->assign('title','免费注册');
			}
            
            $this->display();
        }
    }

	public function getPhoneCode(){
		if(IS_POST){
			if(!usedExp(I('post.phone'),'phoneExp')){
				$this->ajaxReturn(array('status'=>0,'info'=>'手机号码格式不正确!'));
				exit;
			}
			$this->ajaxReturn(send_sms(I('post.phone')));
		}else{
			$this->error('无权访问!');
		}
	}
}
