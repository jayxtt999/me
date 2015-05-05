<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/21 0021
 * Time: 下午 2:41
 */

namespace Admin\Controller;
use Admin\Controller\abstractController;

class linkController extends abstractController{

    public function indexAction(){
        $link = db()->table('link')->getAll()->order('id')->done();
        $this->getView()->assign(array("link"=>$link));
        $this->getView()->display();

    }


    public function addAction(){
        $sort = post("sort","int");
        $name = post("name","txt");
        $src = post("src","txt");
        $r = db()->table('link')->insert(array('sort'=>$sort,'name'=>$name,'src'=>$src,))->done();
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
        $r = db()->table('link')->upDate(array( $k=>$v),array('id'=>$id))->done();
        if($r){
            return JsonObject(array("status"=>true,"msg"=>"更新成功"));
        }else{
            return JsonObject(array("status"=>false,"msg"=>"更新失败"));
        }

    }

    public function delAction(){

        $id = get("id","int");
        $res = db()->Table('link')->delete(array('id'=>$id))->done();
        if($res){
            return $this->link()->success("admin:link:index","删除成功");
        }else{
            return $this->link()->error("删除失败");
        }

    }




} 