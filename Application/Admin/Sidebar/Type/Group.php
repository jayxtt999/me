<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/27 0027
 * Time: 上午 10:03
 */

namespace Admin\Sidebar\Type;

class Group extends \System\Library\statusGateway{

    const SIDEBAR_SYSTEM = 'system';
    const SIDEBAR_DIY = 'diy';

    public function init()
    {
        $this->set(self::SIDEBAR_SYSTEM, 'system', '系统');
        $this->set(self::SIDEBAR_DIY, 'diy', '自定义');
    }

} 