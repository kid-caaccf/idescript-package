<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradeAppPay;
class Content
{
    // https://opendocs.alipay.com/apis/api_1/alipay.trade.app.pay

    private $biz_content_array = array();

    protected $timeout_express;
    protected $total_amount;
    protected $product_code;
    protected $body;
    protected $subject;
    protected $out_trade_no;
    protected $time_expire;
    protected $goods_type;
    protected $promo_params;
    protected $passback_params;
    protected $extend_params;
    protected $merchant_order_no;
    protected $enable_pay_channels;
    protected $store_id;
    protected $specified_channel;
    protected $disable_pay_channels;
    protected $goods_detail;
    protected $ext_user_info;
    protected $agreement_sign_params;

    public function __construct()
    {
        $this->biz_content_array['product_code'] = "FAST_INSTANT_TRADE_PAY";
    }

    public function get_biz_content(){
        $content = '';
        if (!empty($this->biz_content_array)) {
            $content = json_encode($this->biz_content_array, JSON_UNESCAPED_UNICODE);
        }
        return $content;
    }

    public function get_biz_content_array(){
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

    public function goods_type($goods_type)
    {
        $this->goods_type = $goods_type;
        $this->biz_content_array['goods_type'] = $goods_type;
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

    public function ext_user_info($ext_user_info)
    {
        $this->ext_user_info = $ext_user_info;
        $this->biz_content_array['ext_user_info'] = $ext_user_info;
    }

    public function agreement_sign_params($agreement_sign_params)
    {
        $this->agreement_sign_params = $agreement_sign_params;
        $this->biz_content_array['agreement_sign_params'] = $agreement_sign_params;
    }

    public function specified_channel($specified_channel)
    {
        $this->specified_channel = $specified_channel;
        $this->biz_content_array['specified_channel'] = $specified_channel;
    }


}