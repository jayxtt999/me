<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-28
 * Time: 下午10:40
 */

namespace System\Library\Cache;


interface cacheFactory {

    public function set($key, $value,$path,$model);

    public function get($key,$path,$model);

    public function delete($key,$path,$model);

    public function has($key,$path,$model);

    public function flush();
} 