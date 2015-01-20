<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

namespace Admin\Controller;

use System\Core\View;

class abstractController extends \System\Core\Controller
{

    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        //获取菜单栏 && 获取当前路由相关信息
        $common = new \Admin\Model\commonModel();
        $this->common = $common;
        $menuData = $common->getMenu();
        $navArray = $common->navArray;
        $routeInfo = $common->getRouteInfo();
        $tplData = array(
            'menuData' => $menuData,
            'routeInfo' => $routeInfo,
            'navArray' => $navArray,
        );
        $this->getView()->assign($tplData);
    }

    public function notFound()
    {
        $this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');
    }

}