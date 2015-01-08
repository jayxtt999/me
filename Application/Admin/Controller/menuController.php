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
        $this->View()->assign(array('menuAll'=>$menuAll));
        $this->View()->display();
    }

    public function addAction(){



    }

    public function editAction(){
        $id = get('id','int');
        $db = \System\Core\Model::getDb();
        $row = $db->Table('common_menu')->getRow(array('id'=>$id))->done();        //getRow
        $form = new \Admin\Menu\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('menuEdit');                      //开始渲染
        $this->View()->assign(array('form'=>$form));
        $this->View()->display();
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
        $date = checkForm::init($_POST,$form->_name);
        var_dump($date);exit;

    }

    public function delAction(){



    }



}