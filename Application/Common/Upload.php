<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: ����9:28
 */

namespace Common;


class Upload {

    public function __construct($args=null,$config=array()){

        $type = C("upload_type");
        $class = new \ReflectionClass("\\System\\Library\\Upload\\".ucfirst($type)."\\".ucfirst($type));//���� Upload�����ķ�����

        $instance = $class->newInstance($args,$config);
        $ec=$class->getmethod('upFile');  //��ȡPerson ���е�getName����
        $ec->invoke($instance,"thumbnail");
        //return $r;
    }

} 