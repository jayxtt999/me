<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/21 0021
 * Time: 下午 2:41
 */

namespace Admin\Controller;


use Admin\Controller\abstractController;

class categoryController extends abstractController{

    public function indexAction(){

        $category = db()->table('article_category')->getAll()->order('id')->done();
        foreach($category as $k=>$v){
            $num = db()->table('article')->getAll(array('category'=>$v['id']))->count()->done();
            $category[$k]['num'] = $num;
        }


        $this->getView()->assign(array("category"=>$category));
        $this->getView()->display();

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







} 