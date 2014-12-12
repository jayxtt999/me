<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:38
 */

class Model {
    public $config;
    public static  $routeUrl;
    public static  $db;
    /**
     * 实例化模型
     * @access      final   protected
     * @param       string  $model  模型名称
     */
    final static   function init($model) {

        $route = Application::$appLib['route'];
        self::$routeUrl = $route::$routeUrl;
        if (empty($model)) {
            trigger_error('不能实例化空模型');
        }
        require_once APP_PATH.'/'.ucfirst( self::$routeUrl['module']).'/Model/'.ucfirst($model).'Model.php';
        $model_name = $model . 'Model';
        return new $model_name;
    }

    /**
     * 加载类库
     * @param string $lib   类库名称
     * @return type
     */
    final static function load($lib){
        if(empty($lib)){
            trigger_error('加载类库名不能为空');
        }else{
            return Application::$_lib[$lib];
        }
    }
    /**
     * @access      final   protected
     * @param       string  $config 配置名
     */
    final static function getConfig($config=null){
        if(isset($config)){
            return Application::$appConfig[$config];
        }else{
            return Application::$appConfig;
        }

    }

    final static function getDb(){
        if(self::$db){
            return self::$db;
        }else{
            $DB = new DB();
            $DB->init(self::getConfig('db'));
            return $DB;
        }
    }

    final static function getFrom(){



    }




}