<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Home\Controller;


class indexController extends abstractController{

    public function indexAction(){

        $v = $this->getView();
        $v->display();
    }



}