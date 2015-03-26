<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Home\Controller;


class commentController extends abstractController
{


    public function indexAction()
    {

        //获取评论列表
        $where = $logList = array();
        $where['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;

        $count = db()->Table('comment')->getAll($where)->order("istop desc")->count()->done();        //getAll

        $page = new \System\Library\Page($count);

        if ($page->isShow) {
            $show = $page->show();// 分页显示输出
        } else {
            $show = "";
        }
        // 进行分页数据查询
        $comment = db()->Table('comment')->getAll($where)->limit($page->firstRow, $page->listRows)->order("istop desc")->done();

        $this->getView()->assign(array('comment' => $comment, 'show' => $show));
        $this->getView()->display();
    }

    /**
     * 添加评论
     */
    public function addAction()
    {

        $data = $this->getRequest()->getData();
        $config = new \Admin\Model\webConfigModel();
        $webConfig = $config->getConfig();
        if ($webConfig['ischkcomment']) {
            //用于验证码
            $checkCode = post("check_code", "string");
            $commentVer = new \Common\Security\CommentVerSession();
            $randVal = $commentVer->getSession();
            if (md5(strtoupper($checkCode)) !== $randVal) {
                return JsonObject(array('status' => false,'msg'=>"请输入正确的验证码"));
            }
        }

        $data['type'] = \Admin\Comment\Type\Type::TYPE_ARTICLE;
        $data['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;
        $res = db()->Table('comment')->insert($data)->done();

        if ($res) {
            return JsonObject(array('status' => true));
        } else {
            return JsonObject(array('status' => false,'msg'=>"提交失败"));
        }

    }


    /**
     * 顶踩
     */
    public function likeAction(){

        //id: id, status: status,type: "article",data:1

        $id = post("id","int");
        $operation =  post("operationtype","string");
        $data = post("data","int");
        $type = post("type","string")=="article"?1:2;

        $where = array();
        $where['id'] = $id;
        $where['type'] = $type;
        $where['data'] = $data;
        $where['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;

        if($operation == "like"){
            $res = db()->table("comment")->upDate(array("up"=>"up+1"),$where)->done();
            if($res){
                return JsonObject(array('status' => true));
            }else{
                return JsonObject(array('status' => false));
            }
        }elseif($operation == "dislike"){
            $res = db()->table("comment")->upDate(array("up"=>"down+1"),$where)->done();
            if($res){
                return JsonObject(array('status' => true));
            }else{
                return JsonObject(array('status' => false));
            }
        }else{
                return JsonObject(array('status' => false));
        }

    }


}