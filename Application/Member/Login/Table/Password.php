<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Login\Table;

class Password
{
    /**
     * 用户密码加密随机字符串
     * @var string
     */
    const KEY = 'dfasd$#das*/*-*(&("O12fDSFASDfgsd%$^%*@#sdgh';

    /**
     * 密码密文
     *
     * @var string
     */
    private $password = null;

    public function __construct($pw)
    {
        $this->setPassword($pw);
    }

    /**
     * 指定明文密码
     *
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = md5(md5(md5($password)) . self::KEY);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->password;
    }
} 