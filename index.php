<?php
/**
 * 入口文件
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-24
 * Time: 下午10:09
 */

require_once 'System/init.php';
$config = require_once 'config.php';
Application::run($config);
