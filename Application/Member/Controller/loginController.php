<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;

use Member\Info\Table\Status;
use System\Library\Form\checkForm as checkForm;

class loginController extends abstractController
{


    public function indexAction()
    {

        if(C('USER_AUTH_KEY') && C('ADMIN_AUTH_KEY')){
            return $this->link()->success("admin:index:index","跳转中");
        }
        $redirect = $this->getRequest()->getRedirect();
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
            $authInfo = \System\Library\RBAC::authenticate($username);

            if (empty($authInfo)) {
                return $this->link()->error("账号不存在或者被禁用");
            } else {
                if ($authInfo['password'] != (string)(new \Member\Login\Table\Password($password))) {
                    cache("loginErrorTodayCount" . $username . $ip . date("Y-m-d"),++$loginErrorTodayCount);
                    return $this->link()->error("账号密码错误!");
                } else {
                    $this->LoginGmc($authInfo);
                    $url = $redirect?$redirect:"admin:index:index";
                    return $this->link()->success($url,"登陆成功");
                }
            }
        }
        return $this->getView()->display();
    }

    /**
     * 认证用户登录成功通用操作（本地 && 第三方）
     * @param $manager
     * @param $row
     */
    public function LoginGmc($row){
        if($row['status'] !=  \Member\Info\Table\Status::STATUS_ENABLE){
            return $this->link()->error("该账号不可用 , 登录失败!");
        }
        session(C('USER_AUTH_KEY'), $row['id']);
        if($row['username']=='admin'){
            session(C('ADMIN_AUTH_KEY'),true);
        }
        //存储用户信息cookie
        $user['id']=  $row['id'];
        $user['login_name']=  $row['username'];
        $value=serialize($user);
        $md5str=md5($value . \Member\Login\Table\Password::KEY);
        setcookie('rememberLoginUser', $md5str . $value ,time()+60*60*24*30*3,'/'  );

        //登陆日志
        $ip = $this->getRequest()->getIP();
        $data = array(
            'ip'=>$ip,
            'create_time'=>date("Y-m-d H:i:s"),
            'member_id'=>$user['id'],
        );
        db()->table("member_login_log")->insert($data)->done();
    }


}