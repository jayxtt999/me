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
        $this->init($formName, '/index.php?m=admin&c=config&a=save', '', $array);


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
        $this->setText("index_lognum", "每页显示日志数", $array, array('datatype' => 'n1-5'),false,3,3);


        $array = array(
            "class" => "form-control",
        );

        $timeZone = new \System\Library\timeZone();
        $data = $timeZone->getTimeZoneList();
        $this->setSelect("timezone","你所在时区",$array,$data);

        $array = array(
            "class" => "make-switch",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("login_code","登陆验证码", $array);


        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_title", "站点浏览器标题", $array, array('datatype' => '*0-128',));


        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_key", "站点关键字", $array, array('datatype' => '*0-128',));

        $array = array(
            "class" => "form-control",
        );
        $this->setText("site_description", "站点浏览器描述", $array, array('datatype' => '*0-128',));


        $array = array(
            "class" => "make-switch",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("istwitter", "开启碎语", $array);

        $array = array(
            "class" => "form-control",
        );
        $this->setText("index_twnum", "每页显示碎语", $array, array('datatype' => 'n0-5',),false,3,3);

        $array = array(
            "class" => "make-switch",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("istreply", "开启碎语回复", $array);

        $this->setBsCheckBox("iscomment", "开启评论", $array);

        $this->setBsCheckBox("ischkcomment", "评论审核", $array);

        $this->setBsCheckBox("comment_code", "评论验证码", $array);

        $this->setBsCheckBox("isgravatar", "评论人头像", $array);

        $this->setBsCheckBox("comment_needchinese", "评论必须有中文", $array);

        $this->setBsCheckBox("comment_paging", "评论分页", $array);


        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_interval", "评论间隔时间", $array, array('datatype' => 'n0-5'),false,3,3);

        $array = array(
            "class" => "form-control",
        );
        $this->setText("comment_pnum", "评论每页显示条数", $array, array('datatype' => 'n0-5'),false,3,3);


        $array = array(
            "class" => "form-control",
        );
        $this->setSelect("comment_order", "评论排序规则", $array,array("desc"=>"降序","asc"=>"升序"),3);


        $array = array(
            "class" => "form-control",
        );
        $this->setText("icp", "ICP", $array, array('datatype' => '*0-64',));


        $array = array(
            "class" => "form-control",
            "style" => "height:200px"
        );
        $this->setTextArea("footer_info", "底部信息", $array, array('datatype' => '*0-512'));



    }


}