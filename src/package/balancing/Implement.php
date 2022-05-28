<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
*/
namespace idescript\package\balancing;
class Implement{

    public static function instance(): Implement{
        return new Implement();
    }

    // 平滑加权轮询算法(smooth weighted round-robin balancing) 请求指定次数
    public function swrrb(array $config, int $appoint){
        $all_weight = array_sum(array_column($config,'weight')); // 所有权重总和
        if ($appoint > $all_weight) { // 如果取的次数大于权重总和
            $appoint = $appoint % $all_weight;
        }
        $max_index = 0;
        $back = [];
        for ($i = 1; $i <= $all_weight; $i++) {
            foreach ($config as $key => $value) {
                if(!isset($value['_'])){
                    $config[$key]['_'] = 0;
                }
                $config[$key]['_'] += $config[$key]['weight'];
                if ($config[$key]['_'] > $config[$max_index]['_']) {
                    $max_index = $key;
                }
            }
            $config[$max_index]['_'] -= $all_weight;
            if ($i === $appoint) {
                $back = $config[$max_index];
                break;
            }
        }
        return $back;
    }

    // 平滑加权轮询算法(smooth weighted round-robin balancing) 循环组
    public function swrrb_aloop(array $config){
        $all_weight = array_sum(array_column($config,'weight')); // 所有权重总和
        $max_index = 0;
        $back = [];
        for ($i = 1; $i <= $all_weight; $i++) {
            foreach ($config as $key => $value) {
                if(!isset($value['_'])){
                    $config[$key]['_'] = 0;
                }
                $config[$key]['_'] += $config[$key]['weight'];
                if ($config[$key]['_'] > $config[$max_index]['_']) {
                    $max_index = $key;
                }
            }
            $config[$max_index]['_'] -= $all_weight;
            array_push($back,$config[$max_index]);
        }
        return $back;
    }

}