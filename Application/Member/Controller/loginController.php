<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;
use System\Library\Form\checkForm as checkForm;

class loginController extends abstractController{


    public function indexAction(){

        $redirect = $this->getRequest()->getRedirect();
        $view = $this->getView();

        if($this->getRequest()->getMethod()=="POST"){
            //是否为post方式提交
            $username = post("username","string");
            $password = post("password","string");

            $form = new \Member\Login\Form\loginForm();
            $form->start('login-form');

            $data =array(
                'username'=>$username,
                'password'=>$password,
            );
            //验证表单
            $data = checkForm::init($data,$form->_name);
            if(!$data){
                return false;
            }
            //验证错误次数 大于5次当日禁止登陆
            $ip = $this->getRequest()->getIP();
            $loginErrorTodayCount = (int)cache("loginErrorTodayCount".$username.$ip.date("Y-m-d"));
            if($loginErrorTodayCount>=5){
                $view->assign(array("msg"=>"登录失败,您今天超过5次登陆失败，为了账号安全，我们限制账号当天登陆"));
                $view->display();
            }
            if($loginErrorTodayCount>=2){
                $view->assign(array("msg"=>"登录失败,您今天超过5次登陆失败，为了账号安全，我们限制账号当天登陆"));
                $view->display();
            }

            $errorLoginCount

            var_dump($data);exit;



        }
        $view->display();

    }



}