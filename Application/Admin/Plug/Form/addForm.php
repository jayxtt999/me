<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/18 0018
 * Time: 下午 6:02
 */
namespace Admin\Plug\Form;
use System\Library\Form\Form;

class addForm extends \System\Library\Form\Form{


    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
            "enctype"=>"multipart/form-data",
            "id"=>"plugAdd"
        );
        $this->init($formName, '/index.php?m=admin&c=plug&a=save', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "请输入插件标识",
        );
        $this->setText("name", "标识名", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "请输入插件名",
        );
        $this->setText("title", "插件名", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "请输入作者",
        );
        $this->setText("author", "作者", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "请输入版本"
        );
        $this->setText("version", "版本", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "style" => "height:100px",
            "placeholder" => "请输入描述"
        );
        $this->setTextArea("description", "描述", $array, array('datatype' => '*0-512'));




        $array = array(
            "class" => "make-switch",
            "data-on-color" => "primary",
            "data-off-color" => "info",
        );
        $this->setBsCheckBox("enable", "是否启用", $array);


        $array = array(
            "class" => "make-switch",
            "data-on-color" => "primary",
            "data-off-color" => "info",
        );
        $this->setBsCheckBox("isConfig", "是否需要配置", $array);


        $array = array(
            "class" => "make-switch",
            "data-on-color" => "primary",
            "data-off-color" => "info",
        );
        $this->setBsCheckBox("isAdminList", "是否需要后台列表", $array);


        $array = array(
            "class" => "bs-select form-control",
            "multiple"=>"true"
        );

        $hookModel = new \Admin\Model\hookModel();
        $hookArr = $hookModel->getHookList();
        $this->setSelect("hookName[]", "实现的钩子方法", $array,$hookArr,3);




    }


} 