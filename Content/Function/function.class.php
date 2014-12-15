<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午7:37
 */


/**
 * 错误函数
 * @param $e
 */
function E($e){
    switch($e){
        case "notFound":
            @header("http/1.1 404 not found");
            @header("status: 404 not found");
            include(APP_TEMP_PATH . '/404.html');
        break;
    }
}

function Show($msg)
{
    echo "<h3>" . $msg . "</h3>";
}

function M($model){
    $route = Application::$appLib['route'];
    $routeUrl = $route::$routeUrl;
    if (empty($model)) {
        trigger_error('不能实例化空模型');
    }
    require_once APP_PATH.'/'.ucfirst($routeUrl['module']).'/Model/'.ucfirst($model).'Model.php';
    $model_name = $model . 'Model';
    return new $model_name;
}

function C($config=null){
    if(isset($config)){
        if(strpos($config,":")){
            $configStr = "";
            $config = explode(":",$config);
            foreach($config as $v){
                $configStr .= "['".$v."']";
            }
            $c= "";
            eval("\$c = Application::\$appConfig$configStr;");
            return $c;
        }else{
            return Application::$appConfig[$config];
        }
    }else{
        return Application::$appConfig;
    }
}

function  load($lib){
    if(empty($lib)){
        trigger_error('加载类库名不能为空');
    }else{
        return Application::$_lib[$lib];
    }
}











