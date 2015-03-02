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

        $all = db()->Table('article')->getAll()->done();        //getAll
        $this->getView()->assign(array('articleAll'=>$all));
        return $this->getView()->display();

    }

    /**
     * 日志编辑
     */
    public function editAction(){
        $id = get('id','int');
        $row = db()->Table('article')->getRow(array('id'=>$id))->done();        //getRow
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form'=>$form));
        $tag = new \Admin\Model\articleModel();
        //获取该文章标签


        //获取已有全部标签
        $tags = $tag->getTags();
        $this->getView()->assign(array('tags'=>$tags));
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
        $tags = !empty($data['tag']) ? preg_split ("/[,\s]|(，)/", $data['tag']) : array();
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
            return $this->link()->success("admin:article:list","更新成功");
        }else{
            return $this->link()->error("未更新或更新失败");
        }

    }





} 