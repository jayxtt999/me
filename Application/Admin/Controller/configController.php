<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/5 0005
 * Time: 下午 12:09
 */

namespace Admin\Controller;


class configController extends abstractController{


        public function indexAction(){

            $all = $this->db()->Table('config')->getAll()->done();        //getAll
            $newData = array();
            foreach($all as $v){

                $newData[$v['option_name']] = $v['option_value'];

            }

            $form = new \Admin\Config\Form\configForm();
            $form->bind($newData);                                  //绑定Row
            $form->start('config');                      //开始渲染
            $this->getView()->assign(array('form'=>$form));
            return $this->getView()->display();
        }



} 