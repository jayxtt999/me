<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/5 0005
 * Time: 下午 5:23
 */

namespace Member\Login\Form;
use System\Library\Form\Form;


class infoForm extends \System\Library\Form\Form
{

    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=member&c=info&a=save', '', $array);

        $array = array(
            "class" => "form-control",
        );
        $this->setText("profession", "职业", $array, array('datatype' => 's0-24',));
        $this->setText("favorite", "兴趣爱好", $array, array('datatype' => 's0-24',));
        $this->setText("nickname", "昵称", $array, array('datatype' => 's0-24',));
        $this->setText("userinfo", "用户说明", $array, array('datatype' => 's0-24',));
        $this->setText("password2", "密码", $array, array('datatype' => '*5-15'),"password",3,9);
        $this->setText("email", "邮箱", $array, array('datatype' => 'e',));
        $this->setSelect("sex", "性别", $array, array("男"=>"男", "女"=>"女", "其它"=>"其它"));
        $this->setText("avatar", "", $array,"","hidden");

    }


} 