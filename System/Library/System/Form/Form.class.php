<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-21
 * Time: 下午9:36
 */


class Form {
    //>setAttribute  add  setLabel
    private  $_form = array();
    private  $_start;
    private  $_text = array();
    private  $_textarea = array();
    private  $_select = array();
    /**
     * @param string $name
     * @param string $url
     * @param string $model
     * @param int $isCheck
     * @param array $param
     */
    public function init(string $name=null,string $url=null,$model=null,array $param=null){
        if(!$name){
            trace("表单name未定义",'','ERR');
        }
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        $url = $url?$url:getUrl();
        var_dump($url);exit;
        echo $model;exit;
        $this->_form[strtolower($name)] = "<form name=\"".$name."\" action=\"".$url."\" method='".$model."' ".$paramS.">";
    }

    public function start($name){
        return  $this->_form[$name];
    }
    public function end(){
        return "</form>";

    }

    public function setText($name,$label="",$param=""){
        if(!$name){
            trace("Text name".$name."未定义",'','ERR');
        }
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        if(isset($label)){
            $label = "<label class='col-md-3 control-label'>$label</label>";
        }
        $this->_text[$name] = $label."<div class='col-md-9'><input type='text' name='$name' ".$paramS."></div>";
    }

    public function getText($name){
        if($this->_text[$name]){
            return $this->_text[$name];
        }else{
            return "<input type='text'>";
        }
    }


    public function setTextArea($name,$param=""){
        if(!$name){
            trace("Text name".$name."未定义",'','ERR');
        }
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        $this->_textarea[$name] = "<textarea name='$name' ".$paramS."></textarea>";
    }

    public function getTextArea($name){
        if($this->_textarea[$name]){
            return $this->_textarea[$name];
        }else{
            return "<textarea></textarea>";
        }
    }

    public function setSelect($name,$param="",$data=""){
        if(!$name){
            trace("Text name".$name."未定义",'','ERR');
        }
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        $this->_select[$name] ="<select name='$name' ".$paramS.">";
        if(is_array($data)){
            foreach($data as $k=>$v){
                $this->_select[$name] .="<option value='$k'>$v</option>";
            }
        }
        $this->_select[$name] ="</select>";
    }

    public function getSelect($name){
        if($this->_select[$name]){
            return $this->_select[$name];
        }else{
            return "<select></select>";
        }
    }








} 