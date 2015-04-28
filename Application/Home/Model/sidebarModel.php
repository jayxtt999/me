<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/28 0028
 * Time: ���� 2:44
 */

namespace Home\Model;


class sidebarModel extends \System\Core\Model{


    public function getSidebarData(){
        //��ѯ������ϵͳ�����
        $db = parent::getDb();
        $res = $db->table('sidebar')->getAll(array('show'=>\Admin\Sidebar\Type\Show::STATUS_ENABLE))->order('sort')->done();
        foreach($res as $v){
            $data = unserialize($v['data']);
            $callback = $v['title'];
            if($v['group'] == \Admin\Sidebar\Type\Group::SIDEBAR_SYSTEM){
                $sidebarSystemData[$callback] = \System\Library\sidebar::$callback($data);
            }else{
                $sidebarDiyData[$callback] = \System\Library\sidebar::$callback($data);
            }
        }
        return array('system'=>$sidebarSystemData,'diy'=>$sidebarDiyData);


    }

} 