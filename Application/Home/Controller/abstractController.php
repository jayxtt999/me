<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

namespace Home\Controller;

use System\Core\View;

class abstractController extends \System\Core\Controller
{

    function __construct()
    {
        //获取菜单

        //获取菜单栏 && 获取当前路由相关信息
        $common = new \Home\Model\menuModel();
        $this->common = $common;
        $menuData = $common->getNav();
        $navArray = $common->navArray;
        $routeInfo = $common->getRouteInfo();
        //获取网站填写的前台设置
        $config = new \Admin\Model\webConfigModel();
        $webConfig = $config->getConfig();
        $tplData = array(
            'menuData' => $menuData,
            'routeInfo' => $routeInfo,
            'navArray' => $navArray,
            'webConfig' => $webConfig,
        );
        $this->getView()->assign($tplData);


    }



    public function notFound()
    {
        /*$this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');*/
    }

}