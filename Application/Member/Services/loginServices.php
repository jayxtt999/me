<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/28
 * Time: 17:55
 */
class loginServices
{


    public function LoginGmc($row){
        if($row['status'] !=  \Member\Info\Table\Status::STATUS_ENABLE){
            return $this->link()->error("���˺Ų����� , ��¼ʧ��!");
        }
        session(C('USER_AUTH_KEY'), $row['id']);
        if($row['username']=='admin'){
            session(C('ADMIN_AUTH_KEY'),true);
        }
        //�洢�û���Ϣcookie
        $user['id']=  $row['id'];
        $user['login_name']=  $row['username'];
        $value=serialize($user);
        $md5str=md5($value . \Member\Login\Table\Password::KEY);
        setcookie('rememberLoginUser', $md5str . $value ,time()+60*60*24*30*3,'/'  );

        //��½��־
        $ip = $this->getRequest()->getIP();
        $data = array(
            'ip'=>$ip,
            'create_time'=>date("Y-m-d H:i:s"),
            'member_id'=>$user['id'],
        );
        db()->table("member_login_log")->insert($data)->done();
    }
}