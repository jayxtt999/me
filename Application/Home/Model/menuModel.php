<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/17 0017
 * Time: 下午 5:00
 */
namespace Home\Model;

class menuModel  extends \System\Core\Model{

    private $array = array();

    /**
     * 获取nav
     * @return mixed
     */
    public function getNav(){

        $db = parent::getDb();
        $res = $db->table('common_menu')->getAll(array('is_admin'=>0,'is_display'=>1))->order('sort desc')->done();
        return $res;
    }



    /**
     * 获取当前路由信息
     * @return mixed
     */
    public function getRouteInfo()
    {
        if(!$this->array){
            $this->getSequence();
        }
        $ro = \Application::$appLib['route'];
        $routeUrl = $ro::$routeUrl;
        foreach ($this->array as $v) {
            if ($v['m'] == $routeUrl['module'] && $v['c'] == $routeUrl['controller'] && $v['a'] == $routeUrl['action']) {
                return $this->array[$v['id']];
            }
        }
    }


    /**
     * 获取栏目序列，因为路由信息是与栏目菜单存在关联，在有些地方 如注册，登陆，这些可能不需要栏目数据，所以独立出来
     */
    public function getSequence(){
        $db = parent::getDb();
        //获取菜单数据
        $Menu =  $db->table('common_menu')->getAll(array('is_admin'=>0,'is_display'=>1))->order('parent_id')->done();
        //排序
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'],'is_display' => $v['is_display'], 'ico' => $v['icon'], 'desc' => $v['desc'], 'sort' => $v['sort'], 'm' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
        }
    }



} 