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

        $re  = new \System\Library\Request();
        $p  = post("p","int");
        $page = $p?$p:1;
        $rollPage = 10;
        $list = db()->table("twitter")->getAll(array("status"=>\Admin\Article\Type\Status::STATUS_ENABLE))->order("id desc")->limit($page*$rollPage,$rollPage)->done();

        // 色彩
        $color = array(
            "yellow","green","blue","purple","grey"
        );
        if($re->isAjax()){
            $p = post("p","int");
            exit(json_encode(array("p"=>$page,"data"=>$list,"color"=>$color)));
        }else{
            $this->getView()->assign(array("p"=>$page,"list"=>$list,"color"=>$color));
            $this->getView()->display();
        }

    }

}