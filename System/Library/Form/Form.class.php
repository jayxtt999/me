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
    public   $_check = array();
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

    /**
     * @param $obj
     */
    public function bind($obj){
        $this->_bindDate = $obj;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function begin($name){
        return  $this->_form[$name];
    }

    /**
     * @return string
     */
    public function end(){
        return "</form>";
    }

    /**
     * @param $name
     * @param $param
     * @param bool $isCheck
     */
    public function setHide($name,$param,$isCheck=false){
        if(!$name){
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        $this->_name[$name];
        $this->setText($name,$label="",$param,$valid="",true);
    }

    /**
     * @param $name
     * @param $param
     * @param $value
     */
    public function setBsCheckBox($name,$label="",$param){

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
            $check = $this->_bindDate[$name]?"checked":"";
            $v = $this->_bindDate[$name]?1:0;
        }
        $this->_check[$name] = $label."
             <div class='col-md-3'><input name='".$name."' type='checkbox' ".$paramS." data-size='normal' ".$check." value=".$v."></div>
        ";
    }

    /**
     * @param $name
     * @return string
     */
    public function getBsCheckBox($name){
        if(isset($this->_check[$name])){
            return $this->_check[$name];
        }else{
            return "null";
        }
    }

    /**
     * @param $name
     * @param string $label
     * @param string $param
     * @param string $valid
     * @param bool $isHide
     */
    public function setText($name,$label="",$param="",$valid="",$isHide=false,$lw=3,$dw=9){
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
        if($label){
            $label = "<label class='col-md-".$lw." control-label'>$label</label>";
        }else{
            $label = "";
        }
        if($this->_bindDate[$name]){
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

        $this->_text[$name] = $label."<div class='col-md-".$dw."'><input type='".$type."' name='$name' ".$paramS.$value.$validHtml." >".$additional."</div>";
    }

    /**
     * @param $name
     * @return string
     */
    public function getText($name){
        if($this->_text[$name]){
            return $this->_text[$name];
        }else{
            return "<input type='text'>";
        }
    }

    /**
     * @param $name
     * @param string $param
     */
    public function setTextArea($name,$label="",$param="",$valid="",$isHide=false,$lw=3,$dw=9){
        if(!$name){
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        if(isset($label)){
            $label = "<label class='col-md-".$lw." control-label'>$label</label>";
        }
        if($this->_bindDate[$name]){
            $value = $this->_bindDate[$name];
        }
        $this->_name[$name];
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }

        $this->_textarea[$name] = $label."<div class='col-md-".$dw."'><textarea name='$name' ".$paramS.">$value</textarea></div>";
    }

    /**
     * @param $name
     * @return string
     */
    public function getTextArea($name){
        if($this->_textarea[$name]){
            return $this->_textarea[$name];
        }else{
            return "<textarea></textarea>";
        }
    }

    /**
     * @param $name
     * @param string $param
     * @param string $data
     */
    public function setSelect($name,$label,$param="",$data="",$dw=6){
        if(!$name){
            \System\Core\Error::trace("Text name".$name."未定义",'','ERR');
        }
        if(isset($label)){
            $label = "<label class='col-md-3 control-label'>$label</label><div class='col-md-".$dw."'>";
        }
        $this->_name[$name];
        if(is_array($param)){
            $paramS = "";
            foreach($param as $k=>$v){
                $paramS .= "$k=\"$v\" ";
            }
        }
        $this->_select[$name] =$label."<select name='$name' ".$paramS.">";
        if(is_array($data)){
            foreach($data as $k=>$v){
                $selected = $this->_bindDate[$name] == $k?"selected = 'selected'":"";
                $this->_select[$name] .="<option value='$k' ".$selected.">$v</option>";
            }
        }
        $this->_select[$name] .="</select></div>";
    }

    /**
     * @param $name
     * @return string
     */
    public function getSelect($name){
        if($this->_select[$name]){
            return $this->_select[$name];
        }else{
            return "<select></select>";
        }
    }



} 