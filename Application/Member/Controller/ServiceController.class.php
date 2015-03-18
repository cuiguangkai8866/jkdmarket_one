<?php
    namespace Member\Controller;
    use Think\Controller;
class ServiceController extends CommonController{
    public function consulting(){
        $this->display();
    }
    public function loadConsulting(){
        if(IS_POST){
            $infoExp = M('Product_ask')->where('id = '.I('post.obj'))->field('uid,uname,mold_name,pro_id')->find();
            if($infoExp['uid'] != $_SESSION['member']['uid']){
                $this->error('对不起,您无权操作!');
                exit;
            }
            $infoExp['content'] = I('post.val');
            $infoExp['published'] = $infoExp['update_time'] = time();
            if(M('Product_ask')->add($infoExp)){
                $this->ajaxReturn(array('status'=>1,'info'=>'您的提问我们已经收到!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
            }
        }else{
            $M = M("Product_ask");
            $where['uid'] = $_SESSION['member']['uid'];
            $count = $M->where($where)->count();
            $page = new \Think\memberPage($count,6);
            $showPage = $page->show();
            $askList=$M->where($where)->order('published desc')->limit("$page->firstRow, $page->listRows")->select();
            foreach($askList as $k=>$v){
                $askList[$k]['product'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            }
            $this->assign('askList',$askList);
            $this->assign('page',$showPage);
            $this->display();
        }
    }
    public function refund(){
        $this->display();
    }
    public function loadRefund(){
        //查询已申请退款的订单
        $where['uid'] = $_SESSION['member']['uid'];
        $where['sq_status'] = array('IN','1,2');
        $where['status'] = array('IN','4,6');
        $refundList = M('Product_order')->where($where)->field('id,oid,update_time,status,old_status')->select();
        foreach($refundList as $k=>$v){
            $refundList[$k]['statusHtml'] = $this->s_statusHtml($v['status']);
            $refundList[$k]['old_statusHtml'] = $this->s_statusHtml($v['old_status']);
        }
        $this->assign('refund',$refundList);
        $this->display();
    }

    public function refundDetail(){
        $infoExp = M('Product_order')->where('id = '.I('get.id'))->find();
        if($infoExp['uid'] == $_SESSION['member']['uid']){
            if(($infoExp['status'] != 4) && ($infoExp['status'] != 6)){
                $this->error('您的订单已经被处理！');
                exit;
            }
            $oid = intval(I('get.id'));
            $mustData = M('Product_order')->where('id = '.$oid)->field('pro_id,update_time,oid,cart_id,aid,status,t_why')->find();
            $infoArr = M('Member_address')->where('id = '.$mustData['aid'])->find();
            $infoWhere['id'] = array('IN',$mustData['cart_id']);
            foreach(M('Product_cart')->where($infoWhere)->field('id,pro_id,num')->select() as $k=>$v){
                foreach($v as $k1=>$v1){
                    foreach(M('Product')->where('id = '.$v['pro_id'])->field('id,title,price,image_id,present')->find() as $k2=>$v2){
                        $infoArr['product'][$k][$k2] = $v2;
                        $infoArr['product'][$k]['num'] = $v['num'];
                        if($k2 == 'image_id'){
                            $imgWhere['id'] = array('IN',$v2);
                            $img = M('Images')->where($imgWhere)->getField('savepath',true);
                            $infoArr['product'][$k]['savepath'] = $img[0] == null ? '/Public/Home/images/no_goods.jpg':$img[0];
                        }
                        if($k2 == 'present'){
                            $infoArr['product'][$k]['present'] = $v2 == null ?'无赠品':$v;
                        }
                    }
                }
            }
            $infoArr['status'] = $mustData['status'];
            $infoArr['oid'] = $mustData['oid'];
            $infoArr['update_time'] = $mustData['update_time'];
            $infoArr['t_why'] = $mustData['t_why'];
            $this->assign('info',$infoArr);
            $this->display();
        }else{
            $this->error('对不起,您无权查看!');
        }
    }

    public function requestMessage(){
        $this->display();
    }

    public function loadRequestMessage(){
        if(IS_POST){
            $info = I('post.info');
            foreach($info as $k=>$v){
                if($v == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'您还没有填写完整!'));
                }
            }
            $info['addtime']= time();
            $info['uid']= $_SESSION['member']['uid'];
            if(!usedExp($info['username'],'chineseExp')){
                $this->ajaxReturn(array('status'=>0,'info'=>'用户名必须是中文!'));
                exit;
            }
            if(!usedExp($info['moblie'],'phoneExp')){
                $this->ajaxReturn(array('status'=>0,'info'=>'手机号码填写不规范!'));
                exit;
            }
            if(!usedExp($info['email'],'emailExp')){
                $this->ajaxReturn(array('status'=>0,'info'=>'邮箱地址不合法!'));
                exit;
            }
            if($_SESSION['Home']['messageTime'] < time()){
                if(M('Message')->add($info)){
                    $_SESSION['Home']['messageTime'] = time()+120;
                    $this->ajaxReturn(array('status'=>1,'info'=>'提交成功,我们会尽快给您回复!','url'=>U('/Member/Message')));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'留言/投诉失败!'));
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'留言/投诉重复提交,请两分钟后再试!'));
            }
        }else{
            $this->display();
        }
    }

    public function message(){
        $this->display();
    }
    public function loadMessage(){
        $M = M("Message");
        $where['uid'] = $_SESSION['member']['uid'];
        $count = $M->where($where)->count();
        $page = new \Think\memberPage($count,6);
        $showPage = $page->show();
        $askList=$M->where($where)->order('addtime desc')->field('content,email,t_content,addtime')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign('askList',$askList);
        $this->assign('page',$showPage);
        $this->display();
    }
}