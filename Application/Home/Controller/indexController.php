<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class indexController extends Controller{

    function indexAction(){
        $this->V()->display('index.html');

    }


}