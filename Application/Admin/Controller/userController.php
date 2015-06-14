<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/12 0012
 * Time: 上午 10:56
 */

namespace Admin\Controller;


class userController extends \Admin\Controller\abstractController{

    public function profileAction(){
        //管理员资料
        $member = $this->getMember();
        $memberRow = db()->Table('member_info')->getRow(array('role' => \Member\Info\Table\Role::LEVEL_ADMIN,'id'=>$member['id']))->done();        //getRow
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->bind($memberRow); //绑定Row
        $memberForm->start('info'); //开始渲染
        $token  = getToken();
        session('avatarToken',$token);
        //获取头像
        $this->getView()->assign(array('memberform' => $memberForm,'avatar'=>$member['avatar'],'token'=>$token));
        return $this->getView()->display();
    }


    public function avatarUploadAction(){

        $data = post("data","txt");
        $token = post("avatarToken","txt");

        if($token !== session('avatarToken')){
            exit (JsonObject(array('success' => false, 'msg' => '未知的上传来源,上传失败!')));
        }

        $targetFolder = 'Data/upload/image/avatar'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] .$targetFolder;
        $member = $this->getMember();
        //检验目录
        $targetDir = rtrim($targetPath, '/') . '/' . $member['id'];
        if (!file_exists($targetDir)) {
            mkdir($targetDir,0777,true);
        }

        //move_uploaded_file
        $code = time().rand(0,9999);
        $targetFile = $targetDir . '/yt_' . md5($member['id'].$code) . ".jpg";

        $img = str_replace('data:image/png;base64,', '', $data);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($targetFile, $data);

        if(!$success){
            exit (JsonObject(array('success' => false, 'msg' => '保存失败!')));
        }
        $webFile = 'http://' . str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['HTTP_HOST']."/", $targetFile);
        $res = db()->table('member_info')->upDate(array('avatar'=>$webFile),array('id'=>$member['id']))->done();

        exit (JsonObject(array('success' => true, 'msg' => '保存成功!')));



    }

} 