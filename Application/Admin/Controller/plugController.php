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

        $name = post("val","txt");
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
            $info['name'] = strtolower($info['name']);
            $info['config'] = $config;
            $info['crate_time'] = date("Y-m-d H:i:s");
            db()->table('plugs')->insert($info)->done();
            //exit;
            $hookModel = new \Admin\Model\hookModel();
            $r = $hookModel->updateHooks($name);
            if($r){
                JsonObject(array('status'=>true,'msg'=>"安装成功"));
            }else{
                JsonObject(array('status'=>false,'msg'=>"安装失败"));
            }
            //更新钩子信息


        }catch (\Exception $e){
            db()->rollBack();
        }




    }


    public function unableAction(){

        $id = post("val","int");
        $row = db()->table("plugs")->getRow(array('id'=>$id))->done();
        if(!$row){
            JsonObject(array('status'=>false,'msg'=>"禁用失败,插件不存在"));
        }
        if($row['status'] == \Admin\Plug\Type\Status::STATUS_UNABLE){
            JsonObject(array('status'=>true,'msg'=>"已禁用"));
        }
        $r = db()->table("plugs")->upDate(array('status'=>\Admin\Plug\Type\Status::STATUS_UNABLE),array('id'=>$id))->done();
        JsonObject(array('status'=>true,'msg'=>"已禁用"));
    }

    public function enableAction(){

        $id = post("val","int");
        $row = db()->table("plugs")->getRow(array('id'=>$id))->done();
        if(!$row){
            JsonObject(array('status'=>false,'msg'=>"开启失败,插件不存在"));
        }
        if($row['status'] == \Admin\Plug\Type\Status::STATUS_ENABLE){
            JsonObject(array('status'=>true,'msg'=>"已开启"));
        }
        $r = db()->table("plugs")->upDate(array('status'=>\Admin\Plug\Type\Status::STATUS_ENABLE),array('id'=>$id))->done();
        JsonObject(array('status'=>true,'msg'=>"已开启"));
    }


    public function settingAction(){
        $id = get("id","int");
        if(!$id){
            return $this->link()->error("参数错误");
        }
        $plug = db()->table("plugs")->getRow(array('id'=>$id))->done();
        if(!$plug){
            return $this->link()->error("插件未安装");
        }
        $plugClass = getPlugClass($plug['name']);
        if(!class_exists($plugClass)){
            trace("插件{$plug['name']}无法实例化,",'ADDONS','ERR');
        }
        $data  =   new $plugClass;
        $dbConfig = $plug['config'];
        $plug['config'] = include $data->config_file;
        if($dbConfig){
            $dbConfig = json_decode($dbConfig, true);
            foreach ($plug['config'] as $key => $value) {
                if($value['type'] != 'group'){
                    $plug['config'][$key]['value'] = $dbConfig[$key];
                }else{
                    foreach ($value['options'] as $gourp => $options) {
                        foreach ($options['options'] as $gkey => $value) {
                            $plug['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $dbConfig[$gkey];
                        }
                    }
                }
            }
        }
        $this->getView()->assign(array('data'=>$plug,'id'=>$id));
        $this->getView()->display();
    }

} 