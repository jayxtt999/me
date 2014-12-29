<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class menuController extends abstractController{



    public function indexAction(){
        $menuAll = $this->model->getMenuAll();//获取全部栏目
        $this->View()->assign(array('menuAll'=>$menuAll));
        $this->View()->display();
    }


    public function addAction(){



    }

    public function editAction(){

        $id = get('id','int');
        $row = $this->db->Table('common_menu')->getRow(array('id'=>$id))->done();        //getRow
        $formClass = new Admin_Menu_Form_EditForm();        //获取表单
        $form = $formClass->init();                         //初始化
        $form->bind($row);                                  //绑定Row
        $formClass->start('menuEdit');                      //开始渲染
        $this->View()->assign(array('form'=>$form));
        $this->View()->display();

    }

    public function delAction(){



    }



}