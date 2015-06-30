<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/27 0027
 * Time: ÏÂÎç 4:30
 */

namespace Admin\Controller;


class templateController extends abstractController
{

    public function indexAction()
    {

        $templateAll = db()->table("template")->getAll()->done();
        $this->getView()->assign(array('templateAll'=>$templateAll));
        return $this->getView()->display();

    }


    public function uploadTplAction(){

        $fileData = $_FILES["file_data"];

        $tmp_name = $fileData["tmp_name"];
        $name = $fileData["name"];
        $type = $fileData["type"];
        $size = $fileData["size"];
        try{
            move_uploaded_file($tmp_name, UPLOAD_PATH."/zip/xss123.rar");
        }catch (\Exception $e){
            var_dump($e->getMessage());
        }

        /*foreach ($_FILES["file_data"]["error"] as $key => $error) {
            var_dump($error);exit;
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["file_data"]["tmp_name"][$key];
                $name = $_FILES["file_data"]["name"][$key];
                $type = $_FILES["file_data"]["type"][$key];
                $size = $_FILES["file_data"]["size"][$key];
                if($type !=="application/octet-stream"){

                }
                //var_dump(move_uploaded_file($tmp_name, "/Data/upload/zip/".md5($name)));
            }
        }*/

        //exit;


        $type = "tpl";
        unZip(UPLOAD_PATH."/zip/xss123.rar","/Content/Templates",$type);



    }










} 