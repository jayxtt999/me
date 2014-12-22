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


define('SYSTEM_PATH', dirname(__FILE__));
define('ROOT_PATH', substr(SYSTEM_PATH, 0, -7));
define('SYS_LIB_PATH', SYSTEM_PATH . '/Library/System');
define('EXTEND_PATH', SYSTEM_PATH . '/Library/Extends');
define('Hook_PATH', EXTEND_PATH . '/Hook');
define('APP_PATH', ROOT_PATH . '/Application');
define('APP_LIB_PATH', SYSTEM_PATH . '/Library/Vendor');
define('APP_TEMP_PATH', ROOT_PATH . '/Content/Templates');
define('APP_FUNCTION_PATH', ROOT_PATH . '/Content/Function');
define('SYS_CORE_PATH', SYSTEM_PATH . '/Core');
define('MODULE_PATH', ROOT_PATH . '/Application');
define('JS_PLUGINS_PATH', ROOT_PATH . '/APP_TEMP_PATH/System/plugins');

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

define('APP_DEBUG', TRUE);

final class Application
{
    public static $appLib = null;
    public static $appConfig = null;

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
        spl_autoload_register('loader');
        //Hook('app_begin');
        $route = self::$appLib['route'];
        $route::init(self::$appConfig['route']); //设置url的类型
        // 项目结束拓展
        Hook('trace');
    }


    public static function init()
    {
        self::setAutoLibs();
        self::autoload();
        // 设定错误和异常处理
        self::loadError();
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
        register_shutdown_function('Error::fatalError');
        set_exception_handler('Error::appException');
        set_error_handler('Error::appError');
    }

    /**
     * 自动加载类库
     * @access      public
     * @param       array $appLib
     */
    public static function autoload()
    {
        foreach (self::$appLib as $key => $value) {
            require(self::$appLib[$key]);
            $lib = ucfirst($key);
            self::$appLib[$key] = new $lib; //待解决问题  $lib 为静态
        }
        //加载方法库
        require_once(APP_FUNCTION_PATH . '/function' . EXT);
    }

    /**
     * 设置需要自动加载的类库
     * @access      public
     */
    public static function setAutoLibs()
    {
        self::$appLib = array(
            'route' => SYS_CORE_PATH . '/route.php',
            'view' => SYS_CORE_PATH . '/view.php',
            'model' => SYS_CORE_PATH . '/model.php',
            'controller' => SYS_CORE_PATH . '/controller.php',
            'db' => SYS_CORE_PATH . '/db.php',
            'error' => SYS_CORE_PATH . '/error.php',
            'log' => SYS_CORE_PATH . '/log.php',
        );
    }

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


}



