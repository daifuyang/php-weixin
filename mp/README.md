### php-weixin
分享记录一些自己常用的公共工具库类
## *mp 微信公众号开发*
### indexController extends WeixinController
该控制器为公众号入口项目包含
+ verify方法 （进行公众号接口配置信息）
+ index方法  （网页授权入口测试）
+ getUserInfo方法  （获取用户OpenID）
 
### WeixinController
该控制器为授权控制器，需要用户授权的都需要继承该公众号
+ checkSignature方法   （进行公众号接口配置信息）
+ getAccessToken方法   （获取access_token）
+ checkAuth     　　   （用户无感授权）
+ getOauthAccessToken  (获取网页授权AccessToken)
 
### 问题小计
请先配置appID和secret<br>
确保已经获取到了接口权限<br>
##### 问题列表
+ redirect_uri 域名与后台配置不一致 10003<br>
*确保appid与后台一致*<br>
*确保设置了授权回调页面域名*

### 联系作者
@Author：Return_归来<br>
@Email：belief_dfy@qq.com<br>
@QQ      ：1140444693<br>
@website ：www.dfy520.cn
