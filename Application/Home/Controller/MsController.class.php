<?php
    namespace Home\Controller;
    use Think\Controller;
class MsController extends SystemController{
    public function __construct(){
        parent::__construct();
    }

    public function ms(){
        $field = 'id,image_id,title,tuixiao,price,start_time,end_time';
        $nowWhere['status'] = 1;
        $nowWhere['sale'] = 1;
        $nowWhere['groupon'] = 0;
        $nowWhere['auction'] = 0;
        $nowWhere['_string'] = 'start_time <= '.time().' AND end_time >= '.time();
        $nowList = $this->s_images(M('Product')->where($nowWhere)->order('end_time asc')->limit(C('LISTNUM.msList'))->field($field)->select(),true,false);
        $this->assign('nowList',$nowList);

        //等待开始的秒杀
        $waitWhere['status'] = 1;
        $waitWhere['sale'] = 1;
        $nowWhere['groupon'] = 0;
        $nowWhere['auction'] = 0;
        $waitWhere['_string'] = 'start_time >= '.time().' AND start_time - '.time().'  <= '.(3600*24*C('LISTNUM.startTime'));
        $waitList = $this->s_images(M('Product')->where($waitWhere)->order('start_time asc')->limit(C('LISTNUM.msList'))->field($field)->select(),true,false);
        $this->assign('waitList',$waitList);

        //已经结束的
        $endWhere['sale'] = 1;
        $endWhere['status'] = 1;
        $nowWhere['groupon'] = 0;
        $nowWhere['auction'] = 0;
        $endWhere['end_time'] = array('elt',time());
        $endList = $this->s_images(M('Product')->where($endWhere)->order('end_time asc')->limit(C('LISTNUM.msList'))->field($field)->select(),true,false);
        $this->assign('title',M('Nav')->where("tag = 'ms'")->getField('nav_name'));
        $this->assign('endList',$endList);
        $this->display();
    }

    public function msDetail(){
        $id = I('get.ms');
        $this->collect = M('Product_collect')->where('pro_id = '.$id.' AND uid = '.$_SESSION['member']['uid'])->find();
        if(IS_POST){
            if(I('post.type') == 'addcommect'){
                if($this->collect != null){
                    $this->ajaxReturn('您已收藏过该商品!');
                    exit;
                }
                if($_SESSION['member'] == null){
                    $this->ajaxReturn('请登录后再收藏!');
                    exit;
                }

                $data['pro_id'] = $id;
                $data['uid'] = $_SESSION['member']['uid'];
                $data['published'] = $data['update_time'] = time();
                if(M('Product_collect')->add($data)){
                    $this->ajaxReturn('收藏成功!');
                }else{
                    $this->ajaxReturn('收藏失败!');
                    exit;
                }
            }
            if(I('post.type') == 'delcommect'){
                $common_id = ($this->collect['id'] == null) ? I('post.obj') :$this->collect['id'];
                if(M('Product_collect')->where('id = '.$common_id)->delete()){
                    $this->ajaxReturn('您已成功取消收藏!');
                }else{
                    $this->ajaxReturn('操作失败!');
                }
            }
        }else{
            $info = M('Product')->where('id = '.$id)->find();
            if($info == null){
                $this->error('调取商品信息失败!');
                exit;
            }
            $moods = M('Product')->where('cid = '.$info['cid'].' AND mold_id = '.$info['mold_id'].' AND id != '.$info['id'].' AND sale =0 AND groupon = 0 AND auction = 0')->order('buy_num desc')->limit(5)->Field('image_id,title,id,market,price')->select();
            //组装人气产品图片
            foreach($moods as $k=>$v){
                $moods_where['id'] = array('IN',$v['image_id']);
                $moods[$k]['savepath'] = M('Images')->where($moods_where)->order('create_time desc')->limit(1)->getField('savepath');
            }
            //一周人气排行榜
            $old_time = time() - (3600*24*7);
            $new_time = time() + (3600*24*7);
            $moods_7 = M('Product')->where('update_time > '.$old_time.' AND update_time <'.$new_time.' AND sale =0 AND groupon = 0 AND auction = 0')->order('buy_num desc')->Field('id,image_id,title,price')->select();
            //组装一周人气图片
            foreach($moods_7 as $k=>$v){
                $moods_7_where['id'] = array('IN',$v['image_id']);
                $moods_7[$k]['savepath'] = M('Images')->where($moods_7_where)->order('create_time desc')->limit(1)->getField('savepath');
            }
            $this->assign('moods_7',$moods_7);


            $this->assign('moods',$moods);

            $info['cname'] = M('Category')->where('cid = '.$info['cid'])->getField('name');
            if($info['start_time'] <= time() && $info['end_time'] >= time()){
                $info['statusHtml'] = '距结束';
                $info['buyStatus'] = 0;
                $info['productTIme'] = $info['end_time'];
            }else if($info['start_time'] >= time() && (($info['start_time'] - time()) <=(3600*24*C('LISTNUM.startTime')))){
                $info['statusHtml'] = '距开始';
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
			$pList = M('Product_comment')->where('pro_id = '.$id)->getField('feel',true);
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
			$this->commentnum = M('Product_comment')->where('pro_id = '.$id)->count();
            $this->tag2 = 'ms';
            $this->title = $info['title'];
            $this->assign('info',$this->s_images($info,true,true));
            $this->display();
        }
    }
}