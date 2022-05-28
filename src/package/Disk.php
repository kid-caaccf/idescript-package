<?php
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
namespace idescript\package;
class Disk{

    public static function instance(): Disk{
        return new Disk();
    }

    // : 磁盘列表
    public function disk_list(){
        exec("wmic LOGICALDISK get name", $dir);
        //wmic LOGICALDISK get name,freespace,size,addtime
        return $dir;
    }

    // : 磁盘总空间
    public function disk_total_space($disk){
        $D_ir = iconv("UTF-8", "GBK", $disk);
        $ret = disk_total_space($D_ir);
        if (!$ret) {
            return false;
        }
        return $ret;
    }

    // : 磁盘可用空间
    public function disk_free_space($disk){
        $disk = iconv("UTF-8", "GBK", $disk);
        $ret = disk_free_space($disk);
        if (!$ret) {
            return false;
        }
        return $ret;
    }

}