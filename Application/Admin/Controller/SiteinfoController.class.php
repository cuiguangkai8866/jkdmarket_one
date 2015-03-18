<?php
/**
 * Created by PhpStorm.
 * User: cony
 * Date: 14-2-28
 * Time: 上午11:21
 */
namespace Admin\Controller;
use Think\Controller;
class SiteinfoController extends CommonController {
    /**
     * 菜单显示页面
     */
    public function index(){
        if(IS_POST){
            $act = $_POST['act'];
            $data = $_POST['data'];
            $data['nav_name'] = addslashes($data['nav_name']);
            $M = M("nav");
            if ($act == "edit") { //修改分类
//                var_dump($data['nav_name']);die;
                if (empty($data['nav_name'])) {
                    unset($data['nav_name']);
                }

                if ($data['parent_id'] == $data['id']) {
                    unset($data['parent_id']);
                }
                if($M->where('id='.$data['id'])->save($data)){
                    echo json_encode(array('status' => 1, 'info' => '菜单' . $data['nav_name'] . ' 已经成功更新', 'url' => U('Siteinfo/index', array('time' => time()))));
                }else{
                    echo   json_encode(array('status' => 0, 'info' => '菜单' . $data['nav_name'] . ' 更新失败'));
                }
                // return ($M->save($data)) ? json_encode(array('status' => 1, 'info' => '菜单 ' . $data['nav_name'] . ' 已经成功更新', 'url' => U('Siteinfo/index', array('time' => time())))) : array('status' => 0, 'info' => '菜单 ' . $data['nav_name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['parent_id'], $data['nav_name']);

                if($M->where('parent_id='.$data['id'].' AND id!='.$data['id'])->count()>0){
                    echo json_encode(array('status' => 0, 'info' => $data['nav_name'] . '存在下级分类，请先删除'));
                    exit;
                }

                if($M->where($data)->delete()){
                    echo json_encode(array('status' => 1, 'info' => '菜单' . $data['nav_name'] . ' 已经成功删除', 'url' => U('Siteinfo/index', array('time' => time()))));
                }else{
                    echo json_encode(array('status' => 0, 'info' => '菜单' . $data['nav_name'] . ' 删除失败'));
                }
                //return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '菜单 ' . $data['nav_name'] . ' 已经成功删除', 'url' => U('Siteinfo/index', array('time' => time()))) : array('status' => 0, 'info' => '菜单 ' . $data['nav_name'] . ' 删除失败');
            }
        }else{
            $cat = new \Org\Util\Category('Nav', array('id', 'parent_id', 'nav_name', 'fullname'));
            $this->assign("list", $cat->getList());
            $this->display();
        }
    }

    public function seoAdmin(){
        if(IS_AJAX){
            $data = I('post.data');
            if(M('Nav')->where('id = '.I('post.id'))->save($data)){
                echo json_encode(array('status' => 1, 'info' => 'SEO更新成功', 'url' => U('Siteinfo/seoAdmin')));
            }else{
                echo json_encode(array('status' => 0, 'info' => 'SEO更新失败!'));
            }
        }else{
            $cat = new \Org\Util\Category('Nav', array('id', 'parent_id', 'nav_name', 'fullname'));
            $this->assign("list", $cat->getList());
            $this->display();
        }
    }

    /**
     * 添加菜单
     */
    public function add_nav(){
        C('TOKEN_ON',false);
        if(IS_POST){
            $id=I('post.id');
            $data['lang']=I('post.lang');
            if(!$data['lang'])unset($data['lang']);
            $data['nav_name']=I('post.nav_name');
            $data['parent_id']=I('post.parent_id');
            $moduleguide=I('post.moduleguide');
            $data['type']=I('post.type');
            $data['sort']=I('post.sort');
            $data['target']=I('post.target');
            $data['tag'] = I('post.tag');
            $data['keywords'] = I('post.keywords');
            $data['title'] = I('post.title');
            $data['description'] = I('post.description');
            $mg=explode('-',$moduleguide);
            $data['module']=$mg[0];
            $data['guide']=$mg[1];
            foreach($data as $v){
                if($v==''){
                    echo json_encode(array('status' => 0, 'info' => '信息未填完整'));
                    return;
                }
            }
                if($data['module']=='link'){
                    $data['link']=I('post.link');
                }else{
                    if(!I('post.link'))
                    $data['link']=set_nav($data['module'], $data['guide']);
                    else
                    $data['link']=I('post.link');
                }
            $m_nav=M('nav');
            if($id){
                $map['id']=$id;
                if($m_nav->where($map)->save($data)){
                    echo json_encode(array('status' => 1, 'info' => '菜单' . $data['nav_name'] . ' 更新成功', 'url' => U('Siteinfo/index', array('time' => time()))));
                }else{
                    echo json_encode(array('status' => 0, 'info' => '菜单' . $data['nav_name'] . ' 更新失败'));
                }
            }else{
                if($m_nav->add($data)){
                    echo json_encode(array('status' => 1, 'info' => '菜单' . $data['nav_name'] . ' 添加成功', 'url' => U('Siteinfo/index', array('time' => time()))));
                }else{
                    echo json_encode(array('status' => 0, 'info' => '菜单' . $data['nav_name'] . ' 添加失败'));
                }
            }

        }else{
            if(intval($_GET['id'])){
                $M=M('nav');
                $map['id']=intval($_GET['id']);
                $info=$M->where($map)->find();
                $this->assign('info',$info);
            }

            $cat = new \Org\Util\Category('Nav', array('id', 'parent_id', 'nav_name', 'fullname'));
            $this->assign("list", $cat->getList());
//
//            $map2['type']='mold';
//            $pro = new \Org\Util\Category('Category', array('cid', 'pid', 'name', 'fullname'),$map2);
//            $this->assign("prolist", $pro->getList());
//
//            $map2['type']='n';
//            $art = new \Org\Util\Category('Category', array('cid', 'pid', 'name', 'fullname'),$map2);
//            $this->assign("artlist", $art->getList());

            $pagelist = new \Org\Util\Category('Page', array('id', 'parent_id', 'page_name', 'fullname'));
            $this->assign("pagelist", $pagelist->getList());
            $this->display();
        }
    }
    /**
     * user：cony
     * 单页列表
     */
    public function page(){
        $M = M("page");
        $count = $M->count();
        $page = new \Think\Page($count, 12);
        $showPage = $page->show();
        $list=$M->field('id,unique_id,page_name,display')->order('id desc')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign("page", $showPage);
        $this->assign("list",$list);
        $this->display();
    }

    /**
     * user：cony
     * 修改添加单页
     */
    public function add_page(){
        if(IS_POST){
            $m_page=M('page');
            $data=$_POST['info'];
            $map1['page_name']=$data['page_name'];
            if($data['lang'])$map2['lang']=$data['lang'];
            $map2['unique_id']=$data['unique_id'];
            if($data['id']){
                $map1['id']=$map2['id']=array('neq',$data['id']);
            }
            if(!$data['page_name'] or !$data['unique_id']){
                echo json_encode(array("status" => 0, "info" => "标题和别名不能为空"));
                exit;
            }
            if($m_page->where($map1)->count()>0){
                echo json_encode(array("status" => 0, "info" => "标题已经存在，请修改"));
                exit;
            }
            if($m_page->where($map2)->count()>0){
                echo json_encode(array("status" => 0, "info" => "同一种语言别名已经存在，请修改"));
                exit;
            }
            $image=I('post.image_1');
            if($data['id']){
                if($image){
                    if(is_array($image)){
                        $M_image = M("images");
                        $image_id=array();
                        foreach($image as $k=>$v){
                            $img_data['savepath']=$v;
                            $img_data['savename']=end(explode('/',$v));
                            $img_data['create_time']=time();
                            $img_data['catname']='news';
                            if($v)
                                $image_id[$k]=$M_image->add($img_data);
                        }
                        $data['image_id']=implode(',',$image_id);
                    }
                }
                if($m_page->where('id='.$data['id'])->save($data)){
                    echo json_encode(array("status" => 1, "info" => "修改单页成功",'url'=>U('Siteinfo/page')));
                }
            }else{
                if($image){
                    if(is_array($image)){
                        $M_image = M("images");
                        $image_id=array();
                        foreach($image as $k=>$v){
                            $img_data['savepath']=$v;
                            $img_data['savename']=end(explode('/',$v));
                            $img_data['create_time']=time();
                            $img_data['catname']='news';
                            if($v)
                                $image_id[$k]=$M_image->add($img_data);
                        }
                        $data['image_id']=implode(',',$image_id);
                    }
                }
                if($m_page->add($data)){
                    echo json_encode(array("status" => 1, "info" => "添加单页成功",'url'=>U('Siteinfo/page')));
                }
            }
        }else{
            $m_page=M('page');
            $map['id']=I('get.id');
            $info=$m_page->where($map)->find();
            if($info['image_id']){
                $image = M("images");
                $map['id']= array('in',$info['image_id']);
                $img_info = $image->where($map)->order('id asc')->select();
                $this->assign("img_info", $img_info);
            }
            $pagelist = new \Org\Util\Category('Page', array('id', 'parent_id', 'page_name', 'fullname'));
            $this->assign("pagelist", $pagelist->getList());

            $this->assign('info',$info);
            $this->display();
        }

    }

    /**
     * @return bool
     * 删除单页
     */
    public function delpage(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('page');
        if($M->where('parent_id='.$id.' AND id!='.$id)->count()>0){
            echo json_encode(array("status" => 0, "info" =>'删除失败,存在下级单页'));
            exit;
        }
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /**
     * 检查page_name是否重复
     */
    public function checkPageTitle() {
        $M = M("page");
        $where = "page_name='" . I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
        }
    }
    /**
     * 检查unique_id是否重复
     */
    public function checkPageUnique() {
        $M = M("page");
        $where = "unique_id='" . I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改别名"));
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
        }
    }
    /**
     * 广告图列表
     */
    public function adindex(){
        $M = M("ad");
        $count = $M->count();
        $page = new \Think\Page($count, 10);
        $showPage = $page->show();
        $list=$M->order('id desc')->limit("$page->firstRow, $page->listRows")->order('sort')->select();
        $this->assign("page", $showPage);
        $this->assign("list",$list);
        $this->display();
    }
    /**
     * 添加广告图
     */
    public function add_ad(){
        $this->assign('ad_category',M('Nav')->where('parent_id = '.M('Nav')->where('tag ='."'nav'")->getField('id'))->Field('id,tag,nav_name')->select());
        if(IS_POST){
            $data=$_POST['info'];
            $id=I('post.id');
            if($data['ad_name']==''){
                echo json_encode(array("status" => 0, "info" => "广告名称不能为空"));
                exit;
            }
            if($data['ad_link']!="#"){
                if(false===strpos($data['ad_link'],'http://') && false===strpos($data['ad_link'],'https://')){
                    echo json_encode(array("status" => 0, "info" => "链接格式不正确"));
                    exit;
                }
            }

            if($_FILES['ad_img']['name']){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->savePath  =      './picture/'; // 设置附件上传目录
                $upload->saveName = array('uniqid','');
                $upload->autoSub = false;
                $info   =   $upload->uploadOne($_FILES['ad_img']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{// 上传成功 获取上传文件信息
                    $data['ad_img']=$info['savename'];
                }
            }
            $m_ad=M('ad');
            if($id){
                $map['id']=$id;
                $ad=$m_ad->find($id);
                if($m_ad->where($map)->save($data)){
                    echo json_encode(array("status" => 1, "info" => "广告修改成功",'url'=>U('Siteinfo/adindex')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "广告修改失败"));
                    exit;
                }
            }else{
                if($m_ad->add($data)){
                    echo json_encode(array("status" => 1, "info" => "广告添加成功",'url'=>U('Siteinfo/adindex')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "广告添加失败"));
                    exit;
                }
            }
        }else{
            $m_page=M('ad');
            $map['id']=I('get.id');
            $info=$m_page->where($map)->find();


            $this->assign('info',$info);
            $pagelist = new \Org\Util\Category('Page', array('id', 'parent_id', 'page_name', 'fullname'));
            $this->shopAd = M('Nav')->where("tag = 'shop'")->field('nav_name')->select();
            $this->assign("pagelist", $pagelist->getList());
            $this->display();
        }
    }

    /**
     * 删除单条广告
     */
    public function delad(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('ad');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" =>0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }
    /**
     * 文件管理
     */
    public function file_index(){
        $this->display();
    }

    /*
     * 友情链接
     */
    public function link_index(){
        $M = M("link");
        $count = $M->count();
        $page = new \Think\Page($count, 12);
        $showPage = $page->show();
        $list=$M->order('id desc')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign("page", $showPage);
        $this->assign("list",$list);
        $this->display();

    }

    /**
     * 添加友情链接
     */
    public function add_link(){
        if(IS_POST){
            $data=$_POST['info'];
            $id=I('post.id');
            if($data['title']==''){
                echo json_encode(array("status" => 0, "info" => "链接名称不能为空"));
                exit;
            }
            if(false===strpos($data['link'],'http://') && false===strpos($data['link'],'https://')){
                echo json_encode(array("status" => 0, "info" => "链接格式不正确"));
                exit;
            }
            $m_ad=M('link');
            if($id){
                $map['id']=$id;
                $ad=$m_ad->find($id);
                if($m_ad->where($map)->save($data)){
                    echo json_encode(array("status" => 1, "info" => "链接修改成功",'url'=>U('Siteinfo/link_index')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "链接修改失败"));
                    exit;
                }
            }else{
                if($m_ad->add($data)){
                    echo json_encode(array("status" => 1, "info" => "链接添加成功",'url'=>U('Siteinfo/link_index')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "链接添加失败"));
                    exit;
                }
            }


        }else{
            $id=I('get.id');
            $map['id']=$id;
            $m_link=M('link');
            $info=$m_link->where($map)->find();
            $this->assign('info',$info);
            $this->display();
        }
    }

    /*
         * 删除链接
         */
    public function dellink(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('link');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /**
     * 留言信息
     */
    public function message(){
        if(IS_POST){
            if(I('post.content') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'回复的内容不能为空！'));
                exit;
            }
            $data['t_content'] = I('post.content');
            if(M('Message')->where('id = '.I('post.zid'))->save($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'回复成功!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'回复失败!'));
            }
        }else{
            $M = M("message");
            $count = $M->count();
            $page = new \Think\Page($count, 12);
            $showPage = $page->show();
            $list=$M->order('id desc')->limit("$page->firstRow, $page->listRows")->select();
            $this->assign("page", $showPage);
            $this->assign("list",$list);
            $this->display();
        }

    }

    /**
     * @return bool
     * 删除留言
     */
    public function delmessage(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('message');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /**
     * @return boo
     * 修改留言状态
     */
    public function changeMessageStatus(){
        $id=I('get.id');
        $m_message=M("message");
        $map['id']=$id;
        $status=$m_message->where($map)->getField('display');
        $data['display']=abs($status-1);
        if($m_message->where($map)->save($data)){
            echo json_encode(array("status" => 1, "info" => '<img src="Public/Img/action_'.$data['display'].'.png" border="0">'));
            exit;
        }
        return false;
    }


    public function zixun(){
        if(IS_POST){
            if(I('post.content') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'回复的内容不能为空！'));
                exit;
            }
            $data['ask_content'] = I('post.content');
            $data['status'] = 1 ;
            $data['update_time'] = time();
            if(M('Product_ask')->where('id = '.I('post.zid'))->save($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'回复成功!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'回复失败!'));
            }
        }else{
            $M = M("Product_ask");
            $count = $M->count();
            $page = new \Think\Page($count, 12);
            $showPage = $page->show();
            $list=$M->order('id desc')->limit("$page->firstRow, $page->listRows")->select();
            foreach($list as $k=>$v){
                $list[$k]['product'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            }
            $this->assign("page", $showPage);
            $this->assign("list",$list);
            $this->display();
        }
    }

    /**
     * @return bool
     * 删除留言
     */
    public function delzixun(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('Product_ask');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /**
     * 评价列表
    */
    public function pingjia(){
        if(IS_POST){
            if(I('post.content') == null){
                $this->ajaxReturn(array('status'=>0,'info'=>'回复的内容不能为空！'));
                exit;
            }
            $data['t_content'] = I('post.content');
            $data['update_time'] = time();
            if(M('Product_comment')->where('id = '.I('post.zid'))->save($data)){
                $this->ajaxReturn(array('status'=>1,'info'=>'回复成功!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'回复失败!'));
            }
        }else{
            $M = M("Product_comment");
            $count = $M->count();
            $page = new \Think\Page($count, 12);
            $showPage = $page->show();
            $list=$M->order('id desc')->limit("$page->firstRow, $page->listRows")->select();
            foreach($list as $k=>$v){
                $list[$k]['product'] = M('Product')->where('id = '.$v['pro_id'])->getField('title');
            }

            $this->assign("page", $showPage);
            $this->assign("list",$list);
            $this->display();
        }
    }

    /**
     * 删除评价
    */

    public function delpingjia(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('Product_comment');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /**
     * 标签管理
     */
    public function  tag_index(){
        $m_tag=M('tag');
        $count = $m_tag->count();
        $page = new \Think\Page($count, 12);
        $showPage = $page->show();
        $list=$m_tag->field('id,name,unique_id,lang')->order('id DESC')->select();
        $this->assign("page", $showPage);
        $this->assign("list",$list);
        $this->display();
    }


    /**
     * 添加修改标签
     */
    public function add_tag(){
        if(IS_POST){
            $m_tag=M('tag');
            $data['lang']=I('post.lang');
            $data['name']=I('post.name');
            $data['unique_id']=I('post.unique_id');
            $data['content']=$_POST['content'];
            $id=I('post.id');
            if(!$data['name']){
                echo json_encode(array("status" => 0, "info" => "名称不能为空"));
                exit;
            }
            $s['unique_id']=$data['unique_id'];
            if($data['lang'])$s['lang']=$data['lang'];else unset($data['lang']);
            $s['id']=array('neq',$id);
            if($m_tag->where($s)->count()>0){
                echo json_encode(array("status" => 0, "info" => "同一种语言标识不能重复，请修改"));
                exit;
            }
            if(!ctype_alpha($data['unique_id'])){
                echo json_encode(array("status" => 0, "info" => "标识须为全字母组合"));
                exit;
            }

            if($id){
                $map['id']=$id;
                if($m_tag->where($map)->save($data)){
                    echo json_encode(array("status" => 1, "info" => "更新成功",'url'=>U('Siteinfo/tag_index')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "更新失败"));
                    exit;
                }
            }else{

                if($m_tag->add($data)){
                    echo json_encode(array("status" => 1, "info" => "添加成功",'url'=>U('Siteinfo/tag_index')));
                    exit;
                }else{
                    echo json_encode(array("status" => 0, "info" => "添加失败"));
                    exit;
                }
            }
        }else{
            $m_tag=M('tag');
            $id=I('get.id');
            $info=$m_tag->where('id='.$id)->find();
            $this->assign('info',$info);
            $this->display();
        }
    }
    /**
     * 删除单条标签
     */
    public function deltag(){
        $id=I('get.id');
        if(!$id){
            return false;
        }
        $map['id']=$id;
        $M=M('tag');
        if($M->where($map)->delete()){
            echo json_encode(array("status" => 1, "info" =>'删除成功'));
        }else{
            echo json_encode(array("status" => 0, "info" =>'删除失败，可能是不存在该ID的记录'));
        }
    }

    /*
 * 创建模版标签
 */
    public function create_tag(){
        if(IS_POST){
            $list_type=I('post.list_type');
            $limit=I('post.limit');
            $type=I('post.type');
            $order=I('post.order');
            $content_type=I('post.content_type');
            $str='';
            if($list_type=='n'){$str.='<news ';}else{$str.='<product ';}
            if($limit){$str.=' limit="'.$limit.'" ';}else{
                json_encode(array("status" => 0, "info" =>'请填写显示数量' ));
            }
            if($type!='is_recommend'){$str.='order="'.$type.' '.$order.'" ';
                if($content_type){
                    $str.=' where="cid='.$content_type.'" ';
                }
            }else{
                if($content_type){
                    $str.=' where="is_recommend=1 AND cid='.$content_type.'" ';
                }else{
                    $str.=' where="is_recommend=1" ';
                }
                $str.='order="id '.$order.'"';
            }
            $str.=' >';
            $str.='<p>';
            if($list_type=='n'){$str.='{$new.id}-{$new.title}';}else{$str.='{$pro.id}-{$pro.title}';}
            $str.='</p>';
            if($list_type=='n'){$str.='</news>';}else{$str.='</product>';}
            echo json_encode(array("status" => 1, "info" =>$str));
        }
        else
        {
            $map['type']='n';
            $cat = new \Org\Util\Category('Category', array('cid', 'pid', 'name', 'fullname'),$map);
            $this->assign('newcat',$cat->getList());
            // return $cat->getList();               //获取分类结构
            $this->display();
        }
    }

    public function selectCat(){
        $map['type']=strval($_GET['t']);
        $cat = new \Org\Util\Category('Category', array('cid', 'pid', 'name', 'fullname'),$map);
        $cat=$cat->getList();
        $str='<option value="">全部</option>';
        foreach($cat as $vo){
            $str.='<option value="'.$vo['cid'].'">'.$vo['fullname'].'</option>';
        }
        echo json_encode(array("status" => 1, "info" => $str));
    }

	 public function seo() {
        $seo = M('seo');
        $arr = $seo->order('id')->select();
        $this->list = $arr;
        $this->display();
    }

    public function up_seo() {
		
        $seo = M('seo');
        if (IS_POST) {
            $data = $_POST['info'];
            $where['id'] = I('post.id');
            if ($seo->where($where)->save($data)) {
                    $this->success('修改成功', 'seo');
                } else {
                    //错误页面的默认跳转页面是返回前一页，通常不需要设置
                    $this->error('失败');
                }
        } else {
			
            $where['id'] = I('get.id');
			
            $arr = $seo->where($where)->find();
            $this->info = $arr;
            $this->display();
        }
    }

	public function kdIndex(){
		if(IS_POST){

		}else{
			$User = M('Kuaidi'); // 实例化User对象
			$count      = $User->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->order('published desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('list',$list);
			$this->display();
		}
	}

	public function addKdInfo(){
		$data = I('post.info');
		$info = M('Kuaidi')->where('id = '.I('get.id'))->find();
		if(I('get.id') == null){
			if(IS_POST){
				if($data['name'] == null || $data['code'] == null){
					$this->ajaxReturn(array('status'=>0,'info'=>'您的数据填写不完整!'));
					exit;
				}
				if(M('Kuaidi')->where("code = '".$data['code']."'")->getField('id') != null){
					$this->ajaxReturn(array('status'=>0,'info'=>'快递公司已存在!'));
					exit;
				}
				$data['published'] = $data['update_time'] = time();
				$data['uname'] = $_SESSION['my_info']['nickname'];
				if(M('Kuaidi')->add($data)){
					$this->ajaxReturn(array('status'=>1,'info'=>$data['name'].'添加成功!','url'=>U('Siteinfo/kdIndex')));
					exit;
				}else{
					$this->ajaxReturn(array('status'=>0,'info'=>$data['name'].'添加失败!'));
					exit;
				}
			}
		}else{
			if(IS_POST){
				if($data['name'] == null || $data['code'] == null){
					$this->ajaxReturn(array('status'=>0,'info'=>'您的数据填写不完整!'));
					exit;
				}
				$data['update_time'] = time();
				$data['uname'] = $_SESSION['my_info']['nickname'];
				if(M('Kuaidi')->where('id = '.I('get.id'))->save($data)){
					$this->ajaxReturn(array('status'=>1,'info'=>$data['name'].'修改成功!','url'=>U('Siteinfo/kdIndex')));
					exit;
				}else{
					$this->ajaxReturn(array('status'=>0,'info'=>$data['name'].'修改失败!'));
					exit;
				}
			}
		}
		$this->assign('info',$info);
		$this->display();
	}

	public function delKd(){
		if(I('get.id') == null){
			$this->ajaxReturn(array('status'=>0,'info'=>'删除失败!'));
			exit;
		}
		if(M('Kuaidi')->where('id = '.I('get.id'))->delete()){
			$this->ajaxReturn(array('status'=>1,'info'=>'删除成功!'));
			exit;
		}else{
			$this->ajaxReturn(array('status'=>0,'info'=>'删除失败!'));
			exit;
		}
	}

}