<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-23
 * Time: 下午9:27
 */
namespace Admin\Jutuan\Form;
use System\Library\Form\Form;

class sellerEditCacheForm extends \System\Library\Form\Form
{

    public function start($formName)
    {
        $array = array(
            "class" => "form-horizontal",
            "role" => "form",
        );
        $this->init($formName, '/index.php?m=admin&c=jutuan&a=sellerEditCacheSave', '', $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "SELLER_ID",
        );
        $this->setText("SELLER_ID","",$array,array(),"hidden");


        $array = array(
            "class" => "form-control",
            "placeholder" => "SELLER_NAME",
        );
        $this->setText("SELLER_NAME", "商户名", $array, array('datatype' => '*1-100',));



        $array = array(
            "class" => "form-control ",
            "placeholder" => "AGENT_ID",
        );
        $this->setText("AGENT_ID", "代理商编号", $array, array('datatype' => 'n1-38',));


        $array = array(
            "class" => "form-control",
            "placeholder" => "PROVINCE_ID",
        );
        $this->setText("PROVINCE_ID", "", $array, array('datatype' => 's2-24',),"hidden");

        $array = array(
            "class" => "form-control",
            "placeholder" => "CITY_ID",
        );
        $this->setText("CITY_ID", "", $array, array('datatype' => 's2-24',),"hidden");

        $array = array(
            "class" => "form-control",
            "placeholder" => "COUNTY_ID",
        );
        $this->setText("COUNTY_ID", "", $array, array('datatype' => 's2-24'),"hidden");

        $array = array(
            "class" => "form-control",
            "placeholder" => "DISTRICT_ID",
        );
        $this->setText("DISTRICT_ID", "商圈", $array);

        $array = array(
            "class" => "form-control",
            "placeholder" => "ADDR_DETAIL",
        );
        $this->setText("ADDR_DETAIL", "详细地址", $array, array('datatype' => 's2-300',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "TELEPHONE",
        );
        $this->setText("TELEPHONE", "联系电话（手机）", $array);


        $array = array(
            "class" => "form-control",
            "placeholder" => "LINK_MAN",
        );
        $this->setText("LINK_MAN", "联系人", $array);


        $array = array(
            "class" => "form-control",
            "placeholder" => "LONGITUDE",
            "readonly" => "readonly",
        );
        $this->setText("LONGITUDE", "经度", $array, array('datatype' => '*1-126',));

        $array = array(
            "class" => "form-control",
            "placeholder" => "LATITUDE",
            "readonly" => "readonly",
        );
        $this->setText("LATITUDE", "纬度", $array, array('datatype' => '*1-126',));


    }


}