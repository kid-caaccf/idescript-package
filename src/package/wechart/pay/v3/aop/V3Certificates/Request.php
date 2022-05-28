<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace package\wechart\pay\v3\aop\V3Certificates;
class Request{

    // 网关
    protected $uri = "https://api.mch.weixin.qq.com/v3/certificates";

    // 请求参数
    protected $request_params = array();

    // 请求头
    protected $request_header = array();

    // 请求类型
    protected $http_method = 'GET';


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

    public function request_header($header){
        $this->request_header = array_push($this->request_header,$header);
    }

    public function callback($query, \idescript\package\wechart\pay\v3\aop\AopClient $aop){
        $data = $query->data[0];
        $ciphertext = $data->encrypt_certificate;
        $plaintext = $aop->decrypt_AEAD_AES_256_GCM_To_String($ciphertext->associated_data,$ciphertext->nonce,$ciphertext->ciphertext);
        $data->certificates = $plaintext;
        return $data;
    }


}