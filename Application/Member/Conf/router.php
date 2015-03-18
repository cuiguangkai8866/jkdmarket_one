<?php
/**
 * Created by PhpStorm.
 * User: Ares
 * Date: 14-2-26
 * Time: 下午2:16
 */
return array(
    'URL_ROUTE_RULES'=>array(
        "/^Order$/"    => 'Order/index',
        "/^Sale/"    => 'Order/sale',
        "/^GroupOn/"    => 'Order/groupon',
        "/^MyPat/"    => 'Order/myPat',
        "/^loadMsList/"    => 'Order/loadMsList',
        "/^loadPatList/"    => 'Order/loadPatList',
        "/^loadTuanList/"    => 'Order/loadTuanList',
        "/^Safe$/"    => 'Account/safe_index',
        "/^Address$/"    => 'Account/address',
        "/^User$/"    => 'Account/user_info',
        '/^Detail/'=>'Order/orderDetail',
        '/^loadOrderList/' =>'Order/loadOrderList',
        '/^Evaluation/' =>'Order/evaluation',
        '/^loadEvaluationList/' =>'Order/loadEvaluationList',
        '/^loadEvaluationDetail/' =>'Order/loadEvaluationDetail',
        '/^Favorite/' =>'Order/favorite',
        '/^loadFavorite/' =>'Order/loadFavorite',
        '/^Rcdforme/' =>'Order/rcdforme',
        '/^Consulting/' =>'Service/consulting',
        '/^loadConsulting/' =>'Service/loadConsulting',
        '/^ForRefund/' =>'Order/loadForRefund',
        '/^refundAction/' =>'Order/refundAction',
        '/^Refund/' =>'Service/refund',
        '/^loadRefund/' =>'Service/loadRefund',
        '/^refundDetail/' =>'Service/refundDetail',
        '/^requestMessage/' =>'Service/requestMessage',
        '/^loadRequestMessage/' =>'Service/loadRequestMessage',
        '/^Message/' =>'Service/message',
        '/^loadMessage/' =>'Service/loadMessage',
    ),
);