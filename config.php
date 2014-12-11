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
    'route' => array(
        'default_controller' => 'index', //系统默认控制器
        'default_action' => 'index', //系统默认方法
        'url_type' => 'default' /*定义URL的形式 default 为普通模式    index.php?m=module&c=controller&a=action&id=2
                                   定义URL的形式 pathinfo为PATHINFO 模式  index.php/module/controller/action/id/2(暂时不实现)*/
    ),
    'view_type' => 'myTemp',
    'templates' => 'default',
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
        //myTemp
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

        ),
    ),
);