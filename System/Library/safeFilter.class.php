<?php
namespace System\Library;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/28 0028
 * Time: 20:38:07
 */
class safeFilter
{

    /**
     * @param $val
     * @return int
     */
    public static function int($val)
    {
        return (int)$val;
    }

    /**
     * @param $val
     * @return bool|int|string
     */
    public static function number($val)
    {
        return is_numeric($val) ? $val : false;
    }

    /**
     * @param $val
     * @return mixed
     */
    public static function string($val)
    {
        if (!get_magic_quotes_gpc()) {
            return addslashes($val);
        }
        return $val;
    }

    /**
     * @param $val
     * @return string
     */
    public static function txt($val)
    {
        if ($val != '') {
            $charset_loops = array();
            $charset_loops[] = 'UTF-8';
            foreach ($charset_loops as $charset) {
                if ('' != $parsed = @htmlspecialchars($val, 2, $charset)) {
                    return $parsed;
                }
            }
            return $val;
        } else {
            return $val;
        }
    }

    /**
     * @param $val
     * @return bool
     */
    public  static  function _array($val){

        if(is_array($val)){
            return $val;
        }else{
            return false;
        }


    }

    /**
     * @param $val
     * @return bool
     */
    public static function chars($val)
    {
        if (preg_match('/^[\w\-\+\/\=]+$/i', $val)) {
            return $val;
        } else {
            return false;
        }
    }

    /**
     * @param $val
     * @return float
     */
    public static function float($val)
    {
        return (float)$val;
    }

    /**
     * @param $val
     * @return array|string
     */
    public static function trim($val)
    {
        if (is_array($val)) {
            foreach ($val as $key => $one) {
                $val[$key] = trim($one);
            }
            return $val;
        } else {
            return trim($val);
        }
    }

    /**
     * @param $sql_str
     * @return int
     */
    public  static  function filterSql($sql_str) {
        return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
    }

    /**
     * @param $str
     * @return mixed|string
     */
    public  static function html($str) {
        if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开
            $str = addslashes($str);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤
        }
        $str = str_replace("_", "\_", $str);    // 把 '_'过滤掉
        $str = str_replace("%", "\%", $str);    // 把 '%'过滤掉
        $str = nl2br($str);    // 回车转换
        //$str = htmlspecialchars($str);    // html标记转换
        return $str;
    }


    /**
     * 来源 Thinkphp remove_xss
     * @param $val
     * @return mixed
     */
    function xss($val) {
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
            $val = preg_replace('/(�{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
        }
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true;
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(�{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
                $val = preg_replace($pattern, $replacement, $val);
                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        return $val;
    }




}