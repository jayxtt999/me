<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/27 0027
 * Time: ���� 10:03
 */

namespace Admin\Sidebar\Type;

class Show extends \System\Library\statusGateway{

    const STATUS_ENABLE = 1;
    const STATUS_UNABLE = 0;

    public function init()
    {
        $this->set(self::STATUS_ENABLE, 'enable', '����');
        $this->set(self::STATUS_UNABLE, 'unable', '�ر�');
    }

} 