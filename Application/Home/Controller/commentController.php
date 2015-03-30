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

        //评论是否开启
        if(!$webConfig['iscomment']){
            return JsonObject(array('status' => false,'msg'=>"评论已关闭"));
        }

        //是否需要验证码
        if ($webConfig['comment_code']) {
            //用于验证码
            $commentVer = new \Common\Security\CommentVerSession($data['ref_id']);
            $randVal = $commentVer->getSession();
            //验证 0 开头的 验证码 由于验证码首位为0，会被 getData 过滤
            if (md5(strtoupper(str_pad($data['check_code'],4,0,STR_PAD_LEFT))) !== $randVal) {
                return JsonObject(array('status' => false,'msg'=>"请输入正确的验证码"));
            }
        }

        //内容是否必须有中文
        if ($webConfig['comment_needchinese']){
            if (!preg_match("/[\x7f-\xff]/", $data['content'])) {
                return JsonObject(array('status' => false,'msg'=>"评论内容必须要含有中文"));
            }
        }

        //检测评论间隔时间
        $where = array(
            'ip'=>$this->getRequest()->getIP(),
            'crate_time?>'=>date("Y-m-d H:i:s",(time()-15)),
        );

        $interval = db()->Table('comment')->getAll($where)->done();

        if($interval){
            return JsonObject(array('status' => false,'msg'=>"操作频繁,请稍后再试"));
        }



        $data['type'] = \Admin\Comment\Type\Type::TYPE_ARTICLE;//
        $status = $webConfig['ischkcomment']?\Admin\Comment\Type\Status::STATUS_UNABLE:\Admin\Comment\Type\Status::STATUS_ENABLE;
        $data['status'] = $status;
        $data['crate_time'] = date("Y-m-d H:i:s");
        $data['ip'] =  $this->getRequest()->getIP();
        $level = $data['level'];
        unset($data['level']);
        unset($data['check_code']);

        $res = db()->Table('comment')->insert($data)->done();
        if($status){
            //组转html
            $left1 = 10+30*$level;
            $left2 = 65+30*$level;
            $showCheckCodeHtml = $webConfig['comment_code']?"<div><img src='/index.php?m=common&amp;c=getcommentver&amp;a=index&amp;id=".$res."' onclick='javascript:this.src='/index.php?m=common&amp;c=getcommentver&amp;a=index&amp;id=".$res."'' style='cursor: pointer;height: 44px;width: 100px;'><input type='text' maxlength='4' name='check_code' style='width: 15%;display: inline;margin-left: 5px;' placeholder='验证码' required='check_code'></div>":'';
            $html = "<li class='out comment_".$res."'><img class='avatar' alt='' style='margin-left: ".$left1."px;' src='http://q1.qlogo.cn/g?b=qq&amp;nk={$data['qq']}&amp;s=100&amp;t=".time()."'><div class='message' style='margin-left: ".$left2."px;'><span class='arrow'></span><a href='#' class='name'>".$data['name']." </a><span class='datetime'>at ".$data['crate_time']." </span><span class='body'>".$data['content']." </span><div><span aria-hidden='true' data='ref_".$res."_like' class='ico icon-like' onclick='upDownComment(this)'>0</span><span aria-hidden='true' data='ref_".$res."_dislike' class='ico icon-dislike' onclick='upDownComment(this)'>0</span><span aria-hidden='true' class='ico icon-speech' onclick='icon_speech(this)'>评论</span><div class='clearfix'></div></div><form class='rep_content'><input type='text'class='comment_name' placeholder='昵称'><input type='text' class='comment_qq' placeholder='QQ'><textarea name='content' class='comment_content' placeholder='内容' required='text'></textarea>".$showCheckCodeHtml."<input type='button' style='width: 100px;height: 38px;' value='提交' onclick='addComment();'></form></div>
            </li>";
        }else{
            $html = "";
        }
        //echo $html;exit;
        if ($res) {
            return JsonObject(array('status' => true,'html'=>$html));
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
            $res = db()->table("comment")->upDate(array("down"=>"down+1"),$where)->done();
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