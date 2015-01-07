<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-21
 * Time: 下午9:36
 */

namespace System\Library\Form;

class Form {
    //>setAttribute  add  setLabel
    private  $_form = array();
    private  $_start;
    private  $_text = array();
    private  $_textarea = array();
    private  $_select = array();
    private  $_bind = false;
    private  $_bindDate = array();
    public  $_name = array();
    /**
     * @param string $name
     * @param string $url
     * @param string $model
     * @param int $isCheck
     * @param array $param
     */
    public function init($name=null,$url=null,$model=null,$param=null){
        if(!$name){
            \System\Core\Error::trace("表单name未定义",'','ERR');
        }
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        $url = $url?$url:getUrl();
        $model = $model?$model:"post";
        $this->_form[strtolower($name)] = "<form name=\"".$name."\" action=\"".$url."\" method='".$model."' ".$paramS.">";
    }

    public function bind($obj){
        $this->_bindDate = $obj;
    }


    public function begin($name){
        return  $this->_form[$name];
    }
    public function end(){
        return "</form>";
    }

    public function setHide($name,$param){
        if(!$name){
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        $this->_name[$name];
        $this->setText($name,$label="",$param,$valid="",true);
    }

    public function setText($name,$label="",$param="",$valid="",$isHide=false){
        if(!$name){
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        $this->_name[$name] = $valid;
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        if(isset($label)){
            $label = "<label class='col-md-3 control-label'>$label</label>";
        }
        if($this->_bindDate){
            $value = $this->_bindDate[$name]?"value='".$this->_bindDate[$name]."'":"";
        }
        if($valid){
            $validHtml = "";
            $additional = "";
            if($valid['datatype']){
                $validHtml.="datatype='".$valid['datatype']."'";
            }
            if($valid['errormsg']){
                $validHtml.="errormsg='".$valid['errormsg']."'";
            }
            if($valid['nullmsg']){
                $validHtml.="nullmsg='".$valid['nullmsg']."'";
            }
            $additional.="<span class='help-block help-block-error' style='display:none'></span>";
        }
        if($isHide){
            $type = 'hidden';
        }else{
            $type = 'text';
        }

        $this->_text[$name] = $label."<div class='col-md-9'><input type='".$type."' name='$name' ".$paramS.$value.$validHtml." >".$additional."</div>";
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
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        $this->_name[$name];
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
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        $this->_name[$name];
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