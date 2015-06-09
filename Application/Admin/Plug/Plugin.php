<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/6 0006
 * Time: 下午 3:21
 */
namespace Admin\Plug;
use \System\Core\Controller as Controller;
abstract class Plugin {

    public $plug_path          =   '';
    public $config_file         =   '';

    public function __construct(){
        $this->plug_path   =   PLUGIN_PATH.$this->getName().'/';
        if(is_file($this->plug_path.'config.php')){
            $this->config_file = $this->plug_path.'config.php';
        }
    }


    final public function getName(){
        $class = get_class($this);
        return substr($class,strrpos($class, '\\')+1, -6);
    }

    final public function checkInfo(){
        $info_check_keys = array('name','title','description','status','author','version');
        foreach ($info_check_keys as $value) {
            if(!array_key_exists($value, $this->info))
                return FALSE;
        }
        return TRUE;
    }

    /**
     * 获取插件的配置数组
     */
    final public function getConfig($name=''){

        static $_config = array();
        if(empty($name)){
            $name = $this->getName();
        }
        if(isset($_config[$name])){
            return $_config[$name];
        }

        $config =   array();
        $where['name']    =   $name;
        $where['status']  =   1;

        $config  =   db()->table('plugs')->getRow($where)->fields('config')->done();
        if($config){
            $config   =   json_decode($config, true);
        }else{

            $temp_arr = include $this->config_file;
            if(!$temp_arr){
                $config = array();
            }else{
                foreach ($temp_arr as $key => $value) {
                    if($value['type'] == 'group'){

                        foreach ($value['options'] as $gkey => $gvalue) {
                            foreach ($gvalue['options'] as $ikey => $ivalue) {
                                $config[$ikey] = $ivalue['value'];
                            }
                        }
                    }else{
                        $config[$key] = $temp_arr[$key]['value'];
                    }
                }
            }
        }
        $_config[$name]     =   $config;
        return $config;
    }


    final public function plugAssign($array){

        $c= new Controller();
        $c->getView()->assign($array);
    }

    final public function plugShow($tpl){

        $templateFileName = $tpl?$this->plug_path.$tpl.C('tpl_template_suffix'):$this->plug_path."index".C('tpl_template_suffix');
        if(!is_file($templateFileName)){
            throw new \Exception("模板不存在:$templateFileName");
        }
        echo  file_get_contents($templateFileName);;
    }

    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();

} 