<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;


class hookController extends abstractController{

    public function indexAction()
    {

        $hookAll = db()->table("hook")->getAll()->done();
        $this->getView()->assign(array("hookAll"=>$hookAll));
        return $this->getView()->display();
    }

    public function editAction(){

        $id = get("id","int");
        $row = db()->table("hook")->getRow(array('id'=>$id))->done();
        if(!$row){
            return $this->link()->error("参数错误");
        }
        $form = new \Admin\Hook\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));





    }



} 