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
        //www.xietaotao.cn/index.php?m=member&c=open&a=index
        $this->create(2);
        $url =  $this->openApi->getCodeUrl("http://www.xietaotao.cn/callback.php");
        $this->link()->getUrl($url);

    }


    /**
     * 回调函数
     * @throws \Exception
     */
    public function callbackAction(){
        $this->create(2);
        //获取授权信息， 更新授权信息
        $code = $this->openApi->getCallbackCode();
        //检查用户是否登陆成功
        try {
            if (!$code || !($token = $this->openApi->getAccessToken($code))) {
                $this->link()->error("登录失败");
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $openApi  = db()->table("member_open")->getRow(array("openid"=>$token->getOpenId()));
        //$openApi = $openTable->getRow(array('openid' => $token->getOpenId()));


        if (!$openApi) {
            //新建用户

            //insert data
            $openApiArr['create_time'] = date('Y-m-d H:i:s');
            $openApiArr['type'] = (int)get("id");
            $openApiArr['openid'] = $token->getOpenId();
            $openApiArr['expires_in'] = $token->getExpiresIn();
            $openApiArr['token'] = $token->getToken();
            db()->table("member_open")->insert($openApiArr);
        } else {
            //update data
            $openApi->token = $token->getToken();
            $openApi->expires_in = $token->getExpiresIn();
            $openApi->save();
        }
        //init session
        $this->openSession->type = $this->apiType->id;
        $this->openSession->openid = $token->getOpenId();
        $this->openSession->id = $openApi->id;
        //转向到来路URL
        $this->redirect()->toUrl($this->openSession->goUrl);
        unset($this->openSession->goUrl);










    }








}