<?php
    namespace Home\Controller;
    use Think\Controller;
    header('content-type:text/html;charset=utf-8');
class IndexController extends SystemController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //��������
        $cateList = M('Category')->where('pid = 0 AND type = '."'mold'")->order('sort')->field('cid,name')->select();
        foreach($cateList as $k=>$v){
            if($k == 0 || $k == 1){
                if($k == 0){
                    $liWhere['status'] = 1;
                    $liWhere['is_recommend'] = 1;
                    $liWhere['sale'] = 0;
                    $liWhere['groupon'] = 0;
                    $liWhere['auction'] = 0;
                    $liWhere['is_lipin'] = 1;

                    $productInfo = $this->s_images(M('Product')->where($liWhere)->order('update_time desc')->limit(7)->field('id,title,tuixiao,price,image_id')->select());
                }else{
                    $productInfo = $this->s_images(M('Product')->where('mold_id = '.$v['cid'].' AND status = 1 AND is_recommend = 1 AND sale = 0 AND groupon = 0 AND auction = 0')->limit(7)->order('update_time desc')->field('id,title,tuixiao,price,image_id')->select());
                }

                $tmpWhere['position'] = array('eq',$k == 0 ?'index_m1':'index_m2');
                $productAd = M('Ad')->where($tmpWhere)->select();
                $cateList[$k]['ad'] = $productAd;
            }else{
                $productInfo = $this->s_images(M('Product')->where('mold_id = '.$v['cid'].' AND status = 1 AND is_recommend = 1 AND sale = 0 AND groupon = 0 AND auction = 0')->limit(5)->order('update_time desc')->field('id,title,tuixiao,price,image_id')->select());
            }
            if($productInfo){
                foreach($productInfo as $k1=>$v1){
                    foreach($v1 as $k2=>$v2){
                        $cateList[$k]['product'][$k1][$k2] = $v2;
                    }
                    $cateList[$k]['product'][$k1]['savepath'] = $v1['savepath'][0]['savepath'];
                }
            }
        }
        $indexWhere['status'] = 1;
        $indexWhere['sale'] = 0;
        $indexWhere['auction'] = 0;
        $indexWhere['groupon'] = 0;
        //�������
        $randList = M('Product')->where($indexWhere)->order('rand()')->limit(4)->field('id,title,price,image_id')->select();
        $this->assign('randList',$this->s_images($randList));
        //�����Ƽ�
        $hotList = M('Product')->where($indexWhere)->order('buy_num desc')->limit(4)->field('id,title,price,image_id')->select();
        $this->assign('hotList',$this->s_images($hotList));
        //����ϲ��
        $loveList = M('Product')->where($indexWhere)->order('rand()')->limit(4)->field('id,title,price,image_id')->select();
        $this->assign('loveList',$this->s_images($loveList));
        //��Ʒ�ϼ�
        $newList = M('Product')->where($indexWhere)->order('published desc')->limit(4)->field('id,title,price,image_id')->Select();
        $this->assign('newList',$this->s_images($newList));
        //�������
        $this->assign('index_ad',M('Ad')->where('position = '."'index_top'")->select());
        //�����ؼ�
        $tjList = M('Product')->where('status = 1 AND groupon = 1 AND start_time <='.time().' AND end_time >= '.time())->field('id,image_id,title,tuixiao,price')->select();

        //�̳�����
        $scggId = M('Nav')->where("tag = 'scgg'")->getField('guide');
        $this->scggList = M('News')->where('status = 1 AND cid = '.$scggId)->order('published desc')->limit(6)->field('id,title')->select();

        //������Ϣ
        $cxxxId = M('Nav')->where("tag = 'cxxx'")->getField('guide');
        $this->cxxxList = M('News')->where('status = 1 AND cid = '.$cxxxId)->order('published desc')->limit(6)->field('id,title')->select();

        $this->assign('tjList',$this->s_images($tjList,true,false));
        $this->assign('product',$cateList);
        $this->assign('title',C('SITE_INFO.name'));
        $this->display();
    }

    public function newsInfo(){
        $id = I('get.id');
        $info = M('News')->where('id = '.$id)->field('title,published,content')->find();
        if(empty($id) || empty($info)){
            $this->error('�����ʵ������Ѿ�ɾ�������Ѿ�����!');
            exit;
        }
        $this->assign('info',$info);
        $this->assign('title',$info['title']);
        $this->display();
    }
}