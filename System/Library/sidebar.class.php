<?php
/**
 * �������
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/28 0028
 * Time: ���� 1:52
 */

namespace System\Library;

class sidebar {

    //blogger
    public static  function blogger($data=null){

        $title  = $data[0]['data'];
        $row = db()->table("member_info")->getRow(array('role'=>1))->done();
        return array('title'=>$title,'data'=>$row);

    }


    //����
    public static function calendar($data=null){

        $title  = $data[0]['data'];
        return array('title'=>$title,'data'=>"");

    }


    //����˵˵
    public static function newtwitter($data=null){

        $title  = $data[0]['data'];
        $number  = $data[1]['data'];
        $newTwitter =  db()->table("twitter")->getAll(array('status'=>1))->limit(0,$number)->done();
        return array('title'=>$title,'data'=>$newTwitter);


    }


    //��ǩ
    public static function tags($data=null){



    }


     //����
    public static function category($data=null){

        $title  = $data[0]['data'];
        $category =  db()->table("article_category")->getAll()->done();
        return array('title'=>$title,'data'=>$category);


    }


    //�浵
    public static function archive($data=null){


    }


    //����
    public static function link($data=null){


    }


    //����
    public static function search($data=null){

        $title  = $data[0]['data'];
        return array('title'=>$title,'data'=>"");

    }


    //��������
    public static function newcomment($data=null){


    }


    //������־
    public static function newblog($data=null){


    }


    //������־
    public static function hotblog($data=null){


    }


    //�����־
    public static function randblog($data=null){


    }





} 