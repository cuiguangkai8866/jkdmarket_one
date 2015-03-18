<?php
    namespace Admin\Controller;
    use Think\Controller;
class MadminController extends CommonController{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $M = M("Product");
        //过滤
        $s=array('0','1');
        if($title=I('get.title'))$map['title']=array('like',"%{$title}%");
        if(in_array(I('get.status'),$s))$map['status']=I('get.status');
        if($cid=I('get.cid'))$map['cid']=$cid;
        if(in_array(I('get.is_recommend'),$s))$map['is_recommend']=I('get.is_recommend');
        //
        $map['sale'] = 1;
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,15);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $this->assign("list", D("Product")->listProduct($page->firstRow, $page->listRows,$map));
        $this->assign("catlist", D("Product")->category());
        $this->display();
    }

    public function add(){
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Product")->addProduct('','sale'));
        } else {
            $this->assign("list", D("Product")->category('product'));
            $this->assign("list2", D("Product")->category('brand'));
            $this->assign("list3", D("Product")->category('mold'));
            $this->display();
        }
    }

    public function edit(){
        $M = M("Product");
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Product")->edit());
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();

            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            if($info['image_id']){
                $image = M("images");
                $map['id']=array('in',$info['image_id']);
                $img_info = $image->where($map)->order('id asc')->select();
                $this->assign("img_info", $img_info);
            }
            $this->assign("info", $info);
            $this->assign("list", D("Product")->category('product'));
            $this->assign("list2", D("Product")->category('brand'));
            $this->assign("list3", D("Product")->category('mold'));
            $this->display();
        }
    }
    public function waitStart(){
        $M = M("Product");
        //过滤
        $s=array('0','1');
        if($title=I('get.title'))$map['title']=array('like',"%{$title}%");
        if(in_array(I('get.status'),$s))$map['status']=I('get.status');
        if($cid=I('get.cid'))$map['cid']=$cid;
        if(in_array(I('get.is_recommend'),$s))$map['is_recommend']=I('get.is_recommend');
        $map['status'] = 1;
        $map['sale'] = 1;
        $map['_string'] = 'start_time >= '.time().' AND start_time - '.time().'  <= '.(3600*24*C('LISTNUM.startTime'));
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $this->assign("list", D("Product")->listProduct($page->firstRow, $page->listRows,$map));
        $this->assign("catlist", D("Product")->category());
        $this->display('index');
    }

    public function now(){
        $M = M("Product");
        //过滤
        $s=array('0','1');
        if($title=I('get.title'))$map['title']=array('like',"%{$title}%");
        if(in_array(I('get.status'),$s))$map['status']=I('get.status');
        if($cid=I('get.cid'))$map['cid']=$cid;
        if(in_array(I('get.is_recommend'),$s))$map['is_recommend']=I('get.is_recommend');
        $map['status'] = 1;
        $map['sale'] = 1;
        $map['_string'] = 'start_time <= '.time().' AND end_time >= '.time();
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $this->assign("list", D("Product")->listProduct($page->firstRow, $page->listRows,$map));
        $this->assign("catlist", D("Product")->category());
        $this->display('index');
    }
    public function endList(){
        $M = M("Product");
        //过滤
        $s=array('0','1');
        if($title=I('get.title'))$map['title']=array('like',"%{$title}%");
        if(in_array(I('get.status'),$s))$map['status']=I('get.status');
        if($cid=I('get.cid'))$map['cid']=$cid;
        if(in_array(I('get.is_recommend'),$s))$map['is_recommend']=I('get.is_recommend');
        $map['sale'] = 1;
        $map['end_time'] = array('elt',time());
        $count = $M->where($map)->count();

        $page = new \Think\Page($count,12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $this->assign("list", D("Product")->listProduct($page->firstRow, $page->listRows,$map));
        $this->assign("catlist", D("Product")->category());
        $this->display('index');
    }

    //待支付订单
    public function waitPayOrder(){
        $M = M("Product_order");
        $where['status'] = 0;
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }
        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待支付';
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //待发货订单
    public function waitDeliveryOrder(){
        $M = M("Product_order");
        $where['status'] = 2;
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }
        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待发货';
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //待确认订单
    public function waitReallyOrder(){
        $M = M("Product_order");
        $where['status'] = 3;
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }
        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待确认';
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //待退款订单
    public function waitRefundOrder(){
        $M = M("Product_order");
        $where['status'] = 4;
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }
        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待退款';
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //已成功订单
    public function successOrder(){
        $M = M("Product_order");
        $where['status'] = 5;
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }

        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '交易完成';
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //已失效订单
    public function errorOrder(){
        $M = M("Product_order");
        $where['status'] = array('IN','1,6,7');
        if(I('get.oid') != null){
            $where['oid'] = I('get.oid');
        }
        if(I('get.username') != null){
            $username_where['username'] = array('like','%'.I('get.username').'%');
            $username_id = M('Member_address')->where($username_where)->getField('id',true);
            $where['aid'] = array('IN',implode(',',$username_id));
        }
        $where['order_status'] = 2;
        $count      = $M->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,status,published,status,alipay_id';
        $list = $M->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('status')->field($field)->select();
        //组装购买用户
        foreach($list as $k=>$v){
            $list[$k]['username'] = M('Member_address')->where('id= '.$v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= '.$v['aid'])->getField('phone');
            $list[$k]['nickname'] =M('Member')->where('uid = '.$v['uid'])->getField('nickname');
            switch($v['status']){
                case '1':
                    $list[$k]['statusHtml'] = '订单已取消';
                    break;
                case '6':
                    $list[$k]['statusHtml'] = '订单已退款';
                    break;
                case '7':
                    $list[$k]['statusHtml'] = '订单已过期';
                    break;
                default:
                    $list[$k]['statusHtml'] = '订单已失效';
                    break;
            }
        }

        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('Product:order');
    }

    //管理订单信息
    public function orderEdit(){
        if(IS_POST){
            $data = I('post.info');
            $addressData = I('post.address');
            if(M('Member_address')->where('id = '.$data['aid'])->save($addressData) || M('Product_order')->where('id = '.I('get.id'))->save($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'操作成功!','url'=>$url));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
            }
        }else{
            if(I('get.id') == null){
                $this->error('操作失败!');
                exit;
            }
            $info = M()
                ->table(
                    array(
                        C('DB_PREFIX').'product_order'=>'o',
                        C('DB_PREFIX').'member'=>'m',
                        C('DB_PREFIX').'member_address'=>'a',
                        C('DB_PREFIX').'product'=>'p'
                    )
                )
                ->where("o.id = ".I('get.id').' AND a.id=o.aid AND o.uid=m.uid')
                ->field('o.aid,o.t_why,o.t_content,o.t_phone,o.t_username,a.phone,a.postcode,a.address,a.shen_cityname,a.shi_cityname,a.xian_cityname,o.oid,a.username,m.nickname,o.pro_id,o.delivery,o.invoice,o.total_money,o.total_credit,o.present,o.freight,o.status,o.content,o.order_ip,o.published,o.update_time,o.fee_name,o.fee_kid,o.fee_code,o.old_status')
                ->find();
            //组合订单详情信息
            $info['total_credit'] = $info['total_credit'] == 0?'无可赠积分':$info['credit'];
            $info['freight'] = $info['freight'] == 0 ?'免运费': $info['freight'];
            $info['published'] = date('Y-m-d H:i:s',$info['published']);
            $info['update_time'] = date('Y-m-d H:i:s',$info['update_time']);
            $p_where['id'] = array('IN',$info['pro_id']);
            $productList = M('Product')->where($p_where)->field('id,title')->select();
            $this->assign('productList',$productList);
            $this->assign('info',$info);
            $this->display('Product:orderEdit');
        }
    }
    public function deliveryEdit(){
        $id = I('get.id');
        $info = M('Product_order')->where('id = '.$id)->field('oid,alipay_id,fee_name,fee_kid')->find();
        if(IS_POST){
            if(I('post.fee_code') == null || I('post.fee_kid') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'物流公司或者订单或不能为空!'));
                exit;
            }else{
                $fee_name = M('Kuaidi')->where("code = '".I('post.fee_code')."'")->getField('name');
                if(!empty($fee_name)){
                    $data['status'] = 3;
                    $data['update_time'] = time();
                    $data['fee_name'] = $fee_name;
                    $data['fee_code'] = I('post.fee_code');
                    $data['fee_kid'] = I('post.fee_kid');
                    if(M('Product_order')->where('id = '.$id)->save($data)){
                        $this->ajaxReturn(array('status'=>1,'info'=>'数据同步成功,您已成功发货!','url'=>U(CONTROLLER_NAME.'/'.ACTION_NAME)));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'数据同步失败,站内数据未更新!'));
                    }
                }else{
                     $this->ajaxReturn(array('status'=>0,'info'=>'数据同步失败,站内数据未更新!'));
                }
            }
        }else{
            $this->assign('list',M('Kuaidi')->select());
            $this->assign('info',$info);
            $this->display('Product:deliveryEdit');
        }
    }
    //改变订单状态
    public function changeOrderStatus(){
        if(IS_AJAX){
            if(IS_POST){
                $old_status = M('Product_order')->where('id = '.I('post.obj'))->getField('old_status');
                switch(I('post.type')){
                    //执行同意退款申请
                    case 'agreedRefund':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>6,'sq_status'=>2,'update_time'=>time()))){
						$orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
							M('Member')->where('uid = '.$orderInfo['uid'])->setDec('money',$orderInfo['total_money']+$orderInfo['freight']);
							M('Member')->where('uid = '.$orderInfo['uid'])->setDec('credit',$orderInfo['total_credit']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'该订单已经成功设置为退款状态!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //执行拒绝退款申请
                    case 'refusedRefund':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>$old_status,'sq_status'=>0,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'该订单已拒绝退款!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //执行取消订单
                    case 'cancelOrder':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>1,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功取消该订单!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //设置为已支付
                    case 'setOrderToPay':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>2,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功设置为已支付状态!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //设置为已发货
                    case 'setOrderToDelivery':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>3,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功设置为已发货状态!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //设置为已收货
                    case 'setOrderReally':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>5,'update_time'=>time()))){
						$orderInfo = M('Product_order')->where('id = '.I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('money',$orderInfo['total_money']+$orderInfo['freight']);
							M('Member')->where('uid = '.$orderInfo['uid'])->setInc('credit',$orderInfo['total_credit']);
                            $this->ajaxReturn(array('status'=>1,'info'=>'您已成功设置为已收货状态!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    //执行作废订单
                    case 'invalidOrder':
                        if(M('Product_order')->where('id = '.intval(I('post.obj')))->setField(array('status'=>7,'update_time'=>time()))){
                            $this->ajaxReturn(array('status'=>1,'info'=>'该订单已经作废!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败,请重试!'));
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status'=>0,'info'=>'您的指令系统无法识别,请重试!'));
                        break;
                }
                $this->ajaxReturn(array('status'=>1,'info'=>I('post.status')));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'访问失败!'));
            }
        }else{
            $this->error('访问失败!');
        }
    }
}
?>