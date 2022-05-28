<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package;
class Log{

    public static function instance(): Log{
        return new Log();
    }

    function insert_log(string $path, string $title, array $content): void{
        $txt = "【" . date('Y-m-d H:i:s', time()) . "|" . Time::instance()->microtime() . "】" . $title . ":\r\n";
        $txt .= "" . $this->build_log_content($content) . "\r\n\r\n";
        File::instance()->insert_file($path, $txt);
    }

    private function build_log_content(array $content): string{
        $text = "";
        foreach ($content as $key => $value) {
            $text .= "$key: $value\r\n";
        }
        return $text;
    }
}