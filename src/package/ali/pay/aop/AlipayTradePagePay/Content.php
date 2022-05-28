<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradePagePay;
class Content
{
    // https://opendocs.alipay.com/apis/api_1/alipay.trade.page.pay

    private $biz_content_array = array();

    protected $out_trade_no;
    protected $product_code;
    protected $total_amount;
    protected $subject;
    protected $body;
    protected $time_expire;
    protected $goods_detail;
    protected $passback_params;
    protected $extend_params;
    protected $goods_type;
    protected $timeout_express;
    protected $promo_params;
    protected $royalty_info;
    protected $sub_merchant;
    protected $merchant_order_no;
    protected $enable_pay_channels;
    protected $store_id;
    protected $disable_pay_channels;
    protected $qr_pay_mode;
    protected $qrcode_width;
    protected $settle_info;
    protected $invoice_info;
    protected $agreement_sign_params;
    protected $integration_type;
    protected $request_from_url;
    protected $business_params;
    protected $ext_user_info;

    public function __construct()
    {
        $this->biz_content_array['product_code'] = "FAST_INSTANT_TRADE_PAY";
    }

    public function get_biz_content()
    {
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

    public function royalty_info($royalty_info)
    {
        $this->royalty_info = $royalty_info;
        $this->biz_content_array['royalty_info'] = $royalty_info;
    }

    public function sub_merchant($sub_merchant)
    {
        $this->sub_merchant = $sub_merchant;
        $this->biz_content_array['sub_merchant'] = $sub_merchant;
    }

    public function qr_pay_mode($qr_pay_mode)
    {
        $this->qr_pay_mode = $qr_pay_mode;
        $this->biz_content_array['qr_pay_mode'] = $qr_pay_mode;
    }

    public function qrcode_width($qrcode_width)
    {
        $this->qrcode_width = $qrcode_width;
        $this->biz_content_array['qrcode_width'] = $qrcode_width;
    }

    public function settle_info($settle_info)
    {
        $this->settle_info = $settle_info;
        $this->biz_content_array['settle_info'] = $settle_info;
    }

    public function invoice_info($invoice_info)
    {
        $this->invoice_info = $invoice_info;
        $this->biz_content_array['invoice_info'] = $invoice_info;
    }

    public function agreement_sign_params($agreement_sign_params)
    {
        $this->agreement_sign_params = $agreement_sign_params;
        $this->biz_content_array['agreement_sign_params'] = $agreement_sign_params;
    }

    public function integration_type($integration_type)
    {
        $this->integration_type = $integration_type;
        $this->biz_content_array['integration_type'] = $integration_type;
    }

    public function request_from_url($request_from_url)
    {
        $this->request_from_url = $request_from_url;
        $this->biz_content_array['request_from_url'] = $request_from_url;
    }

    public function business_params($business_params)
    {
        $this->business_params = $business_params;
        $this->biz_content_array['business_params'] = $business_params;
    }


}