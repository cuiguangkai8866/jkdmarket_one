<?php

    namespace Common\Api;

    class aliPay{
        public function __construct(){

            if($_SESSION['member'] == null && MODULE_NAME == 'Home'){
                $this->error('对不起,请先登录!',U('/Login'),2);
                exit;
            }
            if($_SESSION['my_info'] == null && MODULE_NAME == 'Admin'){
                $this->error('对不起,请先登录!',U('/Login'),2);
                exit;
            }
        }
        public function nowPay($order){
            require_once(VENDOR_PATH."/AliPay/alipay.config.php");
            require_once(VENDOR_PATH."/AliPay/lib/alipay_submit.class.php");
            $payment_type = "1";
            $notify_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/').U('/notifyPay');
            $return_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/').U('/returnPay');

            $seller_email = C('WEIXIN.alipay_app');

            //商户订单号
            $out_trade_no = $order['orderId'];
            //订单名称
            $subject = $order['orderName'];
            //付款金额
            $total_fee = $order['orderMoney']+$order['orderFee'];
            //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html        //防钓鱼时间戳
            $anti_phishing_key = "";
            //若要使用请调用类文件submit中的query_timestamp函数        //客户端的IP地址
            $exter_invoke_ip = "";
            //非局域网的外网IP地址，如：221.0.0.1


            /************************************************************/

            //构造要请求的参数数组，无需改动
            $parameter = array(
                "service" => "create_direct_pay_by_user",
                "partner" => trim($alipay_config['partner']),
                "payment_type"	=> $payment_type,
                "notify_url"	=> $notify_url,
                "return_url"	=> $return_url,
                "seller_email"	=> $seller_email,
                "out_trade_no"	=> $out_trade_no,
                "subject"	=> $subject,
                "total_fee"	=> $total_fee,
                "body"	=> $body,
                "show_url"	=> $show_url,
                "anti_phishing_key"	=> $anti_phishing_key,
                "exter_invoke_ip"	=> $exter_invoke_ip,
                "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            );

            //建立请求
            $alipaySubmit = new \AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
            echo $html_text;
        }

        public function refundPay($order){
            require_once(VENDOR_PATH."/AliPay/alipay.config.php");
            require_once(VENDOR_PATH."/AliPay/lib/alipay_submit.class.php");
            $notify_url = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/').U('/allNotifyPay');
            $seller_email = C('WEIXIN.alipay_app');
            $refund_date = date('Y-m-d H:i:s',time());
            $batch_no =  date('Ymd',time()).date('His',time());
            $batch_num = count($order);
            $detail_data = implode('#',$order);
            $parameter = array(
                "service" => "refund_fastpay_by_platform_pwd",
                "partner" => trim($alipay_config['partner']),
                "notify_url"	=> $notify_url,
                "seller_email"	=> $seller_email,
                "refund_date"	=> $refund_date,
                "batch_no"	=> $batch_no,
                "batch_num"	=> $batch_num,
                "detail_data"	=> $detail_data,
                "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            );
            $alipaySubmit = new \AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
            echo $html_text;

        }
    }