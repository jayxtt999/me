<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/9 0009
 * Time: ���� 5:14
 */
namespace System\Core;

class Cache
{
    protected $cache;

    /**
     * 初始化
     * @param $config
     */
    public function init($type = '', $options = array())
    {
        if (empty($type)) $type = C('cache_type');
        $type = strtolower(trim($type));
        $class = 'System\Library\Cache\cache' . ucwords($type);
        if (class_exists($class))
            $this->cache = new $class($options);
        else
            exception('CACHE_TYPE Error:' . $type);
        return $this->cache;
    }


    /**
     * 取得缓存类实例
     * @static
     * @access public
     * @return mixed
     */
    static function getInstance($type='',$options=array()) {
        static $_instance	=	array();
        $guid	=	$type.to_guid_string($options);
        if(!isset($_instance[$guid])){
            $obj	=	new Cache();
            $_instance[$guid]	=	$obj->init($type,$options);
        }
        return $_instance[$guid];
    }


    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->cache->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->cache->set($name, $value);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        $this->cache->delete($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setOptions($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getOptions($name)
    {
        return $this->options[$name];
    }




}