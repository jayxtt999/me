<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-21
 * Time: 下午9:36
 */

namespace System\Library\Form;

class Form
{
    //>setAttribute  add  setLabel
    private $_form = array();
    private $_start;
    private $_text = array();
    public $_check = array();
    private $_textarea = array();
    private $_select = array();
    private $_bind = false;
    private $_bindDate = array();
    public $_name = array();

    /**
     * @param string $name
     * @param string $url
     * @param string $model
     * @param int $isCheck
     * @param array $param
     */
    public function init($name = null, $url = null, $model = null, $param = null)
    {
        if (!$name) {
            trace("表单name未定义", '', 'ERR');
        }
        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }
        $url = $url ? $url : getUrl();
        $model = $model ? $model : "post";
        $this->_form[strtolower($name)] = "<form name=\"" . $name . "\" action=\"" . $url . "\" method='" . $model . "' " . $paramS . ">";
    }

    /**
     * @param $obj
     */
    public function bind($obj)
    {
        $this->_bindDate = $obj;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function begin($name)
    {
        return $this->_form[strtolower($name)];
    }

    /**
     * @return string
     */
    public function end()
    {
        return "</form>";
    }

    /**
     * @param $name
     * @param $param
     * @param bool $isCheck
     */
    public function setHide($name, $param, $isCheck = false)
    {
        if (!$name) {
            trace("Text name" . $name . "未定义", '', 'ERR');
        }
        $this->_name[$name];
        $this->setText($name, $label = "", $param, $valid = "", true);
    }

    /**
     * @param $name
     * @param $param
     * @param $value
     */
    public function setBsCheckBox($name, $label = "", $param)
    {

        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }
        $label = $label ? "<label class='col-md-3 control-label'>$label</label>" : "";
        if ($this->_bindDate) {
            $check = $this->_bindDate[$name] ? "checked" : "";
            $v = $this->_bindDate[$name] ? 1 : 0;
        }
        $this->_check[$name] = $label . "
             <div class='col-md-3'><input name='" . $name . "' type='checkbox' " . $paramS . " data-size='normal' " . $check . " value=" . $v . "></div>
        ";
    }

    /**
     * @param $name
     * @return string
     */
    public function getBsCheckBox($name)
    {
        if (isset($this->_check[$name])) {
            return $this->_check[$name];
        } else {
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
    public function setText($name, $label = "", $param = "", $valid = array(), $type = "text", $lw = 3, $dw = 9,$val="")
    {
        if (!$name) {
            trace("Text name" . $name . "未定义", '', 'ERR');
        }
        $this->_name[$name] = $valid;
        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }
        if ($label) {
            $label = "<label class='col-md-" . $lw . " control-label'>$label</label>";
        } else {
            $label = "";
        }
        if ($this->_bindDate[$name]) {
            $value = $val ? "value='" . $val . "'": $this->_bindDate[$name] ? "value='" . $this->_bindDate[$name] . "'" : "";
        }
        if ($valid) {
            $validHtml = "";
            $additional = "";
            if ($valid['datatype']) {
                $validHtml .= "datatype='" . $valid['datatype'] . "'";
            }
            if ($valid['errormsg']) {
                $validHtml .= "errormsg='" . $valid['errormsg'] . "'";
            }
            if ($valid['nullmsg']) {
                $validHtml .= "nullmsg='" . $valid['nullmsg'] . "'";
            }
            $additional .= "<span class='help-block help-block-error' style='display:none'></span>";
        }

        $this->_text[$name] = $label . "<div class='col-md-" . $dw . "'><input type='" . $type . "' name='$name' " . $paramS . $value . $validHtml . " >" . $additional . "</div>";
    }

    /**
     * @param $name
     * @return string
     */
    public function getText($name)
    {
        if ($this->_text[$name]) {
            return $this->_text[$name];
        } else {
            return "<input type='text'>";
        }
    }

    /**
     * @param $name
     * @param string $param
     */
    public function setTextArea($name, $label = "", $param = "", $valid = "", $isHide = false, $lw = 3, $dw = 9)
    {
        if (!$name) {
            trace("Text name" . $name . "未定义", '', 'ERR');
        }
        $label = $label ? "<label class='col-md-" . $lw . " control-label'>$label</label>" : "";
        if ($this->_bindDate[$name]) {
            $value = $this->_bindDate[$name];
        }
        $this->_name[$name];
        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }

        $this->_textarea[strtolower($name)] = $label . "<div class='col-md-" . $dw . "'><textarea name='$name' " . $paramS . ">".stripslashes($value)."</textarea></div>";
    }

    /**
     * @param $name
     * @return string
     */
    public function getTextArea($name)
    {
        if ($this->_textarea[strtolower($name)]) {
            return $this->_textarea[strtolower($name)];
        } else {
            return "<textarea></textarea>";
        }
    }

    /**
     * @param $name
     * @param $label
     * @param string $param 加载的参数
     * @param string $data 数据
     * @param int $lw label宽度
     * @param int $dw data宽度
     */
    public function setSelect($name, $label, $param = "", $data = "", $lw = 3, $dw = 6)
    {
        if (!$name) {
            trace("Text name" . $name . "未定义", '', 'ERR');
        }
        $label = $label ? "<label class='col-md-" . $lw . " control-label'>$label</label>" : "";
        $this->_name[$name];
        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }
        $this->_select[$name] = $label . "<div class='col-md-" . $dw . "'><select name='$name' " . $paramS . ">";
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $selected = $this->_bindDate[$name] == $k ? "selected = 'selected'" : "";
                $this->_select[$name] .= "<option value='$k' " . $selected . ">$v</option>";
            }
        }
        $this->_select[$name] .= "</select></div>";


    }

    /**
     * @param $name
     * @return string
     */
    public function getSelect($name)
    {
        if ($this->_select[$name]) {
            return $this->_select[$name];
        } else {
            return "<select></select>";
        }
    }

    /**
     * 百度编辑器
     * @param $name
     * @return string
     */
    public function setUeditor($name, $label = "", $param = "",$config="", $lw = 3, $dw = 12)
    {
        $name = strtolower($name);
        if (!$name) {
            trace("Text name" . $name . "未定义", '', 'ERR');
        }
        $label = $label ? "<label class='col-md-" . $lw . " control-label'>$label</label>" : "";
        if ($this->_bindDate[$name]) {
            $value = htmlspecialchars_decode($this->_bindDate[$name],ENT_COMPAT);
        }
        $this->_name[$name];
        if (is_array($param)) {
            $paramS = "";
            foreach ($param as $k => $v) {
                $paramS .= "$k=\"$v\" ";
            }
        }
        //如果加载过 就无需重复加载js文件
        if (!$this->_ueditor) {
            $this->_ueditor[$name] = "
             <script type='text/javascript' charset='utf-8' src='" . SYS_LIB_PATH . "/Ueditor/ueditor.config.js'></script>
             <script type='text/javascript' charset='utf-8' src='" . SYS_LIB_PATH . "/Ueditor/ueditor.all.min.js'> </script>
             <script type='text/javascript' charset='utf-8' src='" . SYS_LIB_PATH . "/Ueditor/lang/zh-cn/zh-cn.js'></script>";
        }
        $this->_ueditor[$name] .= $label .
            "
        <div class='col-md-" . $dw . "'>
             <script id='" . $name . "'  type='text/plain'></script>
             <script type='text/javascript'>
               var ue".$name." = UE.getEditor('" . $name . "',{textarea:\"".$name."\",".$config."});
                ue".$name.".ready(function(){
                        ue".$name.".setContent('".$value."');
                    })
             </script>
        </div>";
    }


    /**
     * @param $name
     * @return string
     */
    public function getUeditor($name)
    {
        if ($this->_ueditor[$name]) {
            return $this->_ueditor[$name];
        }else {
            return "<span style='color: red'>Uedit插件加载失败</span>";
        }
    }

} 