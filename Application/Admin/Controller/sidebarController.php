<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/24 0024
 * Time: 上午 9:33
 */

namespace Admin\Controller;


class sidebarController extends abstractController
{

    public function indexAction()
    {

        $systemWidgetsAll = db()->table("sidebar")->getAll(array('group' => 'system'))->order('sort')->done();

        foreach ($systemWidgetsAll as $k => $v) {
            $systemWidgetsAll[$k]['data'] = unserialize($v['data']);
        }

        $diyWidgetsAll = db()->table("sidebar")->getAll(array('group' => 'diy'))->order('sort')->done();

        $actionWidgetsAll = db()->table("sidebar")->getAll(array('show' => 1))->order('sort')->done();

        $this->getView()->assign(array('systemWidgetsAll' => $systemWidgetsAll, 'diyWidgetsAll' => $diyWidgetsAll, 'actionWidgetsAll' => $actionWidgetsAll));

        $this->getView()->display();

    }


    public function addAction()
    {

        $title = post("new_title", "txt");
        $content = post("new_content", "txt");

        $data = array();


    }


} 