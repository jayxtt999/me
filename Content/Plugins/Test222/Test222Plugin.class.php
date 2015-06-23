<?php
namespace Content\Plugins\Test222;
use \Admin\Plug\Plugin as Plugin;

class test222Plugin extends Plugin{

    public $info = array(
        'name'=>'test222',
        'title'=>'插件测试222',
        'description'=>'插件测试222',
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


    }

}




