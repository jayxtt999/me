<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */

class editForm {
    private $form;
    public function init(){
        if(!is_object($this->form)){
            require_once SYS_LIB_PATH . '/Form/Form'.EXT;
            $this->form =  new Form();
        }
        $this->form->init('menuedit');
        $this->form->setText("name");
        $this->form->setText("module_name");
        $this->form->setText("controller_name");
        $this->form->setText("action_name");
        $this->form->setText("url");
        $this->form->setText("sort");
        $this->form->setText("is_display");
        $this->form->setText("icon");
        $this->form->setText("desc");
    }

    public function getForm(){
        return $this->form;
    }


} 