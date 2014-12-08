<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class menuController extends abstractController{

    public function indexAction(){
        $M = $this->loadModel();//载入模型
        $menuAll = $M->getMenuAll();//获取全部栏目
        $this->View()->assign(array('menuAll'=>$menuAll));
        $this->View()->display();
    }


    public function addMenuAction(){



    }

    public function editMenuAction(){



    }

    public function deleteAction(){



    }



}