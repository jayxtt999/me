<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/30 0030
 * Time: ���� 2:36
 */

namespace Home\Controller;


class twitterController extends abstractController
{

    /**
     * ��ȡ�б�
     */
    public function indexAction(){

        $where = array(
            'status' => \Admin\Article\Type\Status::STATUS_ENABLE,
        );
        $count = db()->Table('twitter')->getAll($where)->count()->done();
        $page = new \System\Library\Page($count);
        $page->listRows = 10;
        if($page->isShow){
            $showPage  = $page->show();// ��ҳ��ʾ���
        }else{
            $showPage = "";
        }
        // ���з�ҳ���ݲ�ѯ
        $list = db()->Table('twitter')->getAll($where)->limit($page->firstRow,$page->listRows)->done();

        return $this->getView()->assign(array('list'=>$list));

    }


} 