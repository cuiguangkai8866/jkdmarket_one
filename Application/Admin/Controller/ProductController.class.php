<?php
/**
 * Created by PhpStorm.
 * User: cony
 * Date: 14-3-3
 * Time: 下午2:35
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ProductController extends CommonController
{

    public function index()
    {
        $map=array();
        $s=array('0','1');
        if($title=I('get.title'))$map['title']=array('like',"%{$title}%");
        if(in_array(I('get.status'),$s))$map['status']=I('get.status');
        if(I('get.cateList') != null)$map['category_id']=I('get.cateList');
        if(in_array(I('get.is_recommend'),$s))$map['is_recommend']=I('get.is_recommend');
        $M = M('product');
        $count = $M->count();
        $page = new \Think\Page($count, 12);
        $showPage = $page->show();
        $this->assign("page", $showPage);
        $productList = $M->order('update_time desc')->where($map)->limit($page->firstRow, $page->listRows)->select();
        $this->assign("productList", $productList);
        $categoryList = D("Product")->category('mold');
        $this->assign("categoryList", $categoryList);
        $this->display();
    }

    //商品分类
    public function category()
    {
        if (IS_POST) {
            echo json_encode(D("Product")->category('product'));
        } else {
            $this->assign("list", D("Product")->category('product'));
            $this->display();
        }
    }

    //商品类型
    public function mold()
    {
        $categoryList = D("Product")->category('mold');
        $this->assign('categoryList', $categoryList);
        $this->display();
    }

    public function  addProp()
    {
        if (IS_POST) {
            $productProp = $_POST['productProp'];
            $tran = D('product_prop');
            $tran->startTrans();
            try {
                $productPropId = M('product_prop')->add($productProp);
                if (!$productPropId) {

                    throw new Exception('save product prop error');
                }
                $propValue = $_POST['propValue'];
                foreach ($propValue['value_name'] as $key => $prop) {
                    $newProp = array();
                    $newProp['category_id'] = $productProp['category_id'];
                    $newProp['value_name'] = $prop;
                    $newProp['pic'] = $propValue['pic'][$key];
                    $newProp['prop_id'] = $productPropId;
                    $newProp['sort'] = 255;
                    $propValueId = M('prop_value')->add($newProp);
                    if (!$propValueId) {
                        throw new Exception('save prop value error');
                    }
                }
                $tran->commit();
                echo json_encode(array('status' => 1, 'message' => '商品属性添加成功'));
            } catch (Exception $ex) {
                $tran->rollback();
                echo json_encode(array('status' => 0, 'message' => '商品属性添加失败'));
            }
        } else {
            echo json_encode(array('status' => 2, 'message' => '不正确的链接'));
        }
    }

    public function propList()
    {

        $page = new \Think\Page(M('product_prop')->count(), 15);
        $showPage = $page->show();
        $propList = M('product_prop')->order('sort desc')->limit($page->firstRow, $page->listRows)->select();
        $this->assign("page", $showPage);
        $this->assign('propList', $propList);
        $this->display();
    }

    public function  editProp($id)
    {
        if (IS_POST) {
//            var_dump($_POST['productProp']);die;
            $productProp = M('product_prop')->where('id="' . $id . '"')->find();
            $propValues = M('prop_value')->where('prop_id="' . $id . '"')->select();
            $tran = D('product_prop');
            $tran->startTrans();
            try {
                $newProductProp = $_POST['productProp'];
                $productPropResult = M('product_prop')->where('id="' . $id . '"')->save($newProductProp);
                if (!$productPropResult && $productPropResult != 0) {
                    throw new Exception('update product prop error');
                }
                $newPropValues = $_POST['propValue'];
                $keyExistList = array();
                foreach ($newPropValues['value_name'] as $newPropValue) {
                    foreach ($propValues as $propValue) {
                        if ($propValue['value_name'] == $newPropValue) {
                            $keyExistList[$propValue['id']] = $propValue['value_name'];
                        }
                    }
                }
                foreach ($propValues as $key => $propValue) {
                    if (!in_array($propValue['value_name'], $keyExistList)) {
                        $result = M('prop_value')->where('id="' . $propValue['id'] . '"')->delete();
                        if (!$result) {
                            throw new Exception('update prop values error');
                        }
                    }
                }
                foreach ($newPropValues['value_name'] as $key => $newPropValue) {
                    $newProp = array();
                    $newProp['category_id'] = $productProp['category_id'];
                    $newProp['value_name'] = $newPropValue;
                    $newProp['pic'] = $newPropValues['pic'][$key];
                    $newProp['prop_id'] = $id;
                    $newProp['sort'] = 255;
                    if (!in_array($newPropValue, $keyExistList)) {
//                        var_dump($newProp);die;
                        $propValueId = M('prop_value')->add($newProp);
                        if (!$propValueId && $propValueId != 0) {
                            throw new Exception('save prop value error');
                        }
                    } else {
                        $propValueId = M('prop_value')->where('id=' . array_search($newProp['value_name'], $keyExistList))->save($newProp);
                        if (!$propValueId && $propValueId != 0) {
                            throw new Exception('save prop value error');
                        }
                    }
                }
                $tran->commit();
                echo json_encode(array('status' => 1, 'message' => '商品属性修改成功'));
            } catch (Exception $ex) {
                $tran->rollback();
                echo json_encode(array('status' => 0, 'message' => '商品属性修改失败'));
            }
        } else {
            $categoryList = D("Product")->category('mold');
            $this->assign("categoryList", $categoryList);
            $productProp = M('product_prop')->where('id="' . $id . '"')->find();
            $propValues = M('prop_value')->where('prop_id="' . $id . '"')->select();
            $this->assign('productProp', $productProp);
            $this->assign('propValues', $propValues);
            $this->display('mold');
        }
//        var_dump($propValues);die;
//        if (IS_POST) {
//
//        }
    }

    public function deleteProp($id)
    {
        $tran = D('product_prop');
        $tran->startTrans();
        try {
            $result = M('product_prop')->where('id=' . $id)->delete();
            if ($result===false) {
                throw new Exception('商品属性删除失败');
            }
            $result = M('prop_value')->where('prop_id=' . $id)->delete();
            if ($result===false) {
                throw new Exception('商品属性值删除失败');
            }
            $tran->commit();
            echo json_encode(array('status' => 1, 'info' => '商品属性删除成功'));
        } catch (Exception $ex) {
            $tran->rollback();
            echo json_encode(array('status' => 0, 'info' => $ex->getMessage()));
        }
    }

    //查询商品的属性
//    public function s_mold(){
//        if(IS_POST){
//            $mold_list = M('category')->where("type='mold' AND pid = ".I('post.cid'))->order('cid desc')->select();
//        }else{
//            $mold_list = M('category')->where("type='mold' AND pid = ".I('get.cid'))->order('cid desc')->select();
//        }
//        $this->ajaxReturn($mold_list);
//    }
    public function add()
    {
        if (IS_POST) {
            $productInfo = $_POST['info'];
            $productSkus = $_POST['Product']['props'];
            $props = implode(',', $productSkus);
            $image = $_POST['image_1'];
            $tran = D('product');
            $tran->startTrans();
            try {
                if (is_array($image)) {
                    $M_image = M("images");
                    $image_id = array();
                    foreach ($image as $k => $v) {
                        if (!preg_match("/^\/Uploads/i", $v)) {
                            $pp = explode('/', ltrim($v, '/'));
                            $pattern = "/^\/{$pp[0]}\//i";
                            $img_data['savepath'] = preg_replace($pattern, '/', $v);
                        } else {
                            $img_data['savepath'] = $v;
                        }
                        $img_data['savename'] = end(explode('/', $v));
                        $img_data['create_time'] = time();
                        $img_data['catname'] = 'product';
                        if ($v)
                            $image_id[$k] = $M_image->add($img_data);
                        if (!$image_id[$k] && $image_id[$k] != 0) {
                            throw new Exception('save product image error');
                        }
                    }
                    $productInfo['image_id'] = implode(',', $image_id);
                }
                $productInfo['props'] = $props;
                $productInfo['create_time'] = $productInfo['update_time'] = time();
                if (empty($productInfo['number'])) {
                    $productInfo['number'] = 'SHOP' . date('YmdHis') . mt_rand(10, 99);
                }
                $product_id = M('product')->add($productInfo);
                if (!$product_id && $product_id != 0) {
                    throw new Exception('save product error');
                }
                $skus = $_POST['Sku'];
                foreach ($skus as $key => $sku) {
                    $sku['product_id'] = $product_id;
                    $sku['props'] = $key;
                    $propNames = array();
                    foreach (explode(',', $key) as $keyValue) {
                        $arr = explode(':', $keyValue);
                        $propName = M('prop_value')->where('id=' . $arr[1])->find();
                        $propNames[] = $propName['value_name'];
                    }
                    $sku['prop_names'] = implode(',', $propNames);
                    $sku['create_time'] = $sku['update_time'] = time();
                    $skuId = M('sku')->add($sku);
                    if (!$skuId && $skuId != 0) {
                        throw new Exception('save product sku error');
                    }
                }
                $tran->commit();
                echo json_encode(array('status' => 1, 'info' => '商品添加成功'));
            } catch (Exception $ex) {
                $tran->rollback();
                echo json_encode(array('status' => 0, 'info' => $ex->getMessage()));
            }
        } else {
            $categoryList = D("Product")->category('mold');
            $this->assign("categoryList", $categoryList);
            $this->display();
        }
    }

    public function changeCategory()
    {
        if (IS_POST) {
            $category_id = $_POST['category_id'];
            $productProps = M('product_prop')->where('category_id=' . $category_id)->select();
            $html = '';
            $arrs = array();
            foreach ($productProps as $productProp) {
                if ($productProp['status'] == 1) {
                    if ($productProp['is_sale_prop'] == 0) {
                        if ($productProp['type'] == 'input') {
                            $html .= '<tr class="prop-tr"><th>' . $productProp['prop_name'] . '：</th><td><input type="text" class="input" size="20" name="Product[props][' . $productProp['id'] . ']" value=""></td></tr>';
                        }
                        if ($productProp['type'] == 'optional') {
                            $propValues = M('prop_value')->where('prop_id=' . $productProp['id'])->select();
                            $temHtml = '';
                            foreach ($propValues as $propValue) {
                                $temHtml .= '<option value="' . $productProp['id'] . ':' . $propValue['id'] . '">' . $propValue['value_name'] . '</option>';
                            }
                            $html .= '<tr class="prop-tr"><th>' . $productProp['prop_name'] . '：</th><td> <select name="Product[props][' . $productProp['id'] . ']">' . $temHtml . '</select></td></tr>';
                        }
                        if ($productProp['type'] == 'multiCheck') {
                            $propValues = M('prop_value')->where('prop_id=' . $productProp['id'])->select();
                            $temHtml = '<div>';
                            $i = 0;
                            foreach ($propValues as $propValue) {
                                $temHtml .= '<span ><input value="' . $productProp['id'] . ':' . $propValue['id'] . '" id="Product_props_' . $productProp['id'] . '_' . $i . '" type="checkbox" name="Product[props][' . $productProp['id'] . '][]">
                        <label class="labelForRadio" for="Product_props_' . $productProp['id'] . '_' . $i . '">' . $propValue['value_name'] . '</label></span>';
                                $i++;
                            }
                            $temHtml .= '</div>';
                            $html .= '<tr class="prop-tr"><th>' . $productProp['prop_name'] . '：</th><td>' . $temHtml . '</td></tr>';
                        }
                        // echo $html;
                    } else {
                        $arrs[] = $productProp;
                    }
                }
            }
            foreach ($arrs as $productProp) {
                if ($productProp['type'] == 'multiCheck') {
                    $propValues = M('prop_value')->where('prop_id=' . $productProp['id'])->select();
                    $temHtml = '<div class="sale-prop">';
                    $i = 0;
                    foreach ($propValues as $propValue) {
                        $temHtml .= '<span><input  data-product-prop-id="' . $productProp['id'] . '" value="' . $productProp['id'] . ':' . $propValue['id'] . '" id="Product_props_' . $productProp['id'] . '_' . $i . '" type="checkbox" >
                        <label class="labelForRadio" for="Product_props_' . $productProp['id'] . '_' . $i . '">' . $propValue['value_name'] . '</label></span>';
                        $i++;
                    }
                    $temHtml .= '</div>';
                    $html .= '<tr class="prop-tr"><th>' . $productProp['prop_name'] . '：</th><td>' . $temHtml . '</td></tr>';
                }
            }
            echo $html;

        }
    }

    public function checkProductTitle()
    {
        $M = M("Product");
        if (!$_GET['title']) {
            echo json_encode(array("status" => 0, "info" => "标题为空"));
        }
        $where = "title='" . I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where .= " And id !=" . (int)$_GET['id'];
        }
        if (!I('get.title')) {
            echo json_encode(array("status" => 0, "info" => "请输入标题"));
        }
        if ($M->where($where)->count() > 0) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
        }
    }

    public function edit()
    {
        $M = M("Product");
        if (IS_POST) {
            $productInfo = $_POST['info'];
            $dbInfo = $M->where("id=" . (int)$productInfo['id'])->find();
            if ($dbInfo['id'] == '') {
                echo json_encode(array('status' => 0, 'info' => '不存在该记录'));
                exit;
            }
            $productSkus = $_POST['Product']['props'];
            $props = implode(',', $productSkus);
            $image = $_POST['image_1'];
            $tran = D('product');
            $tran->startTrans();
            try {
                if (is_array($image)) {
                    $M_image = M("images");
                    $image_id = array();
                    foreach ($image as $k => $v) {
                        if (!preg_match("/^\/Uploads/i", $v)) {
                            $pp = explode('/', ltrim($v, '/'));
                            $pattern = "/^\/{$pp[0]}\//i";
                            $img_data['savepath'] = preg_replace($pattern, '/', $v);
                        } else {
                            $img_data['savepath'] = $v;
                        }
                        $img_data['savename'] = end(explode('/', $v));
                        $img_data['create_time'] = time();
                        $img_data['catname'] = 'product';
                        if ($v)
//                            var_dump($img_data);die;
                            $image_id[$k] = $M_image->add($img_data);
                        if (!$image_id[$k] && $image_id[$k] != 0) {
                            throw new Exception('save product image error');
                        }
                    }
                    $productInfo['image_id'] = implode(',', $image_id);
                }
                $productInfo['props'] = $props;
                $productInfo['update_time'] = time();
                if (empty($productInfo['number'])) {
                    $productInfo['number'] = 'SHOP' . date('YmdHis') . mt_rand(10, 99);
                }
                $product_id = M('product')->where('id=' . $dbInfo['id'])->save($productInfo);
                if (!$product_id && $product_id != 0) {
                    throw new Exception('save product error');
                }
                $skus = $_POST['Sku'];
                $dbSkus = M('sku')->where('product_id=' . $dbInfo['id'])->select();
                $sameSku = array();
                foreach ($dbSkus as $dbSku) {
                    foreach ($skus as $key => $sku) {
                        if ($key == $dbSku['props']) {
                            $sameSku[$dbSku['id']] = $key;
                        }
                    }
                }
                foreach ($dbSkus as $dbSku) {
                    if (!in_array($dbSku['props'], $sameSku)) {
                        M('sku')->where('id=' . $dbSku['id'])->delete();
                    }
                }
                foreach ($skus as $key => $sku) {
                    if (in_array($key, $sameSku)) {
                        $sku['update_time'] = time();
                        $result = M('sku')->where('id=' . array_search($key, $sameSku))->save($sku);
                        if (!$result && $result != 0) {
                            throw new Exception('save product sku error');
                        }
                    } else {
                        $sku['product_id'] = $dbInfo['id'];
                        $sku['props'] = $key;
                        $propNames = array();
                        foreach (explode(',', $key) as $keyValue) {
                            $arr = explode(':', $keyValue);
                            $propName = M('prop_value')->where('id=' . $arr[1])->find();
                            $propNames[] = $propName['value_name'];
                        }
                        $sku['prop_names'] = implode(',', $propNames);
                        $sku['create_time'] = $sku['update_time'] = time();
                        $skuId = M('sku')->add($sku);
                        if (!$skuId && $skuId != 0) {
                            throw new Exception('save product sku error');
                        }
                    }
                }
                $tran->commit();
                echo json_encode(array('status' => 1, 'info' => '商品添加成功'));
            } catch (Exception $ex) {
                $tran->rollback();
                echo json_encode(array('status' => 0, 'info' => $ex->getMessage()));
            }
        } else {
            $info = $M->where("id=" . (int)$_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            if ($info['image_id']) {
                $image = M("images");
                $map['id'] = array('in', $info['image_id']);
                $img_info = $image->where($map)->order('id asc')->select();
                $this->assign("img_info", $img_info);
            }
            $skus = M('sku')->where('product_id=' . $info['id'])->select();
            $categoryList = D("Product")->category('mold');
            $this->assign("categoryList", $categoryList);
            $this->assign("info", $info);
            $this->assign("skus", $skus);
            $this->display('add');
        }
    }

    public function del()
    {
        $img_id = M('Product')->where("id=" . (int)$_GET['id'])->getField('image_id');
        $where['id'] = array('IN', $img_id);
        $img_path = M('images')->where($where)->Field('savepath')->select();
        $tran = D('product');
        $tran->startTrans();
        try {
            if ($img_path != null || $img_path != false) {
                $result = M('images')->where($where)->delete();
                if ($result===false) {
                    throw new Exception('图片删除失败');
                }
            }
            $result = M("Product")->where("id=" . (int)$_GET['id'])->delete();
            if ($result===false) {
                throw new Exception('删除失败，可能是不存在该ID的记录');
            }
           $result= M('sku')->where('product_id='.(int)$_GET['id'])->delete();
            if ($result===false) {
                throw new Exception('商品SKU删除失败');
            }
            $tran->commit();
            echo json_encode(array('status' => 1, 'info' => '产品删除成功'));
        } catch (Exception $ex) {
            $tran->rollback();
            echo json_encode(array('status' => 0, 'info' => $ex->getMessage()));
        }
    }

    public function changeAttr()
    {
        $id = I('get.id');
        $m_news = M("Product");
        $map['id'] = $id;
        $is_recommend = $m_news->where($map)->getField('is_recommend');
        $data['is_recommend'] = abs($is_recommend - 1);
        if ($m_news->where($map)->save($data)) {
            echo json_encode(array("status" => 1, "info" => '<img src="' . __ROOT__ . '/Public/Img/action_' . $data['is_recommend'] . '.png" border="0">'));
            //echo '<img src="../Public/Img/action_'.$data['is_recommend'].'.png" border="0">';
            exit;
        }
        return false;
    }

    public function changeStatus()
    {
        $id = I('get.id');
        $m_news = M("Product");
        $map['id'] = $id;
        $status = $m_news->where($map)->getField('status');
        $data['status'] = abs($status - 1);
        $statusArr = array("待审核", "已发布");
        if ($m_news->where($map)->save($data)) {
            echo json_encode(array("status" => 1, "info" => $statusArr[$data['status']]));
            //echo '<img src="../Public/Img/action_'.$data['is_recommend'].'.png" border="0">';
            exit;
        }
        return false;
    }

    public function changeShow()
    {
        $id = I('get.id');
        $m_news = M("category");
        $map['id'] = $id;
        $is_show = $m_news->where($map)->getField('is_show');
        $data['is_show'] = abs($is_show - 1);
        $statusArr = array("否", "是");
        if ($m_news->where($map)->save($data)) {
            echo json_encode(array("status" => 1, "info" => $statusArr[$data['is_show']]));
            //echo '<img src="../Public/Img/action_'.$data['is_recommend'].'.png" border="0">';
            exit;
        }
        return false;
    }


    public function changePhoneStatus()
    {
        $id = I('get.id');
        $m_news = M("Product");
        $map['id'] = $id;
        $status = $m_news->where($map)->getField('wap_display');
        $data['wap_display'] = abs($status - 1);
        if ($m_news->where($map)->save($data)) {
            echo json_encode(array("status" => 1, "info" => '<img src="' . __ROOT__ . '/Public/Img/iphone-' . $data['wap_display'] . '.png" border="0">'));
            //echo '<img src="../Public/Img/action_'.$data['is_recommend'].'.png" border="0">';
            exit;
        }
        return false;
    }

    //待支付订单
    public function waitPayOrder()
    {
        $M = M("Product_order");
        $where['status'] = 0;
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow . ',' . $Page->listRows)->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待支付';
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
        }

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //待发货订单
    public function waitDeliveryOrder()
    {

        $M = M("Product_order");
        $where['status'] = 2;
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow . ',' . $Page->listRows)->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待发货';
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
        }

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //待确认订单
    public function waitReallyOrder()
    {
        //dump($_SESSION['testInfo']);
        $M = M("Product_order");
        $where['status'] = 3;
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow . ',' . $Page->listRows)->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待确认';
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
        }

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //待退款订单
    public function waitRefundOrder()
    {
        $M = M("Product_order");
        $where['status'] = 4;
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow . ',' . $Page->listRows)->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '待退款';
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
        }

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //已成功订单
    public function successOrder()
    {
        $M = M("Product_order");
        $where['status'] = 5;
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,published,status,alipay_id';
        $list = $M->where($where)->order('published desc')->limit($Page->firstRow . ',' . $Page->listRows)->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['statusHtml'] = '交易完成';
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
        }

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //已失效订单
    public function errorOrder()
    {
        $M = M("Product_order");
        $where['status'] = array('IN', '1,6,7');
        if (I('get.oid') != null) {
            $where['oid'] = I('get.oid');
        }
        if (I('get.username') != null) {
            $username_where['username'] = array('like', '%' . I('get.username') . '%');
            $username_id = M('Member_address')->where($username_where)->getField('id', true);
            $where['aid'] = array('IN', implode(',', $username_id));
        }
        $count = $M->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $field = 'id,oid,uid,aid,total_money,status,published,status,alipay_id';
        $list = $M->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('status')->field($field)->select();
        //组装购买用户
        foreach ($list as $k => $v) {
            $list[$k]['username'] = M('Member_address')->where('id= ' . $v['aid'])->getField('username');
            $list[$k]['phone'] = M('Member_address')->where('id= ' . $v['aid'])->getField('phone');
            $list[$k]['nickname'] = M('Member')->where('uid = ' . $v['uid'])->getField('nickname');
            switch ($v['status']) {
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

        $this->assign('list', $list);// 赋值数据集
        $this->assign('page', $show);// 赋值分页输出
        $this->display('order');
    }

    //管理订单信息
    public function orderEdit()
    {
        if (IS_POST) {
            $data = I('post.info');
            $addressData = I('post.address');
            //设置跳转路径
            switch ($data['status']) {
                case '0':
                    $url = U('Product/waitPayOrder');
                    break;
                case '1':
                    $url = U('Product/errorOrder');
                    break;
                case '2':
                    $url = U('Product/waitDeliveryOrder');
                    break;
                case '3':
                    $url = U('Product/waitReallyOrder');
                    break;
                case '4':
                    $url = U('Product/waitRefundOrder');
                    break;
                case '5':
                    $url = U('Product/successOrder');
                    break;
                case '6':
                    $url = U('Product/errorOrder');
                    break;
                case '7':
                    $url = U('Product/errorOrder');
                    break;
            }
            if ($data['fee_code'] != null) {
                $data['fee_name'] = M('Kuaidi')->where("code = '" . $data['fee_code'] . "'")->getField('name');
            }
            if (M('Member_address')->where('id = ' . $data['aid'])->save($addressData) || M('Product_order')->where('id = ' . I('get.id'))->save($data)) {
                $this->ajaxReturn(array('status' => 1, 'info' => '操作成功!', 'url' => $url));
            } else {
                $this->ajaxReturn(array('status' => 0, 'info' => '操作失败!'));
            }
        } else {
            if (I('get.id') == null) {
                $this->error('操作失败!');
                exit;
            }
            $info = M()
                ->table(
                    array(
                        C('DB_PREFIX') . 'product_order' => 'o',
                        C('DB_PREFIX') . 'member' => 'm',
                        C('DB_PREFIX') . 'member_address' => 'a',
                        C('DB_PREFIX') . 'product' => 'p'
                    )
                )
                ->where("o.id = " . I('get.id') . ' AND a.id=o.aid AND o.uid=m.uid')
                ->field('o.aid,o.t_why,o.t_content,o.t_phone,o.t_username,a.phone,a.postcode,a.address,a.shen_cityname,a.shi_cityname,a.xian_cityname,o.oid,a.username,m.nickname,o.pro_id,o.delivery,o.invoice,o.total_money,o.total_credit,o.present,o.freight,o.status,o.content,o.order_ip,o.published,o.update_time,o.fee_name,o.fee_kid,o.fee_code,o.old_status')
                ->find();
            //组合订单详情信息
            $info['total_credit'] = $info['total_credit'] == 0 ? '无可赠积分' : $info['credit'];
            $info['freight'] = $info['freight'] == 0 ? '免运费' : $info['freight'];
            $info['published'] = date('Y-m-d H:i:s', $info['published']);
            $info['update_time'] = date('Y-m-d H:i:s', $info['update_time']);
            $p_where['id'] = array('IN', $info['pro_id']);
            $productList = M('Product')->where($p_where)->field('id,title')->select();
            $this->assign('productList', $productList);
            $this->assign('list', M('Kuaidi')->select());
            $this->assign('info', $info);
            $this->display();
        }
    }

    //改变订单状态
    public function changeOrderStatus()
    {
        if (IS_AJAX) {
            if (IS_POST) {
                $old_status = M('Product_order')->where('id = ' . I('post.obj'))->getField('old_status');
                switch (I('post.type')) {
                    //执行同意退款申请
                    case 'agreedRefund':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 6, 'sq_status' => 2, 'update_time' => time()))) {
                            $orderInfo = M('Product_order')->where('id = ' . I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setDec('money', $orderInfo['total_money'] + $orderInfo['freight']);
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setDec('credit', $orderInfo['total_credit']);
                            $orderInfo = M('Product_order')->where('id = ' . I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setDec('money', $orderInfo['total_money'] + $orderInfo['freight']);
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setDec('money', $orderInfo['total_credit']);
                            $this->ajaxReturn(array('status' => 1, 'info' => '该订单已经成功设置为退款状态!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //执行拒绝退款申请
                    case 'refusedRefund':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => $old_status, 'sq_status' => 0, 'update_time' => time()))) {
                            $this->ajaxReturn(array('status' => 1, 'info' => '该订单已拒绝退款!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //执行取消订单
                    case 'cancelOrder':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 1, 'update_time' => time()))) {
                            $this->ajaxReturn(array('status' => 1, 'info' => '您已成功取消该订单!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //设置为已支付
                    case 'setOrderToPay':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 2, 'update_time' => time()))) {
                            $this->ajaxReturn(array('status' => 1, 'info' => '您已成功设置为已支付状态!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //设置为已发货
                    case 'setOrderToDelivery':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 3, 'update_time' => time()))) {
                            $this->ajaxReturn(array('status' => 1, 'info' => '您已成功设置为已发货状态!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //设置为已收货
                    case 'setOrderReally':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 5, 'update_time' => time()))) {
                            $orderInfo = M('Product_order')->where('id = ' . I('post.obj'))->field('uid,total_money,total_credit,freight')->find();
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setInc('money', $orderInfo['total_money'] + $orderInfo['freight']);
                            M('Member')->where('uid = ' . $orderInfo['uid'])->setInc('credit', $orderInfo['total_credit']);
                            $this->ajaxReturn(array('status' => 1, 'info' => '您已成功设置为已收货状态!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    //执行作废订单
                    case 'invalidOrder':
                        if (M('Product_order')->where('id = ' . intval(I('post.obj')))->setField(array('status' => 7, 'update_time' => time()))) {
                            $this->ajaxReturn(array('status' => 1, 'info' => '该订单已经作废!'));
                        } else {
                            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败,请重试!'));
                        }
                        break;
                    default:
                        $this->ajaxReturn(array('status' => 0, 'info' => '您的指令系统无法识别,请重试!'));
                        break;
                }
                $this->ajaxReturn(array('status' => 1, 'info' => I('post.status')));
            } else {
                $this->ajaxReturn(array('status' => 0, 'info' => '访问失败!'));
            }
        } else {
            $this->error('访问失败!');
        }
    }

    //库存不足商品
    public function stock()
    {
        if (IS_POST) {
            $obj = rtrim(I('post.obj'), ',');
            $map['id'] = array('IN', $obj);
            if (M('Product')->where($map)->setInc('stock', I('post.num'))) {
                $this->ajaxReturn(array('status' => 1, 'info' => '库存更新成功!'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'info' => '操作失败!'));
            }
            $this->ajaxReturn(array('status' => 1, 'info' => $obj));
        } else {
            $M = M("Product");
            //过滤
            $map['stock'] = array('lt', C('LISTNUM.stockWarning'));
            if ($title = I('get.title')) $map['title'] = array('like', "%{$title}%");
            //
            $count = $M->where($map)->count();

            $page = new \Think\Page($count, 12);
            $showPage = $page->show();
            $this->assign("page", $showPage);
            $this->assign("list", D("Product")->listProduct($page->firstRow, $page->listRows, $map));
            $this->assign("catlist", D("Product")->category());
            $this->display();
        }
    }

    public function deliveryEdit()
    {
        $id = I('get.id');
        $info = M('Product_order')->where('id = ' . $id)->field('oid,alipay_id,fee_name,fee_kid')->find();
        if (IS_POST) {
            if (I('post.fee_code') == null || I('post.fee_kid') == null) {
                $this->ajaxReturn(array('status' => 0, 'info' => '物流公司或者订单或不能为空!'));
                exit;
            } else {
                $fee_name = M('Kuaidi')->where("code = '" . I('post.fee_code') . "'")->getField('name');
                if (!empty($fee_name)) {
                    $data['status'] = 3;
                    $data['update_time'] = time();
                    $data['fee_name'] = $fee_name;
                    $data['fee_code'] = I('post.fee_code');
                    $data['fee_kid'] = I('post.fee_kid');
                    if (M('Product_order')->where('id = ' . $id)->save($data)) {
                        $this->ajaxReturn(array('status' => 1, 'info' => '数据同步成功,您已成功发货!', 'url' => U(CONTROLLER_NAME . '/' . ACTION_NAME)));
                    } else {
                        $this->ajaxReturn(array('status' => 0, 'info' => '数据同步失败,站内数据未更新!'));
                    }
                } else {
                    $this->ajaxReturn(array('status' => 0, 'info' => '数据同步失败,站内数据未更新!'));
                }
            }
        } else {
            $this->assign('list', M('Kuaidi')->select());
            $this->assign('info', $info);
            $this->display();
        }
    }

    public function cancelOrRefund()
    {
        if (I('get.id') != null) {
            $order = array();
            $info = array();
            $where['id'] = array('exp', 'IN(' . I('get.id') . ')');
            if (I('get.type') == 'qxOrder') {
                $content = '取消订单退款操作';
            } else if (I('get.type') == 'tyRefund') {
                $content = '同意用户退款操作';
            } else {
                $content = '订单退款';
            }
            $orderInfo = M('Product_order')->where($where)->field('oid,alipay_id,total_money')->select();
            foreach ($orderInfo as $k => $v) {
                if (empty($v['alipay_id'])) {
                    $info[] = $v['oid'];
                } else {
                    $order[] = $v['alipay_id'] . '^' . $v['total_money'] . '^' . $content;
                }
            }
            if (empty($info)) {
                $pay = new \Common\Api\aliPay();
                $pay->refundPay($order);
            } else {
                echo "订单号<br /><br />" . implode('&nbsp;&nbsp;&nbsp;订单无效<br /><br />', $info) . '&nbsp;&nbsp;&nbsp;订单无效<br /><br />我们未能获取到上面订单号的支付宝交易号!';
            }

        } else {
            echo "<script>alert('该订单不合法!');window.close();</script>";
        }
        $this->display();
    }
}