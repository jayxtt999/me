<?php

class Error
{

    /**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    static public function appError($errno, $errstr, $errfile, $errline) {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                $errorStr = "$errstr ".$errfile." 第 $errline 行.";
                if(C('LOG_RECORD')) Log::write("[$errno] ".$errorStr,Log::ERR);
                self::stop($errorStr);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                $errorStr = "[$errno] $errstr ".$errfile." 第 $errline 行.";
                self::trace($errorStr,'','NOTIC');
                break;
        }
    }



    // 致命错误捕获
    public static function fatalError()
    {
        if ($e = error_get_last()) {
            ob_end_clean();
            self::stop($e);
        }
    }


    public static function stop($error)
    {
        $e = array();
        if (C('app_debug') || PHP_SAPI == "cli") {
            //调试模式下输出错误信息
            if (!is_array($error)) {
                $trace = debug_backtrace();
                $e['message'] = $error;
                $e['file'] = $trace[0]['file'];
                $e['line'] = $trace[0]['line'];
                ob_start();
                debug_print_backtrace();
                $e['trace'] = ob_get_clean();
            } else {
                $e = $error;
            }
            if (PHP_SAPI == "cli") {
                exit($e['message'] . PHP_EOL . 'FILE: ' . $e['file'] . '(' . $e['line'] . ')' . PHP_EOL . $e['trace']);
            }
        } else {
            //否则定向到错误页面
            $error_page = C('error:error_page');
            if (!empty($error_page)) {
                redirect($error_page);
            } else {
                if (C('error:show_error_msg'))
                    $e['message'] = is_array($error) ? $error['message'] : $error;
                else
                    $e['message'] = C('error:error_message');
            }
        }
        // 包含异常页面模板
        $TMPL_EXCEPTION_FILE = C('debug:tmpl_exception_file');
        if (!$TMPL_EXCEPTION_FILE) {
            //显示在加载配置文件之前的程序错误
            exit('<b>Error:</b>' . $e['message'] . ' in <b> ' . $e['file'] . ' </b> on line <b>' . $e['line'] . '</b>');
        }
        include APP_TEMP_PATH . "/" . $TMPL_EXCEPTION_FILE;
        exit;

    }


}