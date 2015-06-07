<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/11 0011
 * Time: ÉÏÎç 11:02
 */

namespace Member\Login\Form;
use System\Library\Form\Form;


class loginForm extends \System\Library\Form\Form
{

    public function start($formName){

        $array = array();

        $this->init($formName, '/index.php?m=member&c=login&a=index', '', $array);

        $this->setText("usernmae", "", $array, array('datatype' => 's5-24',));

        $this->setText("password", "", $array, array('datatype' => 's5-24',));

    }
} 