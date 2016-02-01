<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Article\Form;

use System\Library\Form\Form;

class EditForm extends \System\Library\Form\Form
{
    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
            "enctype"=>"multipart/form-data"
        );
        $this->init($formName, '/index.php?m=admin&c=article&a=save', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "NAME",
        );
        $this->setText("title", "", $array, array('datatype' => '*2-24',));

        $this->setText("id", "", $array, array('datatype' => 'n1-8'), "hidden");


        $array = array(
            "class" => "form-control",
            "placeholder" => date("Y-m-d H:i:s"),
            "disabled" => "disabled"
        );
        $this->setText("time", "", $array, array(), "text", 0, 3);

        $array = array(
            "class" => "form-control",
        );

        $this->setUeditor("content", "", $array);


        $array = array(
            "class" => "form-control",
            "id" => "tags",
            "placeholder" => "日志标签，逗号或空格分隔",
        );
        $this->setText("tag", "", $array, array('datatype' => '*0-256',), "text", 0, 6);


        $array = array(
            "class" => "form-control",

        );
        $menu = new \Admin\Model\articleModel();
        $data = $menu->getCategory();
        $this->setSelect("category", "", $array, $data, 3, 3);

        $array = array(
            "class" => "form-control",
            "style" => "height:200px"

        );
        $this->setUeditor("excerpt", "", $array);


        $array = array(
            "class" => "form-control",
        );
        $this->setText("password", "访问密码", $array, array('datatype' => '*0-24'), "text", 1, 3);

        $array = array(
            "class" => "form-control",
        );
        $this->setText("thumbnail", "", $array, array(), "file", 1, 3);


        $array = array(
            "class" => "make-switch",
            "data-on-color" => "primary",
            "data-off-color" => "info",
        );
        $this->setBsCheckBox("istop", "是否置顶", $array);

        $this->setBsCheckBox("allow_comment", "允许评论", $array);


    }


}