<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-22
 * Time: ÏÂÎç9:53
 */

namespace Admin\Controller;


class calendarController extends abstractController{

    public function indexAction(){


        return $this->getView()->display();
    }


} 