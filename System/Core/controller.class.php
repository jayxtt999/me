<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:39
 */

namespace System\Core;
class Controller {

    final public function View(){
        $view = new View;
        $view->init(\Application::$appConfig['view_type']);
        return $view;
    }

    final public function getRequest(){



    }




}

