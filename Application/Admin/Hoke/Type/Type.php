<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: ���� 3:39
 */
namespace Admin\Hoke\Type;
class Type extends \System\Library\statusGateway{

    const TYPE_CONTROLLER = 1;
    const TYPE_VIEW = 2;

    public function init()
    {
        $this->set(self::TYPE_CONTROLLER, 'controller', '������');
        $this->set(self::TYPE_VIEW, 'view', '��ͼ');
    }

} 