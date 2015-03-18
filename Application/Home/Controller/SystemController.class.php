<?php
    namespace Home\Controller;
    use Think\Controller;
class SystemController extends CommonController{
    public function __construct(){
        parent::__construct();

        //设置登录之后跳转的页面
        if($_SESSION['member'] == null && ACTION_NAME != 'login' && ACTION_NAME != 'register' && MODULE_NAME != 'Member' && ACTION_NAME != 'zixun' && ACTION_NAME != 'pingjia' && ACTION_NAME != 'qqlogin' && ACTION_NAME != 'qqCallback' && ACTION_NAME != 'wblogin' && ACTION_NAME != 'wbCallback' && ACTION_NAME != 'aliFastLogin' && ACTION_NAME !='aliCallback' && ACTION_NAME != 'logout'){
            $_SESSION['login_url'] = $_SERVER['REQUEST_URI'];
        }
    }

    /* * * * * * * * * * * * * * * * * * *
     * $param 邮件发送系统公共方法           *
     * $Param $user_mail 接收邮件的用户     *
     * $Param $mail_title 邮件的主题       *
     * $Param $mail_content 邮件的内容     *
     * $Param Success 成功返回true         *
     * $Param Error 失败返回Flase或者错误信息 *
     * * * * * * * * * * * * * * * * * * */
    protected function SendEmail($user_mail,$mail_title,$mail_content){
        return send_mail($user_mail,"",$mail_title,$mail_content,"");
    }

    /**
     * 公共分页数据查询类
    */

    protected function s_shopPage($where,$order,$int,$field){
        $sql = M('Product');
        $count = $sql->where($where)->count();
        $Page = new \Think\shopPage($count,$int);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show       = $Page->show();
        if($field == null){
            $list = $sql->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $list = $sql->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->Field($field)->select();

        }
        return array('show'=>$show,'list'=>$list,'count'=>$count);
    }

    /**
     * 图片组合公共方法
    */
    protected function s_images($image,$type = false,$obj = false){
        if(empty($image) || !is_array($image)){
            return false;
            exit;
        }
        if($obj){
            foreach($image as $k=>$v){
                if($k == 'image_id'){
                    $img_where['id'] = array('IN',$v);
                    if($v != null){
                        $img_arr = M('images')->where($img_where)->Field('savepath')->select();
                        if($img_arr == null){
                            $img_arr[0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }
                    }
                }
            }
            if(empty($img_arr)){
                if($type == false){
                    $image['savepath'] = '/Public/Home/images/no_goods.jpg';
                }else{
                    $image['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                }
            }else{
                if($type == false){
                    $image['savepath'] = $img_arr[0]['savepath'];
                }else{
                    $image['savepath'] = $img_arr;
                }
            }
        }else{
            foreach($image as $k=>$v){

                if($image[$k]['image_id'] != $v['image_id']){
                    $this->s_images($v);
                }else{
                    if($v['image_id'] == null){
                        if($type==false){
                            $image[$k]['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }else{
                            $image[$k]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }
                    }else{

                        $img_where['id'] = array('exp','IN('.$v['image_id'].')');
                        $img_arr = M('images')->where($img_where)->Field('savepath')->select();
                        if(empty($img_arr)){
                            $image[$k]['savepath'][0]['savepath'] = '/Public/Home/images/no_goods.jpg';
                        }else{
							if($type){
								$image[$k]['savepath'] =  $img_arr[0]['savepath'];
							}else{
								$image[$k]['savepath'] = $img_arr;
							}
                        }
                    }
                }
            }
        }
        return $image;
    }

    /**
     * 订单生成方法
     * $field 需要返回的订单表中的字段
    */
    protected function s_order($field){
        if(empty($field)){
            $field = 'id,oid,published,total_money,uid,freight';
        }
        //订单数据赋值
        $data['oid'] = 'JFW'.date('YmdHis',time()).mt_rand(10,99);
        $data['uid'] = $_SESSION['member']['uid'];
        //检测订单归属类型

        $cart_where['id'] = array('exp','IN('.$_SESSION['orderInfo']['reallyProduct'].')');
        $cartList = M('Product_cart')->where($cart_where)->getField('pro_id',true);
        $order_status = M('Product')->where('id = '.$cartList[0])->field('auction,sale,groupon')->find();
        if($order_status['sale'] == 1){
            $data['order_status'] = 2;
        }else if($order_status['auction'] == 1){
            $data['order_status'] = 1;
        }else if($order_status['groupon'] == 1){
            $data['order_status'] = 3;
        }else{
            $data['order_status'] = 0;
        }
        $data['pro_id'] = implode(',',$cartList);
        $data['cart_id'] = $_SESSION['orderInfo']['reallyProduct'];
        $data['aid'] = $_SESSION['orderInfo']['address'];
        $data['delivery'] = $_SESSION['orderInfo']['deliveryTime'];
        $data['invoice'] = $_SESSION['orderInfo']['invoice'];
        $data['freight'] = $_SESSION['orderInfo']['freight'];
        //加载已选的商品
        $really_product_where['id'] = array('exp','IN('.$_SESSION['orderInfo']['reallyProduct'].')');
        $really_product = M('Product_cart')->where($really_product_where)->Field('present,price,num,credit')->select();
        foreach($really_product as $k=>$v){
            $allMoney += $v['price']*$v['num'];
            $allCredit += $v['credit']*$v['num'];
            if($v['present']!= null){
                $allPresent .= $v['present'].',';
            }
        }
        $data['total_money'] = $allMoney;
        $data['total_credit'] = $allCredit;
        $data['present'] = $allPresent == null ? '无礼品':$allPresent;
        $data['order_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['published'] = $data['update_time'] = time();
        //Todo...

        $id = M('Product_order')->add($data);
        if($id >= 1){
            M('Product_cart')->where($really_product_where)->setField('status',1);
            $return_data = M('Product_order')->where('id = '.$id.' AND uid = '.$_SESSION['member']['uid'])->Field($field)->select();
            $_SESSION['order'] = $return_data[0];
            return $return_data[0];
        }else{
            return 'DATA_ADD_ERROR';
        }
    }
}