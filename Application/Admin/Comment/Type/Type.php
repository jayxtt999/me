<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3 0003
 * Time: ���� 10:35
 */
namespace Admin\Comment\Type;
class Type extends \System\Library\statusGateway
{
    const TYPE_ARTICLE = 1;
    const STATUS_TWIITER = 2;

    public function init()
    {
        $this->set(self::TYPE_ARTICLE, 'article', '文章');
        $this->set(self::STATUS_TWIITER, 'twiiter', '说说');
    }

}