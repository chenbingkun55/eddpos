<?php
return array(
    'MODULE_ALLOW_LIST'     => array('Home','Admin','Secure'), //允许访问的模块
    'LANG_SWITCH_ON'        => true,   // 开启语言包功
    'LANG_AUTO_DETECT'      => false, // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'             => 'en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'          => 'l', // 默认语言切换变量
    'URL_MODEL'             => 2, //配合 Apache rewrite 消除URL里的index.php,需要开启 AllowOverride All
    'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息

    //SESSION
    'SESSION_AUTO_START'    => true, //是否开启SESSION
    'SESSION_TYPE'          => 'Dbi', //Session 写入数据库
    'SESSION_PREFIX'        => 'edd_',
    'SESSION_EXPIRE'        => 3600, //session 过期时间
    'SESSION_TABLE'         => 'edd_session', //存放session 数据表

    //数据库
    'DB_HOST'               => 'localhost',
    'DB_USER'               => 'root',
    'DB_TYPE'               => 'mysqli',
    'DB_NAME'               => 'eddpos',
    'DB_PWD'                => '123456',
    'DB_PORT'               => '3306',
    'DB_PREFIX'             => 'edd_',

    //自定义配置
    'SITE_NAME'             => '易点点 管理系统',
    'SECURE_KEY'            => 'TEST',
);
