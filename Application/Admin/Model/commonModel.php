<?php

namespace Admin\Model;
/**
 * 通用
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:35
 */
class commonModel extends \System\Core\Model
{

    private $html = ""; //html
    public $navArray = array();//我的位置
    public $array = array();
    /**
     * 序列树 来自csdn的大神
     * @param $items
     * @return array
     */
    public function tree($items)
    {
        foreach ($items as $item) {
            $items[$item['pid']]['son'][$item['id']] = & $items[$item['id']];
        }
        return isset($items[0]['son']) ? $items[0]['son'] : array();
    }


    /**
     * 获取栏目序列，因为路由信息是与栏目菜单存在关联，在有些地方 如注册，登陆，这些可能不需要栏目数据，所以独立出来
     */
    public function getSequence(){
        //获取菜单数据
        $Menu = db()->table('common_menu')->getAll()->order('parent_id')->done();
        //排序
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'],'is_display' => $v['is_display'], 'ico' => $v['icon'], 'desc' => $v['desc'], 'sort' => $v['sort'], 'm' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
        }
    }


    /**
     *  获取菜单栏
     * @return string
     */
    public function getMenu()
    {
        //获取菜单数据
        $Menu = db()->table('common_menu')->getAll()->order('parent_id,sort')->done();
        //排序
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'],'is_display' => $v['is_display'],'is_nav' => $v['is_nav'], 'ico' => $v['icon'], 'desc' => $v['desc'], 'sort' => $v['sort'], 'm' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
        }
        $items = $this->tree($this->array);
        //生成html
        $this->htmltree($items[1]['son'], 0);
        return $this->html;
    }


    /**
     * 生成菜单树html
     * @param $items
     * @param int $level
     */
    public function htmlTree($items, $level = 0)
    {
        /**
         *
         *  [id] => 239
             [pid] => 236
         */
        $route = $this->getRouteInfo();

        foreach ($items as $v) {
            $mca = "/index.php?m=" . $v['m'] . "&c=" . $v['c'] . "&a=" . $v['a'] . "";
            if($route['pid']==$v['id'] || ($route['id']==$v['id'] && $route['pid']==$v['pid'])){
                $this->navArray[$level]['name'] = $v['name'];
                $this->navArray[$level]['url'] = $mca;
                $liClass = "active open";
                $arrow = isset($v['son']) ? "<span class='arrow open'></span>" : "";
            }else{
                $liClass ="";
                $arrow = isset($v['son']) ? "<span class='arrow '></span>" : "";
            }
            if(!$v['is_display'] || $v['is_nav']){
                continue;
            }
            $this->html .= "
                        <li class='".$liClass."'>
                        <a href='".$mca."'>
                            <i class='" . $v['ico'] . "'></i>
                            <span class='title'>" . $v['name'] . "</span>" . $arrow . "
                        </a>";
            if (isset($v['son'])) {
                $display = $level ? "style='display: none'" : "display: block";
                $this->html .= "<ul class='sub-menu' " . $display . "'>";
                $level++;
                $this->htmlTree($v['son'], $level);
                $this->html .= "</ul>";
                $level = 0;
            }
            $this->html .= "</li>";
        }

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







}




