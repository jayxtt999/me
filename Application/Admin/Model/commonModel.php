<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:35
 */
class commonModel extends model
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
     *  获取菜单栏
     * @return string
     */
    public function getMenu()
    {
        $Db = parent::getDb();
        //获取菜单数据
        $Menu = $Db->table('common_menu')->getAll(array('is_display?<>' => 0))->order('parent_id')->done();
        //排序
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'], 'ico' => $v['icon'], 'desc' => $v['desc'], 'sort' => $v['sort'], 'm' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
        }
        $items = $this->tree($this->array);
        //生成html
        $this->htmltree($items, 0);
        return $this->html;
    }

    /**
     * 生成菜单树html
     * @param $items
     * @param int $level
     */
    public function htmlTree($items, $level = 0)
    {
        //获取路由信息
        $route = $this->getRouteInfo();
        //重置序列 按sort
        foreach ($items as $key=>$value){
            $sort[$key] = $value['sort'];
        }
        array_multisort($sort,SORT_NUMERIC,SORT_DESC,$items);
        foreach ($items as $v) {
            $mca = "/index.php?m=" . $v['m'] . "&c=" . $v['c'] . "&a=" . $v['a'] . "";
            if($route['pid']==$v['id'] || ($route['id']==$v['id'] && $route['pid']==$v['pid'])){
                $this->navArray[$level]['name'] = $v['name'];
                $this->navArray[$level]['url'] = $mca;
                $liClass = "start active open";
                $arrow = isset($v['son']) ? "<span class='arrow open'></span>" : "";
            }else{
                $liClass ="";
                $arrow = isset($v['son']) ? "<span class='arrow '></span>" : "";
            }
            $this->html .= "
                        <li class='".$liClass."'>
                        <a href='".$mca."'>
                            <i class='icon-diamond'></i>
                            <span class='title'>" . $v['name'] . "</span>" . $arrow . "
                        </a>";
            if (isset($v['son'])) {
                $display = $level ? "style='display: none'" : "display: block";
                $this->html .= "<ul class='sub-menu' " . $display . "'>";
                $level++;
                $this->htmlTree($v['son'], $level);
                $this->html .= "</ul>";
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
        $ro = Application::$appLib['route'];
        $routeUrl = $ro::$routeUrl;
        foreach ($this->array as $v) {
            if ($v['m'] == $routeUrl['module'] && $v['c'] == $routeUrl['controller'] && $v['a'] == $routeUrl['action']) {
                return $this->array[$v['id']];
            }
        }
    }







}




