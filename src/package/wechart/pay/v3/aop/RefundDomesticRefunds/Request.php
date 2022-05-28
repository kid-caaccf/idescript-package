<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart\pay\v3\aop\RefundDomesticRefunds;
class Request{

    // https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_4_9.shtml

    // 网关
    protected $uri = "https://api.mch.weixin.qq.com/v3/refund/domestic/refunds";

    // 请求参数
    protected $request_params = array();

    // 请求头
    protected $request_header = array();

    // 请求类型
    protected $http_method = 'POST';

    // 异步回调地址
    protected $notify_url;

    public function get_uri(){
        return $this->uri;
    }

    public function get_request_params(){
        return $this->request_params;
    }

    public function get_request_header(){
        return $this->request_header;
    }

    public function get_http_method(){
        return $this->http_method;
    }


    public function request_params($params){
        $this->request_params = array_merge($this->request_params,$params);
    }

    public function notify_url($notify_url){
        $this->notify_url=$notify_url;
        $this->request_params['notify_url'] = $notify_url;
    }


    public function request_header($header){
        $this->request_header = array_push($this->request_header,$header);
    }

    public function callback($query, \idescript\package\wechart\pay\v3\aop\AopClient $aop){
        return $query;
    }


}