<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/7 0007
 * Time: обнГ 5:44
 */

namespace System\Library;


class Request {

    function param(){



    }


    function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest';
    }


    function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }


} 