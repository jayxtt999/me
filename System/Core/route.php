<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午2:07
 */
class Route{

    public static  $config;
    public static  $urlType;
    public static  $urlQuery;
    public static  $routeUrl = array();
    public static  $error;

    public static  function init($config) {

        self::$error = Application::loadLibs('error');
        self::$config = $config;
        self::$urlQuery = parse_url($_SERVER['REQUEST_URI']);
        $urlType = $config['url_type'];
        switch($urlType){
            case 'default':
                self::defaultToArray();
                break;
            case 'pathinfo':
                self::pathinfoToArray();
                break;
            default:
                self::defaultToArray();
        }
    }

    public static   function defaultToArray(){
        $query = explode("&",self::$urlQuery['query']);
        $q = array('m'=>'','c'=>'','a'=>'');
        foreach($query as $v){
            $arr = explode("=",$v);
            $q[$arr[0]] = $arr[1];
        }
        self::$routeUrl['module'] = $q['m']?$q['m']:null;
        self::$routeUrl['controller'] = $q['c']?$q['c']:self::$config['default_controller'];
        self::$routeUrl['action'] = $q['a']?$q['a']:self::$config['default_action'];
        unset($q['m'],$q['c'],$q['a']);
        if(count($q)>0){
            self::$routeUrl['params'] = $q;
        }
        if(self::$routeUrl['module']){
            self::routeToCm();
        }else{
            self::$error->notFound();
        }

    }

    public static  function routeToCm(){
        require_once(APP_PATH.'/'.ucfirst(self::$routeUrl['module']).'/Controller/abstractController.php');
        require_once(APP_PATH.'/'.ucfirst(self::$routeUrl['module']).'/Controller/'.self::$routeUrl['controller'].'Controller.php');
        $controller = self::$routeUrl['controller'].'Controller';
        $controller = new $controller;
        $action = self::$routeUrl['action'].'Action';
        if(method_exists($controller, $action)){
            isset($params) ? $controller ->$action($params) : $controller ->$action();
        }else{
            self::$error->show('控制器方法'.$action.'不存在');
        }
    }

}