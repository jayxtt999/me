<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:41
 */

namespace Admin\Model;


class hookModel  extends \System\Core\Model{


    /**
     * 生成钩子=》插件序列
     */
    public static   function getPlugs(){

        $_hooks = db()->table("hook")->getAll(array('status'=>\Admin\Hoke\Type\Status::STATUS_ENABLE))->done();
        foreach($_hooks as $v){

            if($v['plugs']){
                $hook[$v['name']] = explode(",",$v['plugs']);
            }else{
                $hook[$v['name']] = null;
            }
        }
        return $hook;

    }

    /**
     * 更新插件里的所有钩子对应的插件
     */
    public function updateHooks($plug_name){

        $plug_class = getPlugClass($plug_name);//获取插件名
        if(!class_exists($plug_class)){
            JsonObject(array('status'=>false,'msg'=>"未实现".$plug_name."插件的入口文件"));
        }
        $methods = get_class_methods($plug_class);
        $_hooks = db()->table("hook")->getAll(array('status'=>\Admin\Hoke\Type\Status::STATUS_ENABLE,'type'=>\Admin\Hoke\Type\Type::TYPE_DIY))->fields('name')->done();
        $hooks = array();
        foreach($_hooks as $v){
            $hooks[] = $v['name'];
        }
        $common = array_intersect($hooks, $methods);
        if(!empty($common)){
            foreach ($common as $hook) {
                $flag = $this->updateplugs($hook, array($plug_name));
                if(false === $flag){
                    $this->removeHooks($plug_name);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 更新单个钩子处的插件
     */
    public function updatePlugs($hook_name, $plugs_name){

        $o_plugs = db()->table("hook")->getRow(array("name"=>$hook_name))->fields('plugs')->done();
        $o_plugs = $o_plugs['plugs'];
        if($o_plugs)
            $o_plugs = str2arr($o_plugs);
        if($o_plugs){
            $plugs = array_merge($o_plugs, $plugs_name);
            $plugs = array_unique($plugs);
        }else{
            $plugs = $plugs_name;
        }
        $flag = db()->table("hook")->upDate(array('plugs'=>arr2str($plugs)),array('name'=>$hook_name))->done();
        if(false === $flag){
            db()->table("hook")->upDate(array('plugs'=>arr2str($o_plugs)),array('name'=>$hook_name))->done();
        }
        return $flag;
    }

    /**
     * 去除插件所有钩子里对应的插件数据
     */
    public function removeHooks($plug_name){
        $plug_class = getPlugClass($plug_name);
        if(!class_exists($plug_class)){
            return false;
        }
        $methods = get_class_methods($plug_class);
        $_hooks = db()->table("hook")->getAll()->fields('name')->done();
        $hooks = array();
        foreach($_hooks as $v){
            $hooks[] = $v['name'];
        }

        $common = array_intersect($hooks, $methods);
        if($common){
            foreach ($common as $hook) {
                $flag = $this->removePlugs($hook,$plug_name);
                if(false === $flag){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 去除单个钩子里对应的插件数据
     */
    public function removePlugs($hook_name, $plug_name){

        $o_plugs = db()->table("hook")->getRow(array("name"=>$hook_name))->fields('plugs')->done();
        $o_plugs = str2arr($o_plugs);
        if($o_plugs){
            $plugs = array_diff($o_plugs, $plug_name);
        }else{
            return true;
        }
        $flag = db()->table("hook")->upDate(array('plugs'=>arr2str($plugs)),array('name'=>$hook_name))->done();

        if(false === $flag){
            db()->table("hook")->upDate(array('plugs'=>arr2str($o_plugs)),array('name'=>$hook_name))->done();
        }
        return $flag;
    }






} 