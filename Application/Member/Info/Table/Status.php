<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/12 0012
 * Time: ���� 11:06
 */

namespace Member\Info\Table;

class Status extends \System\Library\statusGateway
{
    const STATUS_ENABLE = 1;
    const STATUS_UNABLE = 0;

    public function init()
    {
        $this->set(self::STATUS_ENABLE, 'enable', '����');
        $this->set(self::STATUS_UNABLE, 'unable', '����');
    }


}
