<?php
namespace idescript\package;
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
class File{

    public static function instance(): File{
        return new File();
    }

    public function create_folder(string $path, int $mode = 0777): bool{
        $encode = stristr(PHP_OS, 'WIN') ? 'GBK' : 'UTF-8';
        $storagePath = iconv('UTF-8', $encode, $path);
        if (file_exists($storagePath)) {
            return false;
        }
        @mkdir($storagePath, $mode, true);
        return true;
    }

    public function read_folder(string $path) :array{
        $dir = iconv("UTF-8", "GBK", $path);
        //获取某目录下所有文件、目录名（不包括子目录下文件、目录名）
        $chir_ = scandir($dir);
        if (!$chir_) {
            return [];
        }
        $this_chir_url = array();
        foreach ($chir_ as $value) {
            $temp_type = '';
            $this_chir = is_dir($path . $value);
            if ($this_chir == true) {
                $temp_type = 'dir';
            } else {
                $this_chi = is_file($path . $value);
                if ($this_chi == true) {
                    $temp_type = 'file';
                } else {
                    $temp_type = 'unknown';
                }
            }
            $temp_arr = array(
                "url" => $value,
                "type" => $temp_type
            );
            array_push($this_chir_url, $temp_arr);
        }
        return $this_chir_url;
    }

    public function delete_folder(string $path) :void{
        //如果是目录则继续
        if (is_dir($path)) {
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach ($p as $val) {
                //排除目录中的.和..
                if ($val != "." && $val != "..") {
                    //如果是目录则递归子目录，继续操作
                    if (is_dir($path . $val)) {
                        //子目录中操作删除文件夹和文件
                        $this->delete_folder($path . $val . '/');
                        //目录清空后删除空文件夹
                        @rmdir($path . $val . '/');
                    } else {
                        //如果是文件直接删除
                        unlink($path . $val);
                    }
                }
            }
        }
    }

    public function delete_empty_folder(string $path):void{
        if (is_dir($path)) {
            @rmdir($path);
        }
    }

    public function copy_folder($copy, $to): bool{
        $Source_Folder = iconv("UTF-8", "GBK", $copy);
        $Dest_Folder = iconv("UTF-8", "GBK", $to);
        if (!file_exists($Dest_Folder)) mkdir($Dest_Folder);
        $handle = opendir($Source_Folder);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') continue;
            $_source = $Source_Folder . '/' . $item;
            $_dest = $Dest_Folder . '/' . $item;
            if (is_file($_source)) copy($_source, $_dest);
            if (is_dir($_source)) $this->copy_folder($_source, $_dest);
        }
        closedir($handle);
        return true;
    }

    public function move_folder($move, $to): bool{
        $move_name_folder = iconv("UTF-8", "GBK", $move);
        $to_name_folder = iconv("UTF-8", "GBK", $to);
        $aimDir = str_replace('', '/', $to_name_folder);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $move_name_folder);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }
        if (!file_exists($aimDir)) {
            $this->create_folder($aimDir);
        }
        @ $dirHandle = opendir($oldDir);
        if (!$dirHandle) {
            return false;
        }
        while (false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($oldDir . $file)) {
                $this->move_folder($oldDir . $file, $aimDir . $file);
            } else {
                $this->move_folder($oldDir . $file, $aimDir . $file);
            }
        }
        closedir($dirHandle);
        return rmdir($oldDir);
    }

    public function get_folder_size($path){
        $path = iconv("UTF-8", "GBK", $path);
        $size = 0;
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') continue;
            $_path = $path . '/' . $item;
            if (is_file($_path)) $size += filesize($_path);
            if (is_dir($_path)) $size += $this->get_folder_size($_path);
        }
        closedir($handle);
        return $size;
    }

    // :文件/文件夹-获取父级目录名
    public function get_folder_name($path): string{
        $path = iconv("UTF-8", "GBK", $path);
        return dirname($path);
    }

    // :文件/文件夹-获取绝对路径
    public function get_folder_realpath($path){
        $path = iconv("UTF-8", "GBK", $path);
        return realpath($path);
    }


    public function create_file(string $path, string $data): void{
        $this->create_folder(pathinfo($path)['dirname']);
        $file = fopen($path, "w+") or die("Unable to open file!");
        fwrite($file, $data);
        fclose($file);
    }

    public function create_file_if_non_existent(string $path, string $data): bool{
        $this->create_folder(pathinfo($path)['dirname']);
        $file = @fopen($path, "x+") or false;
        if (!$file) {
            return false;
        }
        fwrite($file, $data);
        fclose($file);
        return true;
    }

    public function read_file($path){
        $path = iconv("UTF-8", "GBK", $path);
        $data = file_get_contents($path);
        if (!$data) {
            return false;
        }
        return $data;
    }

    public function delete_file(string $path):void{
        $url = iconv('utf-8', 'gbk', $path);
        if (PATH_SEPARATOR == ':') {
            //linux
            unlink($path);
        } else {
            //Windows
            unlink($url);
        }
    }

    public function copy_file($copy, $to): bool{
        $copy_file = iconv("UTF-8", "GBK", $copy);
        $to_file = iconv("UTF-8", "GBK", $to);
        $ret = copy($copy_file, $to_file);
        if (!$ret) {
            return false;
        }
        return true;
    }

    public function move_file($move, $to): bool{
        $move_name_file = iconv("UTF-8", "GBK", $move);
        $to_name_file = iconv("UTF-8", "GBK", $to);
        $ret = rename($move_name_file, $to_name_file);
        if (!$ret) {
            return true;
        }
        return false;
    }

    public function get_file_size($path): int{
        $fir = iconv("UTF-8", "GBK", $path);
        $ret = filesize($fir);
        if (!$ret) {
            return 0;
        }
        return $ret;
    }

    public function insert_file(string $path, string $data): void{
        $this->create_folder(pathinfo($path)['dirname']);
        $file = fopen($path, "a+") or die("Unable to open file!");
        fwrite($file, $data);
        fclose($file);
    }

    // :文件获取后缀名
    public function get_file_ext($path): ?string{
        $path = iconv("UTF-8", "GBK", $path);
        $arr = explode('.', $path);
        return array_pop($arr);
    }

    // :文件-获取文件名
    public function get_file_base_name($path): string{
        $path = iconv("UTF-8", "GBK", $path);
        return basename($path);
    }

    // :文件-获取父级目录信息
    public function get_file_pathinfo_data($path){
        $path = iconv("UTF-8", "GBK", $path);
        return pathinfo($path);
    }

    // :文件/文件夹-获取最后访问时间
    public function get_file_last_time($path){
        $path = iconv("UTF-8", "GBK", $path);
        return fileatime($path);
    }

    public function download_file($path, $save_as_file_name):void{
        $file = fopen($path, "rb");
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Content-Disposition:  attachment;  filename=$save_as_file_name");
        $contents = "";
        while (!feof($file)) {
            $contents .= fread($file, 8192);
        }
        echo $contents;
        fclose($file);
    }

    public function lock_file(string $path):void{
        while (!$this->create_file_if_non_existent($path.".lock","")){
            usleep(100);
        }
    }

    public function unlock_file(string $path):void{
        $this->delete_file($path.".lock");
    }

}