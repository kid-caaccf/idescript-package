<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradePay;
class Content
{
    // https://opendocs.alipay.com/apis/api_1/alipay.trade.pay

    private $biz_content_array = array();

    protected $out_trade_no;
    protected $scene;
    protected $auth_code;
    protected $product_code;
    protected $subject;
    protected $buyer_id;
    protected $seller_id;
    protected $total_amount;
    protected $trans_currency;
    protected $settle_currency;
    protected $discountable_amount;
    protected $body;
    protected $goods_detail;
    protected $operator_id;
    protected $store_id;
    protected $terminal_id;
    protected $extend_params;
    protected $timeout_express;
    protected $auth_no;
    protected $auth_confirm_mode;
    protected $terminal_params;
    protected $passback_params;
    protected $promo_params;
    protected $advance_payment_type;
    protected $query_options;
    protected $request_org_pid;
    protected $pay_params;
    protected $is_async_pay;

    public function __construct()
    {
        $this->biz_content_array['product_code'] = "FACE_TO_FACE_PAYMENT";
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

    public function total_amount($total_amount)
    {
        $this->total_amount = $total_amount;
        $this->biz_content_array['total_amount'] = $total_amount;
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

    public function scene($scene)
    {
        $this->scene = $scene;
        $this->biz_content_array['scene'] = $scene;
    }

    public function auth_code($auth_code)
    {
        $this->auth_code = $auth_code;
        $this->biz_content_array['auth_code'] = $auth_code;
    }

    public function buyer_id($buyer_id)
    {
        $this->buyer_id = $buyer_id;
        $this->biz_content_array['buyer_id'] = $buyer_id;
    }

    public function seller_id($seller_id)
    {
        $this->seller_id = $seller_id;
        $this->biz_content_array['seller_id'] = $seller_id;
    }

    public function trans_currency($trans_currency)
    {
        $this->trans_currency = $trans_currency;
        $this->biz_content_array['trans_currency'] = $trans_currency;
    }

    public function settle_currency($settle_currency)
    {
        $this->settle_currency = $settle_currency;
        $this->biz_content_array['settle_currency'] = $settle_currency;
    }

    public function discountable_amount($discountable_amount)
    {
        $this->discountable_amount = $discountable_amount;
        $this->biz_content_array['discountable_amount'] = $discountable_amount;
    }

    public function operator_id($operator_id)
    {
        $this->operator_id = $operator_id;
        $this->biz_content_array['operator_id'] = $operator_id;
    }

    public function terminal_id($terminal_id)
    {
        $this->terminal_id = $terminal_id;
        $this->biz_content_array['terminal_id'] = $terminal_id;
    }

    public function auth_no($auth_no)
    {
        $this->auth_no = $auth_no;
        $this->biz_content_array['auth_no'] = $auth_no;
    }

    public function auth_confirm_mode($auth_confirm_mode)
    {
        $this->auth_confirm_mode = $auth_confirm_mode;
        $this->biz_content_array['auth_confirm_mode'] = $auth_confirm_mode;
    }

    public function terminal_params($terminal_params)
    {
        $this->terminal_params = $terminal_params;
        $this->biz_content_array['terminal_params'] = $terminal_params;
    }

    public function advance_payment_type($advance_payment_type)
    {
        $this->advance_payment_type = $advance_payment_type;
        $this->biz_content_array['advance_payment_type'] = $advance_payment_type;
    }

    public function query_options($query_options)
    {
        $this->query_options = $query_options;
        $this->biz_content_array['query_options'] = $query_options;
    }

    public function request_org_pid($request_org_pid)
    {
        $this->request_org_pid = $request_org_pid;
        $this->biz_content_array['request_org_pid'] = $request_org_pid;
    }

    public function pay_params($pay_params)
    {
        $this->pay_params = $pay_params;
        $this->biz_content_array['pay_params'] = $pay_params;
    }

    public function is_async_pay($is_async_pay)
    {
        $this->is_async_pay = $is_async_pay;
        $this->biz_content_array['is_async_pay'] = $is_async_pay;
    }

}