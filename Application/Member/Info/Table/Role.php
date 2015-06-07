<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/6 0006
 * Time: 上午 9:08
 */

namespace Member\Info\Table;

class Role extends \System\Library\statusGateway
{
    const LEVEL_ADMIN = 1;
    const LEVEL_GENERAL = 2;

    public function init()
    {
        $this->set(self::LEVEL_ADMIN, 'admin', '管理员');
        $this->set(self::LEVEL_GENERAL, 'general', '普通用户');
    }


}
