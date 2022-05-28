<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart\pay\v3\aop;
class AopClient{

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    // APIv3密钥
    protected $api_v3_private_key;

    // 微信支付平台证书
    protected $platform_cert;

    // 微信支付平台证书序列号
    protected $platform_cert_serial_number;

    const AUTH_TAG_LENGTH_BYTE = 16;

    //应用id
    protected $appid;

    // 直连商户号
    protected $mchid;

    // 请求地址
    protected $uri;

    // 请求参数合集
    protected $params = array();

    // 请求头合集
    protected $request_header = array(
        'Content-Type:application/json; charset=UTF-8'
    );

    // 请求类型
    protected $http_method;

    // 请求的时间
    protected $timestamp;

    // 商户证书密钥
    protected $mch_private_key;

    // 商户证书编号
    protected $serial_no;

    // 当前请求类
    protected $request;

    // 在请求体中需要移除的参数
    protected $exclude_params = array();

    function __construct(){

    }

    public function api_v3_private_key($api_v3_private_key){
        $this->api_v3_private_key = $api_v3_private_key;
    }

    public function platform_cert_serial_number($platform_cert_serial_number){
        $this->platform_cert_serial_number = $platform_cert_serial_number;
    }

    public function platform_cert($platform_cert){
        $this->platform_cert = $platform_cert;
    }

    public function build_request_params($request){
        $this->timestamp = time();
        $this->request = $request;
        $this->uri = $request->get_uri();
        $this->http_method = $request->get_http_method();
        $this->params = array_merge($this->params, $request->get_request_params());

        foreach ($this->params as $key => $value){
            foreach ($this->exclude_params as $k => $v){
                if($v === $key){
                    unset($this->params[$key]);
                }
            }
        }
        $this->request_header = array_merge($this->request_header,$request->get_request_header());
        $sign = $this->sign();
        array_push($this->request_header,$sign);
        return $this;
    }

    public function request(){
        $spiders_params = [
            'url' => $this->uri,
            'header' => $this->request_header
        ];
        if ($this->http_method === 'POST' || $this->http_method === 'post') {
            $params = json_encode($this->params,JSON_UNESCAPED_UNICODE);
            $spiders_params['post'] = $params;
        } else {
            $params = $this->unlEncodeArray($this->params);
            $spiders_params['url'] = $spiders_params['url'] . "?$params";
        }
        $data = json_decode($this->spiders()->spiders($spiders_params)['result']);
        if(method_exists($this->request,'callback')){
            $data = $this->request->callback($data,$this);
        }
        return $data;
    }

    public function exclude_params(array $exclude_params){
        $this->exclude_params = $exclude_params;
    }

    private function unlEncodeArray($para_token){
        $url = "";
        foreach ($para_token as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
            $url .= $key . "=" . urlencode($value) . "&";
        }
        return $url;
    }

    private function sign(){
        $url_parts = parse_url($this->uri);
        $canonical_url = ($url_parts['path'] . (!empty($url_parts['query']) ?"?${url_parts['query']}" :""));
        $timestamp = $this->timestamp;
        $nonce = $this->getRandChar(32);
        $message = $this->http_method . "\n";
        $message .= $canonical_url . "\n";
        $message .= $timestamp . "\n";
        $message .= $nonce . "\n";
        if(strtoupper($this->http_method ) !== 'GET'){
            $message .= json_encode($this->params,JSON_UNESCAPED_UNICODE) . "\n";
        }else{
            $message .= "" . "\n";
        }
        openssl_sign($message, $raw_sign, $this->mch_private_key, 'sha256WithRSAEncryption');
        $sign = base64_encode($raw_sign);
        $schema = 'Authorization: WECHATPAY2-SHA256-RSA2048';
        $token = sprintf('mchid="%s",serial_no="%s",nonce_str="%s",timestamp="%d",signature="%s"', $this->mchid, $this->serial_no, $nonce, $timestamp,$sign);
        return $schema.' '.$token;
    }

    public function appid($app_id){
        $this->appid = $app_id;
        $this->params['appid'] = $app_id;
    }

    public function get_appid(){
        return $this->appid;
    }

    public function mchid($mchid){
        $this->mchid = $mchid;
        $this->params['mchid'] = $mchid;
    }

    public function get_mchid(){
        return $this->mchid;
    }

    public function mch_private_key($mch_private_key){
        $this->mch_private_key = $mch_private_key;
    }

    public function get_mch_private_key(){
       return $this->mch_private_key;
    }

    public function serial_no($serial_no){
        $this->serial_no = $serial_no;
    }

    public function get_serial_no($serial_no){
        return $this->serial_no;
    }

    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

    // 生成 sha256WithRSA 签名
    public function RsaEncrypt($str, $pri_key){
        $key = openssl_get_privatekey($pri_key);
        openssl_sign($str, $signature, $key, "SHA256");
        openssl_free_key($key);
        return base64_encode($signature);
    }

    // 验证 sha256WithRSA 签名
    public function RsaDecrypt($content, $sign, $publicKey){
        $key = openssl_get_publickey($publicKey);
        return openssl_verify($content, base64_decode($sign), $key, 'SHA256');
    }

    // 生成 待签名字符串
    public function toSignStr(array $params){
        $str = '';
        foreach ($params as $key=>$value){
            $str.= $value."\n";
        }
        return $str;
    }

    // AEAD_AES_256_GCM  解密
    public function decrypt_AEAD_AES_256_GCM_To_String($associatedData, $nonceStr, $ciphertext){
        $ciphertext = \base64_decode($ciphertext);
        if (strlen($ciphertext) <= self::AUTH_TAG_LENGTH_BYTE) {
            return false;
        }

        // ext-sodium (default installed on >= PHP 7.2)
        if (function_exists('\sodium_crypto_aead_aes256gcm_is_available') &&
            \sodium_crypto_aead_aes256gcm_is_available()) {
            return \sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $associatedData, $nonceStr, $this->api_v3_private_key);
        }

        // ext-libsodium (need install libsodium-php 1.x via pecl)
        if (function_exists('\Sodium\crypto_aead_aes256gcm_is_available') &&
            \Sodium\crypto_aead_aes256gcm_is_available()) {
            return \Sodium\crypto_aead_aes256gcm_decrypt($ciphertext, $associatedData, $nonceStr, $this->api_v3_private_key);
        }

        // openssl (PHP >= 7.1 support AEAD)
        if (PHP_VERSION_ID >= 70100 && in_array('aes-256-gcm', \openssl_get_cipher_methods())) {
            $ctext = substr($ciphertext, 0, -self::AUTH_TAG_LENGTH_BYTE);
            $authTag = substr($ciphertext, -self::AUTH_TAG_LENGTH_BYTE);

            return \openssl_decrypt($ctext, 'aes-256-gcm', $this->api_v3_private_key, \OPENSSL_RAW_DATA, $nonceStr,
                $authTag, $associatedData);
        }

        return false;
    }

    // 微信回调验证
    public function notify($func){
        $response_body = file_get_contents("php://input");
        $response_body_array = json_decode($response_body,true);
        $response_headers = array();
        foreach ($_SERVER as $key => $value) {
            if ('HTTP_' == substr($key, 0, 5)) {
                $response_headers[(strtolower(str_replace('_', '-', substr($key, 5))))] = $value;
            }
        }
        if($response_headers['wechatpay-serial'] !== $this->platform_cert_serial_number){
            return false;
        }
        $plaintext = $this->decrypt_AEAD_AES_256_GCM_To_String($response_body_array['resource']['associated_data'],$response_body_array['resource']['nonce'],$response_body_array['resource']['ciphertext']);
        if(!$plaintext){
            return false;
        }
        $plaintext = json_decode($plaintext,true);
        $sign_arr = [
            'wechatpay-timestamp'=>$response_headers['wechatpay-timestamp'],
            'wechatpay-nonce'=>$response_headers['wechatpay-nonce'],
            'content'=>$response_body
        ];
        $sign = $this->toSignStr($sign_arr);
        $status = $this->RsaDecrypt($sign,$response_headers['wechatpay-signature'],$this->platform_cert);
        if($status === 0){
            return false;
        }
        return $func($plaintext);
    }


}