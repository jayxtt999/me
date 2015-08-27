<?php
/**
 * 应用驱动类
 * @copyright   Copyright(c) 2014
 * @author      xietaotao <435024179@qq.com>
 * @version     1.0
 */

// 版本信息
const BLOG_VERSION = '1.0';
// 类文件后缀
const EXT = '.class.php';
const ext = '.php';

define('SYSTEM_PATH', dirname(__FILE__));
define('ROOT_PATH', substr(SYSTEM_PATH, 0, -7));
define('SYS_LIB_PATH', '/System/Library');
define('Hook_PATH', SYS_LIB_PATH . '/Hook');
define('APP_PATH', ROOT_PATH . '/Application');
define('APP_TEMP_PATH', ROOT_PATH . '/Content/Templates');
define('WEB_TEMP_PATH','/Content/Templates');
define('PLUGIN_PATH', ROOT_PATH . '/Content/Plugins/');
define('APP_FUNCTION_PATH', ROOT_PATH . '/Content/Function');
define('SYS_CORE_PATH', SYSTEM_PATH . '/Core');
define('JS_PLUGINS_PATH', ROOT_PATH . '/APP_TEMP_PATH/System/plugins');
define('ADMIM_TPL_PATH', '/Content/Templates/system');
define('TEMPLATE_PATH', '/Content/Templates');
define('UPLOAD_PATH','/Data/upload/');
define('CACHE_PATH','Data/cache/');

define('IS_CGI', substr(PHP_SAPI, 0, 3) == 'cgi' ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);

// 定义当前请求的系统常量
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || !empty($_POST['ajax']) || !empty($_GET['ajax'])) ? true : false);

define('BLOG_TOKEN', "8D053BCA4C590011BE4A6A8D8C1E7BD7");

define('APP_DEBUG', true);

final class Application
{
    public static $appLib = null;
    public static $appConfig = null;
    public static $rqFile = array();

    /**
     * 创建应用
     * @access      public
     * @param       array $config
     */
    public static function run()
    {
        self::$appConfig = require_once 'config.php';
        //初始化
        self::init();
        // 项目开始拓展
        //Hook('appBegin');
        $route = self::$appLib['route'];
        $route::init(self::$appConfig['route']); //设置url的类型
        Hook('appEnd');
    }

    public static function init()
    {
        //设置自动加载类
        self::setAutoLibs();
        //自动加载 run
        self::autoload();
        // 设定错误和异常处理
        self::loadError();
        //设定插件加载映射
        self::loadPlug();
        //设置网页压缩方式
        if (C('output_encode')) {
            $zlib = ini_get('zlib.output_compression');
            if (empty($zlib)) ob_start('ob_gzhandler');
        }
        // 设置系统时区
        date_default_timezone_set(C('default_timezone'));
        // Session初始化
        session(C('session'));
        // 记录应用初始化时间
        G('initTime');

    }

    /**
     * 设定错误和异常处理
     */
    public static function loadError()
    {
        error_reporting(0);
        register_shutdown_function('\System\Core\Error::fatalError');
        set_exception_handler('\System\Core\Error::appException');
        set_error_handler('\System\Core\Error::appError');
    }

    /**
     * 自动加载类库
     * @access      public
     * @param       array $appLib
     */
    public static function autoload()
    {
        //加载方法库
        require_once(APP_FUNCTION_PATH . '/function' . EXT);
        //加载拓展库
        //require_once ROOT_PATH.'/vendor/autoload.php';
        //自动加载
        spl_autoload_register('loader');
        //Core
        foreach (self::$appLib as $key => $value) {
            //require_once SYS_CORE_PATH."/".$value.EXT;
            self::$appLib[$key] = new $value;
        }
    }

    /**
     * 设置需要自动加载的类库
     * @access      public
     */
    public static function setAutoLibs()
    {
        self::$appLib = array(
            'route' => '\\System\\Core\\Route',
            'view' => '\\System\\Core\\View',
            'model' => '\\System\\Core\\Model',
            'controller' => '\\System\\Core\\Controller',
            'db' => '\\System\\Core\\Db',
            'error' => '\\System\\Core\\Error',
            'log' => '\\System\\Core\\Log',
            'cache' => '\\System\\Core\\Cache',
        );
    }

    /**
     * 加载类库
     * @param $className
     */
    public static function loadLibs($className)
    {
        if (empty($className)) {
            trigger_error('加载类库名不能为空');
        }
        $appFunction = APP_FUNCTION_PATH . '/' . $className . EXT;
        if (file_exists($appFunction)) {
            require($appFunction);
            $classNameS = explode("/", $className);
            foreach ($classNameS as $v) {
                $className = $v;
            }
            $className = ucfirst($className);
            return new $className;
        } else {
            trigger_error('加载 ' . $className . ' 类库不存在');
        }
    }

    /**
     * 读取钩子与插件的对应关系
     */
    public static function loadPlug()
    {
        $plugsAll = \Admin\Model\hookModel::getPlugs();
        \System\Library\Hook::setTags($plugsAll);

    }


}



