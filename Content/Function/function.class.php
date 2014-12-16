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

/**
 * 获取当前模块下的模型
 * @param $model
 * @return mixed
 */
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


/**
 *
 * 获取设置(获取config配置)当被覆盖赋值时是返回赋值
 * @param null $name
 * @param null $val
 * @return string
 * example:
 *       C('test:name',"zhang");
 *       C('demo',"val");
 */
function C($name=null,$val=null){

    static $_config = array();
    $name = $name?strtolower($name):null;
    $val = $val?strtolower($val):null;
    if(isset($name) && isset($val) &&is_string($name)){
        if(strpos($name,":")){
            $configStr = "";
            $config = explode(":",$name);
            foreach($config as $v){
                $configStr .= "['".$v."']";
            }
            eval("return \$_config$configStr = \$val;");
        }else{
            return $_config[$name] = $val;
        }
    }elseif(isset($name) && !$val){
        if(strpos($name,":")){
            $configStr = "";
            $config = explode(":",$name);
            foreach($config as $v){
                $configStr .= "['".$v."']";
            }
            $c1= $c2 ="";
            eval("\$c1 = Application::\$appConfig$configStr;");
            eval("\$c2 = \$_config$configStr;");
            if(isset($c)){
                return $c2;
            }else{
                return $c1;
            }
        }else{
            if(isset($_config[$name])){
                return $_config[$name];
            }else{
                return  Application::$appConfig[$name];
            }
        }
    }else{
        //返回全部
        return array_merge(Application::$appConfig,$_config);
    }

}

function  load($lib){
    if(empty($lib)){
        trigger_error('加载类库名不能为空');
    }else{
        return Application::$_lib[$lib];
    }
}

/**
 * 时间记录
 * @param $start
 * @param string $end
 * @param int $dec
 */
function G($start,$end='',$dec=4) {
    static $_info       =   array();
    static $_mem        =   array();
    if(is_float($end)) { // 记录时间
        $_info[$start]  =   $end;
    }elseif(!empty($end)){ // 统计时间和内存使用
        if(!isset($_info[$end])) $_info[$end]       =  microtime(TRUE);
        if(MEMORY_LIMIT_ON && $dec=='m'){
            if(!isset($_mem[$end])) $_mem[$end]     =  memory_get_usage();
            return number_format(($_mem[$end]-$_mem[$start])/1024);
        }else{
            return number_format(($_info[$end]-$_info[$start]),$dec);
        }

    }else{ // 记录时间和内存使用
        $_info[$start]  =  microtime(TRUE);
        if(MEMORY_LIMIT_ON) $_mem[$start]           =  memory_get_usage();
    }
}


/**
 * 钩子函数
 * @param $tag
 * @param null $params
 * @return bool
 */
function Hook($tag, &$params=NULL){
    if($tag) {
        if(APP_DEBUG) {
            G($tag.'Start');
            Error::trace('[ '.$tag.' ] --START--','','INFO');
        }
        // 执行扩展
        if(strpos($tag,'/')){
            list($tag,$method) = explode('/',$tag);
        }else{
            $method     =   'run';
        }

        $class = $tag.'Hook';
        if(is_file(Hook_PATH."/".$class.EXT)){
            require_once (Hook_PATH."/".$class.EXT);
        }
        if(APP_DEBUG) {
            G('behaviorStart');
        }



        $reflectionMethod  = new ReflectionMethod('traceHook',$method);

        $reflectionMethod->invokeArgs(new traceHook(),$params);

        exit;
        if(APP_DEBUG) { // 记录行为的执行日志
            G('behaviorEnd');
            Error::trace($tag.' Hook ::'.$method.' [ RunTime:'.G('behaviorStart','behaviorEnd',6).'s ]','','INFO');
        }

        if(APP_DEBUG) { // 记录行为的执行日志
            Error::trace('[ '.$tag.' ] --END-- [ RunTime:'.G($tag.'Start',$tag.'End',6).'s ]','','INFO');
        }
    }else{ // 未执行任何行为 返回false
        return false;
    }

}


/**
 * session
 * @param $name
 * @param string $value
 */
function session($name,$value=''){
    $prefix   =  C('session:session_prefix');
    if(is_array($name)){
        if(isset($name['prefix'])) C('session:session_prefix',$name['prefix']);
        if(C('session:var_session_id') && isset($_REQUEST[C('session:var_session_id')])){
            session_id($_REQUEST[C('session:var_session_id')]);
        }elseif(isset($name['id'])) {
            session_id($name['id']);
        }
        ini_set('session.auto_start', 0);

        if(isset($name['name']))            session_name($name['name']);
        if(isset($name['path']))            session_save_path($name['path']);
        if(isset($name['domain']))          ini_set('session.cookie_domain', $name['domain']);
        if(isset($name['expire']))          ini_set('session.gc_maxlifetime', $name['expire']);
        if(isset($name['use_trans_sid']))   ini_set('session.use_trans_sid', $name['use_trans_sid']?1:0);
        if(isset($name['use_cookies']))     ini_set('session.use_cookies', $name['use_cookies']?1:0);
        if(isset($name['cache_limiter']))   session_cache_limiter($name['cache_limiter']);
        if(isset($name['cache_expire']))    session_cache_expire($name['cache_expire']);
        if(isset($name['type']))            C('session:session_type',$name['type']);
        if(C('SESSION_TYPE')) { // 读取session驱动
            $class      = 'Session'. ucwords(strtolower(C('session:session_type')));
            // 检查驱动类
            if(require_once(EXTEND_PATH.'/Session/'.$class.'.class.php')) {
                $hander = new $class();
                $hander->execute();
            }else {
                // 类没有定义
                throw_exception(L('_CLASS_NOT_EXIST_').': ' . $class);
            }
        }
        if(C('session:session_auto_start')){
            session_start();
        }
    }elseif('' === $value){
        if(0===strpos($name,'[')) { // session 操作
            if('[pause]'==$name){ // 暂停session
                session_write_close();
            }elseif('[start]'==$name){ // 启动session
                session_start();
            }elseif('[destroy]'==$name){ // 销毁session
                $_SESSION =  array();
                session_unset();
                session_destroy();
            }elseif('[regenerate]'==$name){ // 重新生成id
                session_regenerate_id();
            }
        }elseif(0===strpos($name,'?')){ // 检查session
            $name   =  substr($name,1);
            if(strpos($name,'.')){ // 支持数组
                list($name1,$name2) =   explode('.',$name);
                return $prefix?isset($_SESSION[$prefix][$name1][$name2]):isset($_SESSION[$name1][$name2]);
            }else{
                return $prefix?isset($_SESSION[$prefix][$name]):isset($_SESSION[$name]);
            }
        }elseif(is_null($name)){ // 清空session
            if($prefix) {
                unset($_SESSION[$prefix]);
            }else{
                $_SESSION = array();
            }
        }elseif($prefix){ // 获取session
            if(strpos($name,'.')){
                list($name1,$name2) =   explode('.',$name);
                return isset($_SESSION[$prefix][$name1][$name2])?$_SESSION[$prefix][$name1][$name2]:null;
            }else{
                return isset($_SESSION[$prefix][$name])?$_SESSION[$prefix][$name]:null;
            }
        }else{
            if(strpos($name,'.')){
                list($name1,$name2) =   explode('.',$name);
                return isset($_SESSION[$name1][$name2])?$_SESSION[$name1][$name2]:null;
            }else{
                return isset($_SESSION[$name])?$_SESSION[$name]:null;
            }
        }

    }elseif(is_null($value)){ // 删除session
        if($prefix){
            unset($_SESSION[$prefix][$name]);
        }else{
            unset($_SESSION[$name]);
        }
    }else{ // 设置session
        if($prefix){
            if (!is_array($_SESSION[$prefix])) {
                $_SESSION[$prefix] = array();
            }
            $_SESSION[$prefix][$name]   =  $value;
        }else{
            $_SESSION[$name]  =  $value;
        }
    }

}


/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $options cookie参数
 * @return mixed
 */
function cookie($name, $value='', $option=null) {
    // 默认设置
    $config = array(
        'prefix'    =>  C('COOKIE:COOKIE_PREFIX'), // cookie 名称前缀
        'expire'    =>  C('COOKIE:COOKIE_EXPIRE'), // cookie 保存时间
        'path'      =>  C('COOKIE:COOKIE_PATH'), // cookie 保存路径
        'domain'    =>  C('COOKIE:COOKIE_DOMAIN'), // cookie 有效域名
    );
    // 参数设置(会覆盖黙认设置)
    if (!is_null($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config     = array_merge($config, array_change_key_case($option));
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return;
    }
    $name = $config['prefix'] . $name;
    if ('' === $value) {
        if(isset($_COOKIE[$name])){
            $value =    $_COOKIE[$name];
            if(0===strpos($value,'blog:')){
                $value  =   substr($value,6);
                return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
            }else{
                return $value;
            }
        }else{
            return null;
        }
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]); // 删除指定cookie
        } else {
            // 设置cookie
            if(is_array($value)){
                $value  = 'blog:'.json_encode(array_map('urlencode',$value));
            }
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value;
        }
    }
}








