<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradePay;
class Request{

    // https://opendocs.alipay.com/apis/api_1/alipay.trade.pay

    // 调用的接口版本
    protected $version="1.0";

    // 网关
    protected $method = "alipay.trade.pay";

    // 同步回调地址
    protected $return_url;

    // 异步回调地址
    protected $notify_url;

    // 请求参数的集合
    protected $biz_content;

    // 网关请求参数
    protected $gateway_params = array();

    public function get_method(){
        return $this->method;
    }

    public function get_version(){
        return $this->version;
    }

    public function get_gateway_params(){
        return $this->gateway_params;
    }

    public function notify_url($notify_url){
        $this->notify_url=$notify_url;
        $this->gateway_params['notify_url'] = $notify_url;
    }

    public function return_url($return_url){
        $this->return_url=$return_url;
        $this->gateway_params['return_url'] = $return_url;
    }

    public function biz_content($biz_content){
        $this->biz_content=$biz_content;
        $this->gateway_params['biz_content'] = $biz_content;
    }


}