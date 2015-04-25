<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/10 0010
 * Time: 上午 9:25
 */

namespace System\Library\Cache;

use System\Core\Cache;

class cacheFile extends Cache{

    private $options = array();

    /**
     * @param array $options
     */
    public function __construct($options=array()) {

        if(!empty($options)) {
            $this->options =  $options;
        }
        $this->options['path']      =   !empty($options['path'])?   $options['path']    :   C('cache:file:path');
        $this->options['suffix']    =   isset($options['suffix'])?  $options['suffix']  :   C('cache:file:suffix');
        $this->options['expire']    =   isset($options['expire'])?  $options['expire']  :   C('cache:file:expire');
        if(substr($this->options['path'], -1) != '/')    $this->options['temp'] .= '/';
        //检查目录是否存在
        if (!is_dir($this->options['path'])) {
            mkdir($this->options['path'],0777);
        }
    }


    /**
     * 增加一对缓存数据
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $filename = $this->_get_cache_file($key);
        //写文件, 文件锁避免出错
        file_put_contents($filename, "<?php exit;//".serialize($value), LOCK_EX);
        if(file_exists($filename)){
            return true;
        }else{
            return false;
        }
    }

    /**删除对应的一个缓存
     * @param $key
     */
    public function delete($key) {
        $filename = $this->_get_cache_file($key);
        unlink($filename);
    }

    /**
     * 获取缓存
     * @param $key
     * @return bool|mixed
     */
    public function get($key) {
        if ($this->_has_cache($key)) {
            $filename = $this->_get_cache_file($key);
            $value = file_get_contents($filename);
            if (empty($value)) {
                return false;
            }
            return unserialize(str_replace("<?php exit;//", '', $value));
        }else{
            $this->delete($key);
            return false;
        }
    }

    /**
     * 删除所有缓存
     */
    public function flush() {
        $fp = opendir($this->cache_path);
        while(!false == ($fn = readdir($fp))) {
            if($fn == '.' || $fn =='..') {
                continue;
            }
            unlink($this->cache_path . $fn);
        }
    }

    /**
     * 是否存在缓存
     * @param $key
     * @return bool
     */
    public function has($key){
        return $this->_has_cache($key);
    }

    /**
     * 是否存在缓存
     * @param $key
     * @return bool
     */
    private function _has_cache($key) {
        $filename = $this->_get_cache_file($key);
        if(file_exists($filename) && (filemtime($filename) + $this->options['expire'] >= time())) {
            return true;
        }
        return false;
    }


    /**
     * 验证cache key是否合法，可以自行增加规则
     * @param $key
     * @return bool
     */
    private function _is_valid_key($key) {
        if ($key != null) {
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return string
     */
    private function _safe_filename($key) {
        if ($this->_is_valid_key($key)) {
            return md5($key);
        }
        //key不合法的时候，均使用默认文件'unvalid_cache_key'，不使用抛出异常，简化使用，增强容错性
        return 'unvalid_cache_key';
    }

    /**
     * 拼接缓存路径
     * @param $key
     * @return string
     */
    private function _get_cache_file($key)
    {
        return $this->options['path'] . $this->_safe_filename($key) . $this->options['suffix'];
    }
}