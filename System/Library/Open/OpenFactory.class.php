<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/26
 * Time: 15:20
 */
namespace System\Library\Open;
/**
 * Class OpenFactory
 * @package System\Library\Open
 */
class OpenFactory
{

    /**
     * »ñÈ¡openApi
     * @param $apiName
     * @param $config
     * @return mixed
     */
    public static function createOpenApi($apiName,$config){

        $className = '\\System\\Library\\Open\\'.ucfirst($apiName);
        $openApi = new $className;
        $openApi->setOptions($config);
        return $openApi;

    }


}