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
        );
        $this->init($formName, '/index.php?m=admin&c=article&a=save', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "NAME",
        );
        $this->setText("title", "", $array, array('datatype' => '*2-24',));

    }



}