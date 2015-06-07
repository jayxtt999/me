<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */
namespace Admin\Controller;
use Admin\Model\commonModel;

class notFoundController extends abstractController{



    function indexAction(){

        $this->View()->display();
    }



}