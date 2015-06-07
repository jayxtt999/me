<?php
namespace Content\Plugins\Headtest;
use \Admin\Plug\Plugin as Plugin;
class HeadtestPlugin extends Plugin{

    public $info = array(
        'name'=>'HeadTest',
        'title'=>'tempHead插件测试',
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
    public function tempHead($param){
        echo "I'am headPlugs ..." ;
    }

}




