<?php
    namespace Member\Controller;
    use Think\Controller;
    header('content-type:text/html;charset=utf-8');
class AccountController extends CommonController{
    public function __construct(){
        parent::__construct();
    }

    public function safe_index(){
        if(IS_POST){
            if($_POST == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'您提交的数据是空的!'));
                exit;
            }
            switch(I('post.type')){
                case 'pass':
                    if(I('post.pass') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'输入的密码是空的!'));
                        exit;
                    }
                    if(!preg_match('/^[0-9a-zA-Z]{4,16}$/',I('post.pass'))){
                        $this->ajaxReturn(array('status'=>0,'info'=>'提交的密码是不合法的!'));
                        exit;
                    }
                    $status = D('Account')->set_pass(I('post.pass'));
                    if($status == true && is_bool($status)){
                        $_SESSION['member']['pwd'] = PassWord(I('post.pass'));
                        $this->ajaxReturn(array('status'=>1,'info'=>'密码更新成功!'));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'密码修改失败!'));
                    }
                    break;
                //绑定邮箱获取验证码
                case 'get_check_code':
                    if(I('post.email') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'输入的邮箱是空的!'));
                        exit;
                    }
                    if(!usedExp(I('post.email'),'emailExp')){
                        $this->ajaxReturn(array('status'=>0,'info'=>'提交的邮箱是不合法的!'));
                        exit;
                    }
                    if(M('Member')->where("email = '".I('post.email')."'")->getField('email') == null){
                        $status = send_email(I('post.email'));
                        $this->ajaxReturn($status);
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'提交的邮箱已经存在!'));
                        exit;
                    }
                    
                    break;
                //执行验证验证码
                case 'check_code':
                    if(I('post.code') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'提交的验证码是不合法的!'));
                        exit;
                    }
                    if(I('post.code') == $_SESSION['check_code']['number'] && $_SESSION['check_code']['time'] - time() > 1){
                        if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField('email',$_SESSION['check_code']['email'])){
                            $_SESSION['member']['email'] = $_SESSION['check_code']['email'];
                            unset($_SESSION['check_code']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'操作成功!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'验证码是无效的!'));
                            exit;
                        }
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'验证码已过期!'));
                        exit();
                    }
                    break;
                //验证旧邮箱
                case 'check_old_email':
                    if(I('post.code') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'提交的验证码是不合法的!'));
                        exit;
                    }

                    if($_SESSION['check_code']['email'] != M('Member')->where('uid = '.$_SESSION['member']['uid'])->getField('email')){
                        $this->ajaxReturn(array('status'=>0,'info'=>'旧邮箱匹配失败!'));
                        exit;
                    }

                    if(I('post.code') == $_SESSION['check_code']['number'] && $_SESSION['check_code']['time'] - time() > 1){
                        $this->ajaxReturn(array('status'=>1,'info'=>'匹配成功,输入新邮箱!'));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'输入的验证码是无效的!'));
                    }
                break;
                //绑定新手机号码
                case 'get_phone_check_code':
                    if(!usedExp(I('post.phone'),'phoneExp')){
                        $this->ajaxReturn(array('status'=>0,'info'=>'输入的手机号不合法!'));
                        exit;
                    }
                    if(M('Member')->where("phone = '".I('post.phone')."'")->getField('phone') == null){
                        $status = send_sms(I('post.phone'));
                        $this->ajaxReturn($status);
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'输入的手机号已经存在!'));
                        exit();
                    }
                break;
                //验证手机号的验证码
                case 'check_phone':
                    if(I('post.phone') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'数据不能为空!'));
                        exit;
                    }

                    if(!usedExp(I('post.phone'),'phoneExp')){
                        $this->ajaxReturn(array('status'=>0,'info'=>'数据不合法!'));
                        exit;
                    }

                    if($_SESSION['check_code']['number'] == I('post.phone')){
                        if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField('phone',$_SESSION['check_code']['phone'])){
                            $_SESSION['member']['phone'] = $_SESSION['check_code']['phone'];
                            unset($_SESSION['check_code']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'操作成功!'));
                        }
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'绑定失败!'));
                        exit;
                    }
                break;
                case 'set_pay_pass':
                    if(I('post.set_pay_pass') == null){
                        if(!preg_match("/^(\w|\+|\-|\=\,\@\#\!\%\^\&\*){6,20}$/",I('post.pay_pass'))){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码格式不正确!'));
                            exit;
                        }
                        if(PassWord(I('post.pay_pass')) == $_SESSION['member']['pwd']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码不能与登录密码相同!'));
                            exit;
                        }
                        $_SESSION['pay_pass'] = PassWord(I('post.pay_pass'));
                    }else{
                        if(!preg_match("/^(\w|\+|\-|\=\,\@\#\!\%\^\&\*){6,20}$/",I('post.set_pay_pass'))){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码格式不正确!'));
                            exit;
                        }
                        if(PassWord(I('post.set_pay_pass')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'旧密码匹配失败!'));
                            exit;
                        }
                    }


                    if(I('post.set_pay_pass') == null){
                        if($_SESSION['member']['phone'] != null){
                            $status = send_sms($_SESSION['member']['phone']);
                            $this->ajaxReturn($status);
                            exit;
                        }else{
                            $status = send_email($_SESSION['member']['email']);
                            $this->ajaxReturn($status);
                            exit;
                        }
                    }else{
                        $this->ajaxReturn(array('status'=>1,'info'=>'支付密码匹配成功!'));
                    }
                break;
                case 'set_pay_pass_start':
                    if(I('post.code') != $_SESSION['check_code']['number'] || $_SESSION['check_code']['time']-time() <1 ){
                        $this->ajaxReturn(array('status'=>0,'info'=>'验证码是无效的!'));
                        exit;
                    }
                    if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField('pay_pass',$_SESSION['pay_pass'])){
                        unset($_SESSION['pay_pass']);
                        unset($_SESSION['check_code']);
                        $_SESSION['member'] = M('Member')->where('uid = '.$_SESSION['member']['uid'])->find();
                        $this->ajaxReturn(array('status'=>1,'info'=>'支付密码设置成功!'));
                        exit;
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'.M('Member')->_sql()));
                        exit;
                    }

            }
        }
        $this->display();
    }

    //收货地址管理
    public function address(){

        if(IS_AJAX){
            if(!IS_POST){
                $this->ajaxReturn(array('status'=>0,'info'=>'非法提交!'));
                exit;
            }

            $status = D('Account')->CheckAddress();
            if($status == true && is_bool($status)){
                $this->ajaxReturn(array('status'=>1,'info'=>'保存成功!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>$status));
            }
        }

        $this->assign('address_list',M('Member_address')->where('uid = '.$_SESSION['member']['uid'])->select());
        $this->display();
    }

    //更新收货地址
    public function save_address(){
        $this->ajaxReturn(1);
    }

    //收货地址删除操作
    public function del_address(){
        if(IS_GET){
			$id= explode('.',I('get.id'));
            $status = M('Member_address')->where('id = '.$id[0].' AND uid = '.$_SESSION['member']['uid'])->delete();
            if($status >=1){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn('删除失败!'.I('get.id'));
            }
        }else{
            $this->error('未授权访问!');
        }
    }

    public function user_info(){
        if(IS_POST){

            //保存原图
            if(I('post.img_path_old') != null){

                //删除旧原图操作
                $img_old_data = M('Member')->where('uid = '.$_SESSION['member']['uid'])->getField('avatar_old');
                if($img_old_data != null){
                    if(file_exists('.'.$img_old_data)){
                        if(!unlink('.'.$img_old_data)){
                            unlink('.'.str_replace(strchr(I('post.img_path_old'),'?'),'',I('post.img_path_old')));
                            $this->ajaxReturn(array('status'=>0,'info'=>'原图删除失败!'));
                            exit;
                        }
                    }
                }

                //执行保存
                $img_old = str_replace(strchr(I('post.img_path_old'),'?'),'',I('post.img_path_old'));
                $new_status = M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField('avatar_old',$img_old);
                if(!$new_status){
                    unlink('.'.str_replace(strchr(I('post.img_path_old'),'?'),'',I('post.img_path_old')));
                }
            }

            //保存头像
            if(I('post.img_path') != null){
                $data = I('post.img_path');
                $img2 = array('avatar_100'=>$data[0],'avatar_50'=>$data[1],'avatar_32'=>$data[2]);

                //删除原头像操作
                $old_data = M('Member')->where('uid = '.$_SESSION['member']['uid'])->Field('avatar_100,avatar_50,avatar_32')->find();
                if(!empty($old_data['avatar_100'])){
                    foreach($old_data[0] as $k=>$v){
                        if(file_exists('.'.$v)){
                            if(!unlink('.'.$v)){
                                foreach($img2 as $key=>$val){
                                    unlink('.'.$val);
                                }
                                $this->ajaxReturn(array('status'=>0,'info'=>'旧头像替换失败!'));
                                exit;
                            }
                        }
                    }
                }



                //保存新头像
                foreach($img2 as $k=>$v){
                    $status = M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField($k,$v);
                    if($status >=1){
                        $_SESSION['member']['avatar_100'] = M('Member')->where('uid = '.$_SESSION['member']['uid'])->getField('avatar_100');
                        $arr[] = true;
                    }else{
                        $arr[] = false;
                    }
                }

//                //返回状态
                if(in_array(false,$arr)){
                    foreach($img2 as $key=>$val){
                        unlink('.'.$val);
                    }
                    $this->ajaxReturn(array('status'=>0,'info'=>'保存失败!'));
                }else{
                    $this->ajaxReturn(array('status'=>1,'info'=>'保存成功!','url'=>U('/Member/User')));
                }
            }

            //保存基本资料
            if(I('post.user') != null){
                $data = I('post.user');

                if(!usedExp($data['username'],'chineseExp')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'用户名必须是汉字!'));
                    exit;
                }

                $status = M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField($data);

                if($status){
                    $_SESSION['member'] = M('Member')->where('uid = '.$_SESSION['member']['uid'])->find();
                    $this->ajaxReturn(array('status'=>1,'info'=>'更新成功!','url'=>U('/Member/User')));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'更新失败!'));
                }

            }

            //更新详细资料
            if(I('post.info') != null){
                $data = I('post.info');
                $data['jiu'] = implode(',',I('post.jiu'));

                if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField($data)){
                    $_SESSION['member'] = M('Member')->where('uid = '.$_SESSION['member']['uid'])->find();
                    $this->ajaxReturn(array('status'=>1,'info'=>'更新成功!','url'=>U('/Member/User')));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'更新失败!'));

                }
            }

        }else{
            $this->assign('category',M('Category')->where("type='mold' AND pid = 0")->Field('cid,name')->select());
            $this->display();
        }
    }
}