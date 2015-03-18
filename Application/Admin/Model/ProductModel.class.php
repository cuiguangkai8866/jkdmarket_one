<?php
/**
 * Created by PhpStorm.
 * User: cony
 * Date: 14-3-3
 * Time: 下午2:52
 */
namespace Admin\Model;
use Think\Model;
class ProductModel extends Model {

    public function listProduct($firstRow = 0, $listRows = 20,$__map) {
        $M = M("Product");

        $list = $M->field("`id`,`title`,`stock`,`start_time`,`end_time`,`status`,`cid`,`published`,`aid`,`is_recommend`,`lang`,wap_display")->where($__map)->order("`published` DESC")->limit("$firstRow , $listRows")->select();
        $statusArr = array("待审核", "已发布");
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        $map['type']='product';
        $cidArr = M("Category")->field("`cid`,`name`")->where($map)->select();
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
            $act = $_POST[act];
            $data = $_POST['data'];
            $data['name'] = addslashes($data['name']);
           // $data['parent_id']=1;
           // $data['type'] = $type;
           // $data['sort'] = $_POST['data']['sort'];
            $M = M("Category");
            if ($act == "add") { //添加分类
                unset($data[id]);
               // $data['type']= $_POST['type'];
                if ($M->where($data)->count() == 0) {
                    return ($M->add($data)) ? array('status' => 1, 'info' => '当前类 ' . $data['name'] . ' 已经成功添加到系统中', 'url' => U(CONTROLLER_NAME.'/'.ACTION_NAME, array('time' => time()))) : array('status' => 0, 'info' => '当前类 ' . $data['name'] . ' 添加失败');
                } else {
                    return array('status' => 0, 'info' => '系统中已经存在分类' . $data['name']);
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['parent_id'] == $data['id']) {
                    unset($data['parent_id']);
                }
                return ($M->save($data)) ? array('status' => 1, 'info' => '当前类 ' . $data['name'] . ' 已经成功更新', 'url' => U(CONTROLLER_NAME.'/'.ACTION_NAME, array('time' => time()))) : array('status' => 0, 'info' => '当前类 ' . $data['name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['parent_id'], $data['name']);
                if($M->where('parent_id='.$data['id'].' AND id!='.$data['id'])->count()>0){
                    return (array('status' => 0, 'info' => $data['parent_id'] . '存在下级分类，请先删除'));
                    exit;
                }


            return ( $M->where('id='.$data['id'])->delete()) ? array('status' => 1, 'info' => '当前类 ' . $data['name'] . ' 已经成功删除', 'url' => U(CONTROLLER_NAME.'/'.ACTION_NAME, array('time' => time()))) : array('status' => 0, 'info' => '当前类 ' . $data['name'] . ' 删除失败');
        }
        } else {
             $map['id'] =array('neq','0');
//            $map['is_show'] =array('neq','0');
            $cat = new \Org\Util\Category('Category', array('id', 'parent_id', 'name', 'fullname'),$map);
            return $cat->getList();               //获取分类结构
        }
    }

    public function addProduct($imagename='',$type) {
        $M = M("Product");
        $data = $_POST['info'];
        $data['published'] = time();
        $data['summary']=nl2br($data['summary']);
        $data['title']=strip_tags($data['title']);
        $data['mold_cid'] = ','.implode(',',$_POST['mole_cid']).',';
        $data['mold_pid'] = ','.implode(',',$_POST['mole_pid']).',';
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        if($type != null){
            $data[$type] = 1;
        }
        if(empty($data['number'])){
            $data['number'] = 'SHOP'.date('YmdHis').mt_rand(10,99);
        }
        if(empty($data['credit'])){
            $data['credit'] = floor($data['price']/C('LISTNUM.setCredit'));
        }
        $image=I('post.image_1');
        if($image){
            if(is_array($image)){
                $M_image = M("images");
                $image_id=array();
                foreach($image as $k=>$v){
                    if(!preg_match("/^\/Uploads/i",$v)){
                        $pp = explode('/',ltrim($v,'/'));
                        $pattern = "/^\/{$pp[0]}\//i";
                        $img_data['savepath'] = preg_replace($pattern, '/', $v);
                    }else{
                        $img_data['savepath'] = $v;
                    }
                    $img_data['savename']=end(explode('/',$v));
                    $img_data['create_time']=time();
                    $img_data['catname']='product';
                    if($v)
                    $image_id[$k]=$M_image->add($img_data);
                }
                $data['image_id']=implode(',',$image_id);
            }
        }

        $data['aid'] = $_SESSION['my_info']['aid'];
        if(empty($data['title'])){
            return array('status' => 0, 'info' => "请输入标题！",'url'=>__SELF__);
        }
        if (empty($data['summary'])) {
            $data['summary'] = cutStr(strip_tags($data['content']), 200);
        }
        if ($pro_id = $M->add($data)) {
            if($data['auction'] == 1){
                $paipai['pro_id'] = $pro_id;
                $paipai['published'] = $paipai['update_time'] = time();
                M('Paipai')->add($paipai);
            }
            return array('status' => 1, 'info' => "已经发布", 'url' => U(CONTROLLER_NAME.'/index'));
        } else {
            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
        }
    }

    public function edit() {
        $M = M("Product");
        $data = $_POST['info'];
        $data['update_time'] = time();
        $data['title']=strip_tags($data['title']);
        $data['mold_cid'] = ','.implode(',',$_POST['mole_cid']).',';
        $data['mold_pid'] = ','.implode(',',$_POST['mole_pid']).',';
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        if(empty($data['number'])){
            $data['number'] = 'JFW'.date('YmdHis').mt_rand(10,99);
        }
        $data['summary'] = str_replace("\n",',',$data['summary']);
        $M_image = M("images");
        $map['id']=$data['id'];
        $image_ids=$M->where($map)->getField('image_id');
        $image_map['id']=array('in',$image_ids);
        $img_path = M('images')->where($image_map)->order('id asc')->Field('savepath')->select();
        $data['image_id']='';
        //判断图片数据是否删除成功并且数据不为空
        if($M_image->where($image_map)->delete() && $img_path != null){
                // 获取图片数据
                $image=I('post.image_1');
                if($image){
                    if(is_array($image)){
                        $image_id=array();
                        //格式化图片路径
                        foreach($image as $k=>$v){
                            if(!preg_match("/^\/Uploads/i",$v)){
                                $pp = explode('/',ltrim($v,'/'));
                                $pattern = "/^\/{$pp[0]}\//i";
                                $img_data['savepath'] = preg_replace($pattern, '/', $v);
                            }else{
                                $img_data['savepath'] = $v;
                            }
                            $img_data['savename']=end(explode('/',$v));
                            $img_data['create_time']=time();
                            $img_data['catname']='product';
                            $image_id[$k]=$M_image->add($img_data);
                            //删除图片
//                            if($v){
//                                $image_id[$k]=$M_image->add($img_data);
//                            }
//                            foreach($img_path as $key=>$val){
//                                if($val['savepath'] != $img_data['savepath']){
//                                    if(file_exists('.'.$val['savepath'])){
//                                        unlink('.'.$val['savepath']);exit;
//                                    }else{
//                                        $image_id[$k]=$M_image->add($img_data);
//                                    }
//                                }
//                            }



                        }
                        $data['image_id']=implode(',',$image_id);
                    }

                if(empty($data['title'])){
                    return array('status' => 0, 'info' => "请输入标题！",'url'=>__SELF__);
                }

                if ($M->where('id='.I('get.id'))->save($data)) {
                    if($data['auction'] == 1){
                        if(M('Paipai')->where('pro_id = '.I('get.id'))->getField('id') == null){
                            $paipai['pro_id'] = I('get.id');
                            $paipai['published'] = $paipai['update_time'] = time();
                            M('Paipai')->add($paipai);
                        }else{
                            M('Paipai')->where('pro_id = '.I('get.id'))->setField(array('status'=>0,'update_time'=>time()));
                            M('Product')->where('id = '.I('get.id'))->setField(array('auction'=>0,'update_time'=>time()));
                        }
                    }
                    return array('status' => 1, 'info' => "已经更新",'url'=>U(CONTROLLER_NAME.'/index'));
                } else {
                    return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
                }
            }
        }else{
            $image=I('post.image_1');
            if($image){
                if(is_array($image)){
                    $image_id=array();
                    foreach($image as $k=>$v){
                        if(!preg_match("/^\/Uploads/i",$v)){
                            $pp = explode('/',ltrim($v,'/'));
                            $pattern = "/^\/{$pp[0]}\//i";
                            $img_data['savepath'] = preg_replace($pattern, '/', $v);
                        }else{
                            $img_data['savepath'] = $v;
                        }
                        $img_data['savename']=end(explode('/',$v));
                        $img_data['create_time']=time();
                        $img_data['catname']='product';
                        if($v)
                            $image_id[$k]=$M_image->add($img_data);
                    }
                    $data['image_id']=implode(',',$image_id);
                }
            }
            if(empty($data['title'])){
                return array('status' => 0, 'info' => "请输入标题！",'url'=>__SELF__);
            }
            if ($M->where('id='.I('get.id'))->save($data)) {
                if($data['auction'] == 1){
                    if(M('Paipai')->where('pro_id = '.I('get.id'))->getField('id') == null){
                        $paipai['pro_id'] = I('get.id');
                        $paipai['published'] = $paipai['update_time'] = time();
                        M('Paipai')->add($paipai);
                    }else{
                        M('Paipai')->where('pro_id = '.I('get.id'))->setField(array('status'=>0,'update_time'=>time()));
                        M('Product')->where('id = '.I('get.id'))->setField(array('auction'=>0,'update_time'=>time()));
                    }
                }
                return array('status' => 1, 'info' => "已经更新", 'url' => U(CONTROLLER_NAME.'/index'));
            } else {
                return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
            }
        }
    }
}