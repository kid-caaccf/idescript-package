<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop;
class AopClient{

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    //支付宝网关地址
    protected $gateway_url = "https://openapi.alipay.com/gateway.do";

    protected $system_params = array();

    //应用id
    protected $app_id;

    //支付宝公钥
    protected $ali_public_key;

    // 支付宝应用公钥
    protected $ali_apply_public_key;

    // 支付宝应用私钥
    protected $ali_apply_private_key;

    //返回数据格式
    protected $format = "json";

    // 编码格式
    protected $charset = "utf-8";

    //签名方式
    protected $sign_type = "RSA2";

    // 发送请求的时间
    protected $timestamp;

    // 请求参数
    protected $request_params = array();

    function __construct(){
        $this->system_params = [
            'format'=>$this->format,
            'charset'=>$this->charset,
            'sign_type'=>$this->sign_type,
            'timestamp'=>$this->timestamp
        ];
    }

    public function appid($app_id){
        $this->app_id = $app_id;
        $this->system_params['app_id'] = $app_id;
    }

    public function ali_apply_private_key($ali_apply_private_key){
        $this->ali_apply_private_key = $ali_apply_private_key;
    }

    public function ali_apply_public_key($ali_apply_public_key){
        $this->ali_apply_public_key = $ali_apply_public_key;
    }

    public function ali_public_key($ali_public_key){
        $this->ali_public_key = $ali_public_key;
    }

    public function build_request_params($request){
        $this->timestamp = date("Y-m-d H:i:s");
        $this->system_params['timestamp'] = $this->timestamp;
        $this->system_params['method'] = $request->get_method();
        $this->system_params['version'] = $request->get_version();
        $params = array_merge($this->system_params,$request->get_gateway_params());
        $params['sign'] = $this->sign($this->ascii_str($params));
        $this->request_params = $params;
        return $this;
    }

    public function form() {
        $para_temp = $this->request_params;
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway_url."?charset=".trim($this->charset)."' method='POST'>";
        foreach ($para_temp as $key => $value){
            $value = str_replace("'","&apos;",$value);
            $sHtml.= "<input type='hidden' name='".$key."' value='".$value."'/>";
        }
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    public function request($method = 'POST',$config=[]){
        $url = $this->gateway_url;
        $params = $this->unlEncodeArray($this->request_params);
        if($method === 'POST'){
            $spiders_params = [
                'url' =>$url,
                'post'=>$params
            ];
        }else{
            $spiders_params = [
                'url' =>"$url?$params",
            ];
        }
        return $this->spiders()->spiders($spiders_params);
    }

    private function unlEncodeArray($para_token){
        $url = "";
        foreach ($para_token as $key => $value) {
            $url .= $key . "=" . urlencode($value) . "&";
        }
        return $url;
    }

    private function ascii_str($params){
        $p = ksort($params);
        if ($p) {
            return urldecode(http_build_query($params));
        }
        return '';
    }

    // RSA2 签名
    private function sign($str){
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            $this->ali_apply_private_key .
            "\n-----END RSA PRIVATE KEY-----";
        $key = openssl_get_privatekey($privateKey);
        openssl_sign($str, $signature, $key, "SHA256");
        openssl_free_key($key);
        return base64_encode($signature);
    }

    // 验证 RSA2 签名
    private function verify_sign($content, $sign){
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
            $this->ali_public_key .
            "\n-----END PUBLIC KEY-----";
        $key = openssl_get_publickey($publicKey);
        return openssl_verify($content, base64_decode($sign), $key, 'SHA256');
    }

    // 支付宝回调验证
    public function notify($func){
       try{
           $response_body = file_get_contents("php://input");
           parse_str($response_body,$query_arr);
           $sign_true = $query_arr['sign'];
           unset($query_arr['sign']);
           unset($query_arr['sign_type']);
           $sign_str = $this->ascii_str($query_arr);
           $status = $this->verify_sign($sign_str,$sign_true);
           if($status === 0){
               return false;
           }
           return $func($query_arr);
       }catch (\Exception $err){
           return false;
       }
    }





}