<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: 下午 3:39
 */
namespace Admin\Hoke\Type;
class Type extends \System\Library\statusGateway{

    const TYPE_DIY = 1;
    const TYPE_ADMIN = 2;

    public function init()
    {
        $this->set(self::TYPE_DIY, 'diy', '自定义');
        $this->set(self::TYPE_ADMIN, 'admin', '系统');
    }

} 