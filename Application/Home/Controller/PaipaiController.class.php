<?php
    namespace Home\Controller;
    use Think\Controller;
class PaipaiController extends SystemController{
    public function paipai(){
        $M = M("Paipai");
        //过滤
        $map['status'] = 1;

        $list = $M->where($map)->order('end_time desc')->limit(C('LISTNUM.paipaiList'))->select();
        foreach($list as $k=>$v){
            $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            $list[$k]['price'] = M('Product')->where('id = '.$v['pro_id'])->getField('price');
            $img_id = M('Product')->where('id = '.$v['pro_id'])->getField('image_id');
            $img = explode(',',$img_id);
            $img_info = M('Images')->where('id = '.$img[0])->getField('savepath');
            $list[$k]['savepath'] = $img_info == null ? '/Public/Home/images/no_goods.jpg':$img_info;
        }
        $this->assign('proList',$this->s_images(M('Product')->where('status = 1 AND auction = 0 AND groupon = 0 AND sale = 0')->limit(C('LISTNUM.paipaiList'))->order('rand()')->field('title,image_id,price,id')->select()));
        $this->assign("list",$list);
        $this->assign('title',M('Nav')->where("tag = 'paipai'")->getField('nav_name'));
        $this->display();
    }

    public function patDetail(){
        if(IS_POST){
            $price = I('post.price');
            if($price == null){
                $this->ajaxReturn(array('status'=>'error','info'=>'数据非法!'));
                exit;
            }
            if(empty($_SESSION['member'])){
                $this->ajaxReturn(array('status'=>'isNoLogin','info'=>'尚未登录,是否跳转至登陆页?'));
                exit;
            }

            $infoWhere['start_time'] = array('elt',time());
            $infoWhere['end_time'] = array('egt',time());
            $infoWhere['status'] = 1;
            $infoWhere['id'] = I('get.pat');
            $info = M('Paipai')->where($infoWhere)->find();
            $data['oid'] = 'JFW'.date('YmdHis',time()).mt_rand(10,99);
            $data['uid'] = $_SESSION['member']['uid'];
            $data['pro_id'] = $info['pro_id'];
            $data['order_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['order_status'] = 1;
            $data['published'] = $data['update_time'] = time();
            if($id = M('Product_order')->add($data)){

            }
        }else{
            $id = I('get.pat');
            $info = M('Paipai')->where('id = '.$id)->find();
            $proInfo = $this->s_images(M('Product')->where('id = '.$info['pro_id'])->field('title,tuixiao,image_id')->find(),true,true);
            foreach($proInfo as $k=>$v){
                $info[$k] = $v;
            }
            $this->tag2 = 'paipai';
            $info['now_price'] = $info['now_price'] == 0 ? $info['basic_price'] : $info['now_price'];
            $info['price_count'] = M('Paipai_offer')->where('pai_id = '.$id)->count();
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function offerList(){
        $id = I('get.pat');
        $User  = M('Paipai_offer');
        $count = $User->where('pai_id = '.$id)->count();
        $Page  = new \Think\memberPage($count,5);
        $show  = $Page->show();
        $list  = $User->where('pai_id = '.$id)->order('price desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        if($_SESSION['PAT']['priceId'] == null){
            $_SESSION['PAT']['priceId'] = $list[0]['id'];
        }else{
            if($_SESSION['PAT']['priceId'] != $list[0]['id'] && (I('get.p') == 1 || I('get.p') == null)){
                $_SESSION['PAT']['priceId'] = $list[0]['id'];
            }
        }
        $this->assign('page',$show);
        $this->assign('offer_num',$list);
        $this->display();
    }
}