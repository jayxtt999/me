<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Menu\Form;

use System\Library\Form\Form;

class editForm extends \System\Library\Form\Form
{
    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=admin&c=menu&a=save', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "NAME",
        );
        $this->setText("name", "栏目名", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "ID",
        );
        $this->setHide("id",$array);


        $array = array(
            "class" => "form-control ",
            "placeholder" => "MODULE_NAME",
        );
        $this->setText("module_name", "模块名", $array, array('datatype' => 's2-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "CONTROLLER_NAME",
        );
        $this->setText("controller_name", "控制器名", $array, array('datatype' => 's2-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "ACTION_NAME",
        );
        $this->setText("action_name", "方法名", $array, array('datatype' => 's2-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "URL",
        );
        $this->setText("url", "URL", $array, array('datatype' => 'url',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "SORT",
        );
        $this->setText("sort", "排序", $array, array('datatype' => 'n1-4',));

        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_DISPLAY",
        );
        $this->setBsCheckBox("is_display","是否显示", $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "ICON",
        );
        $this->setText("icon", "图标", $array, array('datatype' => 's0-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "DESC",
        );
        $this->setText("desc", "栏目描述", $array, array('datatype' => 's0-24',));

    }


}