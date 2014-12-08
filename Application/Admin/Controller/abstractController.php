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
        $common = Model::init('common');
        $menuData = $common->getMenu();
        $navArray = $common->navArray;
        $routeInfo = $common->getRouteInfo();
        $tplData = array(
            'menuData'=>$menuData,
            'routeInfo'=>$routeInfo,
            'navArray'=>$navArray,
        );
        $this->View()->assign($tplData);
    }

    /**
     * 获取模型
     * @param null $name
     * @return mixed
     */
    public function loadModel($name=null){
        $name = $name?$name:Route::$routeUrl['controller'];
        return Model::init($name);
    }


} 