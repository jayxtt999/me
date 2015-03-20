<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/28 0028
 * Time: 上午 10:49
 */

namespace Admin\Controller;
use System\Library\Form\checkForm as checkForm;


class twitterController extends abstractController{

    /**
     * 说说
     */
    public function indexAction(){

        $list = db()->table("twitter")->getAll(array("status"=>\Admin\Article\Type\Status::STATUS_ENABLE))->order("id desc")->limit(10)->done();

        // 色彩
        $color = array(
            "yellow","green","blue","purple","grey"
        );
        $this->getView()->assign(array("list"=>$list,"color"=>$color));
        $this->getView()->display();

    }







} 