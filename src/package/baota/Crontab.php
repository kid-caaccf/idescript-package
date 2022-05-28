<?php
/**
 * @auth guest
 * @time 2021-9-8 14:53
 * @description 创建
*/
namespace idescript\package\baota;
class Crontab{

    private $host;
    private $api_sk;
    private $request_time;
    private $request_token;

    public static function instance($host,$api_sk): Crontab{
        return new Crontab($host,$api_sk);
    }

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    public function __construct($host,$api_sk){
        $this->host = $host;
        $this->api_sk = $api_sk;
    }

    public function token(): Crontab{
        $api_sk = $this->api_sk;
        $request_time = time();
        $request_token = md5($request_time . '' . md5($api_sk));
        $this->request_time = $request_time;
        $this->request_token = $request_token;
        return $this;
    }

    // 获取任务列表
    public function get_to_do_list(){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                    'action'=>'GetCrontab',
                ]),
            'post'=>[
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取目录数据
    public function get_catalogue_data_detail($path,$disk,$showRow){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/files?'.http_build_query([
                'action'=>'GetDir',
            ]),
            'post'=>[
                'path'=>$path,
                'disk'=>$disk,
                'showRow'=>$showRow,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取网站目录
    public function get_website_catalogue_list(){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'GetDataList',
            ]),
            'post'=>[
                'type'=>'sites',
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取网站目录
    public function get_database_list(){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'GetDataList',
            ]),
            'post'=>[
                'type'=>'databases',
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取任务详情
    public function get_to_do_detail($id){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'get_crond_find',
            ]),
            'post'=>[
                'id'=>$id,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 停止/开始任务
    public function state_to_do($id){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'set_cron_status',
            ]),
            'post'=>[
                'id'=>$id,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 执行任务
    public function execute_to_do($id){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'StartTask',
            ]),
            'post'=>[
                'id'=>$id,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 删除任务
    public function remove_to_do($id){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'DelCrontab',
            ]),
            'post'=>[
                'id'=>$id,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 添加任务
    public function create_to_do($params){
        $paramsInfo = [
            'request_token'=>$this->request_token,
            'request_time'=>$this->request_time
        ];
        $paramsInfo = array_merge($paramsInfo,$params);
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'AddCrontab',
            ]),
            'post'=>$paramsInfo
        ])['result'],true);
    }

    // 修改任务
    public function update_to_do($params){
        $paramsInfo = [
            'request_token'=>$this->request_token,
            'request_time'=>$this->request_time
        ];
        $paramsInfo = array_merge($paramsInfo,$params);
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/crontab?'.http_build_query([
                'action'=>'modify_crond',
            ]),
            'post'=>$paramsInfo
        ])['result'],true);
    }

}
