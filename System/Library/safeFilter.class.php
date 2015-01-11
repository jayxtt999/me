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
        $str = htmlspecialchars($str);    // html标记转换
        return $str;
    }

}