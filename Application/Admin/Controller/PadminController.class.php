<?php
    namespace Admin\Controller;
    use Think\Controller;
class pAdminController extends CommonController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $M = M("Paipai");
        //过滤
        if($title=I('get.title')){
            $productWhere['title']=array('like',"%{$title}%");
            $productWhere['auction']= array('eq',1);
            $map['pro_id'] = array('IN',implode(',',M('Product')->where($productWhere)->getField('id',true)));
        }
        $count = $M->where($map)->count();
        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $list = $M->where($map)->order('update_time desc')->limit($page->firstRow,$page->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            if($v['status'] == 1){
                $list[$k]['statusHtml'] = '已发布';
            }else{
                $list[$k]['statusHtml'] = '待审核';
            }
        }
        $this->assign("list",$list);
        $this->display();
    }

    public function del(){
        $id = I('get.id');
        $pro_id = M('Paipai')->where('id = '.$id)->getField('pro_id');
        if(M('Paipai')->where('id = '.$id)->delete()){
            M('Product')->where('id = '.$pro_id)->setField(array('auction'=>0,'update_time'=>time()));
            $this->ajaxReturn(array('status'=>1,'info'=>'删除成功!'),'json');
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'删除失败!'),'json');
        }
    }

    public function edit(){
        if(IS_POST){
            $pro = I('post.pro');
            $info = I('post.info');
            $pro_id = M('Paipai')->where('id = '.I('get.id'))->getField('pro_id');
            $pro['update_time'] = time();
            M('Product')->where('id = '.$pro_id)->save($pro);
            $info['update_time'] = time();
            $info['start_time'] = strtotime($info['start_time']);
            $info['end_time'] = strtotime($info['end_time']);
            $info['content']=$_POST['info']['content'];
            $now_price = M('Paipai')->where('id = '.I('get.id'))->getField('now_price');
            if($now_price <=0){
                $info['now_price'] = $info['basic_price'];
            }
            if(M('Paipai')->where('id = '.I('get.id'))->save($info)){
                $this->ajaxReturn(array('status'=>1,'info'=>'更新成功!'),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'更新失败!'),'json');
            }
        }else{
            $infoWhere['id'] = I('get.id');
            $info = M('Paipai')->where($infoWhere)->find();
            $info['title'] = M('Product')->where('id = '.$info['pro_id'])->getField('title');
            $info['tuixiao'] = M('Product')->where('id = '.$info['pro_id'])->getField('tuixiao');
            $this->assign('info',$info);
            $this->display();
        }

    }

    public function waitStart(){
        $M = M("Paipai");
        //过滤
        if($title=I('get.title')){
            $productWhere['title']=array('like',"%{$title}%");
            $productWhere['auction']= array('eq',1);
            $map['pro_id'] = array('IN',implode(',',M('Product')->where($productWhere)->getField('id',true)));
        }
        $map['status'] = 1;
        $map['_string'] = 'start_time >= '.time().' AND start_time - '.time().'  <= '.(3600*24*C('LISTNUM.startTime'));
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $list = $M->where($map)->order('update_time desc')->limit($page->firstRow,$page->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            if($v['status'] == 1){
                $list[$k]['statusHtml'] = '即将开始';
            }else{
                $list[$k]['statusHtml'] = '尚未开始';
            }
        }
        $this->assign("list",$list);
        $this->display('index');
    }

    public function now(){
        $M = M("Paipai");
        //过滤
        if($title=I('get.title')){
            $productWhere['title']=array('like',"%{$title}%");
            $productWhere['auction']= array('eq',1);
            $map['pro_id'] = array('IN',implode(',',M('Product')->where($productWhere)->getField('id',true)));
        }
        $map['status'] = 1;
        $map['_string'] = 'start_time <= '.time().' AND end_time >= '.time();
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $list = $M->where($map)->order('update_time desc')->limit($page->firstRow,$page->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            if($v['status'] == 1){
                $list[$k]['statusHtml'] = '正在进行';
            }else{
                $list[$k]['statusHtml'] = '尚未上架';
            }
        }
        $this->assign("list",$list);
        $this->display('index');
    }

    public function endList(){
        $M = M("Paipai");
        //过滤
        if($title=I('get.title')){
            $productWhere['title']=array('like',"%{$title}%");
            $productWhere['auction']= array('eq',1);
            $map['pro_id'] = array('IN',implode(',',M('Product')->where($productWhere)->getField('id',true)));
        }
        $map['status'] = 1;
        $map['end_time'] = array('elt',time());
        $count = $M->where($map)->count();
        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $list = $M->where($map)->order('update_time desc')->limit($page->firstRow,$page->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            $list[$k]['nickname'] = M('Paipai_offer')->where('pai_id = '.$v['id'])->order('price desc')->limit(1)->getField('nickname');
            if($v['status'] == 1){
                $list[$k]['statusHtml'] = '已经结束';
            }else{
                $list[$k]['statusHtml'] = '尚未上架';
            }
        }
        $this->assign("list",$list);
        $this->display('index');
    }
}