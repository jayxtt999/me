<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Admin\Controller;


class indexController extends abstractController{

    function indexAction(){
        $v = $this->getView();
        $v->display();
    }

    function index2Action(){
        $this->View()->display();
    }


}