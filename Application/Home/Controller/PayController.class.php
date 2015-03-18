<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends SystemController{


    public function dbAlipay(){
        if(empty($_SESSION['member'])){
            $this->error('非法操作!');
            exit;
        }
        $payInfo = I('post.pay');
        if($payInfo['payInfo'] == null){
            $this->error('请选择您的支付方式!');
            exit;
        }
        $orderInfo = M('Product_order')->where('oid = '."'".$payInfo['oid']."'")->field('oid,status,aid,total_money,freight,uid')->find();
	
        $addressInfo = M('Member_address')->where('id = '.$orderInfo['aid'])->field('postcode,address,username,phone,shen_cityname,shi_cityname,xian_cityname')->find();

        if($payInfo['oid'] == null){
            $this->error('您的提交是非法的!');
        }
        if($orderInfo['uid'] == $_SESSION['member']['uid'] && $orderInfo['status'] == 0){
            $order['orderId'] = $orderInfo['oid'];
            $order['orderName'] = C('WEIXIN.alipay_appname');
            $order['orderMoney'] = $orderInfo['total_money'];
            $order['orderFee'] = $orderInfo['freight'];
            $pay = new \Common\Api\aliPay();
            $pay->nowPay($order);
        }else{
            $this->error('非法操作!');
        }
    }

    public function returnPay(){
        if(I('get.is_success') == 'T' && I('get.trade_status') == 'TRADE_SUCCESS'){
            $order['oid'] = I('get.out_trade_no');
            $order['price'] = '已付金额：￥'.I('get.total_fee');
            $order['info'] = '您已支付成功，我们会尽快安排发货!';
            $order['status'] = 1;
        }else{
            $order['oid'] = I('get.out_trade_no');
            $order['price'] = '待付金额：￥'.I('get.total_fee');
            $order['info'] = '您的支付已失败，请重试!';
            $order['status'] = 0;
        }
        $this->assign('title','订单支付状态');
        $this->assign('order',$order);
        $this->display('Common:paySuccess');
    }

    public function notifyPay(){
        require_once(VENDOR_PATH."/Alipay/alipay.config.php");
        require_once(VENDOR_PATH."/Alipay/lib/alipay_notify.class.php");
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {
            $_SESSION['testInfo'] = $_POST['out_trade_no'];
            $oid['oid'] = array('eq',$_POST['out_trade_no']);
            $pro['alipay_id'] = $_POST['trade_no'];
            $pro['update_time'] = time();
            $pro['payway'] = $this->payInfo('getPayWay');
            $pro['status'] = $this->payInfo('getPayStatus');
            $proInfo = M('Product_order')->where($oid)->field('cart_id')->find();
            if(M('Product_order')->where($oid)->save($pro)){
                $cartWhere['id'] = array('exp','IN('.$proInfo['cart_id'].')');
                $goods = M('Product_cart')->where($cartWhere)->field('pro_id,num')->select();
                foreach ($goods as $k => $v) {
                    if($pro['status'] == 2){
                        M('Product')->where('id = '.$v['pro_id'])->setDec('stock',$v['num']);
                    }else if($pro['status'] == 6){
                        M('Product')->where('id = '.$v['pro_id'])->setInc('stock',$v['num']);
                    }
                }
                echo 'success';
            }
        }
    }

    public function allNotifyPay(){
        require_once(VENDOR_PATH."/Alipay/alipay.config.php");
        require_once(VENDOR_PATH."/Alipay/lib/alipay_notify.class.php");
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result){
            $alipayInfo['success'] = explode('|',$_POST['result_details']);
            $alipayInfo['error'] = explode('|',$_POST['fail_details']);
            foreach ($alipayInfo['success'] as $k => $v) {
                $alipay = explode('^',$v);
                if($alipay[2] != 'TRADE_HAS_CLOSED'){
                    $where['alipay_id'] = array('eq',$alipay[0]);
                    $orderInfo = M('Product_order')->where($where)->field('id,uid,cart_id,total_money,total_credit,status,old_status,pro_id')->find();
                    $cartWhere['id'] = array('exp','IN('.$orderInfo['cart_id'].')');
                    $cartWhere['uid'] = $orderInfo['uid'];
                    $cartInfo = M('Product_cart')->where($cartWhere)->field('pro_id,num,price,credit')->select();
                    switch ($orderInfo['status']){
                        case 2:
                        case 3:
                            if(M('Product_order')->where('id = '.$orderInfo['id'])->setField(array('status'=>1,'update_time'=>time()))){
                                foreach ($cartInfo as $k1 => $v1) {
                                    M('Product')->where('id = '.$v1['pro_id'])->setInc('stock',$v1['num']);
                                }
                            }
                            break;
                        case 4:
                            if(M('Product_order')->where('id = '.$orderInfo['id'])->setField(array('status'=>6,'update_time'=>time()))){
                                if($orderInfo['old_status'] == 5){
                                    foreach ($cartInfo as $k1 => $v1) {
                                        M('Product')->where('id = '.$v1['pro_id'])->setInc('stock',$v1['num']);
                                    }
                                    if(M('Member')->where('uid = '.$orderInfo['uid'])->setDec('money',$orderInfo['total_money'])){
                                        M('Member')->where('uid = '.$orderInfo['uid'])->setDec('credit',$orderInfo['total_credit']);
                                    }
                                }else{
                                    foreach ($cartInfo as $k1 => $v1) {
                                        M('Product')->where('id = '.$v1['pro_id'])->setInc('stock',$v1['num']);
                                    }
                                }
                            }
                            break;
                    }
                }else{
                    $file = fopen(RUNTIME_PATH."/payLog/".date('Y_m_d_H',time()).".log","a");
                    $payLog = '订单号:  '.$alipay[0]."   退款失败! 本次记录的订单号为支付宝订单号 \n";
                    $payLog .= "      |-- 失败原因:订单已经退款!无需再次退款!\n";
                    $payLog .= "      |-- 操作时间:".date('Y-m-d H:i:s',time())." 系统时间\n";
                    $payLog .= "-------------------------------------------------------------------\n";
                    fwrite($file,$payLog);
                    fclose($file);
                }
            }
            echo 'success';
        }
    }

    private function payInfo($str){
        switch($str){
            case 'getPayWay':
                $infoArr = array();
                $info = explode('|',$_POST['out_channel_type']);
                foreach ($info as $k => $v) {
                    switch ($v){
                        case 'BALANCE':
                            $infoArr[$k] = '支付宝余额';
                            break;
                        case 'CREDIT_PAY':
                            $infoArr[$k] = '信用支付支付方式';
                            break;
                        case 'CASH':
                            $infoArr[$k] = '现金支付方式';
                            break;
                        case 'CONSUMER_CARD':
                            $infoArr[$k] = '消费卡支付方式';
                            break;
                        case 'COUPON':
                            $infoArr[$k] = '红包支付方式';
                            break;
                        case 'VOUCHER':
                            $infoArr[$k] = '购物券支付方式';
                            break;
                        case 'POINT':
                            $infoArr[$k] = '积分支付方式';
                            break;
                        case 'WANG_HUI_E':
                            $infoArr[$k] = '网汇E支付方式';
                            break;
                        case 'PREPAID_CARD':
                            $infoArr[$k] = '预存卡支付方式';
                            break;
                        case 'INTERNATIONAL_CREDIT_CARD':
                            $infoArr[$k] = '国际卡支付方式';
                            break;
                        case 'PREPAY':
                            $infoArr[$k] = '预付卡支付方式';
                            break;
                        case 'RT_DISCOUNT':
                            $infoArr[$k] = '实时优惠支付方式';
                            break;
                        case 'CARTOON':
                            $infoArr[$k] = '借记卡卡通支付方式';
                            break;
                        case 'SC_DEBIT_CARTOON':
                            $infoArr[$k] = '结算中心借记卡卡通支付方式';
                            break;
                        case 'B2C_EBANK':
                            $infoArr[$k] = '借记卡B2C网银支付方式';
                            break;
                        case 'WANGDIAN_DEBIT_CARD':
                            $infoArr[$k] = '网点借记卡刷卡支付方式';
                            break;
                        case 'DEBIT_EXPRESS':
                            $infoArr[$k] = '借记卡快捷支付方式';
                            break;
                        case 'CREDIT_CARTOON':
                            $infoArr[$k] = '普通信用卡卡通支付方式';
                            break;
                        case 'BIGAMOUNT_CREDIT_CARTOON':
                            $infoArr[$k] = '大额信用卡卡通支付方式';
                            break;
                        case 'VISA':
                            $infoArr[$k] = 'VISA网银支付方式';
                            break;
                        case 'CREDIT_CARD_EBANK':
                            $infoArr[$k] = '信用卡网关支付方式';
                            break;
                        case 'MOTO_CREDIT_CARD':
                            $infoArr[$k] = 'moto信用卡支付方式';
                            break;
                        case 'OPTIMIZED_MOTO':
                            $infoArr[$k] = '信用卡快捷支付';
                            break;
                        case 'CREDIT_EXPRESS_INSTALLMENT':
                            $infoArr[$k] = '信用卡快捷分期支付';
                            break;
                        case 'WANGDIAN_CREDIT_CARD':
                            $infoArr[$k] = '网点信用卡刷卡支付方式';
                            break;
                        case 'INTERNATIONAL_CREDIT_CARD_VISA':
                            $infoArr[$k] = 'VISA支付方式';
                            break;
                        case 'INTERNATIONAL_CREDIT_CARD_MASTER':
                            $infoArr[$k] = 'MASTER支付方式';
                            break;
                        case 'INTERNATIONAL_CREDIT_CARD_JCB':
                            $infoArr[$k] = 'JCB支付方式';
                            break;
                        case 'MIXED_B2C_EBANK':
                            $infoArr[$k] = '混合卡B2C网银支付方式';
                            break;
                    }
                }
                if(empty($infoArr)){
                    return '支付宝在线支付';
                }else{
                    return implode('+',$infoArr);
                }
                break;
            case 'getPayStatus':
                switch ($_POST['trade_status']) {
                    case 'WAIT_BUYER_PAY':
                        return 0;
                        break;
                    case 'TRADE_SUCCESS':
                        return 2;
                    break;
                    default:
                        if($_POST['refund_status'] != null){
                            switch ($_POST['refund_status']) {
                                case 'REFUND_SUCCESS':
                                    return 6;
                                    break;
                            }
                        }
                        break;
                }
                break;
            default:
                return false;
                break;
        }
    }
}
?>