<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;
use System\Library\Form\checkForm as checkForm;


class infoController extends abstractController
{


    public function saveAction(){


        $data = $this->request()->getData();
        $memberForm = new \Member\Login\Form\infoForm();
        $memberForm->start('info');
        $coordinates = $data['coordinates'];
        unset($data['coordinates']);
        $data = checkForm::init($data, $memberForm->_name);
        $member = $this->getMember();

        //生成头像
        $zb = explode(",",$coordinates);
        $targ_w = $targ_h = 100;

        $targetFolder = 'Data/upload/image/avatar'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] .$targetFolder;
        $targetDir = rtrim($targetPath, '/') . '/' . $member['id'];
        $targetFile = $targetDir . '/'."yt_".$data['avatar'];
        $img_r = imagecreatefromjpeg($targetFile);
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
        echo $targetFile;exit;
        imagecopyresampled($dst_r,$img_r,0,0,$zb[0],$zb[1],
            $targ_w,$targ_h,$zb[2],$zb[3]);




        db()->upDate($data,array('id'=>$member['id']))->done();

        var_dump($data);exit;





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