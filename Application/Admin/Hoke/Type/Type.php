<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: œ¬ŒÁ 3:39
 */
namespace Admin\Hoke\Type;
class Type extends \System\Library\statusGateway{

    const TYPE_CONTROLLER = 1;
    const TYPE_VIEW = 2;

    public function init()
    {
        $this->set(self::TYPE_CONTROLLER, 'controller', 'øÿ÷∆∆˜');
        $this->set(self::TYPE_VIEW, 'view', ' ”Õº');
    }

} 