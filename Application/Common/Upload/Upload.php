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
    public function __construct($type,$driver = '', $driverConfig = array()){
        //$Upload = new \Think\Upload($setting);
        //$info = $Upload->upload($_FILES);
        /* �����ϴ����� */
        $driver = $driver?$driver:C("upload_type");
        $this->setDriver($type,$driver, $driverConfig);

    }


    /**
     * �����ϴ�����
     * @param string $driver ��������
     * @param array $config ��������
     */
    private function setDriver($type,$driver = null, $driverConfig){
        $this->driver = $driver;
        $this->driverConfig = $driverConfig;
        $className = "\\System\\Library\\Upload\\".ucfirst($driver)."\\".ucfirst($driver);
        $this->uploader = new $className($type,$driverConfig);
        //$this->uploader = new \System\Library\Upload\Local\Local($type,$driverConfig);
        //var_dump($this->uploader);exit;
        if(!$this->uploader){
            E("�������ϴ�������$className");
        }
    }


    public function upload($fileField, $type = "upload"){

        $this->uploader->upFile($fileField, $type = "upload");
        return $this->uploader->getFileInfo();
    }



    public function get($size,$start){

        return $this->uploader->get($size,$start);

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