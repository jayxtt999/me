<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Content\Plugins\SocialComment;
use \Admin\Plug\Plugin as Plugin;
//\Content\Plugins\SocialComment\SocialCommentPlugin
/**
 * 通用社交化评论插件
 * @author thinkphp
 */
    class SocialCommentPlugin extends Plugin{

        public $info = array(
            'name'=>'SocialComment',
            'title'=>'通用社交化评论',
            'description'=>'集成了各种社交化评论插件，轻松集成到系统中。',
            'status'=>1,
            'author'=>'thinkphp',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的pageFooter钩子方法
        public function documentDetailAfter($param){

            $this->assign(array('plugs_config'=>$this->getConfig()));
            $this->display('comment');

        }
    }