<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Menu\Form;

use Admin\Model\menuModel;
use System\Library\Form\Form;

class editForm extends \System\Library\Form\Form
{
    /**
     * 初始化表单，这里的$attribute作为附加属性，在有时候会多个地方用到表单，这样的属性用于动态判断对应的操作
     * 如：edit 与  add 操作，选择父栏目，edit默认为当前父栏目，add 为 当前id
     * @param $formName
     * @param string $attribute
     */
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
        $this->setText("id","",$array,array(),"hidden");


        $array = array(
            "class" => "form-control",

        );
        $menu = new \Admin\Model\menuModel();
        $data  = $menu->getMenuSelect();
        $this->setSelect("parent_id","父栏目",$array,$data);

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
        $this->setText("url", "URL", $array, array('datatype' => 's0-124',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "SORT",
        );
        $this->setText("sort", "排序", $array, array('datatype' => 'n1-4',));

        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_DISPLAY",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("is_display","是否显示", $array);


        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_ADMIN",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("is_admin","是否只能管理员查看", $array);



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