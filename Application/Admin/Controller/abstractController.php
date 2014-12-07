<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

class abstractController extends Controller{

    function __construct(){
        $this->init();
    }
    public function init(){
        //获取菜单栏 && 获取当前路由相关信息
        $menu = Model::init('menu');
        $menuData = $menu->getMenu();
        $navArray = $menu->navArray;
        $routeInfo = $menu->getRouteInfo();
        $tplData = array(
            'menuData'=>$menuData,
            'routeInfo'=>$routeInfo,
            'navArray'=>$navArray,
        );
        $this->View()->assign($tplData);
    }


} 