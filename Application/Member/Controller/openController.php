<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-29
 * Time: 下午8:40
 */

namespace Member\Controller;

class openController extends abstractController
{
    private $openSession = null;

    /**
     * @var \System\Library\Open\OpenAbstract
     */
    private $openApi;

    /**
     * @var object
     */
    private $apiType;

    protected function create($id)
    {
        $this->apiType = (new \Member\Open\Type)->getById($id);
        if (!$this->apiType) {
            throw new \Exception('没有开通的第三方接入');
        }
        //init api
        $config = arrayToObject(C("open:".$this->apiType->key));
        $this->openApi = \System\Library\Open\OpenFactory::createOpenApi($this->apiType->key,$config);
    }


    /**
     * 第三方平台授权发起页面
     */
    public function indexAction()
    {
        //test
        $this->create(2);
        $url =  $this->openApi->getCodeUrl();
        var_dump($url);exit;
        echo $url;exit;


        //http://openapi.qzone.qq.com/oauth/show?which=ConfirmPage&display=pc&response_type=code&client_id=100273020&redirect_uri=http://qq.jd.com/new/qq/callback.action

        //https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101212806&redirect_uri=http://www.xietaotao.cn/member/open/callback/id/2&state=e51f4a186340d916568b298924ab880b&scope=



        $this->link()->getUrl($url);

    }



    public function callbackAction(){

        //获取授权信息， 更新授权信息
        $code = $this->openApi->getCallbackCode();
        //检查用户是否登陆成功
        try {
            if (!$code || !($token = $this->openApi->getAccessToken($code))) {
                //return $this->notFoundAction();
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }


    }








}