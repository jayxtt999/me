<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-8-8
 * Time: 上午11:31
 */

namespace Admin\Controller;


class memberController extends \Admin\Controller\abstractController{


    /**
     * 用户列表
     */
    public function indexAction(){

        $status = new \Member\Info\Table\Status();
        $all = db()->Table('member_info')->getAll()->done();//getAll
        $this->getView()->assign(array('memberAll' => $all,'status'=>$status));
        return $this->getView()->display();

    }


    public function editAction(){

	
	
	
	
	
	
        $id = get("id","int");
        $memberRow = db()->Table('member_info')->getRow(array('id' => $id))->done();        //getRow
        if (!$memberRow) {
            return $this->link()->error("参数错误");
        }
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->bind($memberRow); //绑定Row
        $memberForm->start('info'); //开始渲染
        $this->getView()->assign(array('form' => $memberForm));

    }


} 