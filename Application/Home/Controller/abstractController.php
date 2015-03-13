<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

namespace Home\Controller;

use System\Core\View;

class abstractController extends \System\Core\Controller
{

    function __construct()
    {
        $this->init();
    }

    public function notFound()
    {
        /*$this->getView()->assign(array('url' => curPageURL()));
        $this->getView()->display('admin:notFound:index');*/
    }

}