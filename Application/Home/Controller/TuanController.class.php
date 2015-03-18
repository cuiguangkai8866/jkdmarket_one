<?php
    namespace Home\Controller;
    use Think\Controller;
class TuanController extends SystemController{
    public function __construct(){
        parent::__construct();
    }

    public function tuan(){
        $field = 'id,image_id,title,tuixiao,price,start_time,end_time,buy_num';
        $nowWhere['status'] = 1;
        $nowWhere['groupon'] = 1;
        $nowWhere['sale'] = 0;
        $nowWhere['auction'] = 0;
        $nowWhere['_string'] = 'start_time <= '.time().' AND end_time >= '.time();
        $nowList = $this->s_images(M('Product')->where($nowWhere)->order('end_time asc')->limit(C('LISTNUM.tuanList'))->field($field)->select(),true,false);
        foreach($nowList as $k=>$v){
            $nowList[$k]['nownum'] = M('Product_comment')->where('pro_id = '.$v['id'])->count();
        }
        $this->assign('nowList',$nowList);

        //等待开始的
        $waitWhere['status'] = 1;
        $waitWhere['groupon'] = 1;
        $nowWhere['sale'] = 0;
        $nowWhere['auction'] = 0;
        $waitWhere['_string'] = 'start_time >= '.time().' AND start_time - '.time().'  <= '.(3600*24*C('LISTNUM.startTime'));
        $waitList = $this->s_images(M('Product')->where($waitWhere)->order('start_time asc')->limit(C('LISTNUM.tuanList'))->field($field)->select(),true,false);
        foreach($waitList as $k=>$v){
            $waitList[$k]['nownum'] = M('Product_comment')->where('pro_id = '.$v['id'])->count();
        }
        $this->assign('waitList',$waitList);

        //已经结束的
        $endWhere['groupon'] = 1;
        $endWhere['status'] = 1;
        $nowWhere['sale'] = 0;
        $nowWhere['auction'] = 0;
        $endWhere['end_time'] = array('elt',time());
        $endList = $this->s_images(M('Product')->where($endWhere)->order('end_time asc')->limit(C('LISTNUM.tuanList'))->field($field)->select(),true,false);
        foreach($endList as $k=>$v){
            $endList[$k]['nownum'] = M('Product_comment')->where('pro_id = '.$v['id'])->count();
        }
        $this->assign('title',M('Nav')->where("tag = 'tuan'")->getField('nav_name'));
        $this->assign('endList',$endList);
        $this->display();
    }

    public function tDetail(){
        $Goods_id = ($_GET['tid']);
        if(IS_POST){
            if(I('post.ask') != null){
                //咨询
                $data = I('post.ask');
                if($data['content'] == null){
                    $this->ajaxReturn('您还没有填写任何咨询的内容!');
                    exit;
                }
                $data['pro_id'] = $Goods_id;
                $data['published'] = $data['update_time'] = time();
                $data['uid'] = $_SESSION['member'] == null ? 0 : $_SESSION['member']['uid'];
                if( $_SESSION['member']['nickname'] != null){
                    $data['uname'] = $_SESSION['member']['nickname'];
                }
                if(M('Product_ask')->add($data)){
                    $this->ajaxReturn(1);
                }else{
                    $this->ajaxReturn('咨询提交失败,请重试!');
                    exit;
                }
            }
        }else{
            $productInfo = M('Product')->where('id= '.$Goods_id)->setInc('click');
            if($Goods_id == null || $productInfo == null || $productInfo == false){
                $this->error('非法操作...！');
                exit;
            }
            $info = M('Product')->where('id = '.$Goods_id)->find();
            //设置分类 -- 对比导航栏
            $this->tag2 = 'tuan';
            //组装商品规格
            $info['cname'] = M('Category')->where('cid = '.$info['cid'])->getField('name');
            //组装商品图片
            $img_where['id'] = array('IN',$info['image_id']);
            $info['savepath'] = M('Images')->where($img_where)->Field('savepath')->select();
            //查询人气排行
            $moods = M('Product')->where('cid = '.$info['cid'].' AND mold_id = '.$info['mold_id'].' AND id != '.$info['id'].' AND status = 1 AND sale = 0 AND groupon = 0 AND auction = 0')->order('buy_num desc')->limit(5)->Field('image_id,title,id,market,price')->select();
            //组装人气产品图片
            foreach($moods as $k=>$v){
                $moods_where['id'] = array('IN',$v['image_id']);
                $moods[$k]['savepath'] = M('Images')->where($moods_where)->order('create_time desc')->limit(1)->getField('savepath');
            }
            //一周人气排行榜
            $old_time = time() - (3600*24*7);
            $new_time = time() + (3600*24*7);
            $moods_7 = M('Product')->where('update_time > '.$old_time.' AND update_time <'.$new_time.' AND status = 1 AND sale = 0 AND auction = 0 AND groupon = 0')->order('buy_num desc')->Field('id,image_id,title,price')->select();
            //组装一周人气图片
            foreach($moods_7 as $k=>$v){
                $moods_7_where['id'] = array('IN',$v['image_id']);
                $moods_7[$k]['savepath'] = M('Images')->where($moods_7_where)->order('create_time desc')->limit(1)->getField('savepath');
            }
            $this->assign('moods_7',$moods_7);
            $this->assign('moods',$moods);

            //重组产品参数
            $canshu = explode(',',$info['summary']);
            $this->assign('canshu',$canshu);
        }
        if($info['start_time'] <= time() && $info['end_time'] >= time()){
            $info['statusHtml'] = '马上团';
            $info['buyStatus'] = 0;
            $info['productTIme'] = $info['end_time'];
        }else if($info['start_time'] >= time() && (($info['start_time'] - time()) <=(3600*24*C('LISTNUM.startTime')))){
            $info['statusHtml'] = '即将开团';
            $info['buyStatus'] = 1;
            $info['productTIme'] = $info['start_time'];
        }else if($info['end_time'] <= time()){
            $info['statusHtml'] = '已结束';
            $info['buyStatus'] = 2;
        }else{
            $info['statusHtml'] = '尚未开始';
            $info['buyStatus'] = 3;
        }

        //计算评价总分
        $pList = M('Product_comment')->where('pro_id = '.$Goods_id)->getField('feel',true);
		if($pList == null){
			$pListNum = 0;
		}else{
			foreach($pList as $k=>$v){
				$pListNum += $v;
			}
		}
        
        $pCount = count($pList);
		if($pListNum == 0 && $pCount == 0){
			$this->pnum = 0;
		}else{
			$this->pnum = $pListNum/$pCount;
		}
        $this->commentnum = M('Product_comment')->where('pro_id = '.$Goods_id)->count();
        $this->assign('info',$this->s_images($info,true,true));
        $this->assign('title',$info['title']);
        $this->display();

    }
}