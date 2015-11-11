<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Jutuan\Form;
use System\Library\Form\Form;

class sellerEditForm extends \System\Library\Form\Form
{

    public function start($formName)
    {
        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=admin&c=jutuan&a=sellerEditSave', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "SELLER_NAME",
        );
        $this->setText("SELLER_NAME", "商户名", $array, array('datatype' => '*2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "SELLER_ID",
        );
        $this->setText("SELLER_ID","",$array,array(),"hidden");


        $array = array(
            "class" => "form-control ",
            "placeholder" => "AGENT_ID",
        );
        $this->setText("AGENT_ID", "代理商编号", $array, array('datatype' => 's2-24',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "PROVINCE_ID",
        );
        $this->setText("PROVINCE_ID", "省", $array, array('datatype' => 's2-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "CITY_ID",
        );
        $this->setText("CITY_ID", "市", $array, array('datatype' => 's2-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "COUNTY_ID",
        );
        $this->setText("COUNTY_ID", "区县", $array, array('datatype' => '/^\\s*$/|*1-126|url',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "DISTRICT_ID",
        );
        $this->setText("DISTRICT_ID", "商圈", $array, array('datatype' => 'n1-4',));

        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_DISPLAY",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("is_display","是否显示", $array);


        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_ADMIN",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("is_admin","是否只能管理员查看", $array);


        $array = array(
            "class" => "make-switch",
            "placeholder" => "IS_NAV",
            "data-on-color"=>"primary",
            "data-off-color"=>"info",
        );
        $this->setBsCheckBox("is_nav","是否为导航", $array);



        $array = array(
            "class" => "form-control",
            "placeholder" => "ICON",
        );
        $this->setText("icon", "图标", $array, array('datatype' => '/^\\s*$/|*1-24',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "DESC",
        );
        $this->setText("desc", "栏目描述", $array, array('datatype' => 's1-126',));

    }


}