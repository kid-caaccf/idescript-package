<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart\pay\v3\aop\RefundDomesticRefunds;
class Content
{
    // https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_4_9.shtml

    protected $params = array();

    // 微信支付订单号
    protected $transaction_id;

    // 商户订单号
    protected $out_trade_no;

    // 商户退款单号
    protected $out_refund_no;

    // 退款原因
    protected $reason;

    // 退款资金来源
    protected $funds_account;

    // 金额信息
    protected $amount;

    // 退款商品
    protected $goods_detail;

    public function __construct(){

    }

    public function getParams()
    {
        return $this->params;
    }

    public function transaction_id($transaction_id){
        $this->transaction_id = $transaction_id;
        $this->params['transaction_id'] = $transaction_id;
    }

    public function out_trade_no($out_trade_no){
        $this->out_trade_no = $out_trade_no;
        $this->params['out_trade_no'] = $out_trade_no;
    }

    public function out_refund_no($out_refund_no){
        $this->out_refund_no = $out_refund_no;
        $this->params['out_refund_no'] = $out_refund_no;
    }

    public function reason($reason){
        $this->reason = $reason;
        $this->params['reason'] = $reason;
    }

    public function funds_account($funds_account){
        $this->funds_account = $funds_account;
        $this->params['funds_account'] = $funds_account;
    }

    public function amount(object $amount){
        $this->amount = $amount;
        $this->params['amount'] = $amount;
    }

    public function goods_detail($goods_detail){
        $this->goods_detail = $goods_detail;
        $this->params['goods_detail'] = $goods_detail;
    }



}