<?php
/**
 * 应用全局配置
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-24
 * Time: 下午10:23
 */

return array(
    /*数据库配置*/
    'db' => array(
        //默认数据库配置
        'db_type' => 'pdoMysql',
         'db_sql_log' => 'false',
        'pdoMysql' => array(
            'dsn'   => 'mysql:dbname=myframe;host=127.0.0.1;',
            'username' => 'root',
            'password' => '',
            'profiler' => true,
            'options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
        )
    ),
    /*路由配置*/
    'route' => array(
        'default_controller' => 'index', //系统默认控制器
        'default_action' => 'index', //系统默认方法
        'url_type' => 'default' /*定义URL的形式 default 为普通模式    index.php?m=module&c=controller&a=action&id=2
                                   定义URL的形式 pathinfo为PATHINFO 模式  index.php/module/controller/action/id/2(暂时不实现)*/
    ),
    /*视图配置*/
    'view_type' => 'myTemp',
    'view_templates' => 'default',
    /*缓存文件配置*/
    'view' => array(

        //smarty
        'smarty' => array(
            'left_delimiter' => '{',
            'right_delimiter' => '}',
            'template_dir' => 'Content/Templates/default',
            'compile_dir' => 'Data/template_c',
            'php_handling' => 'SMARTY_PHP_ALLOW',
        ),
        //Thinkphp
        'myTemp' => array(
            'template_dir' => 'Content/Templates/default',
            'cache_path' => 'Data/template_c',
            'template_suffix' => '.html',
            'cache_suffix' => '.php',
            'tmpl_cachfile_suffix' => '.php',
            'tmpl_cache' => true,
            'cache_time' => 0,
            'taglib_begin' => '<',
            'taglib_end' => '>',
            'tmpl_begin' => '\{',
            'tmpl_end' => '\}',
            'default_tmpl' => null,
            'tmpl_cache_time' => -1,
            'layout_item' => '{__CONTENT__}',
            'tmpl_deny_php' => false,
            'tmpl_l_delim' => '<{',
            'tmpl_r_delim' => '}>',
            'tmpl_strip_space' => false,
            'tmpl_parse_string'=>array(),
            'tmpl_var_identify'=>"array",
            'taglib_load'=>true,
            'tmpl_engine_type'=>"mytp",

        ),
    ),
    /*Debug*/
    'debug'=>array(
        'tmpl_exception_file'=>'exception.html',
        'tmpl_trace_file'=>'trace.html',
        'log_record'=>true,  // 进行日志记录
        'log_exception_record'  => true,    // 是否记录异常信息日志
        'log_level'       =>   'emerg,alert,crit,err,warn,notic,info,debug,sql',  // 允许记录的日志级别
        'db_fields_cache'=> false, // 字段缓存信息
        'app_file_case'  =>   true, // 是否检查文件的大小写 对windows平台有效
        'show_page_trace'   => true,   // 显示页面Trace信息
        'trace_page_tabs'   => array('BASE'=>'基本','FILE'=>'文件','INFO'=>'流程','ERR|NOTIC'=>'错误','SQL'=>'SQL','DEBUG'=>'调试'), // 页面Trace可定制的选项卡
        'page_trace_save'   => false,
    ),

    /* 错误设置 */
    'error'=> array(
        'error_message'         =>  '服务器内部错误...',//错误显示信息,非调试模式有效
        'error_page'            =>  '/Content/Templates/error.html',	// 错误定向页面
        'show_error_msg'        =>  true,    // 显示错误信息
        'trace_exception'       =>  false,   // trace错误信息是否抛异常 针对trace方法
        'trace_max_record'      =>  100,    // 每个级别的错误信息 最大记录数
    ),
    /* 日志设置 */
    'log' => array(
        'log_type'              =>  'file', // 日志记录类型 默认为文件方式
        'log_path'              =>  '/Data/Log', // 日志记录类型 默认为文件方式
        'log_level'             =>  'emerg,alert,crit,err',// 允许记录的日志级别
        'log_file_size'         =>  2097152,	// 日志文件大小限制
        'log_exception_record'  =>  false,    // 是否记录异常信息日志
        'log_dest'  =>  '',
        'log_extra'  =>  '',
    ),

    /*session*/
    'session' => array(
        'name' => 'session_name',
        'prefix' => 'blog',
        'expire' => '3600',
        'session_auto_start' => false,
    ),

    /*cookie*/
    'cookie' => array(
        'PREFIX'    => '', // cookie 名称前缀
        'EXPIRE'    => '3600', // cookie 保存时间
        'PATH'      =>  '/', // cookie 保存路径
        'DOMAIN'    =>  '', // cookie 有效域名
    ),

    /*杂项*/
    'default_timezone' => 'PRC',





);