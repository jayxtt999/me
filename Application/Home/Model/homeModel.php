<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/19 0019
 * Time: ���� 11:30
 */

namespace Home\Model;


class homeModel  extends \System\Core\Model{


    /**
     * ��ȡ���·�����
     * @param $id
     * @return mixed
     */
    public function getArticleCategory($id){
        $Db = parent::getDb();
        $category = $Db->table('article_category')->getRow(array('id'=>$id))->done();
        return ($category['name']);
    }
} 