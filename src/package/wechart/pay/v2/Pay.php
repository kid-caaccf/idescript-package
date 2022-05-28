<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart\pay\v2;
class Pay{

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    private function arrays(){
        return new \package\Arrays();
    }

    private $api_unifiedorder = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    protected $api_micropay = 'https://api.mch.weixin.qq.com/pay/micropay';
    static $appId = '';
    static $apiKey = '';
    static $MchId = '';
    static $trade_type = [
        'H5' => 'MWEB',
        'App' => 'APP',
        'Native' => 'NATIVE',
        'SmallApp' => 'JSAPI',
        'JSApi' => 'JSAPI',
        'PayCode' => 'PAYCODE',
    ];
    static $scene_info = [
        'ios' => [
            'type' => '', // 场景类型
            'app_name' => '', // 应用名
            'bundle_id' => '' // bundle_id
        ],
        'android' => [
            'type' => 'Android', // 场景类型
            'app_name' => '', // 应用名
            'package_name' => '' // 包名
        ],
        'wap' => [
            'type' => 'Wap', // 场景类型
            'wap_url' => '', // WAP网站URL地址
            'wap_name' => '' // WAP 网站名
        ]
    ];

    public function __construct($appId, $apiKey, $MchId)
    {
        self::$appId = $appId;
        self::$apiKey = $apiKey;
        self::$MchId = $MchId;
    }

    /**
     * [start 微信支付统一下单接口]
     * @Author   肖振宇    2434981942@qq.com
     * @DateTime 2021-01-13
     * @param string science [H5:H5支付,App:App支付,Native:扫码支付,SmallApp:小程序支付,JSApi:公众号网页支付,PayCode:付款码支付]
     * @param string order [生成的微信支付订单号]
     * @param int price [支付金额]
     * @param string notify_url [回调地址]
     * @param string openid [微信OpenId   小程序支付或公众号支付必须要]
     * @param string device [设备类型   H5支付必填 ios|android|wap]
     * @param string product_id [扫码支付必填 此参数必传。此参数为二维码中包含的商品ID，商户自行定义。]
     * @param string auth_code [付款码支付必填 此参数必传。此参数为付款码字符串。]
     * @return array|int
     * */
    public function start($wx_pay){
        $uri = $this->api_unifiedorder;
        $status = $this->isEmpty($wx_pay, ['science', 'order', 'price', 'notify_url', 'body']);
        if ($status === -1) {
            return -1;
        }
        $science = $wx_pay['science'];
        $device = !empty($wx_pay['device']) ? $wx_pay['device'] : '';

        if (!isset(self::$trade_type[$science]) || empty(self::$appId) || empty(self::$MchId)) {
            return -1;
        }

        if ($science === 'JSApi' || $science === 'SmallApp') {
            if (!isset($wx_pay['openid']) || empty($wx_pay['openid'])) {
                return -1;
            }
        } else if ($science === 'Native') {
            if (!isset($wx_pay['product_id'])) {
                return -1;
            }
        } else if ($science === 'H5') {
            if (!isset(self::$scene_info[$device])) {
                return -1;
            }
        }else if($science === 'PayCode'){
            $uri = $this->api_micropay;
            if (!isset($wx_pay['auth_code'])) {
                return -1;
            }
        } else if ($science !== 'App') {
            return -1;
        }


        $WxConf = [];
        $WxConf['appid'] = self::$appId; // Appid
        $WxConf['mch_id'] = self::$MchId; // 商户平台id
        $WxConf['nonce_str'] = $this->getRandChar(32); // 随机数
        $WxConf['out_trade_no'] = $wx_pay['order']; // 订单号
        $WxConf['spbill_create_ip'] = $this->getClientIp(); // 客户端IP
        $WxConf['total_fee'] = (int)$wx_pay['price']; // 金额
        $WxConf['fee_type'] = 'CNY'; // 交易类型
        $WxConf['attach'] = isset($wx_pay['attach']) ? $wx_pay['attach'] : ''; // 附加数据
        $WxConf['body'] = isset($wx_pay['body']) ? $wx_pay['body'] : ''; // 商品描述

        if($science !== 'PayCode'){
            $WxConf['trade_type'] = self::$trade_type[$science]; // 交易类型
            $WxConf['notify_url'] = $wx_pay['notify_url']; // 回调地址
        }

        if (self::$trade_type[$science] == 'MWEB') {
            $scene_info = json_encode(self::$scene_info[$device]);
            $scene_info = '{"h5_info":' . $scene_info . '}';
            $WxConf['scene_info'] = $scene_info;
        } else if (self::$trade_type[$science] == 'JSAPI') {
            $WxConf['openid'] = $wx_pay['openid'];
        } else if (self::$trade_type[$science] == 'NATIVE') {
            $WxConf['product_id'] = $wx_pay['product_id'];
        }else if(self::$trade_type[$science] === 'PAYCODE'){
            $WxConf['auth_code'] = $wx_pay['auth_code'];
        }
        ksort($WxConf);
        $WxConf['sign'] = $this->getSign($WxConf);
        $data = $this->to_xml($WxConf);
        $result = $this->spiders()->spiders([
            'url' => $uri,
            'post' => $data
        ])['result'];
        libxml_disable_entity_loader(true);
        $result_info = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if ($result_info['return_code'] == 'SUCCESS' && $result_info['return_msg'] == 'OK') {
            if ($science == 'JSApi') {
                if ($result_info['prepay_id']) {
                    $SmallApp = [];
                    $SmallApp["appId"] = self::$appId;
                    $SmallApp["package"] = 'prepay_id=' . $result_info['prepay_id'];
                    $SmallApp["nonceStr"] = $this->getRandChar(32);
                    $SmallApp["timeStamp"] = time();
                    $SmallApp["signType"] = 'MD5';
                    $SmallApp["paySign"] = $this->getSign($SmallApp);
                    return $SmallApp;
                }
            } else if ($science == 'SmallApp') {
                if ($result_info['prepay_id']) {
                    $SmallApp = [];
                    $SmallApp["appId"] = self::$appId;
                    $SmallApp["nonceStr"] = $this->getRandChar(32);
                    $SmallApp["package"] = 'prepay_id=' . $result_info['prepay_id'];
                    $SmallApp["signType"] = 'MD5';
                    $SmallApp["timeStamp"] = time();
                    $SmallApp["paySign"] = $this->getSign($SmallApp);
                    return $SmallApp;
                }
            } else if ($science == 'App') {
                if ($result_info['prepay_id']) {
                    $APP = [];
                    $APP["appid"] = self::$appId;
                    $APP["noncestr"] = $this->getRandChar(32);
                    $APP["package"] = 'Sign=WXPay';
                    $APP["partnerid"] = self::$MchId;
                    $APP["prepayid"] = $result_info['prepay_id'];
                    $APP["timestamp"] = time();
                    $APP["sign"] = $this->getSign($APP);
                    return $APP;
                }
            }
        }
        return $result_info;
    }


    private $CallData = '';

    public function call($data)
    {
        $this->CallData = $data;
        return $this;
    }

    public function notify($func){
        if (!empty($this->CallData)) {
            $data = $this->arrays()->xml_to_array($this->CallData);
            $sign = $this->getSign($data);
            if ($sign == $data['sign'] && $data['result_code'] == "SUCCESS") {
                $func($data);
            }
        }
        $this->success();
    }

    public function success(){
        $success = '<xml>';
        $success .= '<return_code><![CDATA[SUCCESS]]></return_code>';
        $success .= '<return_msg><![CDATA[OK]]></return_msg>';
        $success .= '</xml>';
        exit($success);
    }

    private function isEmpty($data, $keys)
    {
        $status = 1;
        if (!isset($data) || empty($data)) {
            return -1;
        }
        foreach ($keys as $key => $val) {
            if (!isset($data[$val]) || empty($data[$val])) {
                $status = -1;
            }
        }
        return $status;
    }

    private function getClientIp()
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR_POUND'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR_POUND'];
        }else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if(isset($_SERVER['HTTP_REMOTE_HOST']) && filter_var(isset($_SERVER['HTTP_REMOTE_HOST']), FILTER_VALIDATE_IP)){
                return $_SERVER['HTTP_REMOTE_HOST'];
            }else{
                return $_SERVER['REMOTE_ADDR'];
            }
        }
    }

    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            if($k != 'sign'){
                $Parameters[$k] = $v;
            }
        }
        ksort($Parameters);
        $String = self::formatBizQueryParaMap($Parameters, false);
        $String = $String . "&key=" . self::$apiKey;
        $String = md5($String);
        $result_ = strtoupper($String);
        return $result_;
    }

    private function to_xml($values)
    {
        if (!is_array($values) || count($values) <= 0) {
            return -1;
        }
        $xml = "<xml>";
        foreach ($values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    private function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

}