<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart;
class Mp{

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    // 向微信获取普通access_token
    public function access_token($appid,$secret){
        return json_decode($this->spiders()->spiders([
            'url'=>'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret,
        ])['result']);
    }

    // 向微信获取带openid的access_token
    public function access_token_openid($appid,$secret,$code){
        return json_decode($this->spiders()->spiders([
            'url'=>'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code',
        ])['result']);
    }

    // 向微信获取JsApi_ticket
    public function jsapi_ticket($access_token){
        return json_decode($this->spiders()->spiders([
            'url'=>'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi',
        ])['result']);
    }

    // 向微信获取用户UserInfo(需scope为snsapi_userinfo)
    public function userinfo($access_token,$openId){
        return json_decode($this->spiders()->spiders([
            'url'=>'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openId.'&lang=zh_CN',
        ])['result']);
    }

    // 生成JsSDK调用配置
    public function jssdk_config($jsApiTicket,$url){
        $noncestr = $this->RandChar(32);
        $timestamp = time();
        $jsapi_ticket = $jsApiTicket;
        $params = [
            'noncestr' =>$noncestr,
            'jsapi_ticket'=>$jsapi_ticket,
            'timestamp'=>$timestamp,
            'url'=>$url
        ];
        $paramsStr = $this->ASCII($params);
        $signature = sha1($paramsStr);
        return[
            'str'=>$paramsStr,
            'timestamp'=>$timestamp,
            'nonceStr'=>$noncestr,
            'signature'=>$signature
        ];
    }

    // 获取指定位数随机数
    private function RandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

    // 将数组ASCII排序后进行URl编码
    private function ASCII($params){
        $p =  ksort($params);
        if($p){
            $str = '';
            foreach ($params as $k=>$val){
                $str .= $k .'=' . $val . '&';
            }
            $strs = rtrim($str, '&');
            return $strs;
        }
        return -1;
    }
}