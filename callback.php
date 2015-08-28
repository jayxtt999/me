<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/28
 * Time: 16:22
 */

$code = $_GET['code'];
$state = $_GET['state'];
header("Location:http://www.xietaotao.cn/index.php?m=member&c=open&a=callback&id=2&code=$code&state=$state");