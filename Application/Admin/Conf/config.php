<?php
$DB_PREFIX = C('DB_PREFIX');
return array(
    'admin_big_menu' => array(
        'Index' => '首页',
         'Member' => '会员管理',
        'Product'=>'商品管理',
//        'Padmin'=>'拍拍管理',
        'Madmin'=>'秒杀管理',
        'Tadmin'=>'团购管理',
        'News' => '资讯管理',
        'Siteinfo'=>'网站功能',
         //'Models'=>'模型管理',
        'SysData' => '数据管理',
        'Access' => '权限管理',
    ),
    'admin_sub_menu' => array(
        'Common' => array(
            'Index/myInfo' => '修改密码',
            'Index/cache' => '缓存清理',
            'News/add' => '新闻发布'
        ),
        'Webinfo' => array(
            'index' => '站点配置',
            'setEmailConfig' => '邮箱配置',
            'setSafeConfig' => '安全配置',
            'setWeixin'=>'密钥配置',
            'setListNum'=>'全局配置',
        ),
        'Models'=>array(
            'index'=>'模型列表',
            'add'=>'添加模型',
            ),
        'Fields'=>array(
            'jkd/Models/index'=>'模型列表',
            'jkd/Models/add'=>'添加模型',
            ),
        'Member' => array(
            'index' => '用户列表',
//            'u_group' => '用户等级',
//            'u_group' => '用户等级',
        ),
        'News' => array(
            'index' => '新闻列表',
            'category' => '新闻分类管理',
            'add' => '发布新闻',
        ),
        'Product'=>array(
            'add' => '发布新的商品',
            'index' => '所有商品列表',
            'category'=>'商品分类管理',
            'propList' => '商品属性管理',
//            'stock' => '库存不足商品',
//            'successOrder'=>'已成功订单',
//            'waitPayOrder'=>'待支付订单',
//            'waitDeliveryOrder'=>'待发货订单',
//            'waitReallyOrder'=>'待确认订单',
//            'waitRefundOrder'=>'待退款订单',
//            'errorOrder'=>'已失效订单',
        ),
        'Siteinfo'=>array(
            'index'=>'导航菜单',
            'adindex'=>'轮播管理',
            'page'=>'单页管理',
//            'tag_index'=>'标签管理',
//            'create_tag'=>'模版标签',
            //'file_index'=>'文件管理',
//            'link_index'=>'友情链接',
            'message'=>'留言信息',
            'zixun'=>'咨询列表',
            'pingjia'=>'评价列表',
			'seoAdmin' => 'SEO管理',
			'kdIndex' => '快递管理',

        ),
        'SysData' => array(
            'index' => '数据库备份',
            'restore' => '数据库导入',
            'zipList' => '数据库压缩包',
            'repair' => '数据库优化修复'
        ),
        'Access' => array(
            'index' => '后台用户',
            'nodeList' => '节点管理',
            'roleList' => '角色管理',
            'addAdmin' => '添加管理员',
            'addNode' => '添加节点',
            'addRole' => '添加角色',
        ),
        'Padmin' => array(
            'index' => '所有拍拍列表',
            'waitStart' => '即将开始的拍拍',
            'now' => '正在进行的拍拍',
            'endList' => '已结束的拍拍',
        ),
        'Madmin' => array(
            'add' => '发布秒杀商品',
            'index' => '秒杀商品列表',
            'waitStart' => '即将开始的秒杀',
            'now' => '正在进行的秒杀',
            'endList' => '已结束的秒杀',
            'successOrder'=>'已成功订单',
            'waitPayOrder'=>'待支付订单',
            'waitDeliveryOrder'=>'待发货订单',
            'waitReallyOrder'=>'待确认订单',
            'waitRefundOrder'=>'待退款订单',
            'errorOrder'=>'已失效订单',
        ),
        'Tadmin' => array(
            'add' => '发布团购商品',
            'index' => '团购商品列表',
            'waitStart' => '即将开始的团购',
            'now' => '正在进行的团购',
            'endList' => '已结束的团购',
            'successOrder'=>'已成功订单',
            'waitPayOrder'=>'待支付订单',
            'waitDeliveryOrder'=>'待发货订单',
            'waitReallyOrder'=>'待确认订单',
            'waitRefundOrder'=>'待退款订单',
            'errorOrder'=>'已失效订单',
        ),
    ),
    /*
     * 以下是RBAC认证配置信息
     */
    'USER_AUTH_ON' => true,
    'USER_AUTH_TYPE' => 2, // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY' => 'authId', // 用户认证SESSION标记
//    'ADMIN_AUTH_KEY' => '422857458@qq.com',
    'USER_AUTH_MODEL' => 'Admin', // 默认验证数据表模型
    'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式encrypt
    'USER_AUTH_GATEWAY' => '/admin/Public/index', // 默认认证网关
    'NOT_AUTH_MODULE' => 'Public', // 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => '', // 默认需要认证模块
    'NOT_AUTH_ACTION' => '', // 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
    'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, // 游客的用户ID
    'RBAC_ROLE_TABLE' => $DB_PREFIX . 'role',
    'RBAC_USER_TABLE' => $DB_PREFIX . 'role_user',
    'RBAC_ACCESS_TABLE' => $DB_PREFIX . 'access',
    'RBAC_NODE_TABLE' => $DB_PREFIX . 'node',
    'URL_HTML_SUFFIX'=>'',
    
    //'URL_HTML_SUFFIX'       => C('TOKEN.URL_HTML_SUFFIX'),  // URL伪静态后缀设置
    //'URL_MODEL' =>C('TOKEN.false_static'),// URL伪静态设置/开启，关闭
    
    'LOAD_EXT_CONFIG'=>'model_menu',
    // 系统保留表明
    'SYSTEM_TBL_NAME' => 'model,models,filed,fileds,admin,admins',
    /*
     * 系统备份数据库时每个sql分卷大小，单位字节
     */
    'sqlFileSize' => 5242880, //该值不可太大，否则会导致内存溢出备份、恢复失败，合理大小在512K~10M间，建议5M一卷
        //10M=1024*1024*10=10485760
        //5M=5*1024*1024=5242880
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__UPLOAD__' => __ROOT__ . '/Uploads',
        '__STATIC__' => __ROOT__ . '/Public',
        '__IMG__'    => __ROOT__ . '/Public/Admin/Img',
        '__CSS__'    => __ROOT__ . '/Public/Admin/Css',
        '__JS__'     => __ROOT__ . '/Public/Admin/Js',
        '--PUBLIC--'=>__ROOT__ . '/Public' ,
    ),
//    'URL_ROUTER_ON'   => true,// 开启路由
//    'URL_ROUTE_RULES'=>array(
//        'Webinfo/setShop'    => 'Webinfo/index',
//    ),
     // 表单令牌
    'TOKEN_ON' => false,
);

//return array_merge($config_arr1, $config_arr2);
?>