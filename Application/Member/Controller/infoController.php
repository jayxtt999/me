<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;

use System\Core\Error;
use System\Library\Form\checkForm as checkForm;


class infoController extends abstractController
{

    /**
     * 保存用户信息
     */
    public function saveAction()
    {

        $data = $this->request()->getData();
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->start('info');
        $data = checkForm::init($data, $memberForm->_name);
        $member = $this->getMember();
        //生成头像
        try {
            db()->upDate($data, array('id' => $member['id']))->done();
            return $this->link()->success("admin:user:profile", "保存成功");
        } catch (\Exception $e) {
            Error::halt($e->getMessage());
            exit;
        }


    }

    /**
     * 更新密码
     */
    public function passwordAction()
    {

        $oldPassword = post("oldPassword", "txt");
        $password = post("password", "txt");
        $password2 = post("password2", "txt");
        if ($password !== $password2) {
            return $this->link()->error("二次密码不一致");
        }
        //验证当前密码
        $member = $this->getMember();
        if ($member['password'] != (string)(new \Member\Login\Table\Password($oldPassword))) {
            return $this->link()->error("密码错误");
        }
        //验证是否与原密码一致
        if ($member['password'] == (string)(new \Member\Login\Table\Password($password))) {
            return $this->link()->error("修改失败");
        }

        //Todo  防暴力破解 设置错误次数加验证码
        $newPassword = (string)(new \Member\Login\Table\Password($password));
        $r = db()->table("member")->update(array("password" => $newPassword), array("id" => $member['id']));
        if ($r) {
            //Todo 退出登录
            return $this->link()->success("admin:user:profile", "更新成功");
        } else {
            return $this->link()->error("admin:user:profile", "更新失败");
        }


    }

}


