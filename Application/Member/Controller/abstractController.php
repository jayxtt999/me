<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

namespace Member\Controller;

use System\Core\View;

class abstractController extends \System\Core\Controller
{
    public  $webConfig;

    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        //获取菜单栏 && 获取当前路由相关信息
        $common = new \Admin\Model\commonModel();
        $this->common = $common;
        $routeInfo = $common->getRouteInfo();
        //获取网站填写的前台设置
        $config = new \Admin\Model\webConfigModel();
        $webConfig = $config->getConfig();
        $tplData = array(
            'routeInfo' => $routeInfo,
            'webConfig' => $webConfig,
        );
        $this->webConfig = $webConfig;
        $this->getView()->assign($tplData);
    }

    public function notFound()
    {
        $this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');
    }

}