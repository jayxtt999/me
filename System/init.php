<?php
/**
 * 应用驱动类
 * @copyright   Copyright(c) 2011
 * @author      yuansir <yuansir@live.cn/yuansir-web.com>
 * @version     1.0
 */
define('SYSTEM_PATH', dirname(__FILE__));
define('ROOT_PATH',  substr(SYSTEM_PATH, 0,-7));
define('SYS_LIB_PATH', SYSTEM_PATH.'/Library/System');
define('APP_PATH', ROOT_PATH.'/Application');
define('APP_LIB_PATH', SYSTEM_PATH.'/Library/Vendor');
define('APP_TEMP_PATH', ROOT_PATH.'/Content/Templates');
define('APP_FUNCTION_PATH', ROOT_PATH.'/Content/Function');
define('SYS_CORE_PATH', SYSTEM_PATH.'/Core');
define('MODULE_PATH', ROOT_PATH.'/Application');
define('LOG_PATH', ROOT_PATH.'/Data/log');
define('BLOG_TOKEN', "8D053BCA4C590011BE4A6A8D8C1E7BD7");
final class Application {
        public static $appLib = null;
        public static $appConfig = null;
        public static function init() {
                self::setAutoLibs();
        }
        /**
         * 创建应用
         * @access      public
         * @param       array   $config
         */
        public static function run($config){
            self::$appConfig = $config;
            self::init();
            self::autoload();
            $route = self::$appLib['route'];
            $route::init(self::$appConfig['route']); //设置url的类型
        }
        /**
         * 自动加载类库
         * @access      public
         * @param       array   $appLib
         */
        public static function autoload(){
                foreach (self::$appLib as $key => $value){
                        require (self::$appLib[$key]);
                        $lib = ucfirst($key);
                        self::$appLib[$key] = new $lib;//待解决问题  $lib 为静态
                }
        }

        /**
         * 自动加载的类库
         * @access      public 
         */
        public static function setAutoLibs(){
                self::$appLib = array(
                    'route' => SYS_CORE_PATH.'/route.php',
                    'view' => SYS_CORE_PATH.'/view.php',
                    'model' => SYS_CORE_PATH.'/model.php',
                    'controller' => SYS_CORE_PATH.'/controller.php',
                    'db' => SYS_CORE_PATH.'/db.php',
                );
        }

        public static function loadLibs($className){
            if(empty($className)){
                trigger_error('加载类库名不能为空');
            }
            $appFunction = APP_FUNCTION_PATH.'/'.$className.'.class.php';
            if(file_exists($appFunction)){
                require ($appFunction);
                $classNameS = explode("/",$className);
                foreach($classNameS as $v){
                    $className = $v;
                }
                $className = ucfirst($className);
                return new $className;
            }else{
                trigger_error('加载 '.$className.' 类库不存在');
            }
        }

        //自动初始化
        public static function initLib($config){


        }

}


