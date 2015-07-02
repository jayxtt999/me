<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/27 0027
 * Time: ���� 4:30
 */

namespace Admin\Controller;
use Admin\Model\templateModel as templateModel;


class templateController extends abstractController
{
    private $error = array(
        -3=>"����ZipArchive",
        -2=>"�ϴ�ʧ�ܣ�ȱ��ģ���Ҫ��˵���ļ�",
        -1=>"�ϴ�ʧ�ܣ�����ڲ�����",
         0=>"�ϴ��ɹ�",

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
            return ('�ļ����ʹ���');
        }
        if (!$zipFile || $error >= 1 || empty($tmp_name)) {
            return ('����ϴ�ʧ��');
        }
        $ret = unZip($tmp_name,"/Content/Templates","tpl");
        switch ($ret) {
            case -3:
                return JsonObject(array("error"=>'�ϴ��������ȿ���ZipArchive'));
                break;
            case -2:
                return JsonObject(array("error"=>'�ϴ���������ģ���ļ�������'));
                break;
            case 0:
                //���¼�¼
                $info = array();

                $templateModel = new templateModel();
                $data = file_get_contents(APP_TEMP_PATH."/".basename($name,".zip")."/info.log");
                $data = explode("\r\n",$data);
                foreach($data as $v){
                    $v = str_replace("��",":",$v);
                    $infos = explode(":",$v);
                    if(in_array($infos[0],$templateModel::$infoKey)){
                        $info[$infos[0]]= $infos[1];
                    }
                }
                $r = $templateModel->addTpl($info);
                if($r){
                    return JsonObject(array("success"=>'�ϴ��ɹ�'));
                }else{
                    return JsonObject(array("error"=>'����ϵ����Ա'));
                }
                break;
            case 1:
                return JsonObject(array("error"=>'�ϴ��ɹ�,��ѹʧ��'));
                break;
            case 2:
                return JsonObject(array("error"=>'��ģ��ѹ����ʧ��'));
                break;
        }
    }










} 