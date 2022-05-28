<?php
/**
 * @auth guest
 * @time 2021-9-8 14:53
 * @description 创建
 */
namespace idescript\package\baota;
class Site{

    private $host;
    private $api_sk;
    private $request_time;
    private $request_token;

    public static function instance($host,$api_sk): Site{
        return new Site($host,$api_sk);
    }

    private function spiders(){
        return new \idescript\package\Spiders();
    }

    public function __construct($host,$api_sk){
        $this->host = $host;
        $this->api_sk = $api_sk;
    }

    public function token(): Site{
        $api_sk = $this->api_sk;
        $request_time = time();
        $request_token = md5($request_time . '' . md5($api_sk));
        $this->request_time = $request_time;
        $this->request_token = $request_token;
        return $this;
    }

    // 获取站点列表
    public function get_site_list($config = [
        'search' => '',
        'limit' => 100,
        'p' => 1,
    ]){
        $p          = $config['p'] ?? 1;
        $limit      = $config['limit'] ?? 100;
        $search     = $config['search'] ?? '';
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/data?action=getData',
            'post'=>[
                'table' => 'sites',
                'type' => -1,
                'p' => $p,
                'limit' => $limit,
                'search' => $search,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 获取指定网站信息
    public function get_site($domain='',$config=[]){
        $siteAll = $this->get_site_list($config);
        $site = [];
        foreach ($siteAll['data'] as $key => $value){
            if($value['name'] === $domain){
                $site = $value;
                break;
            }
        }
        return $site;
    }

    // 在指定网站添加域名
    public function add_domain($main_domain_data,$new_domain){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/site?action=AddDomain',
            'post'=>[
                'domain' => $new_domain,
                'webname' => $main_domain_data['name'],
                'id' => $main_domain_data['id'],
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }

    // 在指定网站删除域名
    public function remove_domain($main_domain_data,$remove_domain,$port=80){
        return json_decode($this->spiders()->spiders([
            'url' => $this->host . '/site?action=DelDomain',
            'post'=>[
                'id' => $main_domain_data['id'],
                'webname' => $main_domain_data['name'],
                'domain' => $remove_domain,
                'port'=>$port,
                'request_token'=>$this->request_token,
                'request_time'=>$this->request_time
            ]
        ])['result'],true);
    }
}
