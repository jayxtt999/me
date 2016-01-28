<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/28 0028
 * Time: 上午 10:49
 */

namespace Admin\Controller;
use System\Library\Form\checkForm as checkForm;


class jutuanController extends abstractController

{
    public function sellerSyncAction(){

        //获取已有产品（微信端）
        return $this->getView()->display();

    }


    public function sellerSyncDateAction(){

        //echo json_encode(array("a"=>1,"b"=>2,"data"=>array(array(1,2,3,4))));exit;

        $start = get("start","int");
        $length = get("length","int");
        $draw = get("draw","int");

        $total = db("jutuan")->table("td_seller_info")->getAll()->count()->done();
        $sellerAll = db("jutuan")->table("td_seller_info")->getAll()->limit($start,$length)->order("SELLER_ID")->done();

        $newArr = [];
        foreach($sellerAll as $k=>$v){
            $newArr[$k][0] = "<td><input type='checkbox' class='checkboxes' value='1'/></td>";
            $newArr[$k][1] = $v['SELLER_NAME'];
            $newArr[$k][2] = $v['AGENT_ID'];
            $newArr[$k][3] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['PROVINCE_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][4] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['CITY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][5] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['COUNTY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][6] = $v['DISTRICT_ID'];
            $newArr[$k][7] = $v['INSERT_TIME'];
            $newArr[$k][8] = "
<td>
	<a href='/index.php?m=admin&c=jutuan&a=sellerSyncEdit&id=".$v['SELLER_ID']."' class='btn red' title='修改'><i class='fa fa-edit'></i></a>
	<a href='javascript:sellerDel('".$v['SELLER_ID']."');' class='btn purple' title='删除'><i class='fa fa-times'></i></a>
</td>";

        }
        $date = array(
            "draw"=>$draw,
            "recordsTotal"=>$total,
            "recordsFiltered"=>$total,
            "data"=>$newArr,
        );
        $jsonp = preg_match('/^[$A-Z_][0-9A-Z_$]*$/i', $_GET['callback']) ? $_GET['callback'] : false;
        if ( $jsonp ) {
            echo $jsonp.'('.json_encode($date).');';
            exit;
        }
        //return (JsonObject($date));
    }

    public function productSyncAction(){

        return $this->getView()->display();

    }


    /**
     * 生成省市县
     */
    public function ssx(){
        $All = db("jutuan")->Table('tb_area')->getAll(array("AREA_LVL"=>1))->done();
        $txt = "'0': {<br/>";
        foreach($All as $v){
            $txt.=$v['AREA_CODE'].":'".$v['AREA_NAME']."',<br/>";
        }
        $txt.="},";
        echo $txt."<br/>";
        $All = db("jutuan")->Table('tb_area')->getAll()->done();
        $newArr = array();
        foreach($All as $v){
            if($v['PARENT_CODE']=="|0|"){
                continue;
            }
            preg_match_all('/\|(\d+)+\|/', $v['PARENT_CODE'], $matches, PREG_SET_ORDER);
            $key= "0,";
            foreach($matches as $k => $v2){
                $key .=$v2[1];
                if($k!=count($matches)-1){
                    $key .=",";
                }
            }
            $newArr[$key][$v['AREA_CODE']] = $v['AREA_NAME'];

        }

        foreach($newArr as $k=>$v){

            echo "'".$k."':<br/>{<br/>";
            foreach($v as $k2=>$v2){
                echo $k2.":"."'$v2',<br/>";
            }
            echo "},<br/>";
            //'0,1': {2: '北京市'},
        }
        exit;
        var_dump($newArr);exit;
        echo($txt);exit;
    }


    public function sellerSyncEditAction(){

        $id = get("id","int");
        $row = db("jutuan")->Table('td_seller_info')->getRow(array('seller_id' => $id))->done();        //getRow
        if (!$row) {
            return $this->link()->error("参数错误");
        }
        $form = new \Admin\Jutuan\Form\sellerEditForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('sellerEdit');                      //开始渲染
        $this->getView()->assign(array('form' => $form,'data' => $row));
        $this->getView()->display();
    }

    public function sellerSyncCacheEditAction(){

        $id = get("id","int");
        $row = db("jutuan")->Table('td_seller_info_copy')->getRow(array('seller_id' => $id))->done();        //getRow
        if (!$row) {
            return $this->link()->error("参数错误");
        }
        $form = new \Admin\Jutuan\Form\sellerEditCacheForm();        //获取表单
        $form->bind($row);                                  //绑定Row
        $form->start('sellerEditCache');                      //开始渲染
        $this->getView()->assign(array('form' => $form,'data' => $row));
        $this->getView()->display();
    }

    public  function sellerEditCacheSaveAction(){

        $form = new \Admin\Jutuan\Form\sellerEditCacheForm();        //获取表单
        $form->start('sellerEditCache');
        $data = $this->request()->getData();//获取数据
        $data = checkForm::init($data, $form->_name);
        $seller_id = $data['seller_id'];
        unset($data['seller_id']);
        //更新
        $res = db("jutuan")->table("td_seller_info_copy")->upDate($data, array('seller_id' => $seller_id))->done();
        if ($res) {
            return $this->link()->success("admin:jutuan:sellerSyncCache", "更新成功");
        } else {
            return $this->link()->error("更新失败");
        }
    }


    public  function sellerEditSaveAction(){

        $form = new \Admin\Jutuan\Form\sellerEditForm();        //获取表单
        $form->start('sellerEdit');
        $data = $this->request()->getData();//获取数据
        $data = checkForm::init($data, $form->_name);

        $seller_id = $data['seller_id'];
        unset($data['seller_id']);
        //更新
        $res = db("jutuan")->table("td_seller_info")->upDate($data, array('seller_id' => $seller_id))->done();
        if ($res) {
            return $this->link()->success("admin:jutuan:sellerSync", "更新成功");
        } else {
            return $this->link()->error("更新失败");
        }

    }

    public function sellerDelAction()
    {
        $id = get("id", "int");
        $res = db()->Table('article')->delete(array('id' => $id));
        return $res;

    }

    public function sellerSyncGoAction(){

        $gTime = microtime(true);
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        echo "<link href='".ADMIM_TPL_PATH."/assets/global/plugins/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'/>";
        echo('<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>');
        print str_repeat(" ", 4096);

        echo "数据同步开始，请不要关闭窗口...<br/>..<br/>..<br/>";
        $oldArr = array();
        $newArr = array();
        $res = db("jutuan")->table("cenwor_tttuangou_seller")->getAll()->done();
        foreach($res as $v){
            $oldArr[]=$v['userid'];
        }
        $res = db("jutuan")->table("td_seller_info")->getAll()->done();
        foreach($res as $v){
            $newArr[]=$v['SELLER_ID'];
        }
        $result = array_diff($oldArr, $newArr);
        echo "检测到待同步记录".count($result)."条<br/>";

        $new= implode(',',$result);

        $res = db("jutuan")->sql("select * from cenwor_tttuangou_seller where userid in (".$new.")");
        //预处理 存为sql
        $sellerSql = array();
        foreach($res as $v){
            $getAgentRow = db("jutuan")->table("cenwor_tttuangou_city")->getRow(array("cityid"=>$v['area']))->done();
            $agentId = $getAgentRow['uid'];
            if($v['baidumap']){
                $map = explode(",",$v['baidumap']);
                $longitude = $map[0];
                $latitude = $map[1];
            }else{
                $map = json_decode(file_get_contents("http://api.map.baidu.com/geocoder?address=".iconv("UTF-8", "GBK",trim($v['selleraddress']))."&output=json"));
                if($map->status == "OK" && $map->result){
                    $longitude = $map->result->location->lng;
                    $latitude =  $map->result->location->lat;
                }else{
                    //beijing
                    $longitude = "116.400906";
                    $latitude =  "39.915662";
                }
            }
            $sql0 = "DELETE FROM `a0923142448`.`td_seller_info_copy` WHERE `SELLER_ID`=".$v['userid'];
            $sql1="INSERT INTO `a0923142448`.`td_seller_info_copy` (`SELLER_ID`, `SELLER_NAME`,`AGENT_ID`, `PROVINCE_ID`, `CITY_ID`, `COUNTY_ID`, `DISTRICT_ID`, `ADDR_DETAIL`, `TELEPHONE`, `LINK_MAN`, `LONGITUDE`, `LATITUDE`, `INSERT_TIME`, `REMARK1`, `REMARK2`, `REMARK3`) VALUES ('".$v['userid']."','".$v['sellername']."', '".$agentId."', '1', '2','3', '', '".$v['selleraddress']."','".$v['sellerphone']."','', '".$longitude."', '".$latitude."','".date("YmdHis",$v['time'])."', NULL, NULL, NULL);";
            db("jutuan")->sql($sql0);
            db("jutuan")->sql($sql1);
            echo "预处理--".$v['sellername']."--成功<br/>";
            echo('<script> $("body").scrollTop($("body")[0].scrollHeight);</script>');
            ob_flush();
            flush();
        }
        $eTime1 = microtime(true);
        echo  "耗时".round($eTime1-$gTime,3)."'s<br/>";
        echo "该窗口10秒后自动关闭..<br/>";
        sleep(10);
        echo "<script>
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                </script>";exit;
    }



    public function sellerSyncCacheAction(){

        return $this->getView()->display();
    }


    public function sellerSyncDateCacheAction(){

        $start = get("start","int");
        $length = get("length","int");
        $draw = get("draw","int");

        $total = db("jutuan")->table("td_seller_info_copy")->getAll()->count()->done();
        $sellerAll = db("jutuan")->table("td_seller_info_copy")->getAll()->limit($start,$length)->order("SELLER_ID")->done();

        $newArr = [];
        foreach($sellerAll as $k=>$v){
            $newArr[$k][0] = "<td><input type='checkbox' class='checkboxes' value='1'/></td>";
            $newArr[$k][1] = $v['SELLER_NAME'];
            $newArr[$k][2] = $v['AGENT_ID'];
            $newArr[$k][3] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['PROVINCE_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][4] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['CITY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][5] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['COUNTY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][6] = $v['DISTRICT_ID'];
            $newArr[$k][7] = $v['INSERT_TIME'];
            $newArr[$k][8] = "
<td>
	<a href='/index.php?m=admin&c=jutuan&a=sellerSyncCacheEdit&id=".$v['SELLER_ID']."' class='btn red' title='修改'><i class='fa fa-edit'></i></a>
	<a href='javascript:;' onclick='showSql(".$v['SELLER_ID'].")'   class='btn purple' title='生成SQl'><i class='fa fa-terminal'></i></a>
</td>";
        }
        $date = array(
            "draw"=>$draw,
            "recordsTotal"=>$total,
            "recordsFiltered"=>$total,
            "data"=>$newArr,
        );
        $jsonp = preg_match('/^[$A-Z_][0-9A-Z_$]*$/i', $_GET['callback']) ? $_GET['callback'] : false;
        if ( $jsonp ) {
            echo $jsonp.'('.json_encode($date).');';
            exit;
        }
        //return (JsonObject($date));
    }



    public function showSqlAction(){

        $seller_id = post("sellerid","int");
        $date = array();
        if($seller_id){
            $date[0] = db("jutuan")->Table('td_seller_info_copy')->getRow(array('seller_id' =>$seller_id))->done();        //getRow
        }else{
            $date = db("jutuan")->Table('td_seller_info_copy')->getAll()->done();        //getRow
        }
        $msg = "<textarea style='width: 100%;height: 100%'>";
        foreach($date as $row){
            $msg .= "UPDATE `a0923142448`.`td_seller_info` SET `SELLER_ID`='".$row['SELLER_ID']."', `SELLER_NAME`='".$row['SELLER_NAME']."', `AGENT_ID`='".$row['AGENT_ID']."', `PROVINCE_ID`='".$row['PROVINCE_ID']."', `CITY_ID`='".$row['CITY_ID']."', `COUNTY_ID`='".$row['COUNTY_ID']."', `DISTRICT_ID`='".$row['DISTRICT_ID']."', `ADDR_DETAIL`='".$row['ADDR_DETAIL']."', `TELEPHONE`='".$row['TELEPHONE']."', `LINK_MAN`='".$row['LINK_MAN']."', `LONGITUDE`='".$row['LONGITUDE']."', `LATITUDE`='".$row['LATITUDE']."', `INSERT_TIME`='".$row['INSERT_TIME']."', `REMARK1`=".$row['REMARK1'].", `REMARK2`=".$row['REMARK2'].", `REMARK3`=".$row['REMARK3']." WHERE (`SELLER_ID`='".$row['SELLER_ID']."');
";
        }
        $msg .= "</textarea>";
        return JsonObject(array("msg"=>$msg));

    }



    public function productSyncDateCacheAction(){

        $start = get("start","int");
        $length = get("length","int");
        $draw = get("draw","int");

        $total = db("jutuan")->table("td_product_info_copy")->getAll()->count()->done();
        $sellerAll = db("jutuan")->table("td_product_info_copy")->getAll()->limit($start,$length)->order("SELLER_ID")->done();

        $newArr = [];
        foreach($sellerAll as $k=>$v){
            $newArr[$k][0] = "<td><input type='checkbox' class='checkboxes' value='1'/></td>";
            $newArr[$k][1] = $v['SELLER_NAME'];
            $newArr[$k][2] = $v['AGENT_ID'];
            $newArr[$k][3] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['PROVINCE_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][4] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['CITY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][5] = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['COUNTY_ID']))->fields("AREA_NAME")->done();
            $newArr[$k][6] = $v['DISTRICT_ID'];
            $newArr[$k][7] = $v['INSERT_TIME'];
            $newArr[$k][8] = "
<td>
	<a href='/index.php?m=admin&c=jutuan&a=sellerSyncCacheEdit&id=".$v['SELLER_ID']."' class='btn red' title='修改'><i class='fa fa-edit'></i></a>
	<a href='javascript:;' onclick='showSql(".$v['SELLER_ID'].")'   class='btn purple' title='生成SQl'><i class='fa fa-terminal'></i></a>
</td>";
        }
        $date = array(
            "draw"=>$draw,
            "recordsTotal"=>$total,
            "recordsFiltered"=>$total,
            "data"=>$newArr,
        );
        $jsonp = preg_match('/^[$A-Z_][0-9A-Z_$]*$/i', $_GET['callback']) ? $_GET['callback'] : false;
        if ( $jsonp ) {
            echo $jsonp.'('.json_encode($date).');';
            exit;
        }
        //return (JsonObject($date));
    }



}
