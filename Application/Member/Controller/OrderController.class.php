<?php
    namespace Member\Controller;
    use Think\Controller;
class OrderController extends CommonController{
    //加载我的订单主框架
    public function index(){
        $this->display('list');
    }
    public function sale(){
        $this->display();
    }
    public function groupon(){
        $this->display();
    }
    public function myPat(){
        $this->display();
    }
    //加载我的订单数据
    public function loadOrderList(){
        if(IS_POST){
            if(I('post.action') == 'perform'){
                if(I('post.type') == 'cancelOrder'){
                    if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>1,'update_time'=>time()))){
                        $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                    }
                }else{
                    if(I('post.obj') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'Action Error,obj is not defined !'));
                    exit;
                    }
                    if(I('post.val') == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'支付密码不能为空!'));
                        exit;
                    }
                    switch(I('post.type')){
                        // case 'cancelOrder':
                        //     if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                        //         $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                        //         exit;
                        //     }
                        //     if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>1,'update_time'=>time()))){
                        //         $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                        //     }else{
                        //         $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        //     }
                        //     break;
                        case 'cancelRefund':
                            if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                                $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                                exit;
                            }
                            $old_status = M('Product_order')->where('id = '.I('post.obj'))->getField('old_status');
                            if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>$old_status,'update_time'=>time(),'sq_status'=>0))){
                                $this->ajaxReturn(array('status'=>1,'info'=>'您已取消本次退款申请!'));
                            }else{
                                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                            }
                            break;
                        case 'pleaseReallyOrderInfo':
                            if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                                $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                                exit;
                            }
                            if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>5,'update_time'=>time()))){
                                $orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
                                M('Member')->where('uid = '.$orderInfo['uid'])->setInc('money',$orderInfo['total_money']+$orderInfo['freight']);
                                M('Member')->where('uid = '.$orderInfo['uid'])->setInc('credit',$orderInfo['total_credit']);
                                $this->ajaxReturn(array('status'=>1,'info'=>'您已成功确认此订单!'));
                            }else{
                                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                            }
                            break;
                        default:
                            $this->ajaxReturn(array('status'=>0,'info'=>I('post.type').'is not defined ！'));
                            break;
                    }
                    $this->ajaxReturn(array('status'=>1,'info'=>I('post.action')));
                }
            }
        }else{
            //读取订单数据
            if(I('get.monthOrder') != null || I('get.monthorder') != null){
                $where['published'] = array('gt',(time() - 3600 * 24 * 30));
            }
            if(I('get.allOrder') != null || I('get.allorder') != null){
                $where['published'] = array('lt',(time() - 3600 * 24 * 30));
            }
            if(I('get.waitPayOrder') != null || I('get.waitpayorder') != null)
                $where['status'] = 0;
            if(I('get.cancelOrder') != null || I('get.cancelorder') != null)
                $where['status'] = 1;
            if(I('get.waitDeliveryOrder') != null || I('get.waitdeliveryorder') != null)
                $where['status'] = 2;
            if(I('get.waitReallyOrder') != null || I('get.waitreallyorder') != null)
                $where['status'] = 3;
            if(I('get.successOrder') != null || I('get.successorder') != null)
                $where['status'] = 5;

            $where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_order');
            $count      = $User->where($where)->count();
            $Page       = new \Think\memberPage($count,4);
            $show       = $Page->show();
            $field = 'id,oid,status,aid,pro_id,total_money,published,alipay_id,freight';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
            $this->assign('page',$show);
            foreach($list as $k=>$v){
                //获取该订单收货人
                $list[$k]['username'] = M('Member_address')->where('id = '.$v['aid'])->getField('username');
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
                //获取订单商品信息
                $product_where['id'] = array('IN',$v['pro_id']);
                $productList = M('Product')->where($product_where)->limit(10)->Field('id,image_id,title')->select();
                $list[$k]['product'] = $this->s_images($productList);
            }
            $this->assign('list',$list);
            $this->display('Public:order');
        }
    }

    //加载我的秒杀订单
    public function loadMsList(){
        if(IS_POST){
            if(I('post.action') == 'perform'){
                if(I('post.obj') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'Action Error,obj is not defined !'));
                    exit;
                }
                if(I('post.val') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'支付密码不能为空!'));
                    exit;
                }
                switch(I('post.type')){
                    case 'cancelOrder':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>1,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'cancelRefund':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        $old_status = M('Product_order')->where('id = '.I('post.obj'))->getField('old_status');
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>$old_status,'update_time'=>time(),'sq_status'=>0))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已取消本次退款申请!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'pleaseReallyOrderInfo':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>5,'update_time'=>time()))){
							$orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('money',$orderInfo['total_money']+$orderInfo['freight']);
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('credit',$orderInfo['total_credit']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功确认此订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status'=>0,'info'=>I('post.type').'is not defined ！'));
                        break;
                }
                $this->ajaxReturn(array('status'=>1,'info'=>I('post.action')));
            }
        }else{
            //读取订单数据
            if(I('get.monthOrder') != null || I('get.monthorder') != null){
                $where['published'] = array('gt',(time() - 3600 * 24 * 30));
            }
            if(I('get.allOrder') != null || I('get.allorder') != null){
                $where['published'] = array('lt',(time() - 3600 * 24 * 30));
            }
            if(I('get.waitPayOrder') != null || I('get.waitpayorder') != null)
                $where['status'] = 0;
            if(I('get.cancelOrder') != null || I('get.cancelorder') != null)
                $where['status'] = 1;
            if(I('get.waitDeliveryOrder') != null || I('get.waitdeliveryorder') != null)
                $where['status'] = 2;
            if(I('get.waitReallyOrder') != null || I('get.waitreallyorder') != null)
                $where['status'] = 3;
            if(I('get.successOrder') != null || I('get.successorder') != null)
                $where['status'] = 5;
            $where['order_status'] = 2;
            $where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_order');
            $count      = $User->where($where)->count();
            $Page       = new \Think\memberPage($count,4);
            $show       = $Page->show();
            $field = 'id,oid,status,aid,pro_id,total_money,published,alipay_id,freight';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
            $this->assign('page',$show);
            foreach($list as $k=>$v){
                //获取该订单收货人
                $list[$k]['username'] = M('Member_address')->where('id = '.$v['aid'])->getField('username');
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
                //获取订单商品信息
                $product_where['id'] = array('IN',$v['pro_id']);
                $productList = M('Product')->where($product_where)->limit(10)->Field('id,image_id,title')->select();
                $list[$k]['product'] = $this->s_images($productList);
            }
            $this->assign('list',$list);
            $this->display('Public:order');
        }
    }

    public function loadPatList(){
        if(IS_POST){
            if(I('post.action') == 'perform'){
                if(I('post.obj') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'Action Error,obj is not defined !'));
                    exit;
                }
                if(I('post.val') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'支付密码不能为空!'));
                    exit;
                }
                switch(I('post.type')){
                    case 'cancelOrder':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>1,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'cancelRefund':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        $old_status = M('Product_order')->where('id = '.I('post.obj'))->getField('old_status');
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>$old_status,'update_time'=>time(),'sq_status'=>0))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已取消本次退款申请!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'pleaseReallyOrderInfo':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>5,'update_time'=>time()))){
							$orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('money',$orderInfo['total_money']+$orderInfo['freight']);
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('credit',$orderInfo['total_credit']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功确认此订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status'=>0,'info'=>I('post.type').'is not defined ！'));
                        break;
                }
                $this->ajaxReturn(array('status'=>1,'info'=>I('post.action')));
            }
        }else{
            //读取订单数据
            if(I('get.monthOrder') != null || I('get.monthorder') != null){
                $where['published'] = array('gt',(time() - 3600 * 24 * 30));
            }
            if(I('get.allOrder') != null || I('get.allorder') != null){
                $where['published'] = array('lt',(time() - 3600 * 24 * 30));
            }
            if(I('get.waitPayOrder') != null || I('get.waitpayorder') != null)
                $where['status'] = 0;
            if(I('get.cancelOrder') != null || I('get.cancelorder') != null)
                $where['status'] = 1;
            if(I('get.waitDeliveryOrder') != null || I('get.waitdeliveryorder') != null)
                $where['status'] = 2;
            if(I('get.waitReallyOrder') != null || I('get.waitreallyorder') != null)
                $where['status'] = 3;
            if(I('get.successOrder') != null || I('get.successorder') != null)
                $where['status'] = 5;
            $where['order_status'] = 1;
            $where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_order');
            $count      = $User->where($where)->count();
            $Page       = new \Think\memberPage($count,4);
            $show       = $Page->show();
            $field = 'id,oid,status,aid,pro_id,total_money,published,alipay_id,freight';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
            $this->assign('page',$show);
            foreach($list as $k=>$v){
                //获取该订单收货人
                $list[$k]['username'] = M('Member_address')->where('id = '.$v['aid'])->getField('username');
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
                //获取订单商品信息
                $product_where['id'] = array('IN',$v['pro_id']);
                $productList = M('Product')->where($product_where)->limit(10)->Field('id,image_id,title')->select();
                $list[$k]['product'] = $this->s_images($productList);
            }
            $this->assign('list',$list);
            $this->display('Public:order');
        }
    }

    public function loadTuanList(){
        if(IS_POST){
            if(I('post.action') == 'perform'){
                if(I('post.obj') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'Action Error,obj is not defined !'));
                    exit;
                }
                if(I('post.val') == null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'支付密码不能为空!'));
                    exit;
                }
                switch(I('post.type')){
                    case 'cancelOrder':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>1,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'cancelRefund':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        $old_status = M('Product_order')->where('id = '.I('post.obj'))->getField('old_status');
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>$old_status,'update_time'=>time(),'sq_status'=>0))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已取消本次退款申请!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    case 'pleaseReallyOrderInfo':
                        if(PassWord(I('post.val')) != $_SESSION['member']['pay_pass']){
                            $this->ajaxReturn(array('status'=>0,'info'=>'支付密码错误!'));
                            exit;
                        }
                        if(M('Product_order')->where('id = '.I('post.obj'))->setField(array('status'=>5,'update_time'=>time()))){
							$orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('money',$orderInfo['total_money']+$orderInfo['freight']);
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('credit',$orderInfo['total_credit']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功确认此订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status'=>0,'info'=>I('post.type').'is not defined ！'));
                        break;
                }
                $this->ajaxReturn(array('status'=>1,'info'=>I('post.action')));
            }
        }else{
            //读取订单数据
            if(I('get.monthOrder') != null || I('get.monthorder') != null){
                $where['published'] = array('gt',(time() - 3600 * 24 * 30));
            }
            if(I('get.allOrder') != null || I('get.allorder') != null){
                $where['published'] = array('lt',(time() - 3600 * 24 * 30));
            }
            if(I('get.waitPayOrder') != null || I('get.waitpayorder') != null)
                $where['status'] = 0;
            if(I('get.cancelOrder') != null || I('get.cancelorder') != null)
                $where['status'] = 1;
            if(I('get.waitDeliveryOrder') != null || I('get.waitdeliveryorder') != null)
                $where['status'] = 2;
            if(I('get.waitReallyOrder') != null || I('get.waitreallyorder') != null)
                $where['status'] = 3;
            if(I('get.successOrder') != null || I('get.successorder') != null)
                $where['status'] = 5;
            $where['order_status'] = 3;
            $where['uid'] = $_SESSION['member']['uid'];
            $User = M('Product_order');
            $count      = $User->where($where)->count();
            $Page       = new \Think\memberPage($count,4);
            $show       = $Page->show();
            $field = 'id,oid,status,aid,pro_id,total_money,published,alipay_id,freight';
            $list = $User->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
            $this->assign('page',$show);
            foreach($list as $k=>$v){
                //获取该订单收货人
                $list[$k]['username'] = M('Member_address')->where('id = '.$v['aid'])->getField('username');
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
                //获取订单商品信息
                $product_where['id'] = array('IN',$v['pro_id']);
                $productList = M('Product')->where($product_where)->limit(10)->Field('id,image_id,title')->select();
                $list[$k]['product'] = $this->s_images($productList);
            }
            $this->assign('list',$list);
            $this->display('Public:order');
        }
    }
    //加载订单详情数据
    public function orderDetail(){
        if(IS_POST){
            //Todo...
        }else{
            if(I('get.id') == null){
                $this->error('查询错误!');
            }
            $info = M('Product_order')->where('id = '.I('get.id').' AND uid = '.$_SESSION['member']['uid'])->field('id,oid,cart_id,status,pro_id,aid,delivery,invoice,freight,total_money,total_credit,fee_kid,fee_name,fee_code')->find();
            if($info == null || $info == false){
                $this->error('订单不存在!');
            }else{
                //判断该订单的状态
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
                //查询收货人信息
                $address = M('Member_address')->where('id = '.$info['aid'])->find();
                $p_where['id'] = array('IN',$info['cart_id']);
                $product = M('Product_cart')->where($p_where)->field('pro_id,price,credit,title,num')->select();
                foreach($product as $k=>$v){
                    $comment = M('Product_comment')->where('pro_id = '.$v['pro_id'].' AND uid = '.$_SESSION['member']['uid'].' AND oid = '.$info['id'])->getField('id');
                    $product[$k]['evaluation'] = $comment == null?0:1;
                }
				$kdInfo = getKdInfo($info['fee_code'],$info['fee_kid']);

				$this->assign('kdInfo',$kdInfo);
                $this->assign('info',$info);
                $this->assign('address',$address);
                $this->assign('product',$product);
                $this->display('Public:orderDetail');
            }
        }
    }

    //加载订单评价列表
    public function evaluation(){
        $this->display();
    }

    public function loadEvaluationList(){
        if(IS_POST){
            $infoExp = M('Product_comment')->where('id = '.I('post.obj'))->getField('uid');
            if(I('post.val') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'输入的内容不能为空!'));
                exit;
            }
            if($infoExp != $_SESSION['member']['uid']){
                $this->ajaxReturn(array('status'=>0,'info'=>'对不起,您无权操作!'));
                exit;
            }else{

                $data = M('Product_comment')->where('id = '.I('post.obj'))->field('pro_id,oid,feel,status')->find();
                $data['update_time'] = $data['published'] = time();
                $data['uid'] = $_SESSION['member']['uid'];
                $data['content'] = I('post.val');
                $data['pid'] = I('post.pid');
                if(M('Product_comment')->add($data)){
                    $this->ajaxReturn(array('status'=>1,'info'=>'您的评论已经成功提交!'));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                }
            }
        }else{
            $where['uid'] = $_SESSION['member']['uid'];
            $where['status'] = 1;
            $User = M('Product_comment');
            $count      = $User->where($where)->count();
            $Page       = new \Think\memberPage($count,10);
            $show       = $Page->show();
            $field = 'id,oid,pro_id,pid,content';
            $list = $User->where($where)->order('update_time desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
            foreach($list as $k=>$v){
                $list[$k]['title'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
                $list[$k]['price'] = M('Product')->where('id = '.$v['pro_id'])->getField('price');
                $list[$k]['oid_published'] = M('Product_order')->where('id = '.$v['oid'])->getField('published');
                $img_id = explode(',',M('Product')->where('id = '.$v['pro_id'])->getField('image_id'));
                $img = M('Images')->where('id = '.$img_id[0])->getField('savepath');
                $list[$k]['savepath'] = $img == null ?'/Public/Home/images/no_goods.jpg':$img;
            }
            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->display();
        }

    }
    //评价详情

    public function loadEvaluation(){
        $this->display();
    }
    public function loadEvaluationDetail(){
        if(IS_POST){
            $uidExp = M('Product_order')->where('id = '.I('get.oid'))->getField('uid');
            if($uidExp != $_SESSION['member']['uid']){
                $this->ajaxReturn(array('status'=>0,'info'=>'对不起,您无权访问!'));
                exit;
            }
            $data = I('post.info');
            if(empty($data['feel']) || empty($data['content'])){
                $this->ajaxReturn(array('status'=>0,'info'=>'评论的数据不能为空!'));
                exit;
            }
            $comment_id = M('Product_comment')->where('status = 0 AND pro_id = '.I('get.id'))->getField('id');
            $data['published'] = $data['update_time'] = time();
            $data['uid'] = $_SESSION['member']['uid'];
            $data['oid'] = I('get.oid');
            $data['pro_id'] = I('get.id');
            if($comment_id != null){
                $data['pid'] = $comment_id;
                $data['status'] = 1;
            }
            if(M('Product_comment')->add($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'您的评论已经成功提交','url'=>U('/Member/Order')));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败'));
            }
        }else{
            $uidExp = M('Product_order')->where('id = '.I('get.oid'))->getField('uid');
            if($uidExp != $_SESSION['member']['uid']){
                $this->error('对不起,您无权访问!');
                exit;
            }
            $proExp = M('Product')->where('id = '.I('get.id'))->Field('status,image_id,title,id')->find();
            if($proExp == null || $proExp['status'] == 0){
                $this->error('该商品不存在,或者已经下架!');
                exit;
            }

            $proExp['savepath'] = M('Images')->where('id = '.explode(',',$proExp['image_id']))->getField('savepath');
            $proExp['savepath'] = $proExp['savepath'] == null? '/Public/Home/images/no_goods.jpg':$proExp['savepath'];
            $this->assign('proInfo',$proExp);
            $this->display();
        }
    }

    //我的收藏
    public function favorite(){
        $this->display();
    }

    //加载我的收藏列表
    public function loadFavorite(){
        $collectList = M('Product_collect')->where('uid = '.$_SESSION['member']['uid'])->select();
        $collectId = implode(',',M('Product_collect')->where('uid = '.$_SESSION['member']['uid'])->getField('pro_id',true));
        $productWhere['id'] = array('exp','IN('.$collectId.')');
        $User  = M('Product');
        $count = $User->where($productWhere)->count();
        $Page  = new \Think\memberPage($count,6);
        $show  = $Page->show();
        $list  = $User->where($productWhere)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field('title,id,price,image_id,present')->select();
        $pageProductInfo = $this->s_images($list);
        foreach($pageProductInfo as $k=>$v){
            foreach($collectList as $k1=>$v1){
                if($v['id'] == $v1['pro_id']){
                    foreach($v1 as $k2=>$v2){
                        $newArray[$k][$k2] = $v2;
                    }
                    foreach($v as $k3=>$v3){
                        $newArray[$k]['product'][$k3] = $v3;
                    }
                    $newArray[$k]['product']['savepath'] = $v['savepath'][0]['savepath'];
                }
            }
        }
        $this->assign('collectList',$newArray);
        $this->assign('page',$show);
        $this->display();
    }

    //为您推荐
    public function rcdforme(){
        $cateList = M('Category')->where("pid = 0 AND type='mold'")->field('cid,name')->select();
        foreach($cateList as $k=>$v){
            $cateList[$k]['product'] = $this->s_images(M('Product')->where('mold_id = '.$v['cid'].' AND status = 1')->order('rand()')->limit(12)->field('id,title,price,image_id')->select());
        }
        $this->assign('cateList',$cateList);
        $this->display();
    }

    //申请退款
    public function loadForRefund(){
        $oid = intval(I('get.id'));
        $mustData = M('Product_order')->where('id = '.$oid)->field('pro_id,oid,cart_id,aid,status')->find();
        if($mustData['status'] == '1' || $mustData['status'] == 6 || $mustData['status'] == 7 || $mustData['status'] == 0){
            $this->error('对不起,非法操作!');
            exit;
        }
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
        $this->assign('info',$infoArr);
        $this->display();
    }

    //处理申请退款
    public function refundAction(){
        $info = I('post.info');
        foreach($info as $v){
            if($v == null){
                $this->error('必填项中存在数据为空!');
                exit;
            }
        }
        //检测该订单是否归属于当前登陆用户
        $infoExp = M('Product_order')->where('id = '.$info['id'])->find();
        if($infoExp['oid'] == $info['oid'] && $info['id'] == $infoExp['id'] && $infoExp['uid'] == $_SESSION['member']['uid']){
            if($infoExp['status'] != 4){
                $data['t_why'] = $info['t_why'];
                $data['t_content'] = $info['t_content'];
                $data['t_username'] = $info['t_username'];
                $data['t_phone'] = $info['t_phone'];
                $data['status'] = 4;
                $data['old_status'] = $infoExp['status'];
                $data['update_time'] = time();
                $data['sq_status'] = 1;
                if(M('Product_order')->where('id = '.$infoExp['id'])->save($data)){
                    $this->assign('oid',$infoExp['oid']);
                    $this->display();
                }else{
                    $this->error('操作失败!');
                }
            }else{
                $this->error('订单当前状态,无法进行操作!');
            }
        }else{
            $this->error('无权对此订单进行操作!');
        }
    }
}