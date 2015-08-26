<?php
/**
 * 第三方开放平台接入开放接口
 *
 * User: fang
 * Date: 10/18/14
 * Time: 11:31 AM
 */
namespace System\Library\Open;

interface OpenInterface
{
    /**
     * 获取跳转获取code的url地址
     *
     * @param string 回调URL地址
     * @return string
     */
    public function getCodeUrl($callbackUrl);

    /**
     * 获取访问授权码
     *
     * @param string $code 用户Code
     * @return AccessToken
     */
    public function getAccessToken($code);

    /**
     * 获取回调的code代码
     *
     * @return string
     */
    public function getCallbackCode();
}