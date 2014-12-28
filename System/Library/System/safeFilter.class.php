<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/28 0028
 * Time: ÉÏÎç 10:34
 */
class System_Library_System_safeFilter
{

    public static function int($val)
    {
        return (int)$val;
    }

    public static function number($val)
    {
        return is_numeric($val) ? $val : false;
    }

    public static function string($val)
    {
        return $val;
    }

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

    public static function chars($val)
    {
        if (preg_match('/^[\w\-\+\/\=]+$/i', $val)) {
            return $val;
        } else {
            return false;
        }
    }

    public static function float($val)
    {
        return (float)$val;
    }

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

} 