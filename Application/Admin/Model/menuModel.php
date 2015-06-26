<?php

namespace Admin\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/8 0008
 * Time: 24:07
 */
class menuModel extends \System\Core\Model
{

    private $html = ""; //html
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
    public function getMenuAll()
    {
        $Db = parent::getDb();
        //获取菜单数据
        $Menu = $Db->table('common_menu')->getAll()->order('parent_id')->done();
        //排序
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'], 'ico' => $v['icon'], 'desc' => $v['desc'],'sort' => $v['sort'],'is_display' => $v['is_display'],'create_time' => $v['create_time'],'m' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
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
        foreach ($items as $key => $value) {
            $sort[$key] = $value['sort'];
        }
        array_multisort($sort, SORT_NUMERIC, SORT_DESC, $items);
        foreach ($items as $v) {

            if ($v['is_display']) {
                $isDisplay = "<span class='label label-sm label-success'>显示</span>";
            } else {
                $isDisplay = "<span class='label label-sm label-default'>不显示</span>";
            }
            if($v['pid']){
                $this->html .= "<tr class='odd gradeX'><td><input type='checkbox'class='checkboxes'value='1'/></td><td>" . "|".str_repeat('-', $level+1) . $v['name'] . "</td><td>" . $v['desc'] . "</td><td>" . $v['create_time'] . "</td><td class='center'>" . $isDisplay . "</td><td><a href='/index.php?m=admin&c=menu&a=add&id=".$v['id']."'class='btn green'title='添加子栏目'><i class='fa fa-plus'></i></a><a href='/index.php?m=admin&c=menu&a=edit&id=".$v['id']."'class='btn red'title='修改'><i class='fa fa-edit'></i></a><a href='javascript:menuDel(".$v['id'].");'class='btn purple'title='删除'><i class='fa fa-times'></i></a></td></tr>";
            }
            if (isset($v['son'])) {
                $level++;
                $this->htmlTree($v['son'], $level);
                $level = 0;
            }
        }
    }

    /**
     * 获取指定栏目对应的路由信息（于栏目管理中）
     * @return mixed
     */
    public function getRouteInfo()
    {
        $ro = \Application::$appLib['route'];
        $routeUrl = $ro::$routeUrl;
        foreach ($this->array as $v) {
            if ($v['m'] == $routeUrl['module'] && $v['c'] == $routeUrl['controller'] && $v['a'] == $routeUrl['action']) {
                return $this->array[$v['id']];
            }
        }
    }


    public function getMenuSelect(){

        $Db = parent::getDb();
        $Menu = $Db->table('common_menu')->getAll()->order('id')->done();
        foreach($Menu as $k=>$v){
            $res[$v['id']]= $v['name'];
        }
        return ($res);
    }

}