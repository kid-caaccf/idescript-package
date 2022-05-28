<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
/**
 * @auth guest
 * @time 2021-9-9 11:16
 * @description 删除 sort,two_array_sort,isEmpty,goEmpty 方法;
 * @description 新增 sort_live,assoc_unique,field_exists,fs_recursion_child,fs_recursion_parent,xml_to_array方法;
 */
namespace idescript\package;
class Arrays{

    public static function instance(): Arrays{
        return new Arrays();
    }

    // 将二维 父子关系型 无限级 数据排列成有序二维数组
    public function sort_live($date,$field,$pid=0 ,$level = 0){
        static $arr = array();
        foreach ($date as $k => $v){
            if($v[$field] == $pid){
                $v['level'] = $level;
                $arr[] = $v;
                $this->sort_live($date ,$field, $v['id'] , $level+1);
            }
        }
        return $arr;
    }

    // 二维数组去重
    public function assoc_unique($arr, $key) {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        return $arr;
    }

    // 检查一维数组指定字符串下标 成员 是否 存在
    public function field_exists($data,$keys): bool{
        if(empty($data)){
            return false;
        }
        $status = true;
        foreach ($keys as $val){
            if(!isset($data[$val])){
                $status = false;
                break;
            }
        }
        return $status;
    }

    // 通过父子关系字段($parent_field,$child_field),
    // 递归数组中 $parent_field = $first_find_parent_value 的所有子级数据集
    // 返回集合。
    public function fs_recursion_child(array $data,$parent_value, string $parent_field='pid',string $child_field='id',$level=-1){
        $arr = array();
        $level++;
        foreach ($data as $v) {
            if ($v[$parent_field] == $parent_value) {
                $v['level']=$level;
                array_push($arr,$v);
                $arr = array_merge($arr, $this->fs_recursion_child($data, $v[$child_field],$parent_field, $child_field,$level));
            }
        }
        return $arr;
    }

    // 通过父子关系字段($parent_field,$child_field),
    // 递归数组中 $child_field = $first_find_parent_value 的所有父级数据集
    // 返回集合。
    public function fs_recursion_parent(array $data,$child_value, string $parent_field='pid',string $child_field='id',$level=-1){
        $arr = array();
        $level++;
        foreach ($data as $v) {
            if ($v[$child_field] === $child_value) {
                $v['level']=$level;
                array_push($arr,$v);
                $arr = array_merge($arr, $this->fs_recursion_parent($data, $v[$parent_field],$parent_field,$child_field,$level));
            }
        }
        return $arr;
    }

    // :Xml 转换成 数组
    public function xml_to_array($xml):array{
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        return json_decode(json_encode($xmlstring),true);
    }

    // :数组 转 Xml 字符串
    public function array_to_xml($data, $root = '', $encoding = 'utf-8'): string{
        $xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
        if (!empty($root)) {
            $xml .= '<' . $root . '>';
        }
        if (is_array($data)) {
            $xml .= $this->to_xml($data);
        } else {
            $xml .= $data;
        }
        if (!empty($root)) {
            $xml .= '</' . $root . '>';
        }
        return $xml;
    }
    private function to_xml($array): string{
        $xml = '';
        foreach ($array as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($val) || is_object($val)) ?
                $this->to_xml($val) :
                $val;
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }

    // :数组 转 Cookie 字符串
    public function array_to_cookie($array):string{
        $cookie="";
        foreach ($array as $key=>$value){
            $cookie.=$value['name']."=".$value['value']."; ";
        }
        $cookie .= rtrim($cookie,"; ");
        return $cookie;
    }

}