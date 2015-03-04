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
        //验证登陆
        $this->checkLogin();
        if(!$_SESSION[C('USER_AUTH_KEY')]){
            //$this->link()->error("请先登录");
        }
        //获取菜单栏 && 获取当前路由相关信息
        $common = new \Admin\Model\commonModel();
        $this->common = $common;
        $menuData = $common->getMenu();
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

    /**
     * 获取当前登陆用户
     * @return mixed
     */
    public function getMember(){

        $id = $_SESSION[C('USER_AUTH_KEY')];
        return db()->table("member_info")->getRow(array('id'=>$id))->done();

    }

    /**
     * 验证登陆
     */
    public function checkLogin()
    {
        var_dump(session(C('USER_AUTH_KEY')));exit;
        if(!session(C('USER_AUTH_KEY'))){
            return $this->link()->dispatchJump("/index.php?m=member&c=login&a=index",1,"请先登陆!",0);
        }elseif(!session(C('ADMIN_AUTH_KEY'))){
            return $this->link()->dispatchJump("/index.php?m=member&c=login&a=index",1,"该用户没有操作权限!",0);
        }
    }

    public function notFound()
    {
        $this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');
    }


}