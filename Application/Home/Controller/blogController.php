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

        $show  = $page->show();// 分页显示输出
        // 进行分页数据查询
        $all = db()->Table('article')->getAll($where)->order("istop desc")->limit($page->firstRow.','.$page->listRows)->done();

        foreach($all as $k=>$v){

            $logList[$k]['title'] = htmlspecialchars(trim($v['title']));
            $logList[$k]['url'] = $this->getView()->log($v['id']);
            $logList[$k]['id'] = $v['id'];
            $cookiePassword = cookie('xtt_logpwd_'.$v['id'])?addslashes(trim($_COOKIE['em_logpwd_' . $v['gid']])) : '';
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
            $logList[$k]['comment_num'] = $v['comment_num']?$v['comment_num']:0;
            $logList[$k]['view_num'] = $v['view_num']?$v['view_num']:0;
            $logList[$k]['istop'] = $v['istop']?true:false;

            $tag = new \Admin\Model\articleModel();
            //获取该文章标签
            $logList[$k]['tags'] =explode(",",$tag->getTags($v['id'],true));
            $logList[$k]['password'] = $v['password'];

        }
        $this->getView()->assign(array('articleAll'=>$logList,'show',$show));



        $v = $this->getView();
        $v->display();
    }



}