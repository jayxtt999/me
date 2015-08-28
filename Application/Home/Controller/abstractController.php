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

    /**
     * 初始化 菜单信息 路由信息  网站设置 侧边栏模块
     */
    function __construct()
    {
        //获取菜单
        //获取菜单栏 && 获取当前路由相关信息
        $common = new \Home\Model\menuModel();
        $this->common = $common;
        $menuData = $common->getNav();
        $routeInfo = $common->getRouteInfo();
        //获取网站填写的前台设置
        $config = new \Admin\Model\webConfigModel();
        $webConfig = $config->getConfig();
        $templatesPath = WEB_TEMP_PATH."/".C("view_templates");
        //获取侧边栏信息
        $sidebarModel  =  new \Home\Model\sidebarModel();
        $sidebar = $sidebarModel->getSidebarData();
        //载入
        $tplData = array(
            'menuData' => $menuData,
            'routeInfo' => $routeInfo,
            'webConfig' => $webConfig,
            'templatesPath' => $templatesPath,
            'sidebarSystem' => $sidebar['system'],
            'sidebarDiy' => $sidebar['diy'],
        );

        //var_dump( $sidebar['system']);exit;
        $this->getView()->assign($tplData);


    }



    public function notFound()
    {
        /*$this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');*/
    }

}