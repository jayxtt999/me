<?php

class Error
{


    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    static public function appException($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        //Log::record($error['message'],Log::ERR);
        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        self::halt($error);
    }

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
                if(C('debug:log_record')){
                    //Log::write("[$errno] ".$errorStr,Log::ERR);
                }
                self::halt($errorStr);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                $errorStr = "[$errno] $errstr ".$errfile." 第 $errline 行.";
                echo $errorStr;exit;
                self::trace($errorStr,'','NOTIC');
                break;
        }
    }



    // 致命错误捕获
    public static function fatalError()
    {
        if ($e = error_get_last()) {
            switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();
                    self::halt($e);
                    break;
            }
        }
    }


    public static function halt($error)
    {
        $e = array();
        if (C('app_debug') || IS_CGI) {
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
            if (IS_CGI) {
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

    /**
     * 添加和获取页面Trace记录
     * @param string $value 变量
     * @param string $label 标签
     * @param string $level 日志级别(或者页面Trace的选项卡)
     * @param boolean $record 是否记录日志
     * @return void
     */
    static public function trace($value='[think]',$label='',$level='DEBUG',$record=false) {
        static $_trace =  array();
        if('[think]' === $value){ // 获取trace信息
            return $_trace;
        }else{
            $info   =   ($label?$label.':':'').print_r($value,true);
            if('ERR' == $level && C('TRACE_EXCEPTION')) {// 抛出异常
                E($info);
            }
            $level  =   strtoupper($level);
            if(!isset($_trace[$level]) || count($_trace[$level])>C('TRACE_MAX_RECORD')) {
                $_trace[$level] =   array();
            }
            $_trace[$level][]   =   $info;
            if((defined('IS_AJAX') && IS_AJAX) || !C('SHOW_PAGE_TRACE')  || $record) {
                //Log::record($info,$level,$record);
            }
        }
    }

}