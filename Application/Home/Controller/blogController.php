<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Home\Controller;


class blogController extends abstractController{

    public function indexAction(){

        //获取文章列表
        $where = $logList = array();
        $where['status'] = \Admin\Article\Type\Status::STATUS_ENABLE;
        $where['member_id'] = 1;

        $count = db()->Table('article')->getAll($where)->order("istop desc")->count()->done();        //getAll

        $page = new \System\Library\Page($count);

        if($page->isShow){
            $showPage  = $page->show();// 分页显示输出
        }else{
            $showPage = "";
        }
        // 进行分页数据查询
        $all = db()->Table('article')->getAll($where)->limit($page->firstRow,$page->listRows)->order("istop desc")->done();

        foreach($all as $k=>$v){

            $logList[$k]['title'] = htmlspecialchars(trim($v['title']));
            $logList[$k]['id'] = $v['id'];
            $logList[$k]['url'] = $this->getView()->log($v['id']);
            $cookiePassword = cookie('xtt_logpwd_'.$v['id'])?addslashes(trim(cookie('xtt_logpwd_'.$v['id']))) : '';
            $logList[$k]['excerpt'] = empty($v['excerpt']) ? breakLog($v['content'], $v['id']) : $v['excerpt'];
            if (!empty($v['password']) && $cookiePassword != $v['password']) {
                $logList[$k]['excerpt'] = '<p>[该日志已设置加密，请点击标题输入密码访问]</p>';
            } else {
                if (!empty($v['excerpt'])) {
                    $logList[$k]['excerpt'] .= '<p class="readmore"><a href="' .  $this->getView()->log($v['id']) . '">阅读全文&gt;&gt;</a></p>';
                }
            }
            $logList[$k]['thumbnail'] = $v['thumbnail'];
            $logList[$k]['time'] = $v['time'];
            $logList[$k]['author'] = member($v['member_id']);

            $model = new \Home\Model\homeModel();
            $logList[$k]['category'] = $model->getArticleCategory($v['category']);
            $tag = new \Admin\Model\articleModel();
            //获取该文章标签
            $tags = $tag->getTags($v['id'],true);
            if($tags){
                $logList[$k]['tags'] =explode(",",$tags);
            }
            $logList[$k]['comment_num'] = $v['comment_num'];
            $logList[$k]['view_num'] = $v['view_num'];
            $logList[$k]['istop'] = $v['istop'];

        }
        $this->getView()->assign(array('articleAll'=>$logList,'show'=>$showPage));
        $this->getView()->display();
    }

    /**
     * 显示博文
     */
    public function showAction(){

        $id = get("id","int");
        $where['status'] = \Admin\Article\Type\Status::STATUS_ENABLE;
        $where['member_id'] = 1;
        $where['id'] = $id;
        $row = db()->Table('article')->getRow($where)->limit(0,1)->done();
        if(!empty($row['password'])){
            $cookiePassword = addslashes(trim(cookie('xtt_logpwd_'.$row['id'])));
            if($cookiePassword != $row['password']){

                $this->getView()->assign(array('id'=>$id,'msg'=>""));
                return $this->getView()->display("checkpwd");
            }
        }
        $config = new \Admin\Model\webConfigModel();
        $webConfig = $config->getConfig();
        if($webConfig['ischkcomment']){
            new \Common\Security\CommentVerSession();
        }
        $model = new \Home\Model\homeModel();
        $row['category'] = $model->getArticleCategory($row['category']);
        $tag = new \Admin\Model\articleModel();
        //获取该文章标签
        $tags = $tag->getTags($row['id'],true);
        if($tags){
            $row['tags'] =explode(",",$tags);
        }
        $row['author'] = member($row['member_id']);

        //加载评论
        $commentWhere['status'] = \Admin\Comment\Type\Status::STATUS_ENABLE;
        $commentWhere['type'] = \Admin\Comment\Type\Type::TYPE_ARTICLE;
        $commentWhere['data'] = $id;

        $comments = db()->Table('comment')->getAll($commentWhere)->order("id ".$webConfig['comment_order'])->done();

        //生成序列树
        $comments= ($this->sortOut($comments));

        $this->getView()->assign(array('blog'=>$row,"comments"=>$comments));


        return $this->getView()->display();
    }

    /**
     * 重置序列
     * @param $cate
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function sortOut($cate,$pid=0,$level=0){
        $tree = array();
        foreach($cate as $v){
            if($v['ref_id'] == $pid){
                $v['level'] = $level + 1;
                $tree[] = $v;
                $tree = array_merge($tree, self::sortOut($cate,$v['id'],$level+1));
            }
        }
        return $tree;
    }


    /**
     * 验证密码
     */
    public function checkPwdAction(){

        $id = post("id","int");
        $password = post("password","string");
        $where['status'] = \Admin\Article\Type\Status::STATUS_ENABLE;
        $where['member_id'] = 1;
        $where['id'] = $id;
        $row = db()->Table('article')->getRow($where)->limit(0,1)->done();
        if($row){

            if(!empty($row['password'])){
                if($password == $row['password']){
                    cookie('xtt_logpwd_'.$row['id'],$password);
                    $this->link()->toUrl("home:blog:show:id-".$id,1,"验证成功");
                }else{
                    //验证失败
                    $this->getView()->assign(array("msg"=>"密码错误",'id'=>$id));
                    return $this->getView()->display();
                }
            }else{
                //无需验证
                $this->link()->toUrl("home:blog:show:id-".$id);
            }

        }else{
            //  不存在
            $this->link()->toUrl("home:blog:index",1,"该博文不存在...");
        }




    }



}