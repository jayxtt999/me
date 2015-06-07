<?php
/**
 * 入口文件
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-24
 * Time: 下午10:09
 */

// 记录开始运行时间
$GLOBALS['_beginTime'] = microtime(TRUE);
// 记录内存初始使用
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();

require_once 'System/init.php';
Application::run();
