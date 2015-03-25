<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-3
 * Time: 上午9:24
 */

namespace Common\Security;


class CommentVerSession {

    private $commentVer = null;

    public function __construct()
    {
        session('[start]');
        $this->commentVer = "Blog_Comment";
    }

    /**
     * 设置session
     * @param $smsCode
     */
    public function setSession($picCode){
        session($this->commentVer,$picCode);
    }


    /**
     * 读取session
     */
    public function getSession(){
        return  session($this->commentVer);
    }


    /**
     * 清除session
     */
    public function clearSession()
    {
        session($this->commentVer,null);
    }


} 