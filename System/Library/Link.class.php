<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午10:15
 */

namespace System\Library;

class Link {
    public $view;
    private $mvc = array('m','c','a');
    private $urlType;
    public function init(){
        $this->urlType =  C("route:url_type");
    }

    /**
     * @param $jumpUrl
     * @param int $time
     * @param string $msg
     * @param bool $status
     * @param bool $ajax
     */
    public function toUrl($jumpUrl,$time=0,$msg="",$status=true,$ajax=false){
        $this->dispatchJump($this->getUrl($jumpUrl),$time,$msg,$status,$ajax);
    }

    /**
     * @param $jumpUrl
     * @param int $time
     * @param string $msg
     * @param bool $status
     * @param bool $ajax
     */
    public function success($jumpUrl,$msg="",$status=false,$ajax=false,$array=array()){
        $this->dispatchJump($this->getUrl($jumpUrl),3,$msg,$status,$ajax,$array);
    }

    /**
     * @param $jumpUrl
     * @param int $time
     * @param string $msg
     * @param bool $status
     * @param bool $ajax
     */
    public function error($msg='',$array=array(),$status=false,$ajax=false){
        $this->dispatchJump("", $time=1, $msg,$status,$ajax,$array);
    }


    /**
     * @param $url
     * @return string
     */
    public function  getUrl($url){
        $url = explode(":",$url);
        switch($this->urlType){
            case "default":
                return $this->defaultUrl($url);
                break;
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function defaultUrl($url){

        $urlMvc = "";
        foreach($url as $k=>$v){
            //m=admin&c=menu&a=save
            $first = $k?"&":"/index.php?";
            if(strpos($v,"-")){
                $param = explode("-",$v);
                $urlMvc.=  $first.$param[0]."=".$param[1];
            }else{
                $urlMvc.= $first.$this->mvc[$k]."=".$v;
            }
        }
        return $urlMvc;
    }

    /**
     * URL重定向
     * @param string $url 重定向的URL地址
     * @param integer $time 重定向的等待时间（秒）
     * @param string $msg 重定向前的提示信息
     * @param integer $status true or false 成功还是失败
     * @param integer $ajax true or false 是否为ajax
     * @return void
     */
    function dispatchJump($jumpUrl, $time=0, $msg='',$status,$ajax,$array) {
        if($ajax || $this->isAjax()){
            $this->ajaxReturn($ajax,$msg,$status);
        }
        if(!empty($jumpUrl)){
            $this->view->assign(array('jumpUrl'=>$jumpUrl));
        }
        // 提示标题
        $this->view->assign(array('msgTitle'=>$this->view->get('msgTitle')));
        //如果设置了关闭窗口，则提示完毕后自动关闭窗口
        if($this->view->get('closeWin')){
            $this->view->assign(array('jumpUrl'=>'javascript:window.close();'));
        }
        //跳转参数
        if($array){
            $i=1;
            foreach($array as $k=>$v){
                $c = $i=1?"?":"&";
                $jumpUrl.=$c.$k."=".$v;
                $i++;
            }
        }
        // 状态
        $this->view->assign(array('status'=>$status));
        if($status){ //发送成功信息
            $this->view->assign(array('message'=>$msg));// 提示信息
            // 成功操作后默认停留1秒
            if(!$this->view->get('waitSecond')){
                $this->view->assign(array('waitSecond'=>"1"));
            }
            // 默认操作成功自动返回操作前页面
            if(!$this->view->get('jumpUrl')){
                $this->view->assign(array("jumpUrl"=>$_SERVER["HTTP_REFERER"]));
            }
            $this->view->display("common/dispatch_jump",true);
            exit;
        }else{
            // 提示信息
            $this->view->assign(array('error'=>$msg));
            //发生错误时候默认停留3秒
            if(!$this->view->get('waitSecond')){
                $this->view->assign(array('waitSecond'=>"3"));
            }
            // 默认发生错误的话自动返回上页
            if(!$this->view->get('jumpUrl')){
                $this->view->assign(array('jumpUrl'=>"javascript:history.back(-1);"));
            }
            $this->view->display("common/dispatch_jump",true);
            // 中止执行  避免出错后继续执行
            exit ;
        }


    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param boolean $status 返回状态
     * @param String $status ajax返回类型 JSON XML
     * @return void
     */
    protected function ajaxReturn($data,$info='',$status=1,$type='') {
        $result  =  array();
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;
        //扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
        if(method_exists($this,"ajaxAssign"))
            $this->ajaxAssign($result);
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        if(strtoupper($type)=='JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        }elseif(strtoupper($type)=='XML'){
            // 返回xml格式数据
            header("Content-Type:text/xml; charset=utf-8");
            exit(xml_encode($result));
        }
    }


    /**
     * 是否AJAX请求
     * @access protected
     * @return bool
     */
    protected function isAjax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
                return true;
        }
        return false;
    }









} 