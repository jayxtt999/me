<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class menuController extends abstractController{

    public function indexAction(){




        //载入模型
        $M = $this->loadModel();
        $menuAll = $M->getMenuAll();
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