<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;


class plugController extends abstractController{

    public function indexAction(){

        /*$plugModel   = new \Admin\Model\plugModel();
        $plugModel->getPlugins();*/
        $plugNewAll = array();
        $plugModel   = new \Admin\Model\plugModel();
        $plugLocAll = $plugModel->getPlugins();
        $plugDb = db()->table('plugs')->getAll()->done();

        foreach($plugDb as $k=>$v){
            $plugAll[$v['name']] = $v;
            $plugAll[$v['name']]['isInstall'] = true;
        }


        $arr = array_diff_assoc($plugLocAll,$plugAll);

        if($arr){
            $plugAll = array_merge($plugAll,$arr);
        }
        $config = new \Admin\Model\webConfigModel();
        $data = array(
            'plugAll'=>$plugAll,
            'plugHooKConfig'=>C("plugs_hook"),
        );

        $this->getView()->assign($data);
        return $this->getView()->display();

    }


    public function installAction(){

        $name = post("name","txt");
        //检查插件是否存在
        $class  = getPlugClass($name);
        if(!class_exists($class)){
            JsonObject(array('status'=>false,'msg'=>'插件不存在'));
        }
        //检查插件是否完整
        $plug  =   new $class;
        $info = $plug->info;
        if(!$info || !$plug->checkInfo()){
            //检测信息的正确性
            JsonObject(array('status'=>false,'msg'=>'插件信息缺失'));
        }
        //预安装，有些插件需要操作数据库..
        $install_flag   =   $plug->install();
        if(!$install_flag){
            JsonObject(array('status'=>false,'msg'=>'插件预安装操作失败'));
        }
        //保存插件信息 && 更新钩子
        try{
            db()->beginTransaction();
            //获取插件配置信息
            $config  =  serialize(array('config'=>json_encode($plug->getConfig())));
            $info['config'] = $config;
            //db()->table('plugs')->insert($info)->done();
            //exit;
            $hookModel = new \Admin\Model\hookModel();
            $hookModel->updateHooks($name);

            //更新钩子信息


        }catch (\Exception $e){
            db()->rollBack();
        }




    }


} 