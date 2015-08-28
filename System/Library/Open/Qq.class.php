<?php
/**
 * QQ开放接口
 *
 * User: fang
 * Date: 10/18/14
 * Time: 11:26 AM
 */
namespace System\Library\Open;
include_once( __DIR__ . '/qq/API/qqConnectAPI.php' );

class Qq extends OpenAbstract
{
    /**
     * @var \SaeTOAuthV2
     */
    private $qq;
    /**
     * 获取回调URL地址
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        $this->callbackUrl;
    }

    private function getQqApi()
    {
        if(!$this->qq) {
            $this->qq = new \QC('','',$this->getOptions());
        }
        return $this->qq;
    }


    public function getCodeUrl($callbackUrl = null)
    {
        if(!$callbackUrl) {
            $callbackUrl = $this->getOptions()->callback_url;
        }
       return $this->getQqApi()->qq_login();
        //$this->getQqApi()->qq_login();

    }


    /**
     * 获取请求回调用户ID
     *
     * @return string
     */
    public function getCallbackCode()
    {
        var_dump($_REQUEST);exit;
        return $_REQUEST['code'];
    }

    /**
     * get access token
     *
     * @param $code
     * @return mixed|void
     */
    protected function requestAccessToken($code)
    {
        $keys = array();
        $keys['code'] = $code;
        $keys['redirect_uri'] = $this->getOptions()->callback_url;
        try {
            $accessToken = new AccessToken();
            $paramsAll = $this->getQqApi()->qq_callback();
            $accessToken->setToken($paramsAll['access_token']);
            $accessToken->setExpiresIn($paramsAll['expires_in']);
            $accessToken->setOpenId($this->getQqApi()->get_openid());
            return $accessToken;
        } catch (\OAuthException $e) {
            throw $e;
        }
    }
}