<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/5 0005
 * Time: 下午 12:09
 */

namespace Admin\Controller;

use System\Library\Form\checkForm as checkForm;


class configController extends abstractController
{


    public function indexAction()
    {

        $all = db()->Table('config')->getAll()->done();        //getAll
        $newData = array();
        foreach ($all as $v) {
            $newData[$v['option_name']] = $v['option_value'];
        }
        //系统全局配置
        $form = new \Admin\Config\Form\configForm();
        $form->bind($newData); //绑定Row
        $form->start('config'); //开始渲染
        //管理员资料
        $member = $this->getMember();
        $memberRow = db()->Table('member_info')->getRow(array('role' => \Member\Info\Table\Role::LEVEL_ADMIN,'id'=>$member['id']))->done();        //getRow
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->bind($memberRow); //绑定Row
        $memberForm->start('info'); //开始渲染
        //获取头像
        $this->getView()->assign(array('form' => $form,'memberform' => $memberForm,'avatar'=>$member['avatar']));
        return $this->getView()->display();
    }


    /**
     * 保存基本信息
     */
    public function saveAction()
    {

        $form = new \Admin\Config\Form\configForm();
        $form->start('config');
        //获取数据
        $data = $this->request()->getData();
        //没有设置的默认赋值为0
        foreach ($form->_check as $k => $v) {
            $data[$k] = $data[$k] ? $data[$k] : 0;
        }
        $data = checkForm::init($data, $form->_name);
        foreach ($data as $k => $v) {
            db()->table("config")->upDate(array("option_name" => $k, "option_value" => $v), array("option_name" => $k))->done();
        }
        return $this->link()->success("admin:config:index", "更新成功");
    }


    /**
     *头像上传
     */
    public function avatarUploadAction()
    {

        $targetFolder = 'Data/upload/image/avatar'; // Relative to the root
        //验证来路合法性
        $verifyToken = md5('unique_salt_xtt' . $_POST['timestamp']);
        if (empty($_FILES) || ($_POST['token'] != $verifyToken)) {
            exit (json_encode(array('success' => false, 'msg' => '未知的上传来源,上传失败!')));
        }
        //验证图片合法性
        $fstat = $_FILES[\Admin\Config\Type\Avatar::FILE_OBJ_NAME];
        $fileParts = pathinfo($fstat['name']);
        $type = explode(";", \Admin\Config\Type\Avatar::FILE_TYPE_EXTS);
        $types = array();
        foreach ($type as $v) {
            $types[] = str_replace("*.", "", $v);
        }
        if (!in_array($fileParts['extension'], $types)) {
            exit (json_encode(array('success' => false, 'msg' => '类型错误!')));
        }

        if (round($fstat["size"] / 1024, 2) > \Admin\Config\Type\Avatar::FILE_SIZE_LIMIT) {
            exit (json_encode(array('success' => false, 'msg' => '超出文件大小!')));
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
        move_uploaded_file($tempFile, $targetFile);

        //返回物绝对路径
        $webFile = 'http://' . str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['HTTP_HOST']."/", $targetFile);
        //更新头像数据路径
        $res = db()->table('member_info')->upDate(array('avatar'=>$webFile),array('id'=>$member['id']))->done();
        exit (json_encode(array('success' => true, 'file' => $webFile)));
    }


}