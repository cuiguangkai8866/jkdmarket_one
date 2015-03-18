<?php
    namespace Home\Controller;
    use Think\Controller;
class ShoplistController extends SystemController{
    public function __construct(){
        parent::__construct();

    }
    public function search(){
        if(I('get.search') != null){
            header('Location:'.U('/shop').'?'.$_SERVER['QUERY_STRING']);
        }else{
            $this->error('搜索失败...');
            exit;
        }
    }
    //列表页操作
    public function shop(){
        //判断是否存在值
        $where['auction'] = 0;
        $where['groupon'] = 0;
        $where['sale'] = 0;
        $where['status'] = 1;
        if(base64_decode(I('get.Mid')) != 0 && base64_decode(I('get.Mid')) != null){
            if(base64_decode(I('get.Mid')) == M('Category')->where("pid = 0 AND type = 'mold'")->order('sort asc')->limit(1)->getField('cid')){
                $tsWhere['mold_id'] = $Mid = base64_decode(I('get.Mid'));
                $tsWhere['is_lipin'] = 1;
                $tsWhere['_logic'] = 'OR';
                $where['_complex'] = $tsWhere;
            }else{
                $where['mold_id'] = $Mid = base64_decode(I('get.Mid'));
            }
        }else{
            //如果不存在搜索条件则列出所有商品
            if(I('get.search') == null){
                $allMid = M('Category')->where("type = 'mold' AND pid = 0")->order('cid asc')->getField('cid',true);
                $where['mold_id'] = array('IN',implode(',',$allMid));
            }
        }
        if(base64_decode(I('get.Gid')) != 0 && base64_decode(I('get.Gid')) != null){
            $where['cid'] = base64_decode(I('get.Gid'));
        }

        if(I('get.search') != null){
			//检测是否存在当前分类
			$searchWhere['name'] = array('like','%'.I('get.search').'%');
			$searchWhere['type'] = array('eq','mold');
			$searchWhere['pid'] = 0;
			$searchMoldCid = M('Category')->where($searchWhere)->getField('cid',true);
			//如果不存在搜索的分类
			if(empty($searchMoldCid)){
				//则按照商品名称匹配
				$where['title'] = array('like','%'.I('get.search').'%');
			}else{
				//否则组装当前搜索条件并列出当前搜索分类下的商品以及商品名称匹配的商品
				$map['title'] = array('like','%'.I('get.search').'%');
				$map['mold_id'] = array('exp','IN('.implode(',',$searchMoldCid).')');
				$map['_logic'] = 'OR';
				//与之前搜索条件合并
				$where['_complex'] = $map;
			}
        }

        //产品规格
        $guige = M('Category')->where("type='product' AND pid = 0")->order('sort')->Field('cid,pid,name')->select();
        //产品的分类
        $category = M('Category')->where("type='mold' AND pid = 0")->order('sort')->Field('cid,pid,name')->select();

        //如果是第一次加载，默认使用第一个分类的筛选条件
        $mold_pid = M('Category')->where('pid = '.$Mid)->Field('cid,name')->order('sort')->select();
        //发送类型父类
        $this->assign('mold_pid',$mold_pid);

        //查询mold_cid
        foreach($mold_pid as $k=>$v){
            if(base64_decode($_GET['Attr'.($k+1)]) != 0 && base64_decode($_GET['Attr'.($k+1)])!=null){
                $attr_id[] = "%,".base64_decode($_GET['Attr'.($k+1)]).",%";
            }
            $mold_cid[] = $v['cid'];
        }

        //判断是否存在参数
        if(!empty($attr_id)){
            $where['mold_cid'] = array('like',$attr_id,'AND');
        }

        //查询属性值
        $mold_where['pid'] = array('IN',implode(',',$mold_cid));
        $mold_cid = M('Category')->where($mold_where)->order('sort')->Field('pid,cid,name')->select();

        //搜索已发布
        $where['status'] = 1;

        //需要的字段
        $field = 'id,image_id,market,price,title,buy_num,present';
        $px = base64_decode(I('get.Px'));

        //排序条件
        if($px == null || $px == 'mr' || $px == 'new'){
            $order = 'id desc';
        }
        if($px == 'm1'){
            $order = 'price asc';
        }
        if($px == 'm2'){
            $order = 'price desc';
        }
        if($px == 'hot'){
            $order = 'buy_num desc';
        }
        if($px == 'moods'){
            $order = 'click desc';
        }
        $shopPage = $this->s_shopPage($where,$order,C('LISTNUM.shopList'),$field);
//        echo M('Product')->_sql();
		if(I('get.search') != null){
			if(empty($shopPage['list'])){
				$emptyWhere['status'] = 1;
				$emptyWhere['sale'] = 0;
				$emptyWhere['groupon'] = 0;
				$emptyWhere['auction'] = 0;
				if(I('get.Mid') != null){
					$emptyWhere['mold_id'] = base64_decode(I('get.Mid'));
				}
				$list = M('Product')->where($emptyWhere)->order('rand()')->limit('70')->field($field)->Select();
				$this->listStatus = 1;
			}else{
				$list = $shopPage['list'];
			}
		}else{
			$list = $shopPage['list'];
		}
        
        $show = $shopPage['show'];
        $count = $shopPage['count'];
        //echo M('Product')->_sql();
        //扩展组合
        foreach($list as $k=>$v){
            $img = explode(',',$v['image_id']);
            //组合图片
            $list[$k]['img_path'] = M('Images')->where('id = '.$img[0])->getField('savepath');
            //组合评论数
            $list[$k]['comment'] = M('Product_comment')->where('id = '.$v['id'])->count();
        }


        //发送mold_cid
        $this->assign('mold_cid',$mold_cid);
        $this->assign('guige',$guige);
        $this->assign('category',$category);
        $this->assign('list',$list);
        $this->assign('show',$show);
        $this->assign('count',$count);
        $this->assign('title','商品列表-'.C('SITE_INFO.name'));
        $this->display();
    }
    //详情页操作
    public function detail(){
        $Goods_id = (base64_decode($_GET[md5('Goods')]));
        $this->collect = M('Product_collect')->where('pro_id = '.$Goods_id.' AND uid = '.$_SESSION['member']['uid'])->find();
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
            if(I('post.type') == 'addcommect'){
                if($this->collect != null){
                    $this->ajaxReturn('您已收藏过该商品!');
                    exit;
                }
                if($_SESSION['member'] == null){
                    $this->ajaxReturn('请登录后再收藏!');
                    exit;
                }

                $data['pro_id'] = $Goods_id;
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
            $productInfo = M('Product')->where('id= '.$Goods_id)->setInc('click');
            if($Goods_id == null || $productInfo == null || $productInfo == false){
                $this->error('非法操作...！');
                exit;
            }
            $info = M('Product')->where('id = '.$Goods_id)->find();
            //设置分类 -- 对比导航栏
            $_GET['Mid'] = base64_encode($info['mold_id']);
            //组装商品规格
            $info['cname'] = M('Category')->where('cid = '.$info['cid'])->getField('name');
            //组装商品图片
            $img_where['id'] = array('IN',$info['image_id']);
            $info['savepath'] = M('Images')->where($img_where)->Field('savepath')->select();
            //查询人气排行
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
            //设置添加购物车成功失败列表数据
            $cart = M('Product')->where('status = 1'.' AND sale =0 AND groupon = 0 AND auction = 0')->order('buy_num desc')->limit(4)->Field('id,title,price,image_id')->select();
            //组装图片
            foreach($cart as $k=>$v){
                $cart_img = explode(',',$v['image_id']);
                $cart[$k]['savepath'] = M('Images')->where('id = '.$cart_img[0])->getField('savepath');
            }

            $this->assign('cart',$cart);

            //设置浏览历史
            $view_str = isset($_COOKIE['list'])?$_COOKIE['list']:'';//转换为数组
            if(!empty($view_str)){
                $view_arr = explode(',',$view_str);
            }else{
                $view_arr = array();
            }
            //将商品入数组
            array_unshift($view_arr,$Goods_id);
            //去除重复
            $view_arr = array_unique($view_arr);
            //取出六条历史记录
            $view_arr = array_slice($view_arr,0,10);
            //将数组拆分成字符串
            $cookie_str = implode(',',$view_arr);
            //把$cookie_str写到cookie
            setcookie('list',$cookie_str,time()+3600);
            //cookie写入完毕 炸开str
            $cookie_str = explode(',',$cookie_str);
            //获取历史数据
            foreach($cookie_str as $k=>$v){
                $cookie_strinfo = M('Product')->where('id = '.$v.' AND sale = 0 AND groupon = 0 AND auction = 0')->Field('id,image_id,title,price')->find();
                if(!empty($cookie_strinfo)){
                    $cookie[] = $cookie_strinfo;
                }
            }
            //组合历史记录图片
            $this->assign('cookie',$this->s_images($cookie,true,false));

            //重组产品参数
            $canshu = explode(',',$info['summary']);
            $this->assign('canshu',$canshu);
        }

        //计算评价总分
        $pList = M('Product_comment')->where('pro_id = '.$Goods_id)->getField('feel',true);
		if($pList == null){
			$pListNum = 0;
		}else{
			foreach($pList as $k=>$v){
				$pListNum += $a;
			}
		}
        
        $pCount = count($pList);
		if($pListNum == 0 && $pCount == 0){
			$this->pnum = 0;
		}else{
			$this->pnum = $pListNum/$pCount;
		}
        $this->commentnum = M('Product_comment')->where('pro_id = '.$Goods_id)->count();
        $this->assign('info',$info);
        $this->assign('title',$info['title']);
        $this->display();

    }
    //详情页咨询
    public function zixun(){
        $pro_id = I('get.pro_id');
        $User = M('Product_ask'); // 实例化User对象
        $count      = $User->where('pro_id = '.intval($pro_id))->count();// 查询满足要求的总记录数
        $Page       = new \Think\iframePage($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $User->where('pro_id = '.intval($pro_id))->order('update_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();$this->assign('list',$list);// 赋值数据集
        $this->assign('show',$show);// 赋值分页输出
        $this->assign('list',$list);
        $this->assign('count',$count);
        $this->display();
    }
    //购物车操作
    public function buycart(){
        if($_SESSION['member'] == null){
            $this->error('请先登录,正在跳转登录页...',U('/Login'),3);
            exit;
        }

        //猜你喜欢
        $loveList = M('Product')->where('status = 1 AND sale = 0 AND groupon = 0 AND auction = 0')->order('rand()')->limit(12)->Field('id,title,image_id,price')->select();
        //组合图片
        $this->assign('loveList',$this->s_images($loveList));

        //我的收藏
        $collect = M('Product_collect')->where('uid = '.$_SESSION['member']['uid'])->Field('pro_id,published')->select();
        foreach($collect as $k=>$v){
            $proinfo .= $v['pro_id'].',';
        }
        $collect_where['id'] = array('IN',trim($proinfo,','));
        $collect_pro = M('Product')->where($collect_where)->Field('id,title,image_id,price')->select();
        $this->assign('collect',$this->s_images($collect_pro));

        //浏览历史
        $cookie_where['id'] = array('IN',$_COOKIE['list']);
        $cookie_where['status'] = 1;
        $cookie_list = M('Product')->where($cookie_where)->Field('id,title,image_id,price')->select();
        $this->assign('cookie',$this->s_images($cookie_list));
        $this->assign('title','我的购物车');
        $this->returnBuyUrl = U('/shop').'?Mid='.base64_encode(M('Category')->where("pid = 0 AND type='mold'")->order('sort')->limit(1)->getField('cid'));
        $this->display();
    }
    //确认订单信息
    public function really(){
        if($_SESSION['member'] == null){
            $this->error('请先登录,正在跳转登录页...',U('/Login'),3);
            exit;
        }

        if(IS_POST){
            if(I('post.type') == 'reallyOrder'){
                if(rtrim(I('post.obj'),',') == null){
                    $this->ajaxReturn('请选择您要购买的商品!');
                    exit();
                }
                $pWhere['id'] = array('exp','IN('.rtrim(I('post.obj'),',').')');
                $proinfos = M('Product_cart')->where($pWhere)->field('pro_id,num,status')->select();
                if(empty($proinfos)){
                    $this->ajaxReturn('商品类型错误!');
                    exit();
                }else{
                    $errPro = array();
                    foreach ($proinfos as $k => $v) {
                        $proWhere['status'] = 1;
                        $proWhere['id'] = $v['pro_id'];
                        $proInfo = M('Product')->where($proWhere)->field('stock,title')->find();
                        if($v['num'] > $proInfo['stock']){
                            $errPro[] = '您购买的第 '.($k+1).' 件商品库存不足';
                        }
                    }
                    if(empty($errPro)){
                        $_SESSION['really_product'] = rtrim(I('post.obj'),',');
                        $this->ajaxReturn(1);
                    }else{
                        $this->ajaxReturn(implode("\n",$errPro));
                        exit();
                    }
                }
            }else if(I('post.type') == 'msOrder'){
                //组合商品信息
                $info = M('Product')->where('id = '.I('post.id'))->find();
                if($info['stock'] <= 0){
                    $this->error('您选购的商品库存不足!');
                    exit;
                }
                if($info['sale'] == 1){
                    if($info['start_time'] <= time() && $info['end_time'] >= time()){
                        //购物车生成
                        $img_ids = explode(',',$info['image_id']);
                        $img_path = M('Images')->where('id = '.$img_ids[0])->getField('savepath');
                        $data = array();
                        $data['img'] = $img_path == null ? '/Public/Home/images/no_goods.jpg':$img_path;
                        $data['title'] = $info['title'];
                        $data['price'] = $info['price'];
                        $data['num'] = I('post.num');
                        $data['credit'] = $info['credit'];
                        $data['uid'] = $_SESSION['member']['uid'];
                        $data['pro_id'] = $info['id'];
                        $data['published'] = time();
                        $data['present'] = $info['present'];
                        $data['market'] = $info['market'];
                        $_SESSION['really_product'] = M('Product_cart')->add($data);
                        if($_SESSION['really_product']){
                            header('Location:'.U('/really'));
                            exit;
                        }else{
                            $this->error('保存购物信息时出现严重性错误!');
                            exit;
                        }
                    }else{
                        $this->error('该商品状态不合法的!');
                    }
                }else{
                    $this->error('商品信息匹配失败!');
                    exit;
                }
            }else if(I('post.type') == 'tuanOrder'){
                //组合商品信息
                $info = M('Product')->where('id = '.I('post.id'))->find();
                if($info['stock'] <= 0){
                    $this->error('您选购的商品库存不足!');
                    exit;
                }
                if($info['start_time'] <= time() && $info['end_time'] >= time()){
                    $tuanWhere['pro_id'] = array('exp','IN('.I('post.id').')');
                    $tuanWhere['order_status'] = 3;
                    $isBuy = M('Product_order')->where($tuanWhere)->getField('id');
                    if(!empty($isBuy)){
                        $this->error('您已经参加过本次的团购!');
                        exit;
                    }
                }else{
                    $this->error('您所选择的团购商品不在开放时间内!');
                    exit;
                }
				if(I('post.num') < $info['zdbuy']){
					$this->error('对不起,本商品最低限购'.$info['zdbuy'].'件!');
					exit;
				}
				if(I('post.num') > $info['zgbuy']){
					$this->error('对不起,本商品最高限购'.$info['zgbuy'].'件!');
					exit;
				}
                if($info['groupon'] == 1){
                    if($info['start_time'] <= time() && $info['end_time'] >= time()){
                        //购物车生成
                        $img_ids = explode(',',$info['image_id']);
                        $img_path = M('Images')->where('id = '.$img_ids[0])->getField('savepath');
                        $data = array();
                        $data['img'] = $img_path == null ? '/Public/Home/images/no_goods.jpg':$img_path;
                        $data['title'] = $info['title'];
                        $data['price'] = $info['price'];
                        $data['num'] = I('post.num');
                        $data['credit'] = $info['credit'];
                        $data['uid'] = $_SESSION['member']['uid'];
                        $data['pro_id'] = $info['id'];
                        $data['published'] = time();
                        $data['present'] = $info['present'];
                        $data['market'] = $info['market'];
                        $_SESSION['really_product'] = M('Product_cart')->add($data);
                        if($_SESSION['really_product']){
                            header('Location:'.U('/really'));
                            exit;
                        }else{
                            $this->error('保存购物信息时出现严重性错误!');
                            exit;
                        }
                    }else{
                        $this->error('该商品状态不合法的!');
                    }
                }else{
                    $this->error('商品信息匹配失败!');
                    exit;
                }
            }
            if(empty($_SESSION['really_product'])){
                $this->error('请重新选择需要购买的商品!',U('/buycart'),3);
                exit;
            }
            //设置订单信息
            if(I('post.type') == 'setInvoice'){
                $_SESSION['orderInfo']['invoice'] = '发票抬头:'.I('post.title').'-'.'发票内容:'.I('post.content');
                if($_SESSION['orderInfo']['invoice']){
                    $this->ajaxReturn(array('status'=>1,'title'=>I('post.title'),'content'=>I('post.content')));
                }
            }
            if(I('post.type') == 'setInvoice'){
                $_SESSION['orderInfo']['invoice'] = I('post.obj');
            }
            if(I('post.type') == 'setAddress'){
                $_SESSION['orderInfo']['address'] = I('post.obj');
            }
            if(I('post.type') == 'setTimeInfo'){
                $_SESSION['orderInfo']['deliveryTime'] = I('post.obj');
            }
            //设置默认
            if(I('post.type') == 'status'){
                M('Member_address')->where('status = 1 AND uid = '.$_SESSION['member']['uid'])->setField('status',0);
                if(M('Member_address')->where('id = '.I('post.obj').' AND uid = '.$_SESSION['member']['uid'])->setField('status',1)){
                    $this->ajaxReturn(array('status'=>1,'info'=>'设置成功!'));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'操作失败!'));
                }
            }
            if(I('post.info') != null){
                $data = I('post.info');
                $data['uid'] = $_SESSION['member']['uid'];
                if(!is_array($data) || empty($data)){
                    $this->ajaxReturn(array('status'=>0,'info'=>'提交的数据为空'));
                    exit;
                }

                if($data['shen_cityname'] == '请选择省市/其他...' || empty($data['shen_cityname'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'请选择省份!'));
                    exit;
                }

                if($data['shi_cityname'] == '请选择城市...' || empty($data['shi_cityname'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'请选择城市!'));
                    exit;
                }

                if($data['xian_cityname'] == '请选择区/县...' || empty($data['xian_cityname'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'请选择县城!'));
                    exit;
                }

                if(!preg_match('/^[0-9]{6}$/',$data['postcode']) || empty($data['postcode'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'请填写邮政编码!'));
                    exit;
                }

                if(empty($data['address']) || !preg_match("/(\~|\!|\@|\#|\$|\%|\^|\&|\*|\<|\>|\[|\'|\"|\*|\`|\])/",$data['address'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'街道地址不合法或不能为空!'));
                    exit;
                }

                if(empty($data['username']) || preg_match("/^(\w)+$/",$data['username'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'收货人姓名不能为空并只能为中文!'));
                    exit;
                }

                if(!usedExp($data['phone'],'phoneExp')){
                    $this->ajaxReturn(array('status'=>0,'info'=>'手机号只能为11位数字,并格式正确!'));
                    exit;
                }

                if($data['id'] == null){
                    //执行添加新地址
                    if(M('Member_address')->add($data)){
                        $this->ajaxReturn(array('status'=>1,'info'=>'添加成功!','url'=>U('/really')));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
                    }
                }else{
                    //执行编辑地址
                    if(M('Member_address')->where('id = '.$data['id'].' AND uid = '.$data['uid'])->save($data)){
                        $this->ajaxReturn(array('status'=>1,'info'=>'更新成功!','url'=>U('/really')));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>'更新失败!'));
                    }
                }
            }
        }else{
            //加载收货地址
            $address = M('Member_address')->where('uid = '.$_SESSION['member']['uid'])->select();
            $this->assign('address',$address);
            //加载已选的商品
            $really_product_where['id'] = array('exp','IN('.$_SESSION['really_product'].')');
            $really_product = M('Product_cart')->where($really_product_where)->select();
            foreach($really_product as $k=>$v){
                $really_product[$k]['stock'] = M('Product')->where('id = '.$v['pro_id'])->getField('stock');
                $allMoney += $v['price']*$v['num'];
                $allCredit += $v['credit']*$v['num'];
            }
            if($allMoney <= 0){
                $this->error('对不起,订单金额不能小于0!',U('/shop'),2);
                exit;
            }
            //设置订单初始值
            if($_SESSION['orderInfo'] == null){
                //设置默认地址
                $_SESSION['orderInfo']['address'] = M('Member_address')->where('status = 1 AND uid = '.$_SESSION['member']['uid'])->getField('id');
                //设置默认配送时间
                $_SESSION['orderInfo']['deliveryTime'] = '不限时间';

                //设置默认发票信息
                $_SESSION['orderInfo']['invoice'] = '不开具发票';
            }
            //保存确认购买的商品
            $_SESSION['orderInfo']['reallyProduct'] = $_SESSION['really_product'];
            $_SESSION['orderInfo']['allMoney'] = $allMoney == null ? 0 : $allMoney;
            $_SESSION['orderInfo']['allCreidt'] = $allCredit == null ? 0 : $allCredit;
            $_SESSION['orderInfo']['freight'] = $allMoney < 100 ?10:0;
            //Todo .... freight wait ing...
            if(empty($really_product)){
                $this->error('确认商品信息失败!',U('/shop'),3);
                exit;
            }
            $this->assign('really_product',$really_product);
            $this->assign('title','确认订单信息');
            $this->display();
        }
    }
    //支付操作
    public function pay(){
        if(IS_POST){

        }else{
            if($_SESSION['member'] == null){
                $this->error('请先登录,正在跳转登录页...',U('/Login'),3);
                exit;
            }
            if(I('get.key') == null){
				
                if($_SESSION['orderInfo']['address'] == null || $_SESSION['orderInfo']['address'] == 0 || $_SESSION['orderInfo']['address'] == false){
                    $this->error('请设置您的收货地址!');
                    exit;
                }
				
                //生成订单信息
                $orderInfo = M('Product_cart')->where('status = 0 AND uid = '.$_SESSION['member']['uid'])->getField('id',true);
                if(preg_match('/'.$_SESSION['really_product'].'/',implode(',',$orderInfo))){
                    $order = $this->s_order(null);
					
					if(is_array($order) && !empty($order)){
						$orderSuccessWhere['id'] = array('exp','IN('.$_SESSION['really_product'].')');
						M('Product_cart')->where($orderSuccessWhere)->setField('status',1);
					}
                }else{
                    $order = $_SESSION['order'];
                }
            }else{
                $order = M('Product_order')->where('id = '.I('get.key').' AND uid = '.$_SESSION['member']['uid'])->field('id,oid,total_money,published,status,update_time,uid,freight')->find();
            }
			
            if(($order['uid'] == $_SESSION['member']['uid']) && ($order['status'] == 0) && ($order['published'] > (time() - (3600 *24 * 30 * 3)))){
				if(M('Product_order')->where("oid = '".$order['oid']."'")->getField('status') == 0){
					$this->assign('order',$order);
					$this->assign('title','订单支付');
					$this->display();
				}else{
					$this->error('当前订单状态不可支付!',U('/Member'),1);
					exit;
				}
                
            }else{
                $this->error('对不起,您无权操作!');
            }
        }
    }

    public function pingjia(){
        $pro_id = I('get.id');
        $User = M('Product_comment'); // 实例化User对象
        $count      = $User->where('pro_id = '.intval($pro_id))->count();// 查询满足要求的总记录数
        $Page       = new \Think\iframePage($count,7);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $User->where('pro_id = '.intval($pro_id))->order('update_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();$this->assign('list',$list);// 赋值数据集

        foreach($list as $k=>$v){
            $list[$k]['avatar'] = M('Member')->where('uid = '.$v['uid'])->getField('avatar_50');
            $nickname = mb_substr(M('Member')->where('uid = '.$v['uid'])->getField('nickname'),2,3,'UTF-8');
            $list[$k]['nickname'] = str_replace($nickname,'***',M('Member')->where('uid = '.$v['uid'])->getField('nickname'));
            $list[$k]['buytime'] = M('Product_order')->where('id = '.$v['oid'])->getField('published');
        }
        $this->assign('show',$show);// 赋值分页输出
        $this->assign('list',$list);
        $this->assign('count',$count);
        $this->display();
    }
}