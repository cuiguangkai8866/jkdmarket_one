<?php
    namespace Wap\Controller;
    use Think\Controller;
    class ShopController extends CommonController{
        public function __construct(){
            parent::__construct();
        }

        public function wapCate(){
            $cid = M('Nav')->where("tag = 'shop'")->order('sort')->getField('guide',true);
            $cateWhere['cid'] = array('exp','IN('.implode($cid,',').')');
            $cateList = M('Category')->where($cateWhere)->order('sort')->field('cid,name')->select();
            foreach($cateList as $k=>$v){
				$subCid = M('Category')->where('pid = '.$v['cid'])->order('sort asc')->limit(1)->getField('cid');
                $cateList[$k]['subList'] = M('Category')->where('pid = '.$subCid)->order('sort')->field('cid,name')->select();
            }
            $this->assign('cateList',$cateList);
            $this->assign('headName','商品分类');
			$this->assign('title','商品分类');
            $this->display();
        }

        public function wapShop(){
            //固定查询条件
            $wapShopWhere['status'] = 1;
            $wapShopWhere['sale'] = 0;
            $wapShopWhere['auction'] = 0;
            $wapShopWhere['groupon'] = 0;
            //返回的字段
            $field = 'id,image_id,title,price';

            //排序条件
            $px = I('get.Px');
            if($px == null || $px == 'hot'){
                $order = 'buy_num desc';
            }
            if($px == 'price'){
                $order = 'price asc';
            }
            if($px == 'click'){
                $order = 'click desc';
            }

            //get查询条件
            if(I('get.shopName') != null){
                $wapShopWhere['title'] = array('like',array('%'.I('get.shopName').'%','%'.I('get.shopName'),I('get.shopName').'%'));
            }
            if(I('get.Mid') != null){
                if(I('get.Mid') == M('Category')->where("pid = 0 AND type = 'mold'")->order('sort asc')->limit(1)->getField('cid')){
                    $tsWhere['mold_id'] = I('get.Mid');
                    $tsWhere['is_lipin'] = 1;
                    $tsWhere['_logic'] = 'OR';
                    $wapShopWhere['_complex'] = $tsWhere;
                }else{
                    $wapShopWhere['mold_id'] = array('eq',I('get.Mid'));
                }
                $headName = M('Category')->where('cid = '.I('get.Mid'))->getField('name');
                $this->assign('headName',$headName);
                $this->assign('title',$headName);
            }else{
                $this->assign('headName','商品列表');
                $this->assign('title','商品列表');
            }
            $shopList = $this->s_shopPage($wapShopWhere,$order,C('LISTNUM.wapShopList'),$field);
            $list = $this->s_images($shopList['list'],true);
            $show = $shopList['show'];

            $this->assign('list',$list);
            $this->assign('show',$show);
            $this->display();
        }

        public function wapDetail(){
            $id = I('get.Gid');

            if($id == null){
                echo '非法操作!';exit;
            }
            if(IS_POST){
                $info = M('Product')->where('id = '.I('post.obj').' AND groupon = 0 AND sale = 0 AND auction = 0')->find();
                if(!$info){
                    $this->ajaxReturn(array('status'=>3,'info'=>'数据不存在!'));
                    exit;
                }
                if(I('post.type') == 'addCart'){
                    if($_SESSION['member'] == null){
                        $this->ajaxReturn(array('status'=>3,'info'=>'您还没有登陆!','url'=>('/login')));
                        exit;
                    }
                    if($info['status'] == 0){
                        $this->ajaxReturn(array('status'=>3,'info'=>'您购买的商品属性是不合法的!'));
                        exit;
                    }
                    $cartId = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0 AND uid = '.$_SESSION['member']['uid'])->getField('id');
                    if($cartId != null && $cartId != false){
                        if(M('Product_cart')->where('pro_id = '.I('post.obj').' AND uid = '.$_SESSION['member']['uid'].' AND status = 0')->setInc('num',I('post.val'))){
                            $_SESSION['wapCartProId'] = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0')->getField('pro_id');
                            $this->ajaxReturn(array('status'=>1,'info'=>'当前购物车商品数量+'.I('post.val')));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
                        }
                    }else{
                        $img_ids = explode(',',$info['image_id']);
                        $img_path = M('Images')->where('id = '.$img_ids[0])->getField('savepath');
                        $data = array();
                        $data['img'] = $img_path == null ? '/Public/Home/images/no_goods.jpg':$img_path;
                        $data['title'] = $info['title'];
                        $data['price'] = $info['price'];
                        $data['num'] = I('post.val');
                        $data['credit'] = $info['credit'];
                        $data['uid'] = $_SESSION['member']['uid'];
                        $data['pro_id'] = $info['id'];
                        $data['published'] = time();
                        $data['present'] = $info['present'];
                        $data['market'] = $info['market'];
                        $_SESSION['wapCartId'] = $status = M('Product_cart')->add($data);
                        if($_SESSION['wapCartId'] >= 1){
                            $_SESSION['wapCartProId'] = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0')->getField('pro_id');
                            $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
                        }
                    }
                }
                if(I('post.type') == 'nowBuy'){
                    if($_SESSION['member'] == null){
                        $this->ajaxReturn(array('status'=>3,'info'=>'您还没有登陆!','url'=>U('/login')));
                        exit;
                    }
                    if($info['status'] == 0){
                        $this->ajaxReturn(array('status'=>3,'info'=>'您购买的商品属性是不合法的!'));
                        exit;
                    }
                    $cartId = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0 AND uid = '.$_SESSION['member']['uid'])->getField('id');
                    if($cartId != null && $cartId != false){
                        if(M('Product_cart')->where('pro_id = '.I('post.obj').' AND uid = '.$_SESSION['member']['uid'].' AND status = 0')->setInc('num',I('post.val'))){
                            $_SESSION['wapCartProId'] = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0')->getField('pro_id');
                            $this->ajaxReturn(array('status'=>1,'info'=>'即将跳转确认页...','url'=>U('/reallyOrder').'?Cp='.$cartId));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                    }else{
                        $img_ids = explode(',',$info['image_id']);
                        $img_path = M('Images')->where('id = '.$img_ids[0])->getField('savepath');
                        $data = array();
                        $data['img'] = $img_path == null ? '/Public/Home/images/no_goods.jpg':$img_path;
                        $data['title'] = $info['title'];
                        $data['price'] = $info['price'];
                        $data['num'] = I('post.val');
                        $data['credit'] = $info['credit'];
                        $data['uid'] = $_SESSION['member']['uid'];
                        $data['pro_id'] = $info['id'];
                        $data['published'] = time();
                        $data['present'] = $info['present'];
                        $data['market'] = $info['market'];
                        $_SESSION['wapCartId'] = $status = M('Product_cart')->add($data);
                        if($_SESSION['wapCartId'] >= 1){
                            $_SESSION['wapCartProId'] = M('Product_cart')->where('pro_id = '.I('post.obj').' AND status = 0')->getField('pro_id');
                            $this->ajaxReturn(array('status'=>1,'info'=>'即将跳转确认页...','url'=>U('/reallyOrder').'?Cp='.$status));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                    }
                }
                if(I('post.type') == 'favoriteAction'){
                    if($_SESSION['member'] == null){
                        $this->ajaxReturn(array('status'=>0,'info'=>'请先登录!'));
                        exit;
                    }
                    if(I('post.types') == 'addFavorite'){
                        if(M('Product_collect')->where('pro_id = '.I('post.obj'))->getField('id') != null){
                            $this->ajaxReturn(array('status'=>0,'info'=>'您已经收藏过啦!'));
                            exit;
                        }
                        $data['uid'] = $_SESSION['member']['uid'];
                        $data['pro_id'] = I('post.obj');
                        $data['published'] = $data['update_time'] = time();
                        if(M('Product_collect')->add($data)){
                            $this->ajaxReturn(array('status'=>1,'info'=>'收藏成功!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                    }elseif(I('post.types') == 'delFavorite'){
                        if(M('Product_collect')->where('pro_id = '.I('post.obj'))->getField('id') == null){
                            $this->ajaxReturn(array('status'=>0,'info'=>'您还没有收藏过!'));
                            exit;
                        }
                        if(M('Product_collect')->where('pro_id = '.I('post.obj'))->delete()){
                            $this->ajaxReturn(array('status'=>1,'info'=>'取消收藏成功!'));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                        }
                    }
                }
            }else{
                $info = M('Product')->where('id = '.$id.' AND groupon = 0 AND sale = 0 AND auction = 0')->find();
                $this->isFavorite = M('Product_collect')->where('pro_id = '.$id.' AND uid = '.$_SESSION['member']['uid'])->getField('id');
                //设置浏览历史
                $view_str = isset($_COOKIE['list'])?$_COOKIE['list']:'';//转换为数组
                if(!empty($view_str)){
                    $view_arr = explode(',',$view_str);
                }else{
                    $view_arr = array();
                }
                //将商品入数组
                array_unshift($view_arr,$id);
                //去除重复
                $view_arr = array_unique($view_arr);
                //取出六条历史记录
                $view_arr = array_slice($view_arr,0,10);
                //将数组拆分成字符串
                $cookie_str = implode(',',$view_arr);
                //把$cookie_str写到cookie
                setcookie('list',$cookie_str,time()+3600);

                //计算评论总数
                $this->count = M('Product_comment')->where('pro_id= '.$id)->count();
                $this->randList = $this->s_images(M('Product')->where('status =1 AND groupon= 0 AND sale = 0 AND auction = 0')->order('rand()')->limit(10)->field('id,image_id,title,price,market')->select(),true,false);
                $this->assign('info',$this->s_images($info,true,true));
                $this->assign('headName','商品详情');
                $this->assign('title',$info['title']);
                $this->display();
            }
        }

        public function comment(){
            $pro_id = I('get.id');
            $User = M('Product_comment');
            $count= $User->where('pro_id = '.intval($pro_id))->count();
            $Page = new \Think\wapIframePage($count,10);
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $Page->setConfig('theme','%UP_PAGE% %NOW_PAGE%/%TOTAL_PAGE% %DOWN_PAGE%');
            $show       = $Page->show();
            $list = $User->where('pro_id = '.intval($pro_id))->order('update_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();$this->assign('list',$list);
            foreach($list as $k=>$v){
                $list[$k]['avatar'] = M('Member')->where('uid = '.$v['uid'])->getField('avatar_50');
                $nickname = mb_substr(M('Member')->where('uid = '.$v['uid'])->getField('nickname'),2,3,'UTF-8');
                $list[$k]['nickname'] = str_replace($nickname,'***',M('Member')->where('uid = '.$v['uid'])->getField('nickname'));
                $list[$k]['buytime'] = M('Product_order')->where('id = '.$v['oid'])->getField('published');
            }
            $this->assign('show',$show);
            $this->assign('list',$list);
            $this->assign('count',$count);
            $this->display();
        }
    }
?>