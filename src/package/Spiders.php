<?php
/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 2021/7/19
 * Time: 6:53
 */
namespace idescript\package;
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 更新到最新版本
 */
/**
 * @auth guest
 * @time 2022-5-28 16:18
 * @description 修复一些bug，使其更加动态化
 */
class Spiders{

    protected $user_agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.25 Safari/537.36 Core/1.70.3676.400 QQBrowser/10.4.3505.400';

    public static function instance(): Spiders{
        return new Spiders();
    }

    public function spiders($data){

        $url                = !isset($data['url'])              ? die("未设置请求地址")       : $data['url'];
        $header             = !isset($data['header'])           ? []                        : $data['header'];
        $cookie             = !isset($data['cookie'])           ? ""                        : $data['cookie'];
        $time_out           = !isset($data['time_out'])         ? 60                        : $data['time_out'];
        $ua                 = !isset($data['user_agent'])       ? $this->user_agent         : $data['user_agent'];
        $post               = !isset($data['post'])             ? ""                        : $data['post'];                            // 需要post提交时的Post提交的数据
        $port               = !isset($data['port'])             ? ""                        : $data['port'];                            // 指定端口
        $referer            = !isset($data['referer'])          ? ""                        : $data['referer'];                         // 伪装的页面来源地址
        $decode             = !isset($data['decode'])           ? ""                        : $data['decode'];                          // 是否需整理数据源编码
        $follow_action      = !isset($data['follow_action'])    ? 1                         : $data['follow_action'];                          // 是否需整理数据源编码
        $other              = !isset($data['other'])            ? []                        : $data['other'];                           // 伪装的页面来源地址

        $return_body        = !isset($data['return_body'])      || $data['return_body'];                                              // 是否需要返回Cookie
        $last_uri           = isset($data['last_uri'])          && $data['last_uri'];                                                   // 是否读取最后跳转地址
        $nobody             = isset($data['nobody'])            && $data['nobody'];                                                     // 是否需要返回Cookie
        $return_cookie      = isset($data['return_cookie'])     && $data['return_cookie'];                                              // 是否需要返回Cookie
        $return_header      = isset($data['return_header'])     && $data['return_header'];                                              // 是否需要返回Cookie
        $content = [];
        $curl_array = [
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_FOLLOWLOCATION  => $follow_action,
            CURLOPT_SSL_VERIFYPEER  => 0,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_TIMEOUT         => $time_out,
            CURLOPT_COOKIE          => $cookie,
            CURLOPT_USERAGENT       => $ua,
        ];
        if (!empty($post)){
            $curl_array[CURLOPT_POST]=1;
            $curl_array[CURLOPT_POSTFIELDS]=$post;
        }

        if (!empty($port)){
            $curl_array[CURLOPT_PORT]=$port;
        }

        if (!empty($referer)){
            $curl_array[CURLOPT_REFERER]=$referer;
        }

        if ($nobody){
            $curl_array[CURLOPT_NOBODY]=1;
            $content['warning']['nobody']="当前 nobody=true 配置将无法捕获302从定向的信息";
        }

        if ($return_cookie || $return_header){
            $curl_array[CURLOPT_HEADER]=1;
        }

        if(!empty($other)){
            $curl_array = array_merge($curl_array,$other);
        }
        if(!$return_body){
            $content['warning']['return_body']="当前 return_body=false 配置将不保存 curl_exec 返回的 body 数据。";
        }

        $curl = curl_init();
        curl_setopt_array($curl,$curl_array);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }


        $result = curl_exec($curl);
        if($last_uri){
            $content['last_uri']=curl_getinfo($curl, CURLINFO_EFFECTIVE_URL); //获取跳转后真实地址;
        }
        if(!empty($decode)){
            $encode = mb_detect_encoding($result, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5"));
            $result = mb_convert_encoding($result, $decode, $encode);
        }

        // 如需读取返回的header 或返回 header
        if($return_cookie || $return_header){
            $result_arr = explode("\r\n\r\n", $result);
            $header = $result_arr[count($result_arr)-2];
            $body = $result_arr[count($result_arr)-1];
            if(count($result_arr) > 2){
                $content['warning']['return_*'] = "当前 return_*=true 配置的下的请求可能经过了302跳转,存在多个Response Header,仅格式化最后一次的header—arr,Cookie则将自动合并，完整内容在header-str中显示";
                $header = $result;
            }
            if($return_cookie){
                preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
                $content['cookie']   = [
                    'str'=>implode(";", $matches[1]),
                    'array'=>$matches[1],
                ];
            }
            if($return_header){
                $header_str = explode("\r\n", $header);
                $header_array = [];
                foreach ($header_str as $value){
                    if(!strstr($value,'HTTP/')){
                        $temp = explode(": ",$value);
                        if(count($temp) === 2){
                            $header_array[$temp[0]] = $temp[1];
                        }
                    }
                }
                $content['header']=[
                    'str'=>$header,
                    'array'=>$header_array
                ];
            }
            if($return_body){
                $content['result'] = $body;
            }
        }else{
            if($return_body){
                $content['result']=$result;
            }
        }
        curl_close($curl);
        return $content;
    }

}