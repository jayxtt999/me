<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Admin\Controller;


class indexController extends abstractController{

    public function indexAction(){

        //获取系统信息
        $system = array();
        //运行环境
        $system['software'] = $_SERVER['SERVER_SOFTWARE'];
        //php版本
        $system['php_version'] = PHP_VERSION;
        //mysql 版本
        $mysqlInfo = db()->sql("select version() as v;");
        $system['mysql_info'] = $mysqlInfo[0]['v'];

        //Gd处理库
        if (function_exists("imagecreate")) {
            if (function_exists('gd_info')) {
                $ver_info = gd_info();
                $system['gd_ver'] = $ver_info['GD Version'];
            } else{
                $system['gd_ver'] = '支持';
            }
        } else{
            $system['gd_ver'] = '不支持';
        }

        //服务器允许上传最大文件
        $system['uploadfile_maxsize'] = ini_get('upload_max_filesize');



        //获取说说数量
        $twitter = db()->table("twitter")->getAll()->done();
        $twitterNum = count($twitter)?count($twitter):"暂无记录";

        //获取文章数量
        $article = db()->table("article")->getAll()->done();
        $articleNum = count($article)?count($article):"暂无记录";

        //获取分类数量
        $category = db()->table("article_category")->getAll()->done();
        $categoryNum = count($category)?count($category):"暂无记录";

        //获取用户数量
        $member = db()->table("member_info")->getAll()->done();
        $memberNum = count($member)?count($member):"暂无记录";



        $this->getView()->assign(array("system"=>$system,"twitterNum"=>$twitterNum,"articleNum"=>$articleNum,"categoryNum"=>$categoryNum,"memberNum"=>$memberNum));
        return $this->getView()->display();
    }

    /**
     * phpinfo
     */
    public function phpinfoAction(){
        phpinfo();

    }


    public function testAction(){
        $r = db()->table("twitter")->upDate(array('replynum'=>"replynum+100"),array('id'=>10))->build()->done();
        var_dump($r);exit;
    }




}