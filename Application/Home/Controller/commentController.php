<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Home\Controller;


class commentController extends abstractController{

    public function indexAction(){

        //获取评论列表
        $where = $logList = array();
        $where['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;

        $count = db()->Table('comment')->getAll($where)->order("istop desc")->count()->done();        //getAll

        $page = new \System\Library\Page($count);

        if($page->isShow){
            $show  = $page->show();// 分页显示输出
        }else{
            $show = "";
        }
        // 进行分页数据查询
        $comment = db()->Table('comment')->getAll($where)->limit($page->firstRow,$page->listRows)->order("istop desc")->done();

        $this->getView()->assign(array('comment'=>$comment,'show'=>$show));
        $this->getView()->display();
    }

    public function addAction(){

        $data = $this->getRequest()->getData();
        $data['type'] = \Admin\Comment\Type\Type::TYPE_ARTICLE;
        $data['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;
        $res = db()->insert($data)->done();

    }



}