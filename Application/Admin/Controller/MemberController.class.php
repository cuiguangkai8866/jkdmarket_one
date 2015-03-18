<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends CommonController {

    public function index() {

        $M = M("Member");
        $count = $M->count();
        //import("ORG.Util.Page");       //载入分页类
        $page = new \Think\Page($count, 12);
        $showPage = $page->show();
        $list=$M->order('uid desc')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign("page", $showPage);
        $this->assign("list",$list);
        $this->display();
    }

    public function add(){
        if(IS_POST){
            $data = I('post.info');
            $data['reg_date'] = time();
            $data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['nickname'] = 'JFW_'.date('Ymdhis').mt_rand(1,9);
            if($data['pwd'] == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'登陆密码不能为空!'));
            }else{
                $data['pwd'] = PassWord($data['pwd']);
            }
            if(!usedExp($data['email'],'emailExp')){
                $this->ajaxReturn(array('status'=>0,'info'=>'邮箱格式不正确!'));
            }
            if(M('Member')->add($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功!','url'=>U('Member/index')));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
            }
        }else{
            $this->display();
        }
    }
    public function edit(){
        if(IS_POST){
            $m_member=M('Member');
            $data=$_POST['info'];
            $uid=I('post.uid');
            $sm['email']=$data['email'];
            $sm['uid']=array('neq',$uid);
            if(!is_email($data['email'])){
                echo json_encode(array("status" => 0, "info" => "邮箱格式错误！"));
                exit;
            }
            if($uid){
                $map['uid']=$uid;
                if($m_member->where($map)->save($data)){
                    echo json_encode(array("status" => 1, "info" => "修改会员成功",'url'=>U('Member/index')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "修改会员失败"));
                    exit;
                }
            }
        }else{
            $uid=I('get.uid');
            $m_member=M('Member');
            $map['uid']=$uid;
            $info=$m_member->where($map)->find();
            $this->assign('info',$info);
            $this->display();
        }
    }
    public function del(){
        $uid=I('get.uid');
        if(!$uid){return false;}
        $m_member=M('Member');
        $map['uid']=$uid;
        if($m_member->where($map)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    public function u_group(){
        if (IS_POST) {
            echo json_encode(D("Product")->category('u_group'));
        } else {
            $this->assign("list", D("Product")->category('u_group'));
            $this->display();
        }
    }


}