<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3 0003
 * Time: ���� 10:35
 */
namespace Admin\Article\Type;
class Status extends \System\Library\statusGateway
{
    const STATUS_ENABLE = 1;
    const STATUS_UNABLE = 0;

    public function init()
    {
        $this->set(self::STATUS_ENABLE, 'enable', '启用');
        $this->set(self::STATUS_UNABLE, 'unable', '关闭');
    }

}