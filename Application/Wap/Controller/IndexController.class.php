<?php
    namespace Wap\Controller;
    use Think\Controller;
    header('content-type:text/html;charset=utf-8');
class IndexController extends CommonController{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //首页商品分类
        $shopList = M('Nav')->where("tag = 'shop'")->order('sort')->field('guide,nav_name')->select();
        $this->assign('shopList',$shopList);

        //分类数据
        $cateList = M('Category')->where('pid = 0 AND type = '."'mold'")->order('sort')->field('cid,name')->select();
        foreach($cateList as $k=>$v){
                if($k == 0){
                    $liWhere['status'] = 1;
                    $liWhere['is_recommend'] = 1;
                    $liWhere['sale'] = 0;
                    $liWhere['groupon'] = 0;
                    $liWhere['auction'] = 0;
                    $liWhere['is_lipin'] = 1;

                    $productInfo = $this->s_images(M('Product')->where($liWhere)->order('update_time desc')->limit(7)->field('id,title,tuixiao,price,image_id')->select());
                }else{
                    $productInfo = $this->s_images(M('Product')->where('mold_id = '.$v['cid'].' AND status = 1 AND auction = 0 AND groupon = 0 AND sale = 0 AND wap_display = 1')->limit(4)->order('update_time desc')->field('id,title,tuixiao,price,image_id')->select());
                }
                $tmpWhere['position'] = array('eq','index_m'.($k+1));
                $productAd = M('Ad')->where($tmpWhere)->select();
                $cateList[$k]['ad'] = $productAd;
            if($productInfo){
                foreach($productInfo as $k1=>$v1){
                    foreach($v1 as $k2=>$v2){
                        $cateList[$k]['product'][$k1][$k2] = $v2;
                    }
                    $cateList[$k]['product'][$k1]['savepath'] = $v1['savepath'][0]['savepath'];
                }
            }
        }
        $this->assign('cateList',$cateList);
        $this->assign('title',C('SITE_INFO.name'));
        $this->display();
    }
}