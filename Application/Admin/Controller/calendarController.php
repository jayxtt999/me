<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-22
 * Time: ����9:53
 */

namespace Admin\Controller;


class calendarController extends abstractController{

    public function indexAction(){


        return $this->getView()->display();
    }

    /**
     * ��ʼ����
     */
    public function showAction(){

        $data = db()->table("calendar")->getAll();
        foreach($data as $k=>$v){

            $allday = $v['allday'];
            $is_allday = $allday==1?true:false;
            $data[] = array(
                'id' => $v['id'],//�¼�id
                'title' => $v['title'],//�¼�����
                'start' => date('Y-m-d H:i',$v['starttime']),//�¼���ʼʱ��
                'end' => date('Y-m-d H:i',$v['endtime']),//����ʱ��
                'allDay' => $is_allday, //�Ƿ�Ϊȫ���¼�
                'color' => $v['color'] //�¼��ı���ɫ
            );

        }

        return JsonObject($data);
    }


} 