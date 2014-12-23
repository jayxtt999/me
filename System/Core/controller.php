<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:39
 */

class Controller {

    final public function View(){
        $view = new View;
        $view->init(Application::$appConfig['view_type']);
        return $view;
    }

} 