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
    public static  $cache;

    final static function getDb(){
        if(self::$db){
            return self::$db;
        }else{
            $DB = new DB();
            $DB->init(C('db'));
            self::$db = $DB;
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