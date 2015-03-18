<?php
namespace Wap\Controller;
use Think\Controller;
class UserController extends CommonController{
    public function __construct(){
        parent::__construct();
        if($_SESSION['member'] == null){
            header('Location:'.__ROOT__.U('/login'));
            exit;
        }
    }

    public function wapUser(){
        //计算待支付订单数量
        $this->waitPayCount = M('Product_order')->where('status = 0 AND uid = '.$_SESSION['member']['uid'])->count();
        //计算待发货订单数量
        $this->waitDeliveryCount = M('Product_order')->where('status = 2 AND uid = '.$_SESSION['member']['uid'])->count();
        //计算待收货订单数量
        $this->waitReallyCount = M('Product_order')->where('status = 3 AND uid = '.$_SESSION['member']['uid'])->count();
        //计算已完成订单数量
        $this->isSuccessCount = M('Product_order')->where('status = 5 AND uid = '.$_SESSION['member']['uid'])->count();
        $this->assign('headName','会员中心');
        $this->assign('title','会员中心');
        $this->display();
    }

    public function myOrder(){
        if(IS_POST){
            $orderInfo = M('Product_order')->where('id = '.I('post.obj'))->find();
            if($orderInfo['uid'] != $_SESSION['member']['uid']){
                $this->ajaxReturn(array('status'=>0,'info'=>'您无权对此订单进行操作!'));
                exit;
            }
            if($orderInfo['status'] == 1 || $orderInfo['status'] == 5 || $orderInfo['status'] == 6 || $orderInfo['status'] == 7){
                $this->ajaxReturn(array('status'=>0,'info'=>'当前订单已无法进行操作!'));
                exit;
            }
            switch(I('post.type')){
                //订单支付
                case 'payOrder':
                    $status = true;
                    $code = 1;
                    $info = '正在跳转支付页...';
                    $url = U('/Pay').'?obj='.$orderInfo['id'];
                    break;
                //取消订单
                case 'cancelOrder':
                    $status = true;
                    $code = 2;
                    $info = '您确定取消订单吗?';
                    break;
                case 'cancelOrderReally':
                    $data['status'] = 1;
                    $data['update_time'] = time();
                    if(M('Product_order')->where('id = '.I('post.obj'))->save($data)){
                        $status = true;
                        $code = 1;
                        $info = '您已成功取消订单!';
                    }else{
                        $status = true;
                        $code = 0;
                        $info = '取消订单操作失败!';
                    }
                    break;
                //申请退款
                case 'refundAction':
                    $status = true;
                    $code = 2;
                    $info = '您确定申请本次退款吗?';
                    break;
                case 'refundActionReally':
                    $data['old_status'] = $orderInfo['status'];
                    $data['status'] = 4;
                    $data['update_time'] = time();
                    if(M('Product_order')->where('id = '.I('post.obj'))->save($data)){
                        $status = true;
                        $code = 1;
                        $info = '您的退款申请提交成功!';
                    }else{
                        $status = true;
                        $code = 0;
                        $info = '您的退款申请提交失败!';
                    }
                    break;
                //取消退款
                case 'cancelRefund':
                    $status = true;
                    $code = 2;
                    $info = '您确定取消本次退款吗?';
                    break;
                case 'cancelRefundReally':
                    $data['status'] = $orderInfo['old_status'];
                    $data['old_status'] = 0;
                    $data['update_time'] = time();
                    if(M('Product_order')->where('id = '.I('post.obj'))->save($data)){
                        $status = true;
                        $code = 1;
                        $info = '您已成功取消退款!';
                    }else{
                        $status = true;
                        $code = 0;
                        $info = '取消退款操作失败!';
                    }
                    break;
                //确认收货
                case 'reallyOrder':
                    $status = true;
                    $code = 2;
                    $info = '您确定要确认收货吗?';
                    break;
                case 'reallyOrderReally':
                    $data['status'] = 5;
                    $data['update_time'] = time();
                    if(M('Product_order')->where('id = '.I('post.obj'))->save($data)){
                        $status = true;
                        $code = 1;
                        $info = '您已成功确认收货!';
                    }else{
                        $status = true;
                        $code = 0;
                        $info = '确认收货操作失败!';
                    }
                    break;
                //删除订单----隐藏订单
                case 'delOrder':
                    break;
                default:
                    break;
            }
            if($status){
                $this->ajaxReturn(array('status'=>$code,'info'=>$info,'url'=>$url));
                exit;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>$info,'url'=>$url));
                exit;
            }
        }else{
            switch(I('get.Status')){
                case 'waitPay':
                    $where['status'] = 0;
                    $headName = '待支付订单';
                    break;
                case 'waitDelivery':
                    $where['status'] = 2;
                    $headName = '待发货订单';
                    break;
                case 'waitReally':
                    $where['status'] = 3;
                    $headName = '待确认订单';
                    break;
                case 'isSuccess':
                    $where['status'] = 5;
                    $headName = '已成功订单';
                    break;
                default:
                    $headName =  '我的订单';
            }
			$where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_order');
            $count      = $User->where($where)->count();
            $Page       = new \Think\wapShopPage($count,5);
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $Page->setConfig('theme','%UP_PAGE% %NOW_PAGE% %DOWN_PAGE%');
            $show       = $Page->show();
            $field = 'id,oid,status,aid,pro_id,total_money,published,alipay_id,freight';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();

            foreach($list as $k=>$v){
                //判断该订单的状态
                switch($v['status']){
                    case '0':
                        $list[$k]['statusHtml'] = '等待支付';
                        break;
                    case '1':
                        $list[$k]['statusHtml'] = '订单已取消';
                        break;
                    case '2':
                        $list[$k]['statusHtml'] = '等待发货';
                        break;
                    case '3':
                        $list[$k]['statusHtml'] = '等待确认';
                        break;
                    case '4':
                        $list[$k]['statusHtml'] = '等待退款';
                        break;
                    case '5':
                        $list[$k]['statusHtml'] = '交易成功';
                        break;
                    case '6':
                        $list[$k]['statusHtml'] = '退款成功';
                        break;
                    case '7':
                        $list[$k]['statusHtml'] = '订单已失效';
                        break;
                    default:
                        $list[$k]['statusHtml'] = '无效订单';
                        break;
                }
            }
            $this->assign('show',$show);
            $this->assign('list',$list);
            $this->assign('headName',$headName);
            $this->assign('title',$headName);
            $this->display();
        }
    }

    public function Pay(){
        $orderInfo = M('Product_order')->where('id = '.I('get.obj'))->find();
        if($orderInfo['uid'] != $_SESSION['member']['uid']){
            exit;
        }
        if($orderInfo['status'] == (1 || 5 || 6 || 7)){
            exit;
        }
        $order['orderId'] = $orderInfo['oid'];
        $order['orderName'] = C('WEIXIN.alipay_appname');
        $order['orderMoney'] = $orderInfo['total_money'];
        $order['orderFee'] = $orderInfo['freight'];
        $pay = new \Common\Api\aliPay();
        $pay->nowPay($order);
    }

    public function wapOrderDetail(){
        $info = M('Product_order')->where('id = '.I('get.oid'))->find();
        if($info == null || $info == false || $info == ''){
            echo '非法操作!';
            exit;
        }
        if(IS_POST){

        }else{
            switch($info['status']){
                case '0':
                    $info['statusHtml'] = '等待支付';
                    break;
                case '1':
                    $info['statusHtml'] = '订单已取消';
                    break;
                case '2':
                    $info['statusHtml'] = '等待发货';
                    break;
                case '3':
                    $info['statusHtml'] = '等待确认';
                    break;
                case '4':
                    $info['statusHtml'] = '等待退款';
                    break;
                case '5':
                    $info['statusHtml'] = '交易成功';
                    break;
                case '6':
                    $info['statusHtml'] = '退款成功';
                    break;
                case '7':
                    $info['statusHtml'] = '订单已失效';
                    break;
                default:
                    $info['statusHtml'] = '无效订单';
                    break;
            }
            $this->assign('info',$info);
            $this->assign('address',M('Member_address')->where('id = '.$info['aid'])->find());
            $cartWhere['id'] = array('exp','IN('.$info['cart_id'].')');
            $cartList = M('Product_cart')->where($cartWhere)->field('id,pro_id,num,price')->select();

            foreach($cartList as $k=>$v){
                $proInfo = M('Product')->where('id = '.$v['pro_id'])->field('id,title,image_id,auction,sale,groupon')->find();
                $cartList[$k]['title'] = $proInfo['title'];
                $cartList[$k]['image_id'] = $proInfo['image_id'];
                if($proInfo['auction'] == 1){
                    $cartList[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/patDetail').'?pat='.$proInfo['id'];
                }else if($proInfo['sale'] == 1){
                    $cartList[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/msDetail').'?ms='.$proInfo['id'];
                }else if($proInfo['groupon'] == 1){
                    $cartList[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/tDetail').'?tid='.$proInfo['id'];
                }else{
                    $cartList[$k]['url'] = U('/wapDetail').'?Gid='.$proInfo['id'];
                }
            }
			$kdInfo = getKdInfo($info['fee_code'],$info['fee_kid']);
			$this->assign('kdInfo',$kdInfo);
            $this->assign('product',$this->s_images($cartList,true));
            $this->assign('headName','订单详情');
            $this->assign('title','订单详情');
            $this->display();
        }
    }

    public function wapCart(){
        if(IS_POST){

            if(I('post.type') != null && I('post.type') != '' && is_string(I('post.type'))){
                switch(I('post.type')){
                    case 'updateCartData':
                        $tableName = 'Product_cart';
                        break;
                }
                $info = M($tableName)->where('id = '.I('post.obj'))->find();
                if($info == null || $info == '' || $info['uid'] != $_SESSION['member']['uid']){
                    $this->ajaxReturn(array('status'=>0,'info'=>'您无权进行操作!'));
                    exit;
                }
                $stock = M('Product')->where('id ='.$info['pro_id'])->getField('stock');
                if($stock < I('post.val')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'库存不足!'));
                    exit;
                }
                if(!M($tableName)->where('id = '.I('post.obj'))->setField('num',I('post.val'))){
                    $this->ajaxReturn(array('status'=>0,'info'=>'修改失败!'));
                    exit;
                }else{
                    $this->ajaxReturn(array('status'=>1));
                    exit;
                }
            }
            if(I('post.lx') != null && I('post.lx') != '' && is_string(I('post.lx'))){
                if(I('post.obj') == null || I('post.obj') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'请选择您的商品!'));
                    exit;
                }
                switch(I('post.lx')){
                    case 'cartReally':
                        $this->ajaxReturn(array('status'=>1,'info'=>'正在跳转确认页...','url'=>U('/reallyOrder').'?Cp='.rtrim(I('post.obj'),',')));
                        break;
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                exit;
            }
        }else{
            $cart_list = M('Product_cart')->where('status = 0 AND uid = '.$_SESSION['member']['uid'])->select();
            foreach ($cart_list as $k => $v) {
                $proInfo = M('Product')->where('id = '.$v['pro_id'])->field('groupon,sale,auction')->find();
                if($proInfo['sale'] == 0  && $proInfo['auction'] == 0 && $proInfo['groupon'] == 0){
                    $cartNewList[] = $v;
                    $cartMoney += $v['price']*$v['num'];
                    $cartMarket += $v['market']*$v['num'];
                }
            }
            $this->assign('cartList',$cartNewList);
            $this->assign('cartMarket',$cartMarket);
            $this->assign('cartMoney',$cartMoney);
            $this->assign('cartCount',count($cartNewList));
            $this->assign('headName','我的购物车');
            $this->assign('title','我的购物车');
            $this->display();
        }
    }

    public function viewCookie(){
        if(IS_POST){
            if(!empty($_COOKIE['list'])){
                if(setcookie("list", "", time() - 3600)){
                    $this->ajaxReturn(array('status'=>1,'info'=>'缓存已被成功清除!'));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'缓存清除失败!'));
                    exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'缓存已被清除!'));
            }
        }else{
            $viewWhere['id'] = array('exp','IN('.$_COOKIE['list'].')');
            $viewWhere['sale'] = 0;
            $viewWhere['auction'] = 0;
            $viewWhere['groupon'] = 0;
            $this->assign('list',$this->s_images(M('Product')->where($viewWhere)->field('id,title,tuixiao,image_id,price')->select(),true));
            $this->assign('headName','浏览历史');
            $this->assign('title','浏览历史');
            $this->display();
        }
    }

    public function myFavorite(){
        if(IS_POST){
            if(I('post.type') != null){
                switch(I('post.type')){
                    case 'delFavorite':
                        $tableName = 'Product_collect';
                        break;
                    case 'delAddress':
                        $tableName = 'Member_address';
                        break;
                    case 'delCartData':
                        $tableName = 'Product_cart';
                        break;
                }
                $info = M($tableName)->where('id = '.I('post.obj'))->field('uid')->find();            
				if($info['uid'] == $_SESSION['member']['uid']){
                    if(M($tableName)->where('id ='.I('post.obj'))->delete()){
                        $this->ajaxReturn(array('status'=>1,'info'=>'删除成功!'));
                        exit;
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'删除失败!'));
                        exit;
                    }
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'您无权操作!'));
                    exit;
                }
            }
        }else{
            $where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_collect');
            $count      = $User->where($where)->count();
            $Page       = new \Think\wapShopPage($count,5);
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $Page->setConfig('theme','%UP_PAGE% %NOW_PAGE% %DOWN_PAGE%');
            $show       = $Page->show();
            $field = 'id,title,image_id,price';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach($list as $k=>$v){
                $proInfo = M('Product')->where('id = '.$v['pro_id'])->field($field)->find();
                $list[$k]['title'] = $proInfo['title'];
                $list[$k]['image_id'] = $proInfo['image_id'];
                $list[$k]['price'] = $proInfo['price'];
                if($proInfo['auction'] == 1){
                    $list[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/patDetail').'?pat='.$proInfo['id'];
                }else if($proInfo['sale'] == 1){
                    $list[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/msDetail').'?ms='.$proInfo['id'];
                }else if($proInfo['groupon'] == 1){
                    $list[$k]['url'] = rtrim(C('SITE_INFO.url'),'/').U('/tDetail').'?tid='.$proInfo['id'];
                }else{
                    $list[$k]['url'] = U('/wapDetail').'?Gid='.$proInfo['id'];
                }
            }
            $this->assign('list',$this->s_images($list,true));
            $this->assign('show',$show);
            $this->assign('headName','我的收藏');
            $this->assign('title','我的收藏');
            $this->display();
        }
    }

    public function myAddress(){
        $list = M('Member_address')->where('uid = '.$_SESSION['member']['uid'])->select();
        $this->assign('list',$list);
        $this->assign('headName','我的收货地址');
        $this->assign('title','我的收货地址');
        $this->display();
    }

    public function editAddress(){
        if(empty($_GET['id'])){
            if(IS_POST){
                if(I('post.name') == null || I('post.name') == '' || !usedExp(I('post.name'),'chineseExp')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人姓名错误!'));
                    exit;
                }
                if(I('post.phone') == null || I('post.phone') == '' || !usedExp(I('post.phone'),'phoneExp')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人联系电话错误!'));
                    exit;
                }
                if(I('post.postcode') == null || I('post.postcode') == '' || !usedExp(I('post.postcode'),'postcodeExp')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人邮编错误!'));
                    exit;
                }
                if(I('post.shen_cityname') == null || I('post.shen_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址错误!'));
                    exit;
                }
                if(I('post.shi_cityname') == null || I('post.shi_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址错误!'));
                    exit;
                }
                if(I('post.xian_cityname') == null || I('post.xian_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址错误!'));
                    exit;
                }if(I('post.address') == null || I('post.address') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址错误!'));
                    exit;
                }
                $data['username'] = I('post.name');
                $data['uid'] = $_SESSION['member']['uid'];
                $data['phone'] = I('post.phone');
                $data['postcode'] = I('post.postcode');
                $data['shen_cityname'] = I('post.shen_cityname');
                $data['shi_cityname'] = I('post.shi_cityname');
                $data['xian_cityname'] = I('post.xian_cityname');
                $data['address'] = I('post.address');
                if(M('Member_address')->add($data)){
                    $this->ajaxReturn(array('status'=>1,'info'=>'添加成功!','url'=>U('/myAddress').(I('get.Cp') == null?'':'?Cp='.I('get.Cp'))));
                    exit;
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
                    exit;
                }
            }else{
                $this->assign('headName','添加收货地址');
                $this->assign('title','添加收货地址');
            }
        }else{
            $info = M('Member_address')->where('id = '.I('get.id'))->find();
            if(IS_POST){
                if(I('post.obj') == null || I('post.obj') != I('get.id')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'您的操作是无效的!'));
                    exit;
                }
                if($info == null || $info == false || $info['uid'] != $_SESSION['member']['uid']){
                    $this->ajaxReturn(array('status'=>0,'info'=>'您无权进行操作!'));
                    exit;
                }
                if(I('post.name') == null || I('post.name') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人姓名不能为空!'));
                    exit;
                }
                if(I('post.phone') == null || I('post.phone') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人联系电话不能为空!'));
                    exit;
                }
                if(I('post.postcode') == null || I('post.postcode') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人邮编不能为空!'));
                    exit;
                }
                if(I('post.shen_cityname') == null || I('post.shen_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址不能为空!'));
                    exit;
                }
                if(I('post.shi_cityname') == null || I('post.shi_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址不能为空!'));
                    exit;
                }
                if(I('post.xian_cityname') == null || I('post.xian_cityname') == '请选择'){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址不能为空!'));
                    exit;
                }if(I('post.address') == null || I('post.address') == ''){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人地址不能为空!'));
                    exit;
                }
                $data['username'] = I('post.name');
                $data['phone'] = I('post.phone');
                $data['postcode'] = I('post.postcode');
                $data['shen_cityname'] = I('post.shen_cityname');
                $data['shi_cityname'] = I('post.shi_cityname');
                $data['xian_cityname'] = I('post.xian_cityname');
                $data['address'] = I('post.address');
                if(M('Member_address')->where('id = '.I('post.obj'))->save($data)){
                    $this->ajaxReturn(array('status'=>1,'info'=>'保存成功!'));
                    exit;
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'保存失败!'));
                    exit;
                }
            }else{
                if($info == null || $info == false || $info['uid'] != $_SESSION['member']['uid']){
                    echo '非法操作!';
                    exit;
                }
                $this->assign('info',$info);
                $this->assign('headName','收货地址编辑');
                $this->assign('title','收货地址编辑');
            }
        }
        $this->display();
    }

    public function reallyOrder(){
        if(I('get.Cp') == null || I('get.Cp') == ''){
            header('Location:'.U('/wapCart'));
            exit;
        }
        if(I('get.address') == null || I('get.address') == ''){
            $adWhere['uid'] = $_SESSION['member']['uid'];
        }else{
            $adWhere['uid'] = $_SESSION['member']['uid'];
            $adWhere['id'] = I('get.address');
        }
        $addressInfo = M('Member_address')->where($adWhere)->order('status desc,id desc')->find();
        if($addressInfo == null || $addressInfo == false || $addressInfo == ''){
            header('Location:'.U('/myAddress').'?Cp='.I('get.Cp'));
            exit;
        }
        $cartWhere['status'] = 0;
        $cartWhere['id'] = array('exp','IN('.I('get.Cp').')');
        $cart_list = M('Product_cart')->where($cartWhere)->select();
        foreach ($cart_list as $k => $v) {
            $proInfo = M('Product')->where('id = '.$v['pro_id'])->field('groupon,sale,auction,present')->find();
            if($proInfo['sale'] == 0  && $proInfo['auction'] == 0 && $proInfo['groupon'] == 0){
                $cartMoney += $v['price']*$v['num'];
                $cartMarket += $v['market']*$v['num'];
                $cartCredit += $v['credit']*$v['num'];
                $allPresent .= $v['present'].',';
            }
        }
        $this->assign('cartMarket',$cartMarket);
        $this->assign('cartMoney',$cartMoney);
        $this->assign('cartFreight',$cartMoney >= 100 ?0:10);
        $this->assign('address',$addressInfo);
		$this->assign('headName','确认商品信息');
		$this->assign('title','确认商品信息');
        $this->display();
    }

    public function reallyInfo(){
        $data = I('post.info');
        if($data == null || $data == '' || !is_array($data)){
            exit('非法操作!');
        }
        $cartWhere['status'] = 0;
        $cartWhere['id'] = array('exp','IN('.$data['cart_id'].')');
        $cartInfo = M('Product_cart')->where($cartWhere)->select();
        if($cartInfo == null || $cartInfo == false || $cartInfo == ''){
            exit('无权操作,请返回!');
        }
        //生成订单
        //订单数据赋值
        $order['oid'] = 'JFW'.date('YmdHis',time()).mt_rand(10,99);
        $order['uid'] = $_SESSION['member']['uid'];
        //检测订单归属类型
        $cartList = M('Product_cart')->where($cartWhere)->getField('pro_id',true);
        $order['pro_id'] = implode(',',$cartList);
        $order['cart_id'] = $data['cart_id'];
        $order['aid'] = $data['aid'];
        $order['delivery'] = $data['deliver'];
        $order['invoice'] = $data['invoice'];
        $really_product = M('Product_cart')->where($cartWhere)->Field('present,price,num,credit')->select();
        foreach($really_product as $k=>$v){
            $allMoney += $v['price']*$v['num'];
            $allCredit += $v['credit']*$v['num'];
            if($v['present']!= null){
                $allPresent .= $v['present'].',';
            }
        }
        $order['freight'] = $allMoney >= 100 ?0:10;
        $order['total_money'] = $allMoney;
        $order['total_credit'] = $allCredit;
        $order['present'] = $allPresent == null ? '无礼品':$allPresent;
        $order['order_ip'] = $_SERVER['REMOTE_ADDR'];
        $order['published'] = $data['update_time'] = time();
        if($id = M('Product_order')->add($order)){
            header('Location:'.U('/acSuccess').'?oid='.$id);
            exit;
        }else{
            exit('操作失败!');
        }
    }

    public function acSuccess(){
        if(I('get.oid') == null || I('get.oid') == ''){
            exit('非法操作!');
        }
        $infoWhere['uid'] = $_SESSION['member']['uid'];
        $infoWhere['status'] = 0;
        $infoWhere['id'] = I('get.oid');
        $info = M('Product_order')->where($infoWhere)->field('id,oid,published,total_money')->find();
        if($info == null || $info == '' || $info == false){
            exit('您无权操作!');
        }
        $this->assign('info',$info);
        $this->display();
    }
}