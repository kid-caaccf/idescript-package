<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradeRefund;
class Request{

    // https://opendocs.alipay.com/apis/api_1/alipay.trade.refund

    // 调用的接口版本
    protected $version="1.0";

    // 网关
    protected $method = "alipay.trade.refund";

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

    public function biz_content($biz_content){
        $this->biz_content=$biz_content;
        $this->gateway_params['biz_content'] = $biz_content;
    }



}