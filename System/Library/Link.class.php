<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午10:15
 */

namespace System\Library;


class Link {

    private $urlType;
    public function init(){
        $this->urlType =  C("route:url_type");
    }

    public function  getUrl(string $url){
        $url = explode(":",$url);
        switch($this->urlType){
            case "default":
                $this->defaultUrl($url);
                break;
        }

    }
    public function defaultUrl($url){
        foreach($url as $k=>$v){
            

        }
    }






} 