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
    \System\Library\Hook::listen($tag, $params);
}


/**
 * Todo 必须先加载才能获取
 * 检查钩子是否有插件函数
 * @param $tag
 * @param null $params
 * @return bool
 */
function havePlugs($tag)
{
    return db()->table("hook")->getRow(array('name' => $tag))->fields("plugs")->done();
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
        // 启动session
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
    //控制器
    if (substr($class, -10) == "Controller" && strlen($class) !== 10) {
        $classPath = APP_PATH . "/" . str_replace('\\', '/', $namespace) . str_replace('_', '/', $class) . ext;
        if (file_exists($classPath)) {
            return include $classPath;
        }
    } //模型
    elseif (substr($class, -5) == "Model" && strlen($class) !== 5) {
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
 * @param string $model model 默认文件名为 MD5（key ）,否则为自定义文件名模式
 */
function cache($key, $val = "", $path = "", $model = "")
{

    $cache = new \System\Core\Cache();
    $type = C("cache:type");
    $cache = new \System\Library\Cache\cacheFile();
    $cache->connect($type, C("cache:$type"));
    if (!empty($key) && !empty($val)) {
        $cache->set($key, $val, $path, $model);
    } else if ($key && !$val) {
        if ($cache->get($key, $path, $model)) {
            return $cache->get($key, $path, $model);
        } else {
            $cache->delete($key, $path, $model);
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


/**
 * 获取用户信息
 * @param $id
 * @return mixed
 */
function member($id)
{
    $user = db()->Table('member_info')->getRow(array('id' => $id))->done();        //getAll
    return $user['username'];
}


/**
 * 日志分割
 *
 * @param string $content 日志内容
 * @param int $lid 日志id
 */
function breakLog($content, $lid)
{
    $a = explode('[break]', $content, 2);
    if (!empty($a[1])) {
        $a[0] .= '<p class="readmore"><a href="' . Url::log($lid) . '">阅读全文&gt;&gt;</a></p>';
    }
    return $a[0];
}

/**
 * 删除[break]标签
 *
 * @param string $content 日志内容
 */
function rmBreak($content)
{
    $content = str_replace('[break]', '', $content);
    return $content;
}


/**
 * 执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
/*function doAction($hook) {
    global $emHooks;
    $args = array_slice(func_get_args(), 1);
    if (isset($emHooks[$hook])) {
        foreach ($emHooks[$hook] as $function) {
            $string = call_user_func_array($function, $args);
        }
    }
}*/


/**
 * json
 * @param $array
 */
function JsonObject($array)
{
    header("Content-type: application/json");
    exit(json_encode($array));
}


/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function getPlugClass($name)
{
    $class = "\\Content\\Plugins\\" . ucfirst($name) . "\\" . ucfirst($name) . "Plugin";
    return $class;
}


/**
 * 获取插件信息
 * @param $pluginClassName
 * @return mixed
 */
function getPluginData($name)
{
    $pluginClassName = getPlugClass($name);
    $plug = new $pluginClassName;
    return $plug->info;

}


/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str 要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ',')
{
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array $arr 要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ',')
{
    return implode($glue, $arr);
}


/**
 * 添加和获取页面Trace记录
 * @param string $value 变量
 * @param string $label 标签
 * @param string $level 日志级别
 * @param boolean $record 是否记录日志
 * @return void|array
 */
function trace($value = '[xtt]', $label = '', $level = 'DEBUG', $record = false)
{
    return \System\Core\Error::trace($value, $label, $level, $record);
}

/**
 * Token
 * @param int $len
 * @param bool $md5
 * @return string
 */
function getToken($len = 32, $md5 = true)
{
    # Seed random number generator
    # Only needed for PHP versions prior to 4.2
    mt_srand((double)microtime() * 1000000);
    # Array of characters, adjust as desired
    $chars = array(
        'Q',
        '@',
        '8',
        'y',
        '%',
        '^',
        '5',
        'Z',
        '(',
        'G',
        '_',
        'O',
        '`',
        'S',
        '-',
        'N',
        '<',
        'D',
        '{',
        '}',
        '[',
        ']',
        'h',
        ';',
        'W',
        '.',
        '/',
        '|',
        ':',
        '1',
        'E',
        'L',
        '4',
        '&',
        '6',
        '7',
        '#',
        '9',
        'a',
        'A',
        'b',
        'B',
        '~',
        'C',
        'd',
        '>',
        'e',
        '2',
        'f',
        'P',
        'g',
        ')',
        '?',
        'H',
        'i',
        'X',
        'U',
        'J',
        'k',
        'r',
        'l',
        '3',
        't',
        'M',
        'n',
        '=',
        'o',
        '+',
        'p',
        'F',
        'q',
        '!',
        'K',
        'R',
        's',
        'c',
        'm',
        'T',
        'v',
        'j',
        'u',
        'V',
        'w',
        ',',
        'x',
        'I',
        '$',
        'Y',
        'z',
        '*'
    );
    # Array indice friendly number of chars;
    $numChars = count($chars) - 1;
    $token = '';
    # Create random token at the specified length
    for ($i = 0; $i < $len; $i++)
        $token .= $chars[mt_rand(0, $numChars)];
    # Should token be run through md5?
    if ($md5) {
        # Number of 32 char chunks
        $chunks = ceil(strlen($token) / 32);
        $md5token = '';
        # Run each chunk through md5
        for ($i = 1; $i <= $chunks; $i++)
            $md5token .= md5(substr($token, $i * 32 - 32, 32));
        # Trim the token
        $token = substr($md5token, 0, $len);
    }
    return $token;
}


/**
 * 删除文件夹所有及其文件
 * @param $name
 * @return bool
 */
function deletePlugDir($dir)
{

    if (str_replace("/", "\\", $dir) !== realpath($dir) || !is_dir($dir))
    {
        return false;
    }

    //先删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    //删除当前文件夹：
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}

/**
 *  获取模板名
 * @return mixed
 */
function getTplName()
{
    return db()->table("template")->getRow(array('status' => 1))->fields("name")->done();
}

/**
 * 是否为后台管理界面
 * @return mixed
 */
function isManagement()
{
    return \System\Core\View::$isManagement;
}

/**
 * 获取文件名后缀
 */
function getFileSuffix($fileName) {
    return strtolower(pathinfo($fileName,  PATHINFO_EXTENSION));
}

/**
 * @param $zipFile 压缩包
 * @param $path   要解压的路径
 * @param $type   类型  tpl=>模板 plug=>插件
 */
function unZip($zipFile,$path,$type){

    if (class_exists('ZipArchive', FALSE)) {
        $zip = new ZipArchive();
        if (@$zip->open($zipFile) === TRUE) {
            $r = explode('/', $zip->getNameIndex(0), 2);
            $dir = isset($r[0]) ? $r[0] . '/' : '';
            switch ($type) {
                case 'tpl':
                    $re = $zip->getFromName($dir . 'info.log');
                    if (false === $re)
                        return -2;
                    break;
                case 'plugin':
                    $plugin_name = substr($dir, 0, -1);
                    $re = $zip->getFromName($dir . $plugin_name . '.php');
                    if (false === $re)
                        return -1;
                    break;
            }
            if (true === @$zip->extractTo(APP_TEMP_PATH)) {
                $zip->close();
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    } else {
        return -3;
    }






}


?>