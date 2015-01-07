<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-7
 * Time: 下午8:51
 */

namespace System\Library\Form;
use \System\Library\safeFilter as safeFilter;

class checkForm {
        private static  $type =array(
            "*"=>"/[\w\W]+/",
			"*?-?"=>"/^[\w\W]{%d,%d}$/",
			"n"=>"/^\d+$/",
			"n?-?"=>"/^\d{%d,%d}$/",
			"s"=>"/^[\u4E00-\u9FA5\uf900-\ufa2d\w\.\s]+$/",
			"s?-?"=>"/^[\u4E00-\u9FA5\uf900-\ufa2d\w\.\s]{%d,%d}$/",
			"p"=>"/^[0-9]{6}$/",
			"m"=>"/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/",
			"e"=>"/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",
			"url"=>"/^(\w+:\/\/)?\w+(\.\w+)+.*$/"
        );

        public static function init($date,$form){
            $dateArray  = array();
            $safeFilter = new safeFilter();
            //初步转换
            foreach ($date as $post_key=>$post_var)
            {
                if (is_numeric($post_var)) {
                    $date[strtolower($post_key)] = $safeFilter::int($post_var);
                } else {
                    $date[strtolower($post_key)] = $safeFilter::string($post_var);
                }
            }
            foreach($date as $k=>$v){
                if(isset($form[$k]['datatype'])){
                   $dataType = $form[$k]['datatype'];
                    if(array_key_exists($dataType,self::$type)){
                        //直接匹配验证

                    }else if(array_key_exists(preg_replace("/\d+/is", "?", $dataType),self::$type)){
                        //正则匹配
                        $key = preg_replace("/\d+/is", "?", $dataType);
                        //获取数值
                        preg_match("/.+(\d)+-(\d+)/",$dataType,$matchAll);
                        //组装正则
                        $preg = sprintf(self::$type[$key],$matchAll[1],$matchAll[2]);

                        //preg_match($date[$k],)

                    }else{
                        //throw new Exception("Value must be 1 or below");
                    }
                }

            }
            var_dump($form);
            var_dump($date);exit;


        }



} 