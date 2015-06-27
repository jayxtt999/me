<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/27 0027
 * Time: ÏÂÎç 4:30
 */

namespace Admin\Controller;


class templateController extends abstractController
{

    public function indexAction()
    {

        $templateAll = db()->table("template")->getAll()->done();
        $this->getView()->assign(array('templateAll'=>$templateAll));
        return $this->getView()->display();

    }


} 