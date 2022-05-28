<?php
/**
 * @auth guest
 * @time 2021-9-6 10:14
 * @description 创建
 */
namespace idescript\package\wechart\pay\v3\aop\PayTransactionsH5;

class Content
{
    // https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_3_1.shtml

    protected $params = array();

    //商品描述
    protected $description;

    // 商户订单号
    protected $out_trade_no;

    // 交易结束时间
    protected $time_expire;

    // 附加数据
    protected $attach;

    // 订单优惠标记
    protected $goods_tag;

    // 订单金额
    protected $amount;

    // 优惠功能
    protected $detail;

    // 场景信息
    protected $scene_info;

    // 结算信息
    protected $settle_info;

    public function __construct(){

    }

    public function getParams()
    {
        return $this->params;
    }

    public function description($description){
        $this->description = $description;
        $this->params['description'] = $description;
    }

    public function out_trade_no($out_trade_no){
        $this->out_trade_no = $out_trade_no;
        $this->params['out_trade_no'] = $out_trade_no;
    }

    public function time_expire($time_expire){
        if(is_int($time_expire)){
            $time_expire = date('Y-m-d\TH:i:sP',$time_expire);
        }else{
            $time_expire = date('Y-m-d\TH:i:sP',strtotime($time_expire));
        }
        $this->time_expire = $time_expire;
        $this->params['time_expire'] = $time_expire;
    }

    public function attach($attach){
        $this->attach = $attach;
        $this->params['attach'] = $attach;
    }

    public function goods_tag($goods_tag){
        $this->goods_tag = $goods_tag;
        $this->params['goods_tag'] = $goods_tag;
    }

    public function amount(object $amount){
        $this->amount = $amount;
        $this->params['amount'] = $amount;
    }

    public function detail($detail){
        $this->detail = $detail;
        $this->params['detail'] = $detail;
    }

    public function scene_info($scene_info){
        $this->scene_info = $scene_info;
        $this->params['scene_info'] = $scene_info;
    }

    public function settle_info($settle_info){
        $this->settle_info = $settle_info;
        $this->params['settle_info'] = $settle_info;
    }


}