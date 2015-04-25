<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/10 0010
 * Time: ���� 9:25
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
        //���Ŀ¼�Ƿ����
        if (!is_dir($this->options['path'])) {
            mkdir($this->options['path'],0777);
        }
    }


    /**
     * ����һ�Ի�������
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $filename = $this->_get_cache_file($key);
        //д�ļ�, �ļ����������
        file_put_contents($filename, "<?php exit;//".serialize($value), LOCK_EX);
        if(file_exists($filename)){
            return true;
        }else{
            return false;
        }
    }

    /**ɾ����Ӧ��һ������
     * @param $key
     */
    public function delete($key) {
        $filename = $this->_get_cache_file($key);
        unlink($filename);
    }

    /**
     * ��ȡ����
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
     * ɾ�����л���
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
     * �Ƿ���ڻ���
     * @param $key
     * @return bool
     */
    public function has($key){
        return $this->_has_cache($key);
    }

    /**
     * �Ƿ���ڻ���
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
     * ��֤cache key�Ƿ�Ϸ��������������ӹ���
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
        //key���Ϸ���ʱ�򣬾�ʹ��Ĭ���ļ�'unvalid_cache_key'����ʹ���׳��쳣����ʹ�ã���ǿ�ݴ���
        return 'unvalid_cache_key';
    }

    /**
     * ƴ�ӻ���·��
     * @param $key
     * @return string
     */
    private function _get_cache_file($key)
    {
        return $this->options['path'] . $this->_safe_filename($key) . $this->options['suffix'];
    }
}