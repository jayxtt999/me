<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-22
 * Time: 下午9:53
 */

namespace Admin\Controller;


class calendarController extends abstractController
{

    public function indexAction()
    {
        return $this->getView()->display();
    }

    /**
     * 初始数据
     */
    public function showAction()
    {
        $data = db()->table("calendar")->getAll()->done();
        foreach ($data as $k => $v) {
            $allday = $v['allday'];
            $is_allday = $allday == 1 ? true : false;
            $data[] = array(
                'id' => $v['id'], //事件id
                'title' => $v['title'], //事件标题
                'start' => date('Y-m-d H:i', $v['starttime']), //事件弿始时闿
                'end' => date('Y-m-d H:i', $v['endtime']), //结束时间
                'allDay' => $is_allday, //是否为全天事仿
                'color' => $v['color'] //事件的背景色
            );
        }
        return JsonObject($data);
    }

    public function eventAction()
    {
        $ac = get("ac", "string");
        if ($ac == "add") {
            //$viewDate['starttime'] = $viewDate['endtime'] = strtotime(get("date", "string"));
            $start = get("start", "string");
            $enddate = get("end", "string");
            if ($start == $enddate) $enddate = '';
            $viewDate['starttime'] = strtotime($start);
            if (empty($enddate)) {
                $viewDate['display'] = 'style="display:none"';
                $viewDate['chk'] = '';
                $viewDate['endtime'] = strtotime($start);

            } else {
                $viewDate['display'] = 'style=""';
                $viewDate['chk'] = 'checked';
                $viewDate['endtime'] = strtotime($enddate);
            }
        } else if ($ac == "edit") {
            $id = get("id", "number");
            if ($id) {
                $viewDate = db()->table("calendar")->getRow(array('id' => $id))->done();
            }
        } else if ($ac == "del") {
            $id = get("id", "number");
            if ($id) {
                try {
                    db()->table("calendar")->delete(array('id' => $id))->done();
                    echo 1;
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
            exit;
        } else if ($ac == "drag") {
            $id = post('id', 'number');
            $daydiff = post('id', 'daydiff') * 24 * 60 * 60;
            $minudiff = post('id', 'minudiff') * 60;
            $allday = $_POST['allday'];
            $row = db()->table("calendar")->getRow(array('id' => $id))->done();
            if ($allday == "true") {//如果是全天事件
                if ($row['endtime'] == 0) {
                    $r = db()->table("calendar")->upDate(array('starttime+=' => $daydiff), array('id' => $id))->build()->done();
                } else {
                    $r = db()->table("calendar")->upDate(array('starttime+=' => $daydiff, 'endtime+=' => $daydiff), array('id' => $id))->build()->done();
                }

            } else {
                $difftime = $daydiff + $minudiff;
                if ($row['endtime'] == 0) {
                    $r = db()->table("calendar")->upDate(array('starttime+=' => $difftime), array('id' => $id))->build()->done();
                } else {
                    $r = db()->table("calendar")->upDate(array('starttime+=' => $difftime, 'endtime+=' => $difftime), array('id' => $id))->build()->done();
                }
            }
            if ($r) {
                echo '1';
            } else {
                echo '变更失败';
            }
            exit;
        } elseif ($ac == "resize") {
            $id = post('id', 'number');
            $daydiff = post('id', 'daydiff') * 24 * 60 * 60;
            $minudiff = post('id', 'minudiff') * 60;

            $row = db()->table("calendar")->getRow(array('id' => $id))->done();
            //echo $allday;exit;
            $difftime = $daydiff + $minudiff;
            if ($row['endtime'] == 0) {
                $r = db()->table("calendar")->upDate(array('endtime=starttime+' => $difftime), array('id' => $id))->build()->done();
            } else {
                $r = db()->table("calendar")->upDate(array('endtime+=' => $difftime), array('id' => $id))->build()->done();
            }
            if ($r) {
                echo '1';
            } else {
                echo '变更失败';
            }
            exit;
        } else {

        }

        $this->getView()->assign(array("date" => $viewDate, "action" => $ac));
        $this->getView()->display();

    }


    public function saveAction()
    {


        $action = post("action", 'txt');//事件类型
        $id = post("id", 'number');//事件类型
        $events = post("event", 'txt');//事件内容
        $isallday = post("isallday", 'txt');//是否是全天事件
        $isend = post("isend", 'txt');//是否有结束时间
        $startdate = post("startdate", 'txt');//开始日期
        $enddate = post("enddate", 'txt');//结束日期
        $s_time = post("s_hour", 'txt') . ':' . post("s_minute", 'txt') . ':00';//开始时间
        $e_time = post("e_hour", 'txt') . ':' . post("e_minute", 'txt') . ':00';//结束时间

        if ($isallday == 1 && $isend == 1) {
            $starttime = strtotime($startdate);
            $endtime = strtotime($enddate);
        } elseif ($isallday == 1 && $isend == "") {
            $starttime = strtotime($startdate);
            $endtime = strtotime($enddate);
        } elseif ($isallday == "" && $isend == 1) {
            $starttime = strtotime($startdate . ' ' . $s_time);
            $endtime = strtotime($enddate . ' ' . $e_time);
        } else {
            $starttime = strtotime($startdate . ' ' . $s_time);
            $endtime = strtotime($enddate . ' ' . $e_time);
        }

        $colors = array("#360", "#f30", "#06c");
        $key = array_rand($colors);
        $color = $colors[$key];
        $isallday = $isallday ? 1 : 0;

        $array = array(
            "title" => $events,
            "starttime" => $starttime,
            "endtime" => $endtime,
            "allday" => $isallday,
            "color" => $color,
        );
        if ($action == "add" && !$id) {
            $res = db()->table("calendar")->insert($array)->done();
        } else if ($action == "edit" && $id) {
            $res = db()->table("calendar")->upDate($array, array('id' => $id))->done();
        }
        if ($res) {
            echo '1';
        } else {
            echo '操作失败！';
        }


    }


}











