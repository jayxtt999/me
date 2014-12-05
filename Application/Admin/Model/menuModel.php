<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:35
 */


class menuModel extends model{

    private $html = "";

    function tree($items){
        foreach ($items as $item){
            $items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];
        }
        return isset($items[0]['son']) ? $items[0]['son'] : array();
    }

    function getMenu(){
        $Db = parent::getDb();
        $Menu =  $Db->table('common_menu')->getAll()->order('parent_id')->done();
        $array = array();
        foreach($Menu as $k => $v){
            $array[$v['id']] = array('id'=>$v['id'],'pid'=>$v['parent_id'],'name'=>$v['name'],'ico'=>$v['icon']);
        }
        $items =$this->tree($array);

        //print_r($items);exit;
        $this->htmltree($items);

        echo $this->html;

        exit;

    }

    public function htmltree($items){
        foreach($items as $v){
                if($v['pid'] == 0){
                    $this->html.="
                            <li class='has-sub'>
                            <a href='javascript:;'>
                                <i class='icon-bookmark-empty'></i>
                                <span class='title'>".$v['name']."</span>
                                <span class='arrow'></span>
                            </a>";
                }else{
                    $this->html.="<li><a href='ui_nestable.html'>Nestable List</a></li>";
                }
                if(isset($v['son'])){
                    $this->html.="<ul class='sub' style='display: none; '>";
                    $this->htmltree($v['son']);
                    $this->html.="</ul>";
                }

                $this->html.="</li>";
        }

    }


} 