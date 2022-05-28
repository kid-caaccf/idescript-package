<?php
/**
 * @auth guest
 * @time 2021-9-6 9:55
 * @description 创建
 */
namespace idescript\package;
class Sql{

    public static function instance(): Sql{
        return new Sql();
    }

    // :-获取数据库所有表名
    public function all_table(): string{
        return "SHOW TABLES";
    }

    // :-获取指定数据表结构
    public function show_table_status($table): string{
        return sprintf("show table status like '%s'", $table);
    }

    // :-获取指定表所有字段数据
    public function table_fields($table,$status="column_name,column_type,column_default,column_comment"): string{
        return sprintf("select %s from information_schema.COLUMNS where table_name = '%s'",$status,$table);
    }

    // :-获取指定表所有主键字段数据
    public function table_key_fields($table,$status="column_name"): string{
        return sprintf("SELECT %s FROM INFORMATION_SCHEMA.`KEY_COLUMN_USAGE` WHERE table_name='%s' AND constraint_name='PRIMARY'",$status,$table);
    }

    // :-获取指定表所有字段
    public function clear_autoincrement($table): string{
        return sprintf("ALTER TABLE %s AUTO_INCREMENT= 0;",$table);
    }

    // :-备份数据库到文件
    public function backup_sql($mysqldump_path,$user,$password,$database_name,$file_path,$host=3306):bool{
        $process = $mysqldump_path . " -h" . $host . " -u" . $user . "  -p" . $password . "  " . $database_name . " >" . $file_path;
        return exec($process);
    }




}