<?php
namespace Admin\Model;
use Think\Model;
class NewsModel extends Model {

    public function listNews($firstRow = 0, $listRows = 20) {
        $M = M("News");
        $list = $M->field("`id`,`title`,`status`,`create_time`,`category_id`,`aid`,`is_recommend`")->order("`create_time` DESC")->limit("$firstRow , $listRows")->select();
        $statusArr = array("审核状态", "已发布状态");
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        $cidArr = M("Category")->field("`cid`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($cidArr);
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
            $list[$k]['status'] = $statusArr[$v['status']];
            $list[$k]['cidName'] = $cids[$v['cid']]['name'];
        }
        return $list;
    }

    public function category() {
        if (IS_POST) {
            $act = $_POST['act'];
            $data = $_POST['data'];
            $data['name'] = addslashes($data['name']);

//            $data['type']='n';
            $M = M("news_category");
            if ($act == "add") { //添加分类
                unset($data['cid']);
                if ($M->where($data)->count() == 0) {
                    return ($M->add($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功添加到系统中', 'url' => U('News/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 添加失败');
                } else {
                    return array('status' => 0, 'info' => '系统中已经存在分类' . $data['name']);
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['parent_id'] == $data['parent_id']) {
                    unset($data['parent_id']);
                }
                return ($M->save($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功更新', 'url' => U('News/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['parent_id'], $data['name']);
                return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功删除', 'url' => U('News/category', array('time' => time()))) : array('status' => 0, 'info' => '分类 ' . $data['name'] . ' 删除失败');
            }
        } else {
            //import("Category");
            $cat = new \Org\Util\Category('news_category', array('id', 'parent_id', 'name','fullname'));
            return $cat->getList();               //获取分类结构
        }
    }

    public function addNews() {
        $M = M("News");
        $data = $_POST['info'];
        $data['create_time'] = time();
        $data['aid'] = $_SESSION['my_info']['aid'];
        if(empty($data['title'])){
            return array('status' => 0, 'info' => "请输入标题！",'url'=>__SELF__);
        }
        $image=I('post.image_1');
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

        if (empty($data['summary'])) {
            $data['summary'] = mb_substr(strip_tags($data['content']),0,200,'utf-8');
        }
        if ($M->add($data)) {
            return array('status' => 1, 'info' => "已经发布", 'url' => U('News/index'));
        } else {
            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
        }
    }

    public function edit() {
        $M = M("News");
        $data = $_POST['info'];
        $data['update_time'] = time();
        if(empty($data['title'])){
            return array('status' => 0, 'info' => "请输入标题！",'url'=>__SELF__);
        }
        $image=I('post.image_1');
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
        if (empty($data['summary'])) {
            $data['summary'] = mb_substr(strip_tags($data['content']),0,200,'utf-8');
        }
        if ($M->save($data)) {
            return array('status' => 1, 'info' => "已经更新", 'url' => U('News/index'));
        } else {
            return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
        }
    }

}

?>
