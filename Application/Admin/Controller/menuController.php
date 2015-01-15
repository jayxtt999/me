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
        $id = post('id','int');
        if(!$id){
            return $this->notFound();
        }
        $form = new \Admin\Menu\Form\editForm();
        $form->start('menuEdit');
        if(!$this->getRequest()->getMethod()=="POST"){
            return $this->notFound();
        }
        $data = $this->request()->getData();
        $id = $data['id'];
        unset($data['id']);
        $data = checkForm::init($data,$form->_name);
        $this->db()->Table('common_menu')->upDate($data,array('id'=>$id))->done();
        return $this->link()->toUrl("admin:menu:index",3,"修改成功");

    }

    public function delAction(){



    }



}