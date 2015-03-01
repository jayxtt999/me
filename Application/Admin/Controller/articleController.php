<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/28 0028
 * Time: 上午 10:49
 */

namespace Admin\Controller;


class articleController extends abstractController{

    /**
     * 日志列表
     */
    public function listAction(){

        $all = db()->Table('article')->getAll()->done();        //getAll
        $this->getView()->assign(array('articleAll'=>$all));
        return $this->getView()->display();

    }

    /**
     * 日志编辑
     */
    public function editAction(){
        $id = get('id','int');
        $row = db()->Table('article')->getRow(array('id'=>$id))->done();        //getRow
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $tag = new \Admin\Model\articleModel();
        $tags = $tag->getTags();
        $this->getView()->assign(array('tags'=>$tags));

        $this->getView()->display();
    }




} 