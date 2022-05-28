<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradeWapPay;
class Content
{
    // https://opendocs.alipay.com/apis/api_1/alipay.trade.wap.pay

    private $biz_content_array = array();

    protected $body;
    protected $subject;
    protected $out_trade_no;
    protected $timeout_express;
    protected $time_expire;
    protected $total_amount;
    protected $auth_token;
    protected $goods_type;
    protected $quit_url;
    protected $passback_params;
    protected $product_code;
    protected $promo_params;
    protected $extend_params;
    protected $merchant_order_no;
    protected $enable_pay_channels;
    protected $disable_pay_channels;
    protected $store_id;
    protected $goods_detail;
    protected $specified_channel;
    protected $ext_user_info;

    public function __construct()
    {
        $this->biz_content_array['product_code'] = "QUICK_WAP_WAY";
    }

    public function get_biz_content()
    {
        $content = '';
        if (!empty($this->biz_content_array)) {
            $content = json_encode($this->biz_content_array, JSON_UNESCAPED_UNICODE);
        }
        return $content;
    }

    public function get_biz_content_array()
    {
        return $this->biz_content_array;
    }

    public function body($body)
    {
        $this->body = $body;
        $this->biz_content_array['body'] = $body;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        $this->biz_content_array['subject'] = $subject;
    }

    public function out_trade_no($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        $this->biz_content_array['out_trade_no'] = $out_trade_no;
    }

    public function timeout_express($timeout_express)
    {
        $this->timeout_express = $timeout_express;
        $this->biz_content_array['timeout_express'] = $timeout_express;
    }

    public function time_expire($time_expire)
    {
        $this->time_expire = $time_expire;
        $this->biz_content_array['time_expire'] = $time_expire;
    }

    public function total_amount($total_amount)
    {
        $this->total_amount = $total_amount;
        $this->biz_content_array['total_amount'] = $total_amount;
    }

    public function auth_token($auth_token)
    {
        $this->auth_token = $auth_token;
        $this->biz_content_array['auth_token'] = $auth_token;
    }

    public function goods_type($goods_type)
    {
        $this->goods_type = $goods_type;
        $this->biz_content_array['goods_type'] = $goods_type;
    }

    public function quit_url($quit_url)
    {
        $this->quit_url = $quit_url;
        $this->biz_content_array['quit_url'] = $quit_url;
    }

    public function passback_params($passback_params)
    {
        $this->passback_params = $passback_params;
        $this->biz_content_array['passback_params'] = $passback_params;
    }

    public function product_code($product_code)
    {
        $this->product_code = $product_code;
        $this->biz_content_array['product_code'] = $product_code;
    }

    public function promo_params($promo_params)
    {
        $this->promo_params = $promo_params;
        $this->biz_content_array['promo_params'] = $promo_params;
    }

    public function extend_params($extend_params)
    {
        $this->extend_params = $extend_params;
        $this->biz_content_array['extend_params'] = $extend_params;
    }

    public function merchant_order_no($merchant_order_no)
    {
        $this->merchant_order_no = $merchant_order_no;
        $this->biz_content_array['merchant_order_no'] = $merchant_order_no;
    }

    public function enable_pay_channels($enable_pay_channels)
    {
        $this->enable_pay_channels = $enable_pay_channels;
        $this->biz_content_array['enable_pay_channels'] = $enable_pay_channels;
    }

    public function disable_pay_channels($disable_pay_channels)
    {
        $this->disable_pay_channels = $disable_pay_channels;
        $this->biz_content_array['disable_pay_channels'] = $disable_pay_channels;
    }

    public function store_id($store_id)
    {
        $this->store_id = $store_id;
        $this->biz_content_array['store_id'] = $store_id;
    }

    public function goods_detail($goods_detail)
    {
        $this->goods_detail = $goods_detail;
        $this->biz_content_array['goods_detail'] = $goods_detail;
    }

    public function specified_channel($specified_channel)
    {
        $this->specified_channel = $specified_channel;
        $this->biz_content_array['specified_channel'] = $specified_channel;
    }

    public function ext_user_info($ext_user_info)
    {
        $this->ext_user_info = $ext_user_info;
        $this->biz_content_array['ext_user_info'] = $ext_user_info;
    }

}