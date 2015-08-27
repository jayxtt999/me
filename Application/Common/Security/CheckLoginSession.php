<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-3
 * Time: 上午9:24
 */

namespace Common\Security;


class CheckLoginSession {

    private $loginCheck = null;

    public function __construct()
    {
        $this->loginCheck = "Member_Login";
    }

    /**
     * 设置session
     * @param $smsCode
     */
    public function setSession($picCode){
        session($this->loginCheck,$picCode);
    }


    /**
     * 读取session
     */
    public function getSession(){
        return  session($this->loginCheck);
    }


    /**
     * 清除session
     */
    public function clearSession()
    {
        session($this->loginCheck,null);
    }


} 