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
        $page = $p?$p:0;
        $rollPage = 10;
        $list = db()->table("twitter")->getAll(array("status"=>\Admin\Article\Type\Status::STATUS_ENABLE))->order("id desc")->limit($page*$rollPage,$rollPage)->done();
        // 色彩
        $color = array(
            "yellow","green","blue","purple","grey"
        );
        if($re->isAjax()){
            return JsonObject(array("p"=>$page+1,"data"=>$list,"color"=>$color));
        }else{
            $this->getView()->assign(array("p"=>$page+1,"list"=>$list,"color"=>$color));
            $this->getView()->display();
        }

    }


    /**
     *        添加说说
     * */
    public function addAction(){

        $re  = new \System\Library\Request();
        $content  = post("twitter","html");
        $member = $this->getMember();
        $crate_time = date("Y-m-d H:i:s");
        $array = array(
            'content'=>$content,
            'img'=>"",
            'author'=>$member['id'],
            'crate_time'=>$crate_time,
            'replynum'=>0,
            'status'=>1,
        );
        $color = array(
            "yellow","green","blue","purple","grey"
        );
        $id = db()->table("twitter")->insert($array)->done();
        if($re->isAjax()){
            if($id){
                return JsonObject(array("status"=>true,"id"=>$id,"crate_time"=>$crate_time,"content"=>$content,"color"=>array_reverse($color)));
            }else{
                return JsonObject(array("status"=>false));
            }
        }
    }


    public function delAction(){

        $re  = new \System\Library\Request();
        $id  = post("id","int");
        $res = db()->table("twitter")->delete(array('id'=>$id))->done();
        if($res){
            return JsonObject(array("status"=>true));
        }else{
            return JsonObject(array("status"=>false));
        }
    }

}