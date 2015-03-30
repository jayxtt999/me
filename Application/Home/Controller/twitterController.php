<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/30 0030
 * Time: 下午 2:36
 */

namespace Home\Controller;


class twitterController extends abstractController
{

    /**
     * 获取列表
     */
    public function indexAction(){

        $where = array(
            'status' => \Admin\Article\Type\Status::STATUS_ENABLE,
        );
        $count = db()->Table('twitter')->getAll($where)->count()->done();
        $page = new \System\Library\Page($count);
        $page->listRows = 10;
        if($page->isShow){
            $showPage  = $page->show();// 分页显示输出
        }else{
            $showPage = "";
        }
        // 进行分页数据查询
        $list = db()->Table('twitter')->getAll($where)->limit($page->firstRow,$page->listRows)->done();

        return $this->getView()->assign(array('list'=>$list));

    }


} 