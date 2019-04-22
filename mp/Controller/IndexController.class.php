<?php
namespace Home\Controller;
class IndexController extends WeixinController {

    public function index(){

       $this->checkAuth();
        //redirect($url);
        //$this->getAccessToken();
    }

    /*
  * @Author : belief_dfy@qq.com
  * @Date   : 2019-04-22
  * @Desc   : 公众号接入认证
  * */
    public function verify()
    {
    	$echoStr = $_GET["echostr"];
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    /*
* @Author : belief_dfy@qq.com
* @Date   : 2019-04-22
* @Desc   : 获取code
* */
    public function getUserInfo()
    {
        $code = I('param.code');
        $userinfo = $this->getOauthAccessToken($code);
        $openId = $this->openid;
        if ($openId == ''){
            $this->checkAuth();
        }
        print_r($openId);
    }
}