<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package\sms;
interface impl{

    public function __construct($data,...$args);

    public static function instance($data, ...$args);

    // 单条短信发送
    public function send($data,...$args);
    // 指定模板单条短信发送
    public function send_tpl($data,...$args);

    // 批量短信发送
    public function batch($data,...$args);
    // 指定模板批量短信发送
    public function batch_tpl($data,...$args);

    // 查询发送记录
    public function query($data,...$args);

    // 添加签名
    public function sign_add($data,...$args);
    // 删除签名
    public function sign_delete($data,...$args);
    // 修改签名
    public function sign_update($data,...$args);
    // 查询签名
    public function sign_query($data,...$args);

    // 添加模板
    public function tpl_add($data,...$args);
    // 删除模板
    public function tpl_delete($data,...$args);
    // 修改模板
    public function tpl_update($data,...$args);
    // 查询模板
    public function tpl_query($data,...$args);

    // 签名构造函数
    public function sign($data,...$args);

}