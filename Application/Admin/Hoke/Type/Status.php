<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: ���� 3:39
 */
namespace Admin\Hoke\Type;
class Status extends \System\Library\statusGateway{

    const STATUS_ENABLE = 1;
    const STATUS_UNABLE = 0;

    public function init()
    {
        $this->set(self::STATUS_ENABLE, 'enable', '����');
        $this->set(self::STATUS_UNABLE, 'unable', '����');
    }

} 