<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */

class Admin_Menu_Form_EditForm {
    private $form;
    public function init($formName){
        if(!is_object($this->form)){
            require_once SYS_LIB_PATH . '/Form/Form'.EXT;
            $this->form =  new Form();
        }
        $this->form->init($formName);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"NAME",
        );
        $this->form->setText("name","栏目名",$array);


        $array = array(
            "class"=>"form-control",
            "placeholder"=>"MODULE NAME",
        );
        $this->form->setText("module_name","模块名",$array);



        $this->form->setText("controller_name");
        $this->form->setText("action_name");
        $this->form->setText("url");
        $this->form->setText("sort");
        $this->form->setText("is_display");
        $this->form->setText("icon");
        $this->form->setText("desc");

        return $this->form;
    }



} 