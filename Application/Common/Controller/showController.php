<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午3:06
 */

namespace Common\Controller;


class showController extends abstractController
{
    /**
     * @return array|string
     */
    public function errorAction()
    {
        return $this->getView()->display();

    }
} 