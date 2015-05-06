<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;


class plugController extends abstractController{

    public function indexAction(){

        /*$plugModel   = new \Admin\Model\plugModel();
        $plugModel->getPlugins();*/
        $plugNewAll = array();
        $plugModel   = new \Admin\Model\plugModel();
        $plugLocAll = $plugModel->getPlugins();
        $plugDb = db()->table('plugs')->getAll()->done();

        foreach($plugDb as $k=>$v){
            $plugAll[$v['name']] = $v;
            $plugAll[$v['name']]['isInstall'] = true;
        }


        $arr = array_diff_assoc($plugLocAll,$plugAll);

        if($arr){
            $plugAll = array_merge($plugAll,$arr);
        }
        $config = new \Admin\Model\webConfigModel();
        $data = array(
            'plugAll'=>$plugAll,
            'plugHooKConfig'=>C("plugs_hook"),
        );

        $this->getView()->assign($data);
        return $this->getView()->display();



    }

} 