<?php
/**
 * 侧边栏类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/28 0028
 * Time: 下午 1:52
 */

namespace System\Library;

class sidebar {

    //blogger
    public static  function blogger($data=null){

        $title  = $data[0]['data'];
        $row = db()->table("member_info")->getRow(array('role'=>1))->done();
        return array('title'=>$title,'data'=>$row);

    }


    //日历
    public static function calendar($data=null){

        $title  = $data[0]['data'];
        return array('title'=>$title,'data'=>"");

    }


    //最新说说
    public static function newtwitter($data=null){

        $title  = $data[0]['data'];
        $number  = $data[1]['data'];
        $newTwitter =  db()->table("twitter")->getAll(array('status'=>1))->limit(0,$number)->done();
        return array('title'=>$title,'data'=>$newTwitter);


    }


    //标签
    public static function tags($data=null){



    }


     //分类
    public static function category($data=null){

        $title  = $data[0]['data'];
        $category =  db()->table("article_category")->getAll()->done();
        return array('title'=>$title,'data'=>$category);


    }


    //存档
    public static function archive($data=null){


    }


    //链接
    public static function link($data=null){


    }


    //搜索
    public static function search($data=null){

        $title  = $data[0]['data'];
        return array('title'=>$title,'data'=>"");

    }


    //最新评论
    public static function newcomment($data=null){


    }


    //最新日志
    public static function newblog($data=null){


    }


    //热门日志
    public static function hotblog($data=null){


    }


    //随机日志
    public static function randblog($data=null){


    }





} 