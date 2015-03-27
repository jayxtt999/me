<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午3:06
 */

namespace Common\Controller;


class getCommentVerController
{
    private $type = "buildImageVerify"; // buildImageVerify or GBVerify 位图/中文

    /**
     * @return array|string
     */
    public function indexAction()
    {
        $id = get("id","int");
        $fun =  $this->type;
        $CheckVerifyCode = new \Common\Security\CommentVerSession($id);
        return \System\Library\VerifyCode\Image::$fun(4,1,'png',95,32,$CheckVerifyCode,true);
    }
} 