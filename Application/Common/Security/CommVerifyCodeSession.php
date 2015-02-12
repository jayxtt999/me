<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午2:20
 */

namespace Common\Security;


class CommVerifyCodeSession {

    private $smsVerifyCode = null;

    public function __construct()
    {

        $this->smsVerifyCode = new \Zend\Authentication\Storage\Session('Commerce_Controller_Goods');
    }

    /**
     * 设置商品评论验证码session
     * @param $smsCode
     */
    public function setSession($commCode){
        $this->smsVerifyCode->write($commCode);
    }


    /**
     * 读取商品评论验证码session
     */
    public function getSession(){
        return  $this->smsVerifyCode->read();
    }


    /**
     * 清除商品评论验证码session
     */
    public function clearSession()
    {
        $this->smsVerifyCode->clear();
    }



} 