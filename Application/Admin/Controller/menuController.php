<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class menuController extends abstractController{

    private $model;

    function __construct(){
        parent::__construct();
        $this->model = $this->loadModel();
    }
    public function indexAction(){
        $menuAll = $this->model->getMenuAll();//获取全部栏目
        $this->View()->assign(array('menuAll'=>$menuAll));
        $this->View()->display();
    }


    public function addAction(){



    }

    public function editAction(){



        $this->View()->display();

    }

    public function delAction(){



    }



}