<?php

/*
 * ͨ�������ļ�
 * Author��leo.li��281978297@qq.com��
 * Date:2013-02-01
 */

return array(
    /* ���ݿ����� */

    'DB_TYPE' => 'mysql', // ���ݿ�����
    'SHOW_PAGE_TRACE' => FALSE,
    'TOKEN_ON' => true, // �Ƿ���������֤
    'TOKEN_NAME' => '__conist__', // ������֤�ı������ֶ�����
    'TOKEN_TYPE' => 'md5', //���ƹ�ϣ��֤���� Ĭ��ΪMD5
    'TOKEN_RESET' => FALSE, //������֤������Ƿ��������� Ĭ��Ϊtrue
    'LOAD_EXT_CONFIG' => 'systemConfig',

    'DEFAULT_C_LAYER'       =>  'Controller', // Ĭ�ϵĿ�����������
    'MODULE_ALLOW_LIST'     =>  array('Home','Jkd','Member'), // ������ԭ���ķ����б�
    'DEFAULT_MODULE'        =>  'Home', // ������ԭ����Ĭ�Ϸ���
	'MODULE_DENY_LIST'      =>  array('Wap','Common','Runtime','Ucenter'),
	'URL_MODULE_MAP'    =>    array('jkd'=>'admin'),	//ģ��ӳ��
);
/*$config2 = WEB_ROOT . "Common/Conf/systemConfig.php";
$config2 = file_exists($config2) ? include "$config2" : array();
return array_merge($config1, $config2);*/