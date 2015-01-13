<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午10:15
 */

namespace System\Library;


class Link {
    private $mvc = array('m','c','a');
    private $urlType;
    public function init(){
        $this->urlType =  C("route:url_type");
    }

    public function toUrl(string $url,$time=0,$msg=""){
        redirect($this->getUrl($url),$time,$msg);
    }

    public function  getUrl(string $url){
        $url = explode(":",$url);
        switch($this->urlType){
            case "default":
                return $this->defaultUrl($url);
                break;
        }
    }
    public function defaultUrl($url){
        /*foreach($url as $k=>$v){
            $urlMvc[$this->mvc[$k]] = $v;
        }*/
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






} 