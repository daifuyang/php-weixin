<?php


namespace Home\Controller;


use Think\Controller;

class WeixinController extends Controller
{
    public $appid = 'wx935432603092b4ae';
    public $secret = 'a41a82d021ffcbefc161d2717f7e61c9';
    public $access_token = '';
    public $openid = '';
    /*
     * @Author : belief_dfy@qq.com
     * @Date   : 2019-04-22
     * @Desc   : 验证签名
     * */
    protected function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "wxtest123456789";

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    protected function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }
    }

    /*
     * @Author : belief_dfy@qq.com
     * @Date   : 2019-04-22
     * @Desc   :获取access_token
     * */
    public function getAccessToken()
    {
        $appid = $this->appid;
        $secret = $this->secret;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $data =  json_decode(curl_request($url),TRUE);
        if ($data['access_token']){
            $this->access_token = $data['access_token'];
            return $this->access_token;
        }
        else{
            return false;
        }
    }

    /*
     * @Author : belief_dfy@qq.com
     * @Date   : 2019-04-22
     * @Desc   :用户微信无感授权
     * */
    public function checkAuth()
    {
        $appid = $this->appid;
        $urlStr = urlencode(U("getUserInfo","","",true));
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$urlStr&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        redirect($url);
    }

    /*
     * @Author : belief_dfy@qq.com
     * @Date   : 2019-04-22
     * @Desc   :用户微信获取openID
     * */
    public function getOauthAccessToken($code)
    {
        $appid = $this->appid;
        $secret = $this->secret;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $data =  json_decode(curl_request($url),TRUE);
        if ($data){
            $this->openid = $data['openid'];
            return $data;
        }
        else{
            return false;
        }
    }

    public function setLog($text)
    {
        $file = 'log.txt';
        $dir = THINK_PATH . '../Public/log/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            echo '创建文件夹成功';
        }

        $fp = fopen(THINK_PATH . '../Public/log/' . $file, 'a');
        fwrite($fp, date("Y-m-d H:i:s") . " " . $text . "\r\n");
        fclose($fp);
    }
}