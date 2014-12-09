<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/8 0008
 * Time: 24:07
 */
class menuModel extends Model
{
    /**
     * 获取栏目
     * @return mixed
     */
    public function getMenuAll()
    {
        $db = $this->getDb();
        return $db->table('common_menu')->getAll()->order('parent_id')->done();
    }


}