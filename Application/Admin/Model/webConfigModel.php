<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/9 0009
 * Time: ���� 3:56
 */

namespace Admin\Model;


class webConfigModel extends \System\Core\Model{


    /**
     * ��ȡ��վ��д��ǰ̨����
     * @return array
     */
    public function getConfig(){

        $config =  db()->table('config')->getAll()->done();
        $array = array();
        foreach($config as  $v){
            $array[$v['option_name']] =  $v['option_value'];
        }
        return $array;
    }


} 