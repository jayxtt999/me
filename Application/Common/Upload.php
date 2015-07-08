<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: 下午9:28
 */

namespace Common;


class Upload {

    public function __construct($args=null,$config=array()){

        $type = C("upload_type");
        $class = new \ReflectionClass("\\System\\Library\\Upload\\".ucfirst($type)."\\".ucfirst($type));//建立 Upload这个类的反射类

        $instance = $class->newInstance($args,$config);
        $ec=$class->getmethod('upFile');  //获取Person 类中的getName方法
        $ec->invoke($instance,"thumbnail");
        //return $r;
    }

} 