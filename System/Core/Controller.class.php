<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午1:39
 */

namespace System\Core;

use \System\Library\Request;

class Controller
{
    private $view;

    /**
     * 视图
     * @return View
     */
    final public function getView()
    {
        //Todo 工厂模式加载
        if (is_object($this->view)) {
            return $this->view;
        }
        $this->view = new View;
        $this->view->init(\Application::$appConfig['view_type']);
        return $this->view;
    }

    /**
     * Request
     * @return \System\Library\Request
     */
    final public function getRequest()
    {
        return new \System\Library\Request();
    }

    final public function request()
    {
        return new Request();
    }


    /**
     *  跳转
     * @return \System\Library\Link
     */
    final public function link()
    {
        $link = new \System\Library\Link();
        $link->init();
        $link->view = $this->getView();
        return $link;
    }


    final  public function getServices(){
        $backtrace = debug_backtrace();
        array_shift($backtrace);
        $class = $backtrace[0]['class'];
        $class = explode("\\",$class);
        if(is_array($class) && $class[1]=="Controller"){
            $class = new \ReflectionClass("\\$class[0]\Services\\".str_replace("Controller","",$class[2])."Services");//建立反射类
            $instance  = $class->newInstanceArgs();//实例化
            return $instance;
        }else{
            trace("getServices Error");
        }

    }


}

