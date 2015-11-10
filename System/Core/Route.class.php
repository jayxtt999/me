<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午2:07
 */
namespace System\Core;
class Route{
    public static  $config;
    public static  $urlType;
    public static  $urlQuery;
    public static  $routeUrl = array();

    /**
     * 初始化 暂时只支持默认模式
     * @param $config
     */
    public static  function init($config) {
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

    /**
     * 路由默认模式
     */
    public static   function defaultToArray(){
        $q = array('m'=>'','c'=>'','a'=>'');
        $query = @self::$urlQuery["query"];
        if($query){
            $query = explode("&",$query);
        }
        if(is_array($query)){
            foreach($query as $v){
                $arr = explode("=",$v);
                $q[$arr[0]] = $arr[1];
            }
        }
        self::$routeUrl['module'] = $q['m']?$q['m']:"home";
        self::$routeUrl['controller'] = $q['c']?$q['c']:self::$config['default_controller'];
        self::$routeUrl['action'] = $q['a']?$q['a']:self::$config['default_action'];
        unset($q['m'],$q['c'],$q['a']);
        if(count($q)>0){
            self::$routeUrl['params'] = $q;
        }
        if(self::$routeUrl['module']){
            self::routeToCm();
        }else{
            E("notFound");
        }
    }

    /**
     * 控制器实现
     */
    public static  function routeToCm(){

        //require_once(APP_PATH.'/'.ucfirst(self::$routeUrl['module']).'/Controller/abstractController.php');
        //require_once(APP_PATH.'/'.ucfirst(self::$routeUrl['module']).'/Controller/'.self::$routeUrl['controller'].'Controller.php');
        //Admin\Controller\Index;
        $controller = "\\".ucfirst(self::$routeUrl['module'])."\\Controller\\".self::$routeUrl['controller'].'Controller';
        $controller = new $controller;
        $action = self::$routeUrl['action'].'Action';
        try{

            $ca  = new \ReflectionMethod($controller,$action);
            $ca->invoke(new $controller,isset($params)?$params:null);
        }catch (\Exception $e){
            exception('控制器方法'.$action.'不存在');
        }

    }

}