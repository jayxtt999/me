<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;
use System\Core\Error;
use System\Library\Form\checkForm as checkForm;


class infoController extends abstractController
{


    public function saveAction(){


        $data = $this->request()->getData();
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->start('info');
        $data = checkForm::init($data, $memberForm->_name);
        $member = $this->getMember();
        //生成头像
        try{
            db()->upDate($data,array('id'=>$member['id']))->done();
            return $this->link()->success("admin:user:profile", "保存成功");
        }catch (\Exception $e){
            Error::halt($e->getMessage());exit;
        }


    }

}


/*<?php

$targ_w = $targ_h = 150;
$jpeg_quality = 90;

$src = 'demo_files/flowers.jpg';
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
    $targ_w,$targ_h,$_POST['w'],$_POST['h']);

header('Content-type: image/jpeg');
imagejpeg($dst_r, null, $jpeg_quality);

*/?>