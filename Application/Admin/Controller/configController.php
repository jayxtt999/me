<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/5 0005
 * Time: 下午 12:09
 */

namespace Admin\Controller;
use System\Library\Form\checkForm as checkForm;


class configController extends abstractController{


        public function indexAction(){

            $all = db()->Table('config')->getAll()->done();        //getAll
            $newData = array();
            foreach($all as $v){
                $newData[$v['option_name']] = $v['option_value'];
            }
            $form = new \Admin\Config\Form\configForm();
            $form->bind($newData);                                  //绑定Row
            $form->start('config');                      //开始渲染
            $this->getView()->assign(array('form'=>$form));
            return $this->getView()->display();
        }


        public function saveAction(){

            $form = new \Admin\Config\Form\configForm();
            $form->start('config');
            $data = $this->request()->getData();//获取数据
            //没有设置的默认赋值为0
            foreach($form->_check as $k=>$v){
                $data[$k] = $data[$k]?$data[$k]:0;
            }
            $data = checkForm::init($data,$form->_name);
            foreach($data as $k=>$v){
                db()->table("config")->upDate(array("option_name"=>$k,"option_value"=>$v),array("option_name"=>$k))->done();
            }
            return $this->link()->success("admin:config:index","更新成功");
        }



        public function avatarUploadAction(){

            $targetFolder = '/Data/upload/avatar'; // Relative to the root
            //验证来路
            $verifyToken = md5('unique_salt_xtt' . $_POST['timestamp']);
            if(empty($_FILES) || ($_POST['token'] != $verifyToken)){
                exit (json_encode(array('success'=>false,'msg'=>'未知的上传来源,上传失败!')));
            }
            //验证合法性
            /*
             * 'name' => string 'QQ图片20150301090011.jpg' (length=26)
      'type' => string 'application/octet-stream' (length=24)
      'tmp_name' => string 'D:\wamp\tmp\phpA792.tmp' (length=23)
      'error' => int 0
      'size' => int 41198
            round($fstat["size"]/1024,2)
             *
             */

            $fstat = $_FILES[\Admin\Config\Type\Avatar::FILE_OBJ_NAME];
            $fileParts = pathinfo($fstat['name']);
            $type = explode(";",\Admin\Config\Type\Avatar::FILE_TYPE_EXTS);
            $types = array();
            foreach($type as $v){
                $types[]=str_replace("*.","",$v);
            }
            if(!in_array($fileParts['extension'],$types)){
                exit (json_encode(array('success'=>false,'msg'=>'类型错误!')));
            }

            if(round($fstat["size"]/1024,2) > \Admin\Config\Type\Avatar::FILE_SIZE_LIMIT){
                exit (json_encode(array('success'=>false,'msg'=>'超出文件大小!')));
            }

            $tempFile = $fstat['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $member = $this->getMember();

            $targetFile = rtrim($targetPath,'/') . '/' . "xtt_".$member['id'].'/'.time();
            move_uploaded_file($tempFile,$targetFile);
            exit (json_encode(array('success'=>true,'msg'=>'success')));
        }



} 