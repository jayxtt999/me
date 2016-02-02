<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/28 0028
 * Time: 上午 10:49
 */

namespace Admin\Controller;

use System\Library\Form\checkForm as checkForm;


class articleController extends abstractController
{

    /**
     * 日志列表
     */
    public function listAction()
    {

        //检测标签 组合where
        $class = get("class", "int");
        $tags = get("tags", "txt");
        $member = get("member", "int");
        $where = array();
        if ($class) {
            $where['category'] = $class;
        }
        if ($member) {
            $where['member_id'] = $member;
        }
        if ($tags) {
            $tags = db()->table('article_tag')->getAll(array("tagname?LIKE" => "%$tags%"))->order('id')->done();
            $tid = array();
            //获取文章id
            foreach ($tags as $v) {
                $arr = explode(",", $v['gid']);
                $tid = array_unique(array_merge($tid, $arr));
            }
            $tid = implode(',', $tid);
            $where['id?in'] = $tid;
        }
        $where['status'] = \Admin\Article\Type\Status::STATUS_ENABLE;
        $all = db()->Table('article')->getAll($where)->done();        //getAll
        $this->getView()->assign(array('articleAll' => $all));
        //获取分类
        $menu = new \Admin\Model\articleModel();
        $category = $menu->getCategory();
        //获取标签
        $tag = new \Admin\Model\articleModel();
        $tags = $tag->getTags();
        //获取作者
        $member = new \Member\Model\memberModel();
        $author = $member->getAuthor();
        $this->getView()->assign(array('tags' => $tags, 'category' => $category, 'author' => $author));
        return $this->getView()->display();

    }

    /**
     * 添加日志
     */
    public function addAction()
    {

        $row = db()->Table('article')->getTableStructure()->done();
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form' => $form));
        $tag = new \Admin\Model\articleModel();
        //获取已有全部标签
        $tags = $tag->getTags("", true);
        $this->getView()->assign(array('tags' => $tags));
        $this->getView()->display('edit');
    }


    /**
     * 日志编辑
     */
    public function editAction()
    {
        $id = get('id', 'int');
        $row = db()->Table('article')->getRow(array('id' => $id))->done();        //getRow
        if (!$row) {
            return $this->link()->error("参数错误");
        }
        $row['title'] = htmlspecialchars($row['title']);
        $row['content'] = htmlspecialchars($row['content']);
        $row['excerpt'] = htmlspecialchars($row['excerpt']);
        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('articleEdit');                      //开始渲染
        $this->getView()->assign(array('form' => $form));
        $tag = new \Admin\Model\articleModel();
        //获取该文章标签
        $tTags = $tag->getTags($id, true);
        //获取已有全部标签
        $tags = $tag->getTags("", true);

        $this->getView()->assign(array('tags' => $tags, 'tTags' => $tTags, 'data' => $row));
        $this->getView()->display();
    }

    /**
     * @return mixed
     */
    public function saveAction()
    {

        $form = new \Admin\Article\Form\editForm();        //获取表单
        $form->start('articleEdit');
        $data = $this->request()->getData();//获取数据
        $data['id'] = post("id", 'int');
        $data['title'] = post("title", 'string');
        $data['tag'] = post("tag", 'string');
        $data['category'] = post("category", 'int');
        $data['istop'] = post("istop", 'int');
        $data['allow_comment'] = post("allow_comment", 'int');
        $data['content'] = post("content", 'html');
        $data['excerpt'] = post("excerpt", 'html');
        $data = checkForm::init($data, $form->_name);
        $id = $data['id'];
        unset($data['id']);
        $data['time'] = date("Y-m-d H:i:s");
        $member = $this->getMember();
        $data['member_id'] = $member['id'];
        //处理日志缩略图（空则取文章第一张,文章没有则取默认图片）
        if ($_FILES['thumbnail']['name']) {
            /*
            上传文件old
            //thumbnail不为空
              $targetFolder = 'Data/upload/image/article'; // Relative to the root
              //验证来路合法性
              //验证图片合法性
              $fstat = $_FILES[\Admin\Config\Type\Images::FILE_OBJ_NAME];
              $fileParts = pathinfo($fstat['name']);
              $type = explode(";", \Admin\Config\Type\Images::FILE_TYPE_EXTS);
              $types = array();
              foreach ($type as $v) {
                  $types[] = str_replace("*.", "", $v);
              }
              if (!in_array($fileParts['extension'], $types)) {
                  return $this->link()->error("文章缩略图类型错误!");
              }
              if (round($fstat["size"] / 1024, 2) > \Admin\Config\Type\Images::FILE_SIZE_LIMIT) {
                  return $this->link()->error("文章缩略图超出文件大小!");
              }
              $tempFile = $fstat['tmp_name'];
              $targetPath = $_SERVER['DOCUMENT_ROOT'] .$targetFolder;
              $member = $this->getMember();
              //检验目录
              $targetDir = rtrim($targetPath, '/') . '/' . $member['id'];
              if (!file_exists($targetDir)) {
                  mkdir($targetDir,0777,true);
              }
              //move_uploaded_file
              $code = time().rand(0,9999);
              $targetFile = $targetDir . '/yt_' . md5($member['id'].$code) . "." . $fileParts['extension'];
              move_uploaded_file($tempFile, $targetFile);*/

            $upload = new \Common\Upload\Upload();// 实例化上传类
            // 上传文件
            $fileInfo = $upload->upload("image", "thumbnail", "upload");
            if (!$fileInfo) {// 上传错误提示错误信息
                trace($upload->getError());
            } else {// 上传成功 获取上传文件信息
                /*
                 * 调试用
                 * foreach ($info as $file) {
                    echo $file['savepath'] . $file['savename'];
                }*/
            }
            //保存
            $data['thumbnail'] = $fileInfo['thumbnail']['url'];
        } elseif ($data['content']) {
            //thumbnail为空
            preg_match("<img.*src=[\"](.*?)[\"].*?>", $data['content'], $match);
            $data['thumbnail'] = "$match[1]";
        } else {
            $data['thumbnail'] = "";
        }

        // 处理标签
        $tags = !empty($data['tag']) ? preg_split("/[,\s]|(，)/", $data['tag']) : array();
        $tags = array_filter(array_unique($tags));
        foreach ($tags as $tagName) {
            $result = db()->table("article_tag")->getRow(array("tagname" => $tagName))->done();
            if (empty($result)) {
                db()->Table('article_tag')->insert(array("tagname" => $tagName, "gid" => $id))->done();
            } else {
                $gid = $result['gid'];
                $gids = strpos($gid, $id) ? $gid : $gid . "," . $id;
                db()->Table('article_tag')->upDate(array("gid" => $gids), array('tagname' => $tagName))->done();
            }
        }
        unset($data['tag']);
        //更新
        $res = db()->table("article")->upDate($data, array('id' => $id))->done();
        if ($res) {
            return $this->link()->success("admin:article:list", "保存成功");
        } else {
            return $this->link()->error("保存失败");
        }

    }

    /**
     * @return mixed
     */
    public function delAction()
    {
        $id = get("id", "int");
        $res = db()->Table('article')->upDate(array('status' => \Admin\Article\Type\Status::STATUS_UNABLE), array('id' => $id))->done();
        return $res;

    }


}
