<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/27 0027
 * Time: 下午 4:30
 */

namespace Admin\Controller;


class templateController extends abstractController
{
    private $error = array(
        -3=>"开启ZipArchive",
        -2=>"上传失败，缺少模板必要的说明文件",
        -1=>"上传失败，插件内部错误",
         0=>"上传成功",

    );

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
            return ('文件类型错误');
        }
        if (!$zipFile || $error >= 1 || empty($tmp_name)) {
            return ('插件上传失败');
        }
        $ret = unZip($tmp_name,"/Content/Templates","tpl");
        switch ($ret) {
            case -3:
                return JsonObject(array("error"=>'上传错误：请先开启ZipArchive'));
                break;
            case -2:
                return JsonObject(array("error"=>'上传错误：请检查模板文件完整性'));
                break;
            case 0:
                return JsonObject(array("success"=>'上传成功'));
                break;
            case 1:
                return JsonObject(array("error"=>'上传成功,解压失败'));
                break;
            case 2:
                return JsonObject(array("error"=>'打开模板压缩包失败'));
                break;
        }
    }










} 