<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/27 0027
 * Time: ���� 4:30
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

        $zipFile = isset($_FILES['pluzip']) ? $_FILES['pluzip'] : '';
        $tmp_name = $zipFile["tmp_name"];
        $name = $zipFile["name"];
        $type = $zipFile["type"];
        $size = $zipFile["size"];
        $error = $zipFile["error"];

        if (getFileSuffix($zipFile['name']) != 'zip') {
            return ('�ļ����ʹ���');
        }

        if (!$zipFile || $error >= 1 || empty($tmp_name)) {
            return ('����ϴ�ʧ��');
        }
        $serverZipFile = UPLOAD_PATH."zip/".$name;
        move_uploaded_file($tmp_name,$serverZipFile);
        unZip($serverZipFile,"/Content/Templates","tpl");

    }










} 