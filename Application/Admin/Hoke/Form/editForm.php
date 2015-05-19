<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/18 0018
 * Time: 下午 6:02
 */
namespace Admin\Hoke\Form;
use System\Library\Form\Form;

class editForm extends \System\Library\Form\Form{


    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
            "enctype"=>"multipart/form-data"
        );
        $this->init($formName, '/index.php?m=admin&c=hook&a=save', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "NAME",
        );
        $this->setText("name", "Hook名", $array, array('datatype' => '*2-24',));




        $array = array(
            "class" => "form-control",
            "style" => "height:100px"
        );
        $this->setTextArea("description", "描述", $array, array('datatype' => '*0-512'));




        $array = array(
            "class" => "make-switch",
            "data-on-color" => "primary",
            "data-off-color" => "info",
        );
        $this->setBsCheckBox("status", "状态", $array);


        $array = array(
            "class" => "form-control",
        );
        $this->setSelect("type", "类型", $array,array("controller"=>"控制器","view"=>"视图"),3);



        $array = array(
            "class" => "form-control",
            "disabled" => "disabled"
        );
        $this->setText("crate_time", "创建时间", $array, array(), "text", 3);





    }


} 