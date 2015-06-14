<?php
    /*
     *@plugin 示例插件
     *@author 无名氏
     */
    namespace Content\Plugins\testPlug;
    use \Admin\Plug\Plugin as Plugin;
    class testPlugPlugin extends Plugin{

         public $info = array(
            'name'=>'testPlug',
            'title'=>'testPlug',
            'description'=>'',
            'status'=>0,
            'author'=>'naix',
            'version'=>'1.0'

        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }
        //实现的navbar钩子方法
        public function navbar($param)
        {

        }
        //实现的appBegin钩子方法
        public function appBegin($param)
        {

        }

        public $adminList = array(
            'model'=>'Example',//要查的表
            'fields'=>'*',//要查的字段
            'map'=>'',//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
            'order'=>'id desc',//排序,
            'listKey'=>array(//这里定义的是除了id序号外的表格里字段显示的表头名
                '字段名'=>'表头显示名'
            ),
        );
    }