<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:38
 */
namespace System\Core;
class Model {

    public static  $db = array();
    public static  $cache;

    final static function getDb($name){

        if(self::$db[$name]){
            return self::$db[$name];
        }else{
            $DB = new DB();
            C('db:db_type',$name);
            $DB->init(C('db'));
            self::$db[$name] = $DB;
            return $DB;
        }
    }


    final static function getCache(){

        if(self::$cache){
            return self::$cache;
        }else{
            $cache = new Cache();
            $cache->init(C('cache'));
            self::$cache = $cache;
            return $cache;
        }

    }

    final static function getForm(){





    }




}