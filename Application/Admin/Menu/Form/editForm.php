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
        $array = array(
            "class"=>"form-horizontal",
            "role"=>"form",
        );
        $this->form->init($formName,'','',$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"NAME",
        );
        $this->form->setText("name","栏目名",$array);


        $array = array(
            "class"=>"form-control ",
            "placeholder"=>"MODULE_NAME",
        );
        $this->form->setText("module_name","模块名",$array);


        $array = array(
            "class"=>"form-control",
            "placeholder"=>"CONTROLLER_NAME",
        );
        $this->form->setText("controller_name","控制器名",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"ACTION_NAME",
        );
        $this->form->setText("action_name","方法名",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"URL",
        );
        $this->form->setText("url","URL",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"SORT",
        );
        $this->form->setText("sort","排序",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"IS_DISPLAY",
        );
        $this->form->setText("is_display","是否显示",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"ICON",
        );
        $this->form->setText("icon","图标",$array);

        $array = array(
            "class"=>"form-control",
            "placeholder"=>"DESC",
        );
        $this->form->setText("desc","排序方式",$array);

        return $this->form;
    }



} 