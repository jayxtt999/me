<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/12 0012
 * Time: 上午 11:06
 */

namespace Member\Open;

class Type extends \System\Library\statusGateway
{
    /**
     * 新浪微博接口
     */
    const TYPE_WEIBO = 1;
    /**
     * qq接口
     */
    const TYPE_QQ = 2;
    /**
     * 百度接口
     */
    const TYPE_BAIDU = 3;

    /**
     * 人人开放平台接口
     */
    const TYPE_RENREN = 4;


    protected function init()
    {
        $this->set(self::TYPE_WEIBO, 'weibo', '新浪微博');
        $this->set(self::TYPE_QQ, 'qq', '腾讯QQ');
        $this->set(self::TYPE_BAIDU, 'baidu', '百度');
        $this->set(self::TYPE_RENREN, 'renren', '人人网');
    }


}


