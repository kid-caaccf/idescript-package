<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package\compress;
class Json{

    public static function instance(): Json{
        return new Json();
    }

    public function compress(array $data){
        if(empty($data)){
            return false;
        }
        $temp = [
            '_'=>[],
            '-'=>[]
        ];
        foreach ($data as $value){
            $tk=[];
            $td=[];
            foreach ($value as $k => $v){
                $tk[]=$k;
                if(is_array($v) && !empty($v) && isset($v[0])){
                    $td[] = $this->compress($v);
                }else{
                    $td[]=$v;
                }
            }
            if(count($tk) !== count($temp['_']) && !empty($temp['_'])){
                break;
            }
            $temp['_']=$tk;
            array_push($temp['-'],$td);
        }
        return $temp;
    }

    public function decompression(array $data){
        if(empty($data)){
            return false;
        }
        $arr = [];
        foreach ($data['-'] as $value){
            $temp=[];
            foreach ($value as $k => $v){
                if(is_array($v) && !empty($v) && isset($v['_']) && isset($v['-'])){
                    $temp[$data['_'][$k]] = $this->decompression($v);
                }else{
                    $temp[$data['_'][$k]]=$v;
                }
            }
            array_push($arr,$temp);
        }
        return $arr;
    }


}