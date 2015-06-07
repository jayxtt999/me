<?php

namespace Member\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/8 0008
 * Time: 24:07
 */
class memberModel extends \System\Core\Model
{

    /**
     * 获取作者
     * @return mixed
     */
   public function getAuthor(){

       $Db = parent::getDb();
       $member = $Db->table('member_info')->getAll()->order('id')->done();
       foreach($member as $k=>$v){
           $res[$v['id']]= $v['nickname'];
       }
       return ($res);

   }

}