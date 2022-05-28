<?php
/**
 * @auth guest
 * @time 2021-9-8 15:00
 * @description 创建
*/
namespace idescript\package\transfer;
class Request{

    public static function instance(): Request{
        return new Request();
    }

    // :获取客户端真实IP
    public function client_ip(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR_POUND'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR_POUND'];
        }else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if(isset($_SERVER['HTTP_REMOTE_HOST']) && filter_var(isset($_SERVER['HTTP_REMOTE_HOST']), FILTER_VALIDATE_IP)){
                return $_SERVER['HTTP_REMOTE_HOST'];
            }else{
                return $_SERVER['REMOTE_ADDR'];
            }
        }
    }

    // :获取当前协议+域名
    public function host(): string{
        $http_type = ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")) ? "https://" :"http://";
        return $http_type.$_SERVER['HTTP_HOST'];
    }

    // :获取当前请求协议
    public function protocol(): string{
        return ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")) ? "https://" :"http://";
    }

}