<?php

namespace idescript\package\sms\yunpian;
use idescript\package\sms\impl;
class Request implements impl {

    // https://www.yunpian.com/official/document/sms/zh_CN/domestic_list

    protected $api_key;
    protected $header = [
        'Accept:application/json;charset=utf-8;',
        'Content-Type:application/x-www-form-urlencoded;charset=utf-8;'
    ];

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    public static function instance($data, ...$args):Request{
        return new Request($data, ...$args);
    }

    public function __construct($api_key, ...$args){
        $this->api_key = $api_key;
    }

    public function send($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sms/single_send.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function send_tpl($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sms/tpl_single_send.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function batch($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sms/batch_send.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function batch_tpl($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sms/tpl_batch_send.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function query($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sms/get_record.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function sign_add($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sign/add.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function sign_delete($data, ...$args){
        // TODO: Implement sign_delete() method.
    }

    public function sign_update($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sign/update.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function sign_query($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/sign/get.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function tpl_add($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/tpl/add.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function tpl_delete($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/tpl/del.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function tpl_update($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/tpl/update.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function tpl_query($data, ...$args){
        $data['apikey'] = $this->api_key;
        return json_decode($this->spiders()->spiders([
            'url'=>'https://sms.yunpian.com/v2/tpl/get.json',
            'header'=>$this->header,
            'post'=>http_build_query($data)
        ])['result']);
    }

    public function sign($data, ...$args)
    {
        // TODO: Implement sign() method.
    }

}