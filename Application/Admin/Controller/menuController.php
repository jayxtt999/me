<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */
namespace Admin\Controller;
use Admin\Model\commonModel;
use System\Library\Form\checkForm as checkForm;

class menuController extends abstractController{

    public function indexAction(){
        $menuAll = new \Admin\Model\menuModel();
        $menuAll = $menuAll->getMenuAll();//获取全部栏目
        $v = $this->getView();
        $v->assign(array('menuAll'=>$menuAll));
        $v->display();
    }

    public function addAction(){
        $pid = get('id','int');
        $form = new \Admin\Menu\Form\editForm();        //获取表单
        $form->start('menuEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $this->getView()->display('edit');
    }



    public function editAction(){
        $id = get('id','int');
        $row = $this->db()->Table('common_menu')->getRow(array('id'=>$id))->done();        //getRow
        $form = new \Admin\Menu\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('menuEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $this->getView()->display();
    }

    public function saveAction(){
        $form = new \Admin\Menu\Form\editForm();
        $form->start('menuEdit');
        $data = $this->request()->getData();//获取数据
        $id = $data['id'];
        unset($data['id']);
        if($id){
            if(!$this->getRequest()->getMethod()=="POST"){
                //是否为post方式提交
                return $this->notFound();
            }
            $data = checkForm::init($data,$form->_name);
            $res = $this->db()->Table('common_menu')->upDate($data,array('id'=>$id))->done();
            if($res){
                return $this->link()->success("admin:menu:index","更新成功");
            }else{
                return $this->link()->error("未更新或更新失败");
            }
        }else{
            if(!$this->getRequest()->getMethod()=="POST"){
                return $this->notFound();
            }
            $data = checkForm::init($data,$form->_name);
            $res = $this->db()->Table('common_menu')->insert($data,array('id'=>$id))->done();
            if($res){
                return $this->link()->success("admin:menu:index","添加栏目成功");
            }else{
                return $this->link()->error("添加栏目失败");
            }
        }
    }



    public function delAction(){



    }



}