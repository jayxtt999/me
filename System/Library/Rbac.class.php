<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/12 0012
 * Time: ���� 10:44
 */

namespace System\Library;


use Member\Info\Table\Status;

class Rbac
{
    private $db;



    static public function authenticate($username) {

        if($username){
            return db()->table("member_info")->getRow(array('username'=>$username,'status'=>\Member\Info\Table\Status::STATUS_ENABLE))->done();
        }else{
            return false;
        }
    }

} 