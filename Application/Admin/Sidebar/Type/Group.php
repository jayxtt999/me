<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/27 0027
 * Time: ���� 10:03
 */

namespace Admin\Sidebar\Type;

class Group extends \System\Library\statusGateway{

    const SIDEBAR_SYSTEM = 'system';
    const SIDEBAR_DIY = 'diy';

    public function init()
    {
        $this->set(self::SIDEBAR_SYSTEM, 'system', 'ϵͳ');
        $this->set(self::SIDEBAR_DIY, 'diy', '�Զ���');
    }

} 