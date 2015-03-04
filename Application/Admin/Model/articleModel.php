<?php
/**
 * 文章 分类 标签 说说相关
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/1 0001
 * Time: 下午 2:42
 */

namespace Admin\Model;


class articleModel extends \System\Core\Model{

    /**
     * 获取文章分类列表
     * @return mixed
     */
    public function getCategory(){
        $Db = parent::getDb();
        $Menu = $Db->table('article_category')->getAll()->order('id')->done();
        foreach($Menu as $k=>$v){
            $res[$v['id']]= $v['name'];
        }
        return ($res);
    }


    /**
     * 获取标签
     * @param $tid
     * @return string
     */
    public function getTags($tid=""){

        $Db = parent::getDb();
        if($tid){
            $tagAll = $Db->table('article_tag')->getAll(array("gid?LIKE"=>"%$tid%"))->order('id')->done();
            foreach($tagAll as $k=>$v){
                $tagFull[$k] = $v['tagname'];
            }
            $tags = implode(",",$tagFull);
        }else{
            $tagAll = $Db->table('article_tag')->getAll()->order('id')->done();
            $tags = "<ul class='nav nav-pills'>";
            foreach($tagAll as $k=>$v){
                $tags.="<li><a class='article_tag' href='javascript:;'>".$v['tagname']."</a></li>";
            }
            $tags .= "</ul>";
        }
        return $tags;
    }

} 