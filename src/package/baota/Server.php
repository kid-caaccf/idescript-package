<?php
/**
 * @auth guest
 * @time 2021-9-8 14:53
 * @description 创建
 */
namespace idescript\package\baota;
class Server{

    private $host;
    private $api_sk;
    private $request_time;
    private $request_token;

    public static function instance($host,$api_sk): Server{
        return new Server($host,$api_sk);
    }

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    public function __construct($host,$api_sk){
        $this->host = $host;
        $this->api_sk = $api_sk;
    }

    public function token(): Server{
        $api_sk = $this->api_sk;
        $request_time = time();
        $request_token = md5($request_time . '' . md5($api_sk));
        $this->request_time = $request_time;
        $this->request_token = $request_token;
        return $this;
    }

    // 获取服务器信息
    public function get_server_info(){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/system?action=GetSystemTotal',
            'post'=>[
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取服务器磁盘信息
    public function get_server_disk_info(){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/system?action=GetDiskInfo',
            'post'=>[
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }


}
