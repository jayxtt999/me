<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;
use System\Library\Form\checkForm as checkForm;


class hookController extends abstractController{

    public function indexAction()
    {

        $hookAll = db()->table("hook")->getAll()->done();
        $this->getView()->assign(array("hookAll"=>$hookAll));
        return $this->getView()->display();
    }


    public function editAction(){

        $id = get("id","int");
        $row = db()->table("hook")->getRow(array('id'=>$id))->done();
        if(!$row){
            return $this->link()->error("参数错误");
        }
        $form = new \Admin\Hoke\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('hookEdit');                      //开始渲染
        $plugs = array();
        if($row['plugs']){
            $plugs = explode(",",$row['plugs']);
        }

        $this->getView()->assign(array('form'=>$form,'plugs'=>$plugs,'id'=>$id));
        return $this->getView()->display();

    }

    public function sortAction(){

        $data = post("data", "txt");
        $id = post("id", "int");
        $plugs = arr2str($data,",");
        $res = db()->table('hook')->upDate(array('plugs' => $plugs), array('id' => $id))->done();
        if($res){
            return JsonObject(array("msg" => "保存成功"));
        }
    }


    public function addAction(){


        $row = db()->Table('hook')->getTableStructure()->done();
        $form = new \Admin\Hoke\Form\editForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('hookEdit');                      //开始渲染

        $this->getView()->assign(array('form'=>$form));
        return $this->getView()->display();

    }


    public function saveAction(){



        $form = new \Admin\Hoke\Form\editForm();        //获取表单
        $form->start('hookEdit');
        $data = $this->request()->getData();//获取数据
        $data = checkForm::init($data,$form->_name);
        $id = $data['id'];
        unset($data['id']);
        $data['crate_time'] = date("Y-m-d H:i:s");
        $res = db()->table("hook")->upDate($data,array('id'=>$id))->done();



        if($res){
            return $this->link()->success("admin:hook:index","保存成功");
        }else{
            return $this->link()->error("保存失败");
        }

    }


} 