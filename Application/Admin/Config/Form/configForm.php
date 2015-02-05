<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Config\Form;

use System\Library\Form\Form;

class configForm extends \System\Library\Form\Form
{
    /**
     * @param $formName
     * @param string $attribute
     */
    public function start($formName)
    {

        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=admin&c=menu&a=save', '', $array);


        $array = array(
            "class" => "form-control",
        );
        $this->setText("blogname", "站点标题", $array, array('datatype' => '*2-24',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("bloginfo", "站点副标题", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("blogurl", "站点地址", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("index_lognum", "每页显示日志数", $array, array('datatype' => 'd0-5',));



        $array = array(
            "class" => "form-control",
        );
        $this->setText("timezone", "你所在时区", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("login_code", "登陆验证码", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_title", "站点浏览器标题", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_key", "站点关键字", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_description", "站点浏览器描述", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("istwitter", "开启碎语", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("index_twnum", "每页显示碎语", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("istreply", "开启碎语回复", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("iscomment", "开启评论", $array, array('datatype' => 'd0-5',));




        $array = array(
            "class" => "form-control",
        );
        $this->setText("ischkcomment", "评论审核", $array, array('datatype' => 'd0-5',));



        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_code", "评论验证码", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("isgravatar", "评论人头像", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_needchinese", "评论必须有中文", $array, array('datatype' => 'd0-5',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_interval", "评论间隔时间", $array, array('datatype' => 'd0-5',));



        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_paging", "评论分页", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_pnum", "评论每页显示条数", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_order", "评论排序规则", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("icp", "ICP", $array, array('datatype' => 'd0-5',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("footer_info", "底部信息", $array, array('datatype' => 'd0-5',));



    }


}