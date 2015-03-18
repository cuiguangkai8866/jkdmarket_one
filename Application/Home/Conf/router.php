<?php
/**
 * Created by PhpStorm.
 * User: Ares
 * Date: 14-2-26
 * Time: 下午2:16
 */
return array(
    'URL_ROUTE_RULES'=>array(
        '/^Register$/i'    => 'Member/register',
        '/^login$/i'    => 'Member/login',
        '/^Logout$/i'    => 'Member/logout',
        '/^Re_pass$/i' => 'Member/getCheckLose_pass',
        '/^Set_pass$/i' => 'Member/set_pass',
        '/^shop$/i'=> 'Shoplist/shop',
        '/^search/i'=> 'Shoplist/search',
        '/^detail/' =>'Shoplist/detail',
        '/^buycart$/' =>'Shoplist/buycart',
        '/^really$/i' =>'Shoplist/really',
        '/^pay$/i'=> 'Shoplist/pay',
        '/^paipai$/i'=> 'Paipai/paipai',
        '/^ms$/i'=> 'Ms/ms',
        '/^tuan$/i'=> 'Tuan/tuan',
        '/^patDetail/i'=> 'Paipai/patDetail',
        '/^payAction$/i'=> 'Pay/dbAlipay',
        '/^returnPay/i'=> 'Pay/returnPay',
        '/^notifyPay/i'=> 'Pay/notifyPay',
        '/^allNotifyPay/i'=> 'Pay/allNotifyPay',
        '/^msDetail/'=> 'Ms/msDetail',
        '/^tDetail/'=> 'Tuan/tDetail',
        '/^Help$/'=> 'Help/process',

        'newsInfo/:id'=> 'Index/newsInfo',
		'qqlogin'=>'Member/qqlogin',
		'qqCallback'=>'Member/qqCallback',
		'aliFastLogin'=>'Member/aliFastLogin',
		'aliCallback'=>'Member/aliCallback',
		'wblogin'=>'Member/wblogin',
		'wbCallback'=>'Member/wbCallback',
        'bindUser' => 'Member/bindUser',
    ),
);