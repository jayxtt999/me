<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;


class plugController extends abstractController{

    public function indexAction(){

        $plugModel   = new \Admin\Model\plugModel();
        $plugModel->getPlugins();


    }

} 