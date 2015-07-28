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
        $class = 'System\Library\Cache\Cache' . ucwords($type);
        if (class_exists($class))
            $this->cache = new $class($options);
        else
            exception('CACHE_TYPE Error:' . $type);
        return $this->cache;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        $this->delete($name);
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


    public function set($name, $value)
    {
       $this->cache->set($name, $value);
    }


    public function get($name)
    {
        $this->cache->get($name);

    }


    public function delete($name)
    {
        $this->cache->delete($name);

    }


}