<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/9 0009
 * Time: ÏÂÎç 5:14
 */
namespace System\Core;

class Cache {


    /**
     * ³õÊ¼»¯ÅäÖÃ
     * @param $config
     */
    public function init($config)
    {
        $this->db = new \System\Library\Db\pdoMysql($config[$config['type']]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        return $this->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name,$value) {
        return $this->set($name,$value);
    }

    /**
     * @param $name
     */
    public function __unset($name) {
        $this->rm($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setOptions($name,$value) {
        $this->options[$name]   =   $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getOptions($name) {
        return $this->options[$name];
    }




} 