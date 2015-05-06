<?php
namespace Content\Plugins\Test;
use \Admin\Plug\Plugin as Plugin;

class testPlugin extends Plugin{

    public $info = array(
        'name'=>'test',
        'title'=>'插件测试',
        'description'=>'插件测试',
        'status'=>1,
        'author'=>'xietaotao',
        'version'=>'1.0'
    );

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }

    //实现的documentDetailAfter钩子方法
    public function documentDetailAfter($param){
        echo "??????";
    }

}




