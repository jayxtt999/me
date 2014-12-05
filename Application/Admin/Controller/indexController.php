<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class indexController extends abstractController{

    function indexAction(){
        $menu = Model::init('menu');
        $menuData = $menu->getMenu();
        $tplData = array(
            'menuData'=>$menuData,
        );
        $this->View()->assign($tplData)->display();
    }


}