<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/2 0002
 * Time: ���� 5:59
 */

namespace Admin\Model;


class templateModel extends \System\Core\Model{

    public static  $infoKey = array("name","varsion","author","descriptor");

    /**
     * @param $name
     * @return mixed
     */
    public function getTemplate($name){

        if($name){
            return db("template")->getRow(array('name'=>$name))->done();
        }else{
            return false;
        }
    }

    /**
     * ģ���Ƿ����
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
     * ����ΪĬ��ģ��
     * @param $name
     * @return mixed
     */
    public function setTplDefault($name){

        db("template")->upDate(array('status'=>0),array())->done();
        return db("template")->upDate(array('status'=>1),array('name'=>$name))->done();
    }

    /**
     * ���ģ������
     * @param $data
     * @return bool|mixed
     */
    public function addTpl($data){

        if(!is_array($data) || empty($data)){
            return false;
        }
        if($this->isHaveTpl($data['name'])){
            db("template")->upDate($data,array('name'=>$data['name']))->done();
            return true;
        }else{
            return  db("template")->insert($data)->done();
        }

    }

} 