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
function E($e)
{
    switch ($e) {
        case "notFound":
            @header("http/1.1 404 not found");
            @header("status: 404 not found");
            include(APP_TEMP_PATH . '/404.html');
            break;
    }
}

/**
 * @param $msg
 */
function Show($msg)
{
    echo "<h3>" . $msg . "</h3>";
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '')
{
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

/**
 * 获取完整URL
 * @return string
 */
function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
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
function C($name = null, $val = null)
{

    static $_config = array();
    $name = $name ? strtolower($name) : null;
    $val = $val ? strtolower($val) : null;
    if (isset($name) && isset($val) && is_string($name)) {
        if (strpos($name, ":")) {
            $configStr = "";
            $config = explode(":", $name);
            foreach ($config as $v) {
                $configStr .= "['" . $v . "']";
            }
            eval("return \$_config$configStr = \$val;");
        } else {
            return $_config[$name] = $val;
        }
    } elseif (isset($name) && !$val) {
        if (strpos($name, ":")) {
            $configStr = "";
            $config = explode(":", $name);
            foreach ($config as $v) {
                $configStr .= "['" . $v . "']";
            }
            $c1 = $c2 = "";
            eval("\$c1 = Application::\$appConfig$configStr;");
            eval("\$c2 = \$_config$configStr;");
            if (isset($c)) {
                return $c2;
            } else {
                return $c1;
            }
        } else {
            if (isset($_config[$name])) {
                return $_config[$name];
            } else {
                return Application::$appConfig[$name];
            }
        }
    } else {
        //返回全部
        return array_merge(Application::$appConfig, $_config);
    }

}

/**
 * @param $lib
 * @return mixed
 */
function  load($lib)
{
    if (empty($lib)) {
        trigger_error('加载类库名不能为空');
    } else {
        return Application::$_lib[$lib];
    }
}

/**
 * 时间记录
 * @param $start
 * @param string $end
 * @param int $dec
 */
function G($start, $end = '', $dec = 4)
{
    static $_info = array();
    static $_mem = array();
    if (is_float($end)) { // 记录时间
        $_info[$start] = $end;
    } elseif (!empty($end)) { // 统计时间和内存使用
        if (!isset($_info[$end])) $_info[$end] = microtime(TRUE);
        if (MEMORY_LIMIT_ON && $dec == 'm') {
            if (!isset($_mem[$end])) $_mem[$end] = memory_get_usage();
            return number_format(($_mem[$end] - $_mem[$start]) / 1024);
        } else {
            return number_format(($_info[$end] - $_info[$start]), $dec);
        }

    } else { // 记录时间和内存使用
        $_info[$start] = microtime(TRUE);
        if (MEMORY_LIMIT_ON) $_mem[$start] = memory_get_usage();
    }
}


/**
 * 钩子函数
 * @param $tag
 * @param null $params
 * @return bool
 */
function Hook($tag, &$params = NULL)
{
    if ($tag) {
        if (APP_DEBUG) {
            G($tag . 'Start');
            \System\Core\Error::trace('[ ' . $tag . ' ] --START--', '', 'INFO');
        }
        // 执行扩展
        if (strpos($tag, '/')) {
            list($tag, $method) = explode('/', $tag);
        } else {
            $method = 'run';
        }
        $class = "\\System\\Library\\Hook\\" . $tag . 'Hook';

        if (APP_DEBUG) {
            G('behaviorStart');
        }
        $behavior = new $class();
        $behavior->$method($params);
        if (APP_DEBUG) { // 记录行为的执行日志
            G('behaviorEnd');
            \System\Core\Error::trace($tag . ' Hook ::' . $method . ' [ RunTime:' . G('behaviorStart', 'behaviorEnd', 6) . 's ]', '', 'INFO');
        }

        if (APP_DEBUG) { // 记录行为的执行日志
            \System\Core\Error::trace('[ ' . $tag . ' ] --END-- [ RunTime:' . G($tag . 'Start', $tag . 'End', 6) . 's ]', '', 'INFO');
        }
    } else { // 未执行任何行为 返回false
        return false;
    }

}


/**
 * session
 * @param $name
 * @param string $value
 */
function session($name, $value = '')
{
    $prefix = C('session:session_prefix');
    if (is_array($name)) {
        if (isset($name['prefix'])) C('session:session_prefix', $name['prefix']);
        if (C('session:var_session_id') && isset($_REQUEST[C('session:var_session_id')])) {
            session_id($_REQUEST[C('session:var_session_id')]);
        } elseif (isset($name['id'])) {
            session_id($name['id']);
        }
        ini_set('session.auto_start', 0);

        if (isset($name['name'])) session_name($name['name']);
        if (isset($name['path'])) session_save_path($name['path']);
        if (isset($name['domain'])) ini_set('session.cookie_domain', $name['domain']);
        if (isset($name['expire'])) ini_set('session.gc_maxlifetime', $name['expire']);
        if (isset($name['use_trans_sid'])) ini_set('session.use_trans_sid', $name['use_trans_sid'] ? 1 : 0);
        if (isset($name['use_cookies'])) ini_set('session.use_cookies', $name['use_cookies'] ? 1 : 0);
        if (isset($name['cache_limiter'])) session_cache_limiter($name['cache_limiter']);
        if (isset($name['cache_expire'])) session_cache_expire($name['cache_expire']);
        if (isset($name['type'])) C('session:session_type', $name['type']);
        if (C('SESSION_TYPE')) { // 读取session驱动
            $class = 'Session' . ucwords(strtolower(C('session:session_type')));
            // 检查驱动类
            if (require_once(EXTEND_PATH . '/Session/' . $class . '.class.php')) {
                $hander = new $class();
                $hander->execute();
            } else {
                // 类没有定义
                Error::halt('_CLASS_NOT_EXIST_' . ': ' . $class);
            }
        }
        if (C('session:session_auto_start')) {
            session_start();
        }
    } elseif ('' === $value) {
        if (0 === strpos($name, '[')) { // session 操作
            if ('[pause]' == $name) { // 暂停session
                session_write_close();
            } elseif ('[start]' == $name) { // 启动session
                session_start();
            } elseif ('[destroy]' == $name) { // 销毁session
                $_SESSION = array();
                session_unset();
                session_destroy();
            } elseif ('[regenerate]' == $name) { // 重新生成id
                session_regenerate_id();
            }
        } elseif (0 === strpos($name, '?')) { // 检查session
            $name = substr($name, 1);
            if (strpos($name, '.')) { // 支持数组
                list($name1, $name2) = explode('.', $name);
                return $prefix ? isset($_SESSION[$prefix][$name1][$name2]) : isset($_SESSION[$name1][$name2]);
            } else {
                return $prefix ? isset($_SESSION[$prefix][$name]) : isset($_SESSION[$name]);
            }
        } elseif (is_null($name)) { // 清空session
            if ($prefix) {
                unset($_SESSION[$prefix]);
            } else {
                $_SESSION = array();
            }
        } elseif ($prefix) { // 获取session
            if (strpos($name, '.')) {
                list($name1, $name2) = explode('.', $name);
                return isset($_SESSION[$prefix][$name1][$name2]) ? $_SESSION[$prefix][$name1][$name2] : null;
            } else {
                return isset($_SESSION[$prefix][$name]) ? $_SESSION[$prefix][$name] : null;
            }
        } else {
            if (strpos($name, '.')) {
                list($name1, $name2) = explode('.', $name);
                return isset($_SESSION[$name1][$name2]) ? $_SESSION[$name1][$name2] : null;
            } else {
                return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
            }
        }

    } elseif (is_null($value)) { // 删除session
        if ($prefix) {
            unset($_SESSION[$prefix][$name]);
        } else {
            unset($_SESSION[$name]);
        }
    } else { // 设置session
        if ($prefix) {
            if (!is_array($_SESSION[$prefix])) {
                $_SESSION[$prefix] = array();
            }
            $_SESSION[$prefix][$name] = $value;
        } else {
            $_SESSION[$name] = $value;
        }
    }

}

function db()
{
    return \System\Core\Model::getDb();
}

/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $options cookie参数
 * @return mixed
 */
function cookie($name, $value = '', $option = null)
{
    // 默认设置
    $config = array(
        'prefix' => C('COOKIE:COOKIE_PREFIX'), // cookie 名称前缀
        'expire' => C('COOKIE:COOKIE_EXPIRE'), // cookie 保存时间
        'path' => C('COOKIE:COOKIE_PATH'), // cookie 保存路径
        'domain' => C('COOKIE:COOKIE_DOMAIN'), // cookie 有效域名
    );
    // 参数设置(会覆盖黙认设置)
    if (!is_null($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config = array_merge($config, array_change_key_case($option));
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) { // 如果前缀为空字符串将不作处理直接返回
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
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            if (0 === strpos($value, 'blog:')) {
                $value = substr($value, 6);
                return array_map('urldecode', json_decode(MAGIC_QUOTES_GPC ? stripslashes($value) : $value, true));
            } else {
                return $value;
            }
        } else {
            return null;
        }
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]); // 删除指定cookie
        } else {
            // 设置cookie
            if (is_array($value)) {
                $value = 'blog:' . json_encode(array_map('urlencode', $value));
            }
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value;
        }
    }
}

/**
 * @param $key
 * @param int $step
 * @param bool $save
 */
function N($key, $step = 0, $save = false)
{
    static $_num = array();
    if (!isset($_num[$key])) {
        $_num[$key] = (false !== $save) ? S('N_' . $key) : 0;
    }
    if (empty($step))
        return $_num[$key];
    else
        $_num[$key] = $_num[$key] + (int)$step;
    if (false !== $save) { // 保存结果
        C('N_' . $key, $_num[$key], $save);
    }
}


/**
 * 自动加载
 * @param $name
 */
function loader($class)
{
    $matches = array();
    preg_match('/(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $class, $matches);
    $class = (isset($matches['class'])) ? $matches['class'] : '';
    $namespace = (isset($matches['namespace'])) ? $matches['namespace'] : '';

    if (substr($class, -10) == "Controller" && strlen($class) !== 10) {
        $classPath = APP_PATH . "/" . str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . ext;
        if (file_exists($classPath)) {
            return include $classPath;
        }
    } elseif (substr($class, -5) == "Model" && strlen($class) !== 5) {
        $classPath = APP_PATH . "/" . str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . ext;
        if (file_exists($classPath)) {
            return include $classPath;
        }
    } elseif (is_file(APP_PATH . "/" . str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . ext)) {
        $classPath = APP_PATH . "/" . str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . ext;
        if (file_exists($classPath)) {
            return include $classPath;
        }
    } else {
        $classPath = str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . EXT;
        if (file_exists(ROOT_PATH . "/" . $classPath)) {
            return include ROOT_PATH . "/" . $classPath;
        }
    }

}

/**
 * 缓存
 * @param $key
 * @param string $val
 * @param string $model  model 默认文件名为 MD5（key ）,否则为自定义文件名模式
 */
function cache($key, $val = "",$model="")
{

    $cache = new \System\Core\Cache();
    $type = C("cache:type");
    $cache = new \System\Library\Cache\cacheFile();
    $cache->connect($type, C("cache:$type"));
    if (!empty($key) && !empty($val)) {
        $cache->set($key, $val);
    } else if ($key && !$val) {
        if ($cache->get($key)) {
            return $cache->get($key);
        } else {
            $cache->delete($key);
        }
    }

}


/**
 * 根据理由模型返回指定路模式的url
 * 支持2中方式
 * 方式1 array: Array ( [module] => admin [controller] => index [action] => index )
 * 方式2 string:admin,index,index
 * @param string $url
 * @return string
 */
function getUrl($url = "")
{
    $url = $url ? $url : \System\Core\Route::$routeUrl;
    if (is_array($url)) {
        $urls = $url;
    } else if (is_string($url)) {
        $urlTmp = explode(",", $url);
        $urls = array();
        $urls['module'] = $urlTmp[0];
        $urls['controller'] = $urlTmp[1];
        $urls['action'] = $urlTmp[2];
    }
    if (C("route:url_type") == "default") {
        //default 模式
        return "/index.php?m=" . $urls['module'] . "&c=" . $urls['controller'] . "&a=" . $urls['action'] . "";
    } else {
        //pathInfo 模式

    }

}

/**
 * GET
 * @param $key
 * @param string $limit
 * @return mixed
 */
function get($key, $limit = '')
{

    $var = $_GET;
    if ($key == '') {
        return $var;
    }
    if ($limit == '') {
        $igc = isset($var[$key]) ? $var[$key] : false;
    } else {
        $igc = $var[$key];
        return \System\Library\safeFilter::$limit($igc);
    }
}

/**
 * POST
 * @param $key
 * @param string $limit
 * @return mixed
 */
function post($key, $limit = '')
{

    $var = $_POST;
    if ($key == '') {
        return $var;
    }
    if ($limit == '') {
        $igc = isset($var[$key]) ? $var[$key] : false;
    } else {
        $igc = $var[$key];
        return \System\Library\safeFilter::$limit($igc);
    }
}

/**
 * 错误抛出
 * @param $msg
 */
function exception($msg)
{
    return \System\Core\Error::halt($msg);
}








