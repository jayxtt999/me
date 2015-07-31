<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 18:08
 */

namespace System\Library\Cache;


class cacheRedis
{

    public function __construct($options = array())
    {
        if (!extension_loaded('redis')) {
            exception(('_nofund_').':redis');
        }
        $options = array_merge(array(
            'host'        =>  C('cache:redis:host') ? : '127.0.0.1',
            'port'        =>  C('cache:redis:port') ? : 6379,
            'timeout'     =>  C('cache:redis:timeout') ? : false,
            'persistent'  =>  false,

        ), $options);

        $this->options = $options;
        $this->options['expire'] =  isset($options['expire'])?  $options['expire']  :   C('cache:expire');
        $this->options['prefix'] =  isset($options['prefix'])?  $options['prefix']  :    C('cache:prefix');
        $func = $options['persistent'] ? 'pconnect' : 'connect';
        $this->handler = new \Redis;
        $options['timeout'] === false ?
            $this->handler->$func($options['host'], $options['port']) :
            $this->handler->$func($options['host'], $options['port'], $options['timeout']);
    }

    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @return mixed
     */
    public function get($name)
    {
        $value = $this->handler->get($this->options['prefix'] . $name);
        $jsonData = json_decode($value, true);
        return ($jsonData === NULL) ? $value : $jsonData;    //检测是否为JSON数据 true 返回JSON解析数组, false返回源数据
    }

    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value 存储数据
     * @param integer $expire 有效时间（秒）
     * @return boolean
     */
    public function set($name, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        $name = $this->options['prefix'] . $name;
        //对数组/对象数据进行缓存处理，保证数据完整性
        $value = (is_object($value) || is_array($value)) ? json_encode($value) : $value;

        try{
            if (is_int($expire) && $expire) {
                $result = $this->handler->setex($name, $expire, $value);
            } else {
                var_dump($name);exit;

                $result = $this->handler->set($name, $value);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function delete($name)
    {
        return $this->handler->delete($this->options['prefix'] . $name);
    }

    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function flush()
    {
        return $this->handler->flushDB();
    }


}