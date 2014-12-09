<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

class menuController extends abstractController{

    public function indexAction(){
        $model = $this->loadModel();
        $menuAll = $model->getMenuAll();//获取全部栏目
        // 重置序列
        foreach ($menuAll as $key=>$value){
            $sort[$key] = $value['sort'];
        }
        array_multisort($sort,SORT_NUMERIC,SORT_DESC,$menuAll);
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