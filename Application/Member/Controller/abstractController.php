<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 下午9:20
 */

namespace Member\Controller;

use System\Core\View;

class abstractController extends \Common\Controller\abstractController
{
    function __construct()
    {
        $this->init();
    }

}