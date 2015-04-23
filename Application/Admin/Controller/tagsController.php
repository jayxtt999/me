<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/21 0021
 * Time: 下午 2:41
 */

namespace Admin\Controller;


use Admin\Controller\abstractController;

class tagsController extends abstractController{

    public function indexAction(){

        $tags = db()->table('article_tag')->getAll()->order('id')->done();
        $this->getView()->assign(array("tags"=>$tags));
        $this->getView()->display();

    }


    public function addAction(){
        $sort = post("sort","int");
        $name = post("name","txt");
        $alias = post("alias","txt");
        $r = db()->table('article_category')->insert(array('sort'=>$sort,'name'=>$name,'alias'=>$alias,))->done();
        if($r){
            return JsonObject(array("status"=>true,"msg"=>"添加成功"));
        }else{
            return JsonObject(array("status"=>false,"msg"=>"添加失败"));
        }

    }

    public function editAction(){
        $id = post("id","int");
        $k = post("type","txt");
        $v = post("v","txt");
        $r = db()->table('article_category')->upDate(array( $k=>$v),array('id'=>$id))->done();
        if($r){
            return JsonObject(array("status"=>true,"msg"=>"更新成功"));
        }else{
            return JsonObject(array("status"=>false,"msg"=>"更新失败"));
        }

    }

    public function delAction(){

        $id = get("id","int");
        $res = db()->Table('article_category')->delete(array('id'=>$id))->done();
        if($res){
            return $this->link()->success("admin:category:index","删除成功");
        }else{
            return $this->link()->error("删除失败");
        }

    }

    /**
     * 对比tags 处理 add or delete
     */
    public function checkTagsAction(){

        $tags = post("tags","txt");
        $tagsAll = db()->table('article_tag')->getAll()->order('id')->done();
        $dbTag = array();//oldTags
        foreach($tagsAll as $v){
            $oldTags[$v['id']] = $v['tagname'];
        }
        $newTags = explode(",",$tags);
        //取差集
        $diffTags = array_merge(array_diff($newTags,$oldTags),array_diff($oldTags,$newTags));
        if(!$diffTags){
            return "null";
        }
        foreach($diffTags as $v){
            if(in_array($v,$oldTags)){
                //删除
                db()->Table('article_tag')->delete(array('tagname'=>$v))->done();
            }else{
                //新增
                db()->Table('article_tag')->insert(array('tagname'=>$v))->done();
            }
        }

    }







} 