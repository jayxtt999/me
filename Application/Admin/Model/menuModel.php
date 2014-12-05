<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:35
 */


class menuModel extends model{

    private $html = "";

    /**
     * 来自csdn的大神
     * @param $items
     * @return array
     */
    function tree($items){
        foreach ($items as $item){
            $items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];
        }
        return isset($items[0]['son']) ? $items[0]['son'] : array();
    }

    function getMenu(){
        $Db = parent::getDb();
        //获取菜单数据
        $Menu =  $Db->table('common_menu')->getAll(array('is_display?<>'=>0))->order('sort')->done();
        $array = array();
        //排序
        foreach($Menu as $k => $v){
            $array[$v['id']] = array('id'=>$v['id'],'pid'=>$v['parent_id'],'name'=>$v['name'],'ico'=>$v['icon'],'sort'=>$v['sort'],'m');
        }
        $items =$this->tree($array);
        //生成html
        $this->htmltree($items,0);

        return $this->html;

    }




    public function htmltree($items,$level=0){

        foreach($items as $v){

                $arrow = isset($v['son'])?"<span class='arrow'></span>":"";
                $this->html.="
                        <li>
                        <a href='javascript:;'>
                            <i class='icon-diamond'></i>
                            <span class='title'>".$v['name']."</span>".$arrow."
                        </a>";
                if(isset($v['son'])){
                    $display = $level?"style='display: none'":"display: none";
                    $this->html.="<ul class='sub-menu' ".$display."'>";
                    $level++;
                    $this->htmltree($v['son'],$level);
                    $this->html.="</ul>";
                }

                $this->html.="</li>";
        }

    }


}




