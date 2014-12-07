<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 上午11:01
 */

class View {

    public static $view;
    public static $error;
    public static $config;
    public static $assignData;
    public static  $routeUrl;
    public static  function init($type) {
        if(self::$view){
            return self::$view;
        }
        if(!empty($type)){
            require_once SYS_LIB_PATH.'/View/'.ucfirst($type).'/'.ucfirst($type).'.class.php';
            $types = ucfirst($type);
            self::$view =  new $types;
            self::$config = Application::$appConfig['view'][$type];
            $ro = Application::$appLib['route'];
            self::$routeUrl = $ro::$routeUrl;
            if(self::$routeUrl['module'] == "admin"){
                self::$config['template_dir'] = APP_TEMP_PATH."/system";
            }
            foreach(self::$config as $key=>$value){
                self::$view -> $key = $value;
            }
        }else{
            self::$error->show("模版解析模式不能为空！");
        }
    }

    public  function assign($data){
        self::$assignData  = $data;
        return $this;
    }
    public  function display($template=null){
        $template = isset($template)?$template.'.html':self::$routeUrl['module']."_".self::$routeUrl['controller'].'.html';
        if(is_array(self::$assignData)){
            foreach(self::$assignData as $key=>$value){
                self::$view->assign($key, $value);
            }
        }
        self::$view->display($template);
    }

}