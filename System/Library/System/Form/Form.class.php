<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-21
 * Time: 下午9:36
 */


class Form {
    //>setAttribute  add  setLabel
    private  $_form = '';
    private  $_start;
    /**
     * @param string $name
     * @param string $url
     * @param string $model
     * @param int $isCheck
     * @param array $param
     */
    public function start(string $name=null,string $url=null,string $model="post",int $isCheck=false,array $param=array()){
        if($isCheck){
            $this->_form.= "<script src=".JS_PLUGINS_PATH."/Validform_v5.3.2_ncr_min.js></script>";
        }

        if(is_array($param)){

        }

    }


    public function  checkForm(){


    }

} 