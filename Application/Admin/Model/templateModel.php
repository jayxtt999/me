<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/2 0002
 * Time: 下午 5:59
 */

namespace Admin\Model;


class templateModel extends \System\Core\Model{

    public static  $infoKey = array("name","version","author","descriptor","title");

    /**
     * @param $name
     * @return mixed
     */
    public function getTemplate($name){

        if($name){
            return db()->table("template")->getRow(array('name'=>$name))->done();
        }else{
            return false;
        }
    }

    /**
     * 模板是否存在
     * @param $name
     * @return bool
     */
    public function isHaveTpl($name){

        $r =  $this->getTemplate($name);
        if($r){
            return true;
        }else{
            return false;
        }

    }

    /**
     * 设置为默认模板
     * @param $name
     * @return mixed
     */
    public function setTplDefault($name){

        $r =  $this->getTemplate($name);
        if($r){
            db()->table("template")->upDate(array('status'=>0),array())->done();
            db()->table("template")->upDate(array('status'=>1),array('name'=>$name))->done();
            return true;
        }else{
            return false;
        }

    }

    /**
     * 添加模板数据
     * @param $data
     * @return bool|mixed
     */
    public function addTpl($data){

        if(!is_array($data) || empty($data)){
            return false;
        }
        if($this->isHaveTpl($data['name'])){
            db()->table("template")->upDate($data,array('name'=>$data['name']))->done();
            return true;
        }else{
            $data['crate_time'] = date("Y-m-d H:i:s");
            return db()->table("template")->insert($data)->done();
        }

    }


    public function delTpl($name){

        if($this->isHaveTpl($name)){
            $res =  db()->table("template")->delete(array('name'=>$name))->done();
            //删除文件夹
            if(1){
                $dir = APP_TEMP_PATH ."/".trim($name);
                return deleteDir($dir);
            }else{
                return true;
            }
        }else{
           return false;
        }

    }

} 