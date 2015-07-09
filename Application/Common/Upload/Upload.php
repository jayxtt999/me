<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: ����9:28
 */

namespace Common\Upload;


class  Upload {

    private $uploader;
    private $driver;
    private $driverConfig;

    /**
     * ���췽�������ڹ����ϴ�ʵ��
     * @param array  $config ����
     * @param string $driver Ҫʹ�õ��ϴ����� LOCAL-�����ϴ�������FTP-FTP�ϴ�����
     */
    public function __construct($driverConfig = array(),$driver = '' ){
        //$Upload = new \Think\Upload($setting);
        //$info = $Upload->upload($_FILES);
        /* �����ϴ����� */
        $driver = $driver?$driver:C("upload_type");
        $this->setDriver($driver, $driverConfig);

    }


    /**
     * �����ϴ�����
     * @param string $driver ��������
     * @param array $config ��������
     */
    private function setDriver($driver = null, $driverConfig){
        $this->driver = $driver;
        $this->driverConfig = $driverConfig;
        $className = "\\System\\Library\\Upload\\".ucfirst($driver)."\\".ucfirst($driver);
        $this->uploader = new $className($driverConfig);
        //$this->uploader = new \System\Library\Upload\Local\Local($type,$driverConfig);
        //var_dump($this->uploader);exit;
        if(!$this->uploader){
            E("�������ϴ�������$className");
        }
    }


    /**
     * @param $fileField �ϴ�filename
     * @param string $type �ϴ���ʽ Զ��remote,base64,����upload
     * @param string $uploadType
     * @return mixed
     */
    public function upload($fileField, $type = "upload",$uploadType="uploadfile"){

        $this->uploader->upFile($fileField, $type,$uploadType);
        return $this->uploader->getFileInfo();
    }



    public function get($size=10,$start=0,$type="listimage"){

        return $this->uploader->get($size,$start,$type);

    }



    /* public function __construct($type=null,$config=array()){
         $this->getClass($type=null,$config=array());
         $Upload = new \Think\Upload($setting);
     }


     public function getClass($type=null,$config=array()){
         $uploadType = C("upload_type");
         $className = "\\System\\Library\\Upload\\".ucfirst($uploadType)."\\".ucfirst($uploadType);
         return new $className($type,$config);
     }*/

} 