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
        $sellerAll = db("jutuan")->table("td_seller_info")->getAll()->limit(1,10)->order("SELLER_ID")->done();
        return $this->getView()->display();
        if(get("type")=="json"){
            return (JsonObject($sellerAll));exit;
        }
        foreach($sellerAll as $k=>$v){

            $PROVINCE_NAME = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['PROVINCE_ID']))->fields("AREA_NAME")->done();
            $CITY_ID = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['CITY_ID']))->fields("AREA_NAME")->done();
            $COUNTY_ID = db("jutuan")->table("tb_area")->getRow(array("area_code"=>$v['COUNTY_ID']))->fields("AREA_NAME")->done();
            $sellerAll[$k]['PROVINCE_NAME'] = $PROVINCE_NAME;
            $sellerAll[$k]['CITY_NAME'] = $CITY_ID;
            $sellerAll[$k]['COUNTY_NAME'] = $COUNTY_ID;
        }
        $this->getView()->assign(array('sellerAll' => $sellerAll));


    }


    public function sellerSyncDateAction(){

        //echo json_encode(array("a"=>1,"b"=>2,"data"=>array(array(1,2,3,4))));exit;

        $start = get("start","int");
        $length = get("length","int");
        $draw = get("draw","int");

        $total = db("jutuan")->table("td_seller_info")->getAll()->count()->done();
        $total = $total[0];
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

        //获取已有产品（微信端）
        //$profuctAll = db("jutuan")->table("td_prod_info")->getAll()->done();

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



    public  function sellerEditSaveAction(){

        $form = new \Admin\Jutuan\Form\sellerEditForm();        //获取表单
        $form->start('sellerEdit');
        $data = $this->request()->getData();//获取数据
        $data = checkForm::init($data, $form->_name);

        $seller_id = $data['id'];
        unset($data['seller_id']);
        //更新
        $res = db("jutuan")->table("td_seller_info")->upDate($data, array('seller_id' => $seller_id))->done();
        if ($res) {
            return $this->link()->success("admin:jutuan:sellerSync", "更新成功");
        } else {
            return $this->link()->error("更新失败");
        }

        var_dump($data);exit;

    }

    public function sellerDelAction()
    {
        $id = get("id", "int");
        $res = db()->Table('article')->delete(array('id' => $id));
        return $res;

    }


    public function sellerSyncGoAction(){

        echo('<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>');

        print str_repeat(" ", 4096);
        /*for ($i=10; $i>0; $i--)
        {
            echo $i.'<br />';
            echo('<script> $("body").scrollTop($("body")[0].scrollHeight);</script>');
            ob_flush();
            flush();
            sleep(1);
        }
        ob_end_flush();*/

        echo 1212;exit;

    }


}
