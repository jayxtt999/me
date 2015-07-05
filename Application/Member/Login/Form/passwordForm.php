<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/5 0005
 * Time: 下午 5:23
 */

namespace Member\Login\Form;

use System\Library\Form\Form;


class passwordForm extends \System\Library\Form\Form
{

    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=member&c=info&a=password', '', $array);

        $array = array(
            "class" => "form-control",
        );
        $this->setText("oldPassword", "当前密码", $array, array('datatype' => '*5-16'),"password");
        $this->setText("password", "新密码", $array, array('datatype' => '*5-16'),"password");
        $array = array(
            "class" => "form-control",
            "recheck"=>"password"
        );
        $this->setText("password2", "确认密码", $array, array('datatype' => '*5-16'),"password");

    }


} 