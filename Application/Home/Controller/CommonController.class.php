<?php
    namespace Home\Controller;
    use Think\Controller;
    use Wap\Controller\BaseController;

    header('content-type:text/html;charset=utf-8');
class CommonController extends BaseController{
/*Common variable Start*/
/**/public $arr = array();
/*Common Variable End*/
    public function __construct(){
        parent::__construct();
        if(!empty($_SESSION['member']) && CONTROLLER_NAME == 'Member' && ACTION_NAME != 'logout'){
            header('Location:'.__ROOT__.'/Member');
            exit;
        }

        //面包屑
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
            case 'newsInfo':
                $id = I('get.id');
                $seo = M('News')->where('id = '.$id)->field('keywords,description')->find();
                break;
            case 'msDetail':
                $this->assign('mianBaoXie',$this->mianBaoXieNav($_GET['ms']));
                $seo = M('Product')->where('id = '.$_GET['ms'])->field('keywords,description')->find();
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

    public function check_code(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 25;
        $Verify->length   = 4;
        $Verify->useImgBg = true;
        $Verify->fontttf = '4.ttf';
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
/* * * * * * * * * * * * * * * * * * * * * * * * * *
 * @param {QueryTitleName Data}                    *
 * @param Success Return String                    *
 * @param Error Return False OR Null               *
 * @param $id is wait Query Data id                *
 * @param $info_id is wait Query Dynamic Data id   *
 * @param $table is wait Query Data Table name     *
 * Todo::....                                      *
 * * * * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QueryTitleName($id,$info_id,$table){
        if($id == null && $info_id == null && $table == null && CONTROLLER_NAME == 'Index'){
            return C('SITE_INFO.name');
        }else if($id != null && $id !='' && $table ==null){
            return M('nav')->where('id = '.$id)->getField('nav_name').' - '.C('SITE_INFO.name');
        }else if($info_id != null && $id == null && $table !== null){
            return M($table)->where('id = '.$info_id)->getField('title').' - '.C('SITE_INFO.name');
        }else{
            return false;
            //Todo...
        }

    }
/* * * * * * * * * * * * * * * * * * * * * * *
 * @param {Query Dynamic Data}               *
 * @param Success Return $info Array         *
 * @param Error Return False OR Null         *
 * @param $id is Wait Query Data id          *
 * @param $field is wait Query Data Field    *
 * @param $table is wait Query Tables        *
 * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QueryDynamicData($id,$table,$field,$img){
        if(empty($id) || empty($table)){
            return false;
        }else{
            if(empty($field)){
                $info[] = M($table)
                    ->where('id = '.$id)
                    ->find();
            }else{
                $info = M($table)
                    ->where('id = '.$id)
                    ->Field($field)->select();
            }
            if($img != null){
                foreach($info as $k=>$v){
                    $where['id'] = array('exp',"IN({$v['image_id']})");
                    $img_list = M('images')->where($where)->Field('savepath')->select();
                    foreach($img_list as $key=>$val){
                        $img_list[$key] = $val['savepath'];
                    }
                    $info[$k]['savepath'] = $img_list;
                }
            }
           return $info;
        }
    }
/* * * * * * * * * * * * * * * * * * * * * * *
 * @param {Query Page Data}                  *
 * @param Success Return $page Array         *
 * @param Error Return false OR Null         *
 * @param $page_tag is wait Query unique_id  *
 * @param $field is wait Query Field         *
 * @param $model is TableName                *
 * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QueryPageData($page_tag,$model,$field,$img= '1'){
        if($page_tag == null || $page_tag == ''){
            return false;
        }else{
            if(empty($model)){
                if($field == null || $field == ''){
                    $page[] = M()->table(array(C('DB_PREFIX').'nav'=>'n',C('DB_PREFIX').'page'=>'p'))->where("p.id=n.guide AND n.tag = '{$page_tag}' AND p.display = 1")->limit(1)->find();
                }else{
                    $page = M()->table(array(C('DB_PREFIX').'nav'=>'n',C('DB_PREFIX').'page'=>'p'))->where("p.id=n.guide AND n.tag = '{$page_tag}' AND p.display = 1")->limit(1)->Field($field.',image_id')->select();
                }
            }else{
                if($field == null || $field == ''){
                    return $page[] = M($model)->select();
                }else{
                    return $page = M($model)->Field($field)->select();
                }
            }
            if($img != null && $model == null){
                foreach($page as $k=>$v){
                    $where['id'] = array('exp',"IN({$v['image_id']})");
                    $img_list = M('images')->where($where)->Field('savepath')->select();
                    foreach($img_list as $key=>$val){
                        $img_list[$key] = $val['savepath'];
                    }
                    $page[$k]['savepath'] = $img_list;
                }
            }
            return $page;
        }
    }
/* * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @param {Query paging Data}                          *
 * @param Success Return Array(list and show)          *
 * @param Error Return False OR null                   *
 * @param $tag is wait Query Data tag                  *
 * @param $table is wait Query Data Query condition    *
 * @param $int is wait Query Data Num                  *
 * @param $img is or no Query IMG Data                 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QueryPagingData($tag,$table,$int,$field,$img,$order){
        import('ORG.Util.Page2');
        $count = M()->table(array(
            C('DB_PREFIX').'nav'=>'n',
            C('DB_PREFIX').'category'=>'c',
            C('DB_PREFIX').$table=>'t'
        ))
            ->where("t.status = 1 AND n.tag ='{$tag}' AND t.cid = n.guide AND c.cid = n.guide AND t.status = 1")
            ->count();
        $Page       = new \Think\Page2($count,$int);
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('prev','«');
        $Page->setConfig('next','»');
        $show       = $Page->show();
        if(empty($field)){
            if($table == 'news'){
                $list = M()->table(array(
                    C('DB_PREFIX').'nav'=>'n',
                    C('DB_PREFIX').'category'=>'c',
                    C('DB_PREFIX').$table=>'t'
                ))
                    ->where("t.cid=n.guide AND t.cid=c.cid AND n.tag= '".$tag."' AND t.status =1 ")
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->order('published desc')
                    ->Field('
                        t.id,
                        t.cid,
                        t.title,
                        t.keywords,
                        t.description,
                        t.status,
                        t.summary,
                        t.published,
                        t.update_time,
                        t.content,
                        t.click,
                        t.aid,
                        t.is_recommend,
                        t.image_id,
                        t.lang
                    ')
                    ->select();
            }else if($table == 'product'){
                $list = M()->table(array(
                    C('DB_PREFIX').'nav'=>'n',
                    C('DB_PREFIX').'category'=>'c',
                    C('DB_PREFIX').$table=>'t'
                ))
                    ->where("t.cid=n.guide AND t.cid=c.cid AND n.tag= '".$tag."' AND t.status =1 ")
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->order($order == null ? 'published desc' : $order)
                    ->Field('
                        t.id,
                        t.cid,
                        t.title,
                        t.price,
                        t.image_id,
                        t.keywords,
                        t.description,
                        t.status,
                        t.summary,
                        t.published,
                        t.update_time,
                        t.content,
                        t.lang,
                        t.aid,
                        t.click,
                        t.is_recommend,
                        t.wap_display
                    ')
                    ->select();
            }

        }else{
            $list = M()->table(array(
                C('DB_PREFIX').'nav'=>'n',
                C('DB_PREFIX').'category'=>'c',
                C('DB_PREFIX').$table=>'t'
            ))
                ->where("t.cid=n.guide AND t.cid=c.cid AND n.tag= '".$tag."' AND t.status =1 ")
                ->limit($Page->firstRow.','.$Page->listRows)
                ->order($order == null ? 'published desc' : $order)
                ->Field($field)
                ->select();
        }
        if($img != null){
            foreach($list as $k=>$v){
                $where['id'] = array('exp',"IN({$v['image_id']})");
                $img_list = M('images')->where($where)->Field('savepath')->select();
                foreach($img_list as $key=>$val){
                    $img_list[$key] = $val['savepath'];
                }
                $list[$k]['savepath'] = $img_list;
            }
        }
        if(is_array($list) && $list != null){
            return array(
                'list' => $list,
                'show' => $show,
            );
        }else{
            return false;
        }
    }
/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @param {Query seo Data}                           *
 * @param Success Return Array                       *
 * @param Error Return False OR null                 *
 * @param $id is wait Query Data id                  *
 * @param $table is wait Query Data Table name       *
 * @param if $id && $table is null Query Index seo   *
 * * * * * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QuerySeoData($tag,$list_id,$table){
        if($table == null && $tag == null && $list_id == null){
            return $seo[] = array(0=>array('keywords'=>C('SITE_INFO.keyword'),'description'=>C('SITE_INFO.description')));
        }else if($tag != null && $table == null){
            return $seo = M('nav')->where("tag = '{$tag}'")->Field('keywords,description')->select();
        }else if($tag == null && $list_id != null && $table != null){
            return $seo = M($table)->where('id='.$list_id)->Field('keywords,description')->select();
        }else{
            return false;
        }
    }
/* * * * * * * * * * * * * * * * * * * * * * * * * *
 * @param {Query Parent Class Data}                *
 * @param Success Return Query pid = 0 End         *
 * @param Error Return false OR null               *
 * @param $id is wait Query data id                *
 * @param $table is wait Query data Table Name     *
 * @param $table == null Query Nav Data            *
 * * * * * * * * * * * * * * * * * * * * * * * * * */
    protected function _QueryAddressData($id,$table){

        if($id == null || $id == ''){
            return false;
        }else{
            if($table == null || $table == ''){
                if($id == 0){
                    return false;
                }else{
                    $pid = M('nav')->where('id = '.$id)->getField('parent_id');
                    if($pid != 0){
                        $this->_QueryAddressData($pid,null);
                        $now_array = M('nav')->where(' id = '.$id)->Field('id,parent_id,                    tag,nav_name')->select();
                        $now_array[0]['tag'] = CONTROLLER_NAME.'/'.$now_array[0]['tag'];
                        $this->arr[] = $now_array;
                    }else{
                        $this->arr[] = M('nav')->where(' id = '.$id)->Field('id,parent_id,                    tag,nav_name')->select();
                    }
                }
            }else if($id != null && $table != null){
                if($id == 0){
                    return false;
                }else{
                    $cid = M($table)->where('id = '.$id)->getField('cid');
                    $nav = M('nav')->where('guide = '.$cid)->Field('id,parent_id,guide')->select();
                    if($nav[0]['parent_id'] != 0){
                        $this->_QueryAddressData($nav[0]['parent_id'],null);
                        $now_array = M('nav')->where(' id = '.$nav[0]['id'])->getField('id,parent_id,tag,nav_name');
                        $now_array[0]['tag'] = CONTROLLER_NAME.'/'.$now_array[0]['tag'];
                        $this->arr[] = $now_array;
                    }else{
                        $this->arr[] = M('nav')->where(' id = '.$nav[0]['id'])->getField('id,parent_id,                    tag,nav_name');
                    }
                }
            }else{
                //Todo ...
            }
        }
        return $this->arr;
    }
/*
 * @param Todo...
 * */
    protected function _GetAd($tag,$limit,$order){
        return M('ad')->where("position = '{$tag}'")->limit($limit)->order($order)->select();
    }
/* * * * * * * * * * * * * * * * *
 * @param {SecureCheck}          *
 * @param Success Return Null    *
 * @param Error Return Warning   *
 * * * * * * * * * * * * * * * * */
    protected function _SecureCheck($info){
        if(empty($info)){
            $info = '操作失败,请使用正常手段浏览本站！';
        }
        if(!preg_match('/(.html){1}/',$_SERVER['PHP_SELF'])){
            $this->error($info);
            exit;
        }
    }

    protected function _QueryDays($month,$year) {
        switch ($month) {
            case 4 :
            case 6 :
            case 9 :
            case 11 :
                $days = 30;
                break;
            case 2 :
                if ($year % 4 == 0) {
                    if ($year % 100 == 0) {
                        $days = $year % 400 == 0 ? 29 : 28;
                    } else {
                        $days = 29;
                    }
                } else {
                    $days = 28;
                }
                break;

            default :
                $days = 31;
                break;
        }
        return $days;
    }

	public function seo($arr){
        $seo=M('seo');
        $where_seo['weizhi']=$arr;
        $seo_info=$seo->where($where_seo)->find();
        $this->seo=$seo_info;
    }

    public function shoppingCart(){
        if($_SESSION['member'] == null){
            $_SESSION['login_url'] = I('post.login_url');
            $this->ajaxReturn(array('status'=>2,'info'=>'您还没有登录,是否需要登录?','url'=>U('/Login')));
            exit;
        }
        if(IS_AJAX){
            if(IS_POST){
                $info = M('Product')->where('status = 1 AND id = '.I('post.obj'))->Field('id,price,title,credit,image_id,stock,market,present')->find();
                if(!$info){
                    $this->ajaxReturn(array('status'=>0,'info'=>'购买的商品不存在!'));
                    exit;
                }

                if($info['stock'] - I('post.num') < 0){
                    $this->ajaxReturn(array('status'=>2,'info'=>'该商品库存不足,是否浏览其他商品?','url'=>U('/shop')));
                    exit;
                }

                if($proNum = M('Product_cart')->where('pro_id = '.$info['id'].' AND uid = '.$_SESSION['member']['uid'].' AND status = 0')->getField('num') != null){
                    if(I('post.type') == 'm'){
                        $this->ajaxReturn(array('status'=>0,'info'=>'秒杀商品不可重复加入购物车!'));
                        exit;
                    }else{
						if($proNum + I('post.num') > $info['stock']){
							$this->ajaxReturn(array('status'=>2,'info'=>'该商品库存不足,是否浏览其他商品?','url'=>U('/shop')));
							exit;
						}
                        $status = M('Product_cart')->where('pro_id = '.$info['id'].' AND uid = '.$_SESSION['member']['uid'])->setInc('num',I('post.num'));
                        $add_status = 'update';
                    }
                }else{
                    //组合商品信息
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
                    $data['id'] = $status = M('Product_cart')->add($data);
                    $add_status = 'add';
                }

                if($status){
                    $data['url'] = U('/detail').'?'.md5('Goods').'='.base64_encode($info['id']);
                    $data['title2'] = mb_substr($data['title'],0,14,'UTF-8').'...';
                    $data['img'] = __ROOT__.$data['img'];
                    $data['del_url'] = "'".U('Common/delBuyCart')."'";
                    $content = ($add_status == 'update') ? I('post.num') : $data;
                    $this->ajaxReturn(array('status'=>1,'info'=>'商品添加成功!','content'=>$content));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'商品添加失败!'));
                }
            }
        }
    }

    public function delBuyCart(){
        if($_SESSION['member'] == null){
            $_SESSION['login_url'] = I('post.login_url');
            $this->ajaxReturn(2);
            exit;
        }
        if(IS_POST){
            if(M('Product_cart')->where('id = '.intval(I('post.obj').' uid = '.$_SESSION['member']['uid']))->delete()){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(2);
            }
        }else{
            $this->ajaxReturn(2);
        }
    }

    public function addBuyNum(){
        if($_SESSION['member'] == null){
            $_SESSION['login_url'] = I('post.login_url');
            $this->ajaxReturn(array('status'=>0,'info'=>'操作无效!'));
            exit;
        }
        if(IS_AJAX){
            if(I('post.num') == null || I('post.obj') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'操作无效!'));
                exit;
            }
            if(M('Product_cart')->where('id = '.I('post.obj'))->getField('uid') != $_SESSION['member']['uid']){
                $this->ajaxReturn(array('status'=>0,'info'=>'您无权操作!'));
                exit;
            }
            if(($returnNum = M('Product')->where('id = '.M('Product_cart')->where('id = '.I('post.obj'))->getField('pro_id'))->getField('stock')) < I('post.num')){
                $this->ajaxReturn(array('status'=>0,'info'=>'该商品库存不足!','num'=>$returnNum));
                exit;
            }else{
                if(M('Product_cart')->where('id = '.I('post.obj'))->setField('num',I('post.num'))){
                $list = M('Product_cart')->where('uid = '.$_SESSION['member']['uid'])->select();
                //计算更新后后的金额总数
                foreach($list as $k=>$v){
                    $money += $v['price']*$v['num'];
                    $market += $v['market']*$v['num'];
                }
                $this->ajaxReturn(array('status'=>1,'info'=>$money,'info2'=>$market - $money));
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>'操作无效!'));
                }
            }
            
        }
    }
    function mianBaoXieNav($id){
        $arr = array();
        $mid = M('Nav')->where('guide ='.M('Product')->where('id = '.$id)->getField('mold_id'))->field('guide,nav_name,tag')->find();
        $arr[0] = array('nav_name'=>'首页','url'=>__ROOT__.'/');
        $arr[1] = $mid;
        $arr[1]['url'] = U('/'.$mid['tag']).'?Mid='.base64_encode($mid['guide']);
        $arr[2]['nav_name'] = M('Product')->where('id = '.$id)->getField('title');
        return $arr;
    }
}
