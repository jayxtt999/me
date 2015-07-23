<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-22
 * Time: 下午9:53
 */

namespace Admin\Controller;


class calendarController extends abstractController{

    public function indexAction(){


        return $this->getView()->display();
    }

    /**
     * 初始数据
     */
    public function showAction(){

        $data = db()->table("calendar")->getAll();
        foreach($data as $k=>$v){

            $allday = $v['allday'];
            $is_allday = $allday==1?true:false;
            $data[] = array(
                'id' => $v['id'],//事件id
                'title' => $v['title'],//事件标题
                'start' => date('Y-m-d H:i',$v['starttime']),//事件开始时间
                'end' => date('Y-m-d H:i',$v['endtime']),//结束时间
                'allDay' => $is_allday, //是否为全天事件
                'color' => $v['color'] //事件的背景色
            );

        }

        return JsonObject($data);
    }


} 