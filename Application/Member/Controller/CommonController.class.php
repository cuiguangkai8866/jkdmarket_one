<?php
    namespace Member\Controller;
    use Think\Controller;
class CommonController extends BaseController{
    public function __construct(){
        parent::__construct();
        if(empty($_SESSION['member']) && ACTION_NAME != 'logout' && MODULE_NAME == 'Member'){
            header('Location:'.U('/Login'));
            exit;
        }

        //会员登录有效期
        if(($_SESSION['member']['login_time']+C('TOKEN.member_timeout')) < time()){
            $_SESSION['member'] = '';
            header('Location:'.U('/Login'));
            exit;
        }

        switch(ACTION_NAME){
            case 'detail':
                $id = base64_decode($_GET[md5('Goods')]);
                $this->assign('mianBaoXie',$this->mianBaoXieNav($id));
                $seo = M('Product')->where('id = '.$id)->field('keywords,description')->find();
                break;
            case 'patDetail':
                $this->assign('mianBaoXie',$this->mianBaoXieNav($_GET['pat']));
                $seo = M('Product')->where('id = '.$_GET['pat'])->field('keywords,description')->find();
                break;
            case 'tDetail':
                $this->assign('mianBaoXie',$this->mianBaoXieNav($_GET['tid']));
                $seo = M('Product')->where('id = '.$_GET['tid'])->field('keywords,description')->find();
                break;
            case 'msDetail':
                $this->assign('mianBaoXie',$this->mianBaoXieNav($_GET['ms']));
                $seo = M('Product')->where('id = '.$_GET['ms'])->field('keywords,description')->find();
                break;
            case 'newsInfo':
                $id = I('get.id');
                $seo = M('News')->where('id = '.$id)->field('keywords,description')->find();
                break;
            case 'shop':
                if($id = base64_decode($_GET['Mid'])){
                    $seo = M('Nav')->where('guide = '.$id)->field('keywords,description')->find();
                }else{
                    $seo = M('Nav')->order('sort')->limit(1)->field('keywords,description')->find();
                }
                break;
            case 'ms':
            case 'tuan':
                $seo = M('Nav')->where("tag = '".ACTION_NAME."'")->field('keywords,description')->find();
                break;
            default:
                $seo['keywords'] = C('SITE_INFO.keyword');
                $seo['description'] = C('SITE_INFO.description');
                break;
        }
        $this->assign('seo',$seo);

        if(C('LISTNUM.isOpenDelTime') == 1){
            //检测是订单超过24小时未支付作废该订单
            M('Product_order')->where('status = 0 AND published < '.(time()-(3600*C('LISTNUM.orderDelTime'))))->setField(array('status'=>7,'update_time'=>time()));
        }

        //计算购物车内的数量
        $cart_list = M('Product_cart')->where('status = 0 AND uid = '.$_SESSION['member']['uid'])->select();
        foreach ($cart_list as $k => $v) {
            $proInfo = M('Product')->where('id = '.$v['pro_id'])->field('groupon,sale,auction')->find();
            if($proInfo['sale'] == 0  && $proInfo['auction'] == 0 && $proInfo['groupon'] == 0){
                $cartNewList[] = $v;
            }
        }
        $this->cart_count = count($cartNewList);
        $this->assign('cart_list',$cartNewList);
        //检测购物车是否存在
        if(ACTION_NAME == 'buycart'){
            if($cart_list == null){
                $this->error('您还没有添加任何商品！',U('/shop'),3);
                exit;
            }
        }
        //获取公共侧边栏
        $cateListArr = M('Category')->where('pid = 0 AND type = '."'mold'")->order('sort')->field('cid,name')->select();
        foreach($cateListArr as $k=>$v){
            $cateListArr[$k]['shuxing'] = M('Category')->where('pid = '.$v['cid'])->order('sort')->field('cid,name')->select();
            foreach($cateListArr[$k]['shuxing'] as $k1=>$v1){
                $cateListArr[$k]['shuxing'][$k1]['val'] = M('Category')->where('pid = '.$v1['cid'])->order('sort')->field('cid,name')->select();
                if($k1 == 0){
                    $cateListArr[$k]['guige'] = M('Category')->where('pid = '.$v1['cid'])->order('sort')->field('cid,name')->select();
                }
            }
            if($k == 0){
                $cateListArr[$k]['guige'] = M('Category')->where("pid = 0 AND type='product'")->order('sort')->field('cid,name')->select();
            }
        }
        $this->assign('cateListArr',$cateListArr);

        //获取QQ客服信息
        $qqInfo = array_filter(explode("\n",C('SITE_INFO.qqkf')));
        $qq = array();
        foreach ($qqInfo as $k => $v) {
            $a = explode('|',$v);
            $qq[$k]['title'] = $a[0];
            $qq[$k]['num'] = $a[1];
        }
        $this->assign('qq',$qq);
    }

    protected function s_images($image){
        if(empty($image) || !is_array($image)){
            return false;
            exit;
        }
        foreach($image as $k=>$v){
            if($image[$k]['image_id'] != $v['image_id']){
                $this->s_images($v);
            }else{
                if($v['image_id'] == null){
                    $image[$k]['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                }else{
                    $img_where['id'] = array('IN',$v['image_id']);
                    $img_arr = M('images')->where($img_where)->Field('savepath')->select();
                    if(empty($img_arr)){
                        $image[$k]['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                    }else{
                        $image[$k]['savepath'] = $img_arr;
                    }
                }
            }
        }
        return $image;
    }

    //状态返回
    protected function s_statusHtml($status){
        switch($status){
            case '0':
                return '等待支付';
                break;
            case '1':
                return '已经取消';
                break;
            case '2':
                return '等待发货';
                break;
            case '3':
                return '等待收货';
                break;
            case '4':
                return '正在退款';
                break;
            case '5':
                return '交易完成';
                break;
            case '6':
                return '退款成功';
                break;
            case '7':
                return '已经失效';
                break;
        }
    }
}