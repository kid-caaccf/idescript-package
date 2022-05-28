<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 改写为AOP模式
 */
namespace idescript\package\transfer;
use idescript\package\Arrays;
class Responses{

    private $code = 200;
    private $data;
    private $other = [];
    private $entity;
    private $data_field = 'data';
    private $code_field = 'code';
    private $charset = 'UTF-8';
    private $type = "JSON";
    private $buff;

    public static function instance(): Responses{
        return new Responses();
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param mixed $other
     */
    public function setOther($other): void
    {
        $this->other = $other;
    }

    /**
     * @param string $code_field
     */
    public function setCodeField(string $code_field): void{
        $this->code_field = $code_field;
    }

    /**
     * @param string $data_field
     */
    public function setDataField(string $data_field): void{
        $this->data_field = $data_field;
    }

    public function setEntity(){
        foreach ($this->other as $key => $val) {
            $this->entity[$key] = $val;
        }
        $this->entity[$this->data_field] = $this->data;
        $this->entity[$this->code_field] = $this->code;
    }

    /**
     * @return array
     */
    public function getEntity(): array{
        return $this->entity;
    }

    /**
     * @param string $charset
     */
    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    public function toJson(){
        $this->type="JSON";
        $this->buff = json_encode($this->entity,320);
    }

    public function toXml($root=""){
        $this->type="XML";
        $this->buff = Arrays::instance()->array_to_xml($this->entity, $root,$this->charset);
    }

    public function toJsonp(){
        $this->type="JSONP";
        $handler = $_GET["callback"] ?? "jsonpReturn";
        $this->buff = $handler . '(' . json_encode($this->entity,320) . ');';
    }

    public function callback(){
        switch (strtoupper($this->type)) {
            case 'JSON' :
                header('Content-Type:application/json; charset=utf-8');
                break;
            case 'XML'  :
                header('Content-Type:text/xml; charset=utf-8');
                break;
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                break;
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                break;
            case 'IMG' :
                header('Content-type: image/jpg');
                break;
        }
        exit($this->buff);
    }


}