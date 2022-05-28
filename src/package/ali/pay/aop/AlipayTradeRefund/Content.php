<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\ali\pay\aop\AlipayTradeRefund;
class Content
{
    // https://opendocs.alipay.com/apis/api_1/alipay.trade.refund

    private $biz_content_array = array();

    protected $out_trade_no;
    protected $trade_no;
    protected $refund_amount;
    protected $refund_currency;
    protected $refund_reason;
    protected $out_request_no;
    protected $operator_id;
    protected $store_id;
    protected $terminal_id;
    protected $goods_detail;
    protected $refund_royalty_parameters;
    protected $org_pid;
    protected $query_options;

    public function __construct()
    {

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

    public function out_trade_no($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        $this->biz_content_array['out_trade_no'] = $out_trade_no;
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

    public function query_options($query_options)
    {
        $this->query_options = $query_options;
        $this->biz_content_array['query_options'] = $query_options;
    }

    public function trade_no($trade_no)
    {
        $this->trade_no = $trade_no;
        $this->biz_content_array['trade_no'] = $trade_no;
    }

    public function refund_amount($refund_amount)
    {
        $this->refund_amount = $refund_amount;
        $this->biz_content_array['refund_amount'] = $refund_amount;
    }

    public function refund_currency($refund_currency)
    {
        $this->refund_currency = $refund_currency;
        $this->biz_content_array['refund_currency'] = $refund_currency;
    }

    public function refund_reason($refund_reason)
    {
        $this->refund_reason = $refund_reason;
        $this->biz_content_array['refund_reason'] = $refund_reason;
    }

    public function out_request_no($out_request_no)
    {
        $this->out_request_no = $out_request_no;
        $this->biz_content_array['out_request_no'] = $out_request_no;
    }

    public function refund_royalty_parameters($refund_royalty_parameters)
    {
        $this->refund_royalty_parameters = $refund_royalty_parameters;
        $this->biz_content_array['refund_royalty_parameters'] = $refund_royalty_parameters;
    }

    public function org_pid($org_pid)
    {
        $this->org_pid = $org_pid;
        $this->biz_content_array['org_pid'] = $org_pid;
    }

}