<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-8-8
 * Time: 上午11:31
 */

namespace Admin\Controller;


class memberController extends \Admin\Controller\abstractController{


    /**
     * 用户列表
     */
    public function indexAction(){

        $all = db()->Table('member_info')->getAll()->done();//getAll
        $this->getView()->assign(array('memberAll' => $all));
        return $this->getView()->display();

    }


} 