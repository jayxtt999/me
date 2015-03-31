<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/30 0030
 * Time: 锟斤拷锟斤拷 2:36
 */

namespace Home\Controller;


class twitterController extends abstractController
{


    public function indexAction(){
        $where = array(
            'status' => \Admin\Article\Type\Status::STATUS_ENABLE,
        );
        $count = db()->Table('twitter')->getAll($where)->count()->done();
        $page = new \System\Library\Page($count);
        $page->listRows = 10;
        if($page->isShow){
            $showPage  = $page->show();
        }else{
            $showPage = "";
        }
        $list = db()->Table('twitter')->getAll($where)->limit($page->firstRow,$page->listRows)->done();
        $commentWhere['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;
        $commentWhere['type'] = \Admin\Comment\Type\Type::STATUS_TWIITER;
        $lists = array();
        foreach($list as $k=>$v){
            $commentWhere['data'] = $v['id'];
            $lists[$k] = $v;
            $lists[$k]['comment'] =  db()->Table('comment')->getAll($commentWhere)->done();
        }
        $this->getView()->assign(array('list'=>$lists));
        $this->getView()->display();
    }


} 