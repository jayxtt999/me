<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/9 0009
 * Time: 下午 3:56
 */

namespace Admin\Model;


class webConfigModel extends \System\Core\Model{


    /**
     * 获取网站填写的前台设置
     * @return array
     */
    public function getConfig(){

        $db = parent::getDb();
        $config =  $db->table('config')->getAll()->done();
        $array = array();
        foreach($config as  $v){
            $array[$v['option_name']] =  $v['option_value'];
        }
        return $array;
    }


} 