<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

class abstractController extends Controller{

    public $common;
    public $model;
    public $db;
    function __construct(){
        $this->init();
        $this->model = $this->loadModel();
        $this->db = Model::getDb();
    }
    public function init(){
        //获取菜单栏 && 获取当前路由相关信息
        $common = M('common');
        $this->common = $common;
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
     * @param null $name
     * @return mixed
     */
    public function loadModel($name=null){
        $name = $name?$name:Route::$routeUrl['controller'];
        return M($name);
    }

}