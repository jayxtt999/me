<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/5 0005
 * Time: ���� 12:09
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
            $form->bind($newData);                                  //��Row
            $form->start('config');                      //��ʼ��Ⱦ
            $this->getView()->assign(array('form'=>$form));
            return $this->getView()->display();
        }



} 