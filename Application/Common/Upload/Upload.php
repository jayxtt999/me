<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: 下午9:28
 */

namespace Common\Upload;


class  Upload {

    private $uploader;
    private $driver;
    private $driverConfig;

    /**
     * 构造方法，用于构造上传实例
     * @param array  $config 配置
     * @param string $driver 要使用的上传驱动 LOCAL-本地上传驱动，FTP-FTP上传驱动
     */
    public function __construct($type,$driver = '', $driverConfig = array()){
        //$Upload = new \Think\Upload($setting);
        //$info = $Upload->upload($_FILES);
        /* 设置上传驱动 */
        $driver = $driver?$driver:C("upload_type");
        $this->setDriver($type,$driver, $driverConfig);

    }


    /**
     * 设置上传驱动
     * @param string $driver 驱动名称
     * @param array $config 驱动配置
     */
    private function setDriver($type,$driver = null, $driverConfig){
        $this->driver = $driver;
        $this->driverConfig = $driverConfig;
        $className = "\\System\\Library\\Upload\\".ucfirst($driver)."\\".ucfirst($driver);
        $this->uploader = new $className($type,$driverConfig);
        //$this->uploader = new \System\Library\Upload\Local\Local($type,$driverConfig);
        //var_dump($this->uploader);exit;
        if(!$this->uploader){
            E("不存在上传驱动：$className");
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