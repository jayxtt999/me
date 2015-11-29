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
        $all = db()->Table('member_info')->getAll(array("role?<>"=>"1"))->done();//getAll
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
        $this->getView()->assign(array('form' => $memberForm, 'data' => $memberRow));
        return $this->getView()->display();

    }


    public function groupAction(){

        $status = new \Member\Info\Table\GroupStatus();
        $all = db()->Table('member_group')->getAll()->done();//getAll
        $this->getView()->assign(array('memberGroupAll' => $all,'status'=>$status));
        return $this->getView()->display();

    }


    /**
     * 权限控制
     */
    public function rulesAction(){

        $id = get("id","int");
        $rulesData = array();
        $commonMenu = db()->Table('common_menu')->getAll()->done();//获取栏目
        $rulesRow = db()->Table('member_group')->getRow(array("id"=>$id))->done();//获取栏目
        $name = $rulesRow['title'];
        $rules = $rulesRow['rules'];
        //组装数据集
        $rulesArr = $rules?explode(",",$rules):array();
        foreach($commonMenu as $v){
            $rulesData[$v['id']]['title'] = $v['name'];
            if(in_array($v['id'],$rulesArr)){
                $rulesData[$v['id']]['ischeck'] = 1;
            }else{
                $rulesData[$v['id']]['ischeck'] = 0;
            }
        }
        $this->getView()->assign(array('rulesData'=>$rulesData,'id'=>$id,'name'=>$name));
        $this->getView()->display();

    }

    /**
     * 修改权限控制
     */
    public function rulesSaveAction(){

        $id = post("id","int");
        $row = db()->table("member_group")->getRow(array('id'=>$id));
        if(!$row){
            return $this->link()->error("用户组不存在");
        }
        $role = implode(',',post('role','_array'));
        $res = db()->table("member_group")->upDate(array('rules'=>$role),array('id'=>$id))->done();
        if($res){
            return $this->link()->success("admin:member:group","更新成功");
        }else{
            return $this->link()->error("更新失败");
        }


    }



} 