<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;

use Member\Info\Table\Status;
use Member\Services\loginServices;
use System\Library\Form\checkForm as checkForm;


class loginController extends abstractController
{
    public function indexAction()
    {


        if(session(C('USER_AUTH_KEY')) && session(C('ADMIN_AUTH_KEY'))){
            return $this->link()->success("admin:index:index","跳转中");
        }


        $view = $this->getView();

        if ($this->getRequest()->getMethod() == "POST") {
            //是否为post方式提交
            $username = post("username", "string");
            $password = post("password", "string");

            $form = new \Member\Login\Form\loginForm();
            $form->start('login-form');

            $data = array(
                'username' => $username,
                'password' => $password,
            );
            //验证表单
            $data = checkForm::init($data, $form->_name);
            if (!$data) {
                return false;
            }

            $LoginVerifyCode = new \Common\Security\CheckLoginSession();
            $randVal = $LoginVerifyCode->getSession();
            //验证错误次数 大于5次当日禁止登陆
            $ip = $this->getRequest()->getIP();
            $loginErrorTodayCount = (int)cache("loginErrorTodayCount" . $username . $ip . date("Y-m-d"));
            //用于密码输入错误次数
            if ($loginErrorTodayCount >= 10) {
                return $this->link()->error("登录失败,您今天超过10次登陆失败，为了账号安全，我们限制账号当天登陆!");
            }
            //用于验证码
            $webConfig = new \Admin\Model\webConfigModel();
            $webConfig = $webConfig->getConfig();
            if ($webConfig['login_code']) {
                $checkCode = post("verifycode", "string");
                if (md5(strtoupper($checkCode)) !== $randVal) {
                    return $this->link()->error("登录失败, 请输入正确的验证码!");
                }
            }
            $authInfo = \System\Library\Rbac::authenticate($username);

            if (empty($authInfo)) {
                return $this->link()->error("账号不存在或者被禁用");
            } else {
                if ($authInfo['password'] != (string)(new \Member\Login\Table\Password($password))) {
                    cache("loginErrorTodayCount" . $username . $ip . date("Y-m-d"),++$loginErrorTodayCount);
                    return $this->link()->error("账号密码错误!");
                } else {

                    $server = $this->getServices();
                    $server->LoginGmc($authInfo);
                    $redirect = urldecode(get("referer","string"));
                    return $this->link()->dispatchJump($redirect,3,"登陆成功",true);
                }
            }
        }
        return $this->getView()->display();
    }


    /**
     * 第三方登录
     */
    public function OauthAction(){

        $type = get("type","string");
        echo $type;



    }


}