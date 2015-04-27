<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/24 0024
 * Time: 上午 9:33
 */

namespace Admin\Controller;


class sidebarController extends abstractController
{

    /**
     * index
     */
    public function indexAction()
    {
        $systemWidgetsAll = db()->table("sidebar")->getAll(array('group' => \Admin\Sidebar\Type\Group::SIDEBAR_SYSTEM))->order('sort')->done();
        foreach ($systemWidgetsAll as $k => $v) {
            $systemWidgetsAll[$k]['data'] = unserialize($v['data']);
        }
        $diyWidgetsAll = db()->table("sidebar")->getAll(array('group' => \Admin\Sidebar\Type\Group::SIDEBAR_DIY))->order('sort')->done();

        foreach ($diyWidgetsAll as $k => $v) {
            $diyWidgetsAll[$k]['data'] = unserialize($v['data']);
        }
        $actionWidgetsAll = db()->table("sidebar")->getAll(array('show' => \Admin\Sidebar\Type\Show::STATUS_ENABLE))->order('sort')->done();
        $this->getView()->assign(array('systemWidgetsAll' => $systemWidgetsAll, 'diyWidgetsAll' => $diyWidgetsAll, 'actionWidgetsAll' => $actionWidgetsAll));
        $this->getView()->display();
    }


    /**
     * add
     */
    public function addAction()
    {
        $title = post("new_title", "txt");
        $content = post("new_content", "txt");
        $data = array(
            'name' => $title,
            'title' => $title,
            'data' => serialize(array(
                    0=>array('title' => '标题','data' => $title),
                    1=>array('title' => '内容','data' => $content)
                )),
            'group' => \Admin\Sidebar\Type\Group::SIDEBAR_DIY,
            'show' => \Admin\Sidebar\Type\Show::STATUS_UNABLE,
            'sort' => 0
        );
        $r = db()->table("sidebar")->insert($data)->done();
        if ($r) {
            return $this->link()->success("admin:sidebar:index","添加成功");
        } else {
            return $this->link()->error("添加失败");
        }
    }

    /**
     * sort
     */
    public function sortAction()
    {
        $data = post("data", "txt");
        foreach ($data as $k => $v) {
            db()->table('sidebar')->upDate(array('sort' => $k), array('id' => $v))->done();
        }
        return JsonObject(array("msg" => "保存成功"));
    }

    /**
     * edit
     */
    public function editAction(){

        $id = post("sidebar_id",'int');
        $name= post("name",'txt');
        $title = post("title",'txt');
        $data = post("data",'txt');
        $dataArray = array();
        foreach($title as $k=>$v){
            $dataArray[] = array('title'=>$v,'data'=>$data[$k]);
        }
        $array  = array(
            'name'=>$name,
            'data'=>serialize($dataArray)
        );
        db()->table('sidebar')->upDate($array, array('id' => $id))->done();
        return $this->link()->success("admin:sidebar:index","操作成功");

    }


    public function delAction(){

        $id = get("id",'int');
        $r = db()->table('sidebar')->delete(array('id' => $id))->done();
        if($r){
            return JsonObject(array("msg" => "删除成功"));
        }else{
            return JsonObject(array("msg" => "删除失败"));
        }


    }
}