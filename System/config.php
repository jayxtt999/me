<?php
/**
 * Ӧ��ȫ������
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-24
 * Time: ����10:23
 */

return array(
    /*���ݿ�����*/
    'db' => array(
        //Ĭ�����ݿ�����
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
    /*·������*/
    'route' => array(
        'default_controller' => 'index', //ϵͳĬ�Ͽ�����
        'default_action' => 'index', //ϵͳĬ�Ϸ���
        'url_type' => 'default' /*����URL����ʽ default Ϊ��ͨģʽ    index.php?m=module&c=controller&a=action&id=2
                                   ����URL����ʽ pathinfoΪPATHINFO ģʽ  index.php/module/controller/action/id/2(��ʱ��ʵ��)*/
    ),
    /*��ͼ����*/
    'view_type' => 'myTemp',
    'view_templates' => 'default',
    /*�����ļ�����*/
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
        'show_page_trace' => true,
        'page_trace_save' => false,
        'tmpl_exception_file'=>'exception.html',
        'tmpl_trace_file'=>'trace.html',
        'log_record'=>true,  // ������־��¼
        'log_exception_record'  => true,    // �Ƿ��¼�쳣��Ϣ��־
        'log_level'       =>   'emerg,alert,crit,err,warn,notic,info,debug,sql',  // �����¼����־����
        'db_fields_cache'=> false, // �ֶλ�����Ϣ
        'app_file_case'  =>   true, // �Ƿ����ļ��Ĵ�Сд ��windowsƽ̨��Ч
    ),

    /* �������� */
    'error'=> array(
        'error_message'         =>  '�������ڲ�����...',//������ʾ��Ϣ,�ǵ���ģʽ��Ч
        'error_page'            =>  '/Content/Templates/error.html',	// ������ҳ��
        'show_error_msg'        =>  true,    // ��ʾ������Ϣ
        'trace_exception'       =>  false,   // trace������Ϣ�Ƿ����쳣 ���trace����
        'trace_max_record'      =>  100,    // ÿ������Ĵ�����Ϣ ����¼��
    ),
    /* ��־���� */
    'log' => array(
        'log_type'              =>  'file', // ��־��¼���� Ĭ��Ϊ�ļ���ʽ
        'log_path'              =>  '/Data/Log', // ��־��¼���� Ĭ��Ϊ�ļ���ʽ
        'log_level'             =>  'emerg,alert,crit,err',// �����¼����־����
        'log_file_size'         =>  2097152,	// ��־�ļ���С����
        'log_exception_record'  =>  false,    // �Ƿ��¼�쳣��Ϣ��־
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
        'PREFIX'    => '', // cookie ����ǰ׺
        'EXPIRE'    => '3600', // cookie ����ʱ��
        'PATH'      =>  '/', // cookie ����·��
        'DOMAIN'    =>  '', // cookie ��Ч����
    ),





);