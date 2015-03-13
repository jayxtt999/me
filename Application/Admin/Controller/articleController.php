<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/28 0028
 * Time: 上午 10:49
 */

namespace Admin\Controller;
use System\Library\Form\checkForm as checkForm;


class articleController extends abstractController{

    /**
     * 日志列表
     */
    public function listAction(){

        $class = get("class","int");
        $tags = get("tags","txt");
        $member = get("member","int");
        $where = array();
        if($class){
            $where['category'] = $class;
        }
        if($member){
            $where['member_id'] = $member;
        }
        if($tags){
            $tags = db()->table('article_tag')->getAll(array("tagname?LIKE"=>"%$tags%"))->order('id')->done();
            $tid = array();
            foreach($tags as $v){
                $arr = explode(",",$v['gid']);
                $tid = array_unique(array_merge($tid,$arr));
            }
            $tid=implode(',',$tid);
            $where['id?in'] =$tid;
        }
        $where['status'] = \Admin\Article\Type\Status::STATUS_ENABLE;

        $all = db()->Table('article')->getAll($where)->done();        //getAll

        $this->getView()->assign(array('articleAll'=>$all));
        //获取分类
        $menu = new \Admin\Model\articleModel();
        $category  = $menu->getCategory();
        //获取标签
        $tag = new \Admin\Model\articleModel();
        $tags = $tag->getTags();
        //获取作者
        $member = new \Member\Model\memberModel();
        $author = $member->getAuthor();
        $this->getView()->assign(array('tags'=>$tags,'category'=>$category,'author'=>$author));
        return $this->getView()->display();

    }

    /**
     * 添加日志
     */
    public function addAction(){

        $id = db()->Table('article')->getNewRow()->done();        //getRow
        $row = db()->Table('article')->getRow(array('id'=>$id))->done();        //getRow
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $tag = new \Admin\Model\articleModel();
        //获取已有全部标签
        $tags = $tag->getTags("",true);
        $this->getView()->assign(array('tags'=>$tags));
        $this->getView()->display('edit');
    }


    /**
     * 日志编辑
     */
    public function editAction(){
        $id = get('id','int');
        $row = db()->Table('article')->getRow(array('id'=>$id))->done();        //getRow
        if(!$row){
            return $this->link()->error("参数错误");
        }
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $tag = new \Admin\Model\articleModel();
        //获取该文章标签
        $tTags = $tag->getTags($id,true);
        //获取已有全部标签
        $tags = $tag->getTags("",true);
        $this->getView()->assign(array('tags'=>$tags,'tTags'=>$tTags));
        $this->getView()->display();
    }


    public function saveAction(){

        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->start('articleEdit');
        $data = $this->request()->getData();//获取数据
        $data = checkForm::init($data,$form->_name);
        $id = $data['id'];
        unset($data['id']);
        $data['time'] = date("Y-m-d H:i:s");
        $member = $this->getMember();
        $data['member_id'] = $member['id'];

        // 处理标签
        $tags = !empty($data['tag'])?preg_split ("/[,\s]|(，)/", $data['tag']) : array();
        $tags = array_filter(array_unique($tags));
        foreach ($tags as $tagName) {
            $result = db()->table("article_tag")->getRow(array("tagname"=>$tagName))->done();
            if (empty($result)) {
                db()->Table('article_tag')->insert(array("tagname"=>$tagName,"gid"=>$id))->done();
            } else {
                $gid = $result['gid'];
                $gids = strpos($gid,$id)?$gid:$gid.",".$id;
                db()->Table('article_tag')->upDate(array("gid"=>$gids),array('tagname'=>$tagName))->done();
            }
        }
        unset($data['tag']);

        //更新
        $res = db()->table("article")->upDate($data,array('id'=>$id))->done();
        if($res){
            return $this->link()->success("admin:article:list","保存成功");
        }else{
            return $this->link()->error("保存失败");
        }

    }

    public function delAction(){
        $id = get("id","int");
        $res = db()->Table('article')->upDate(array('status'=>\Admin\Article\Type\Status::STATUS_UNABLE),array('id'=>$id))->done();
        if($res){
            return $this->link()->success("admin:article:list","删除成功");
        }else{
            return $this->link()->error("删除失败");
        }

    }





} 