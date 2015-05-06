<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: ���� 3:39
 */
namespace Admin\Plug\Type;
class Status extends \System\Library\statusGateway{

    const STATUS_ENABLE = 1;
    const STATUS_UNABLE = 2;
    const STATUS_INSTALL = 3;
    const STATUS_UNINSTALL = 4;

    public function init()
    {
        $this->set(self::STATUS_ENABLE, 'enable', '����');
        $this->set(self::STATUS_UNABLE, 'unable', '����');
        $this->set(self::STATUS_INSTALL, 'install', '��װ');
        $this->set(self::STATUS_UNINSTALL, 'uninstall', 'ж��');
    }

} 