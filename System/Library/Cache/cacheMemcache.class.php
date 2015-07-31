<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 15:09
 */

namespace System\Library\Cache;


class cacheMemcache
{
    private $handler;
    private $options = array();

    /**
     * @param array $options
     */
    public function __construct($options=array()) {

        if ( !extension_loaded('memcache') ) {
            exception(('_nofund_').':memcache');
        }

        $options = array_merge(array (
            'host'        =>  C('cache:memcache:host') ? : '127.0.0.1',
            'port'        =>  C('cache:memcache:port') ? : 11211,
            'timeout'     =>  C('cache:memcache:timeout') ? : false,
            'persistent'  =>  false,
        ),$options);

        $this->options  =   $options;
        $this->options['expire'] =  isset($options['expire'])?  $options['expire']  :   C('cache:expire');
        $this->options['prefix'] =  isset($options['prefix'])?  $options['prefix']  :    C('cache:prefix');
        $func               =   $options['persistent'] ? 'pconnect' : 'connect';
        $this->handler      =   new \Memcache;
        $options['timeout'] === false ?
            $this->handler->$func($options['host'], $options['port']) :
            $this->handler->$func($options['host'], $options['port'], $options['timeout']);
    }

    /**
     * ��ȡ����
     * @access public
     * @param string $name ���������
     * @return mixed
     */
    public function get($name) {
        return $this->handler->get($this->options['prefix'].$name);
    }

    /**
     * д�뻺��
     * @access public
     * @param string $name ���������
     * @param mixed $value  �洢����
     * @param integer $expire  ��Чʱ�䣨�룩
     * @return boolean
     */
    public function set($name, $value, $expire = null) {
        if(is_null($expire)) {
            $expire  =  $this->options['expire'];
        }
        $name   =   $this->options['prefix'].$name;
        if($this->handler->set($name, $value, 0, $expire)) {
            return true;
        }
        return false;
    }

    /**
     * ɾ������
     * @access public
     * @param string $name ���������
     * @return boolean
     */
    public function delete($name, $ttl = false) {
        $name   =   $this->options['prefix'].$name;
        return $ttl === false ?
            $this->handler->delete($name) :
            $this->handler->delete($name, $ttl);
    }

    /**
     * �������
     * @access public
     * @return boolean
     */
    public function flush() {
        return $this->handler->flush();
    }



}