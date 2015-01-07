<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:39
 */

namespace System\Core;
class Controller {

    /**
     * 视图
     * @return View
     */
    final public function View(){
        $view = new View;
        $view->init(\Application::$appConfig['view_type']);
        return $view;
    }

    /**
     * Request
     * @return \System\Library\Request
     */
    final public function getRequest(){
        return new \System\Library\Request();
    }

}

