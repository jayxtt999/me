<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class indexController extends abstractController{

    function indexAction(){


        $this->View()->display();
    }

    public function index2Action(){
        $this->View()->assign(array('name' => 'thinkphp'));
        $this->View()->display('index2');
    }


}