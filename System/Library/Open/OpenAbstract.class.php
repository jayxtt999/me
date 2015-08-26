<?php
/**
 * 开放平台
 *
 * User: fang
 * Date: 10/18/14
 * Time: 11:38 AM
 */
namespace System\Library\Open;

abstract class OpenAbstract implements OpenInterface
{

    private $request;

    /**
     * @var AccessToken
     */
    private $accessToken;

    /**
     * 配置选项信息
     * @var OpenOptions
     */
    private $options;

    /**
     * 设置开放平台选项
     *
     * @param $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * 获取设配器配置信息
     *
     * @return OpenOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * code url
     *
     * @param string $callbackUrl 回调URL地址
     * @return mixed|string
     */
    public function getCodeUrl($callbackUrl)
    {
        return $this->options->code_url;
    }

    /**
     * 设置accesstoken
     *
     * @param $accessToken
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        if(!$this->isVoildAccessToken($accessToken)) {
            throw new \Exception('无效accesstoken, 请重新授权');
        }
        $this->accessToken = $accessToken;
    }

    /**
     * 获取授权码
     *
     * @param $code
     * @return AccessToken|void
     */
    public function getAccessToken($code = null)
    {
        if(!$this->isVoildAccessToken($this->accessToken) && $code) {
            $this->accessToken = $this->requestAccessToken($code);
        }
        return $this->accessToken;
    }

    /**
     * 检查访问授权是否有效
     *
     * @param AccessToken $token
     * @return bool
     */
    public function isVoildAccessToken($token)
    {
        if(!$token) {
            return false;
        }
        return (($token->getExpiresIn() < time()));
    }

    /**
     * @param $code
     * @return mixed
     */
    abstract protected function requestAccessToken($code);
} 