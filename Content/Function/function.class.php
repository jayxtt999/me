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









