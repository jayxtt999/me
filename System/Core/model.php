<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:38
 */
namespace System\Core;
class Model {

    public static  $db;

    final static function getDb(){
        if(self::$db){
            return self::$db;
        }else{
            $DB = new DB();
            $DB->init(C('db'));
            return $DB;
        }
    }

    final static function getForm(){




    }




}