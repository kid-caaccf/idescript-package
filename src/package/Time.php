<?php
namespace idescript\package;
/**
 * @auth guest
 * @time 2021-9-6 0:52
 * @description 创建
 */
class Time{

    public static function instance(): Time{
        return new Time();
    }

    // [毫秒区]

    /**
     * 取13位时间戳
     * @return float
     */
    public function microtime(): float{
        list($s1, $s2) = explode(' ', microtime());
        return floatval($s1 + $s2);
    }


    // [秒区]

    /**
     * 取指定 年月日时分秒 时间戳
     * @param $year
     * @param $mouth
     * @param $day
     * @param $hour
     * @param $minute
     * @param $second
     * @return false|int
     */
    public function appoint_second_timestamp($year,$mouth,$day,$hour,$minute,$second){
        return mktime($hour,$minute,$second,$mouth,$day,$year);
    }


    // [分区]

    /**
     * 取此分钟 起始/结束 时间戳
     * @return array
     */
    public function current_minute_scope(): array{
        return [
            mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y')),
            mktime(date('H'),date('i')+1,0,date('m'),date('d'),date('Y'))-1
        ];
    }

    /**
     * 取上分钟 起始/结束 时间戳
     * @return array
     */
    public function last_minute_scope(): array{
        return [
            mktime(date('H'),date('i')-1,0,date('m'),date('d'),date('Y')),
            mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y'))-1
        ];
    }

    /**
     * 取该分钟 起始/结束 时间戳 (指定年/月/日/时/分)
     * @param $timestamp
     * @return array
     */
    public function appoint_minute_scope_by_timestamp($timestamp): array{
        return [
            mktime(date('H',$timestamp),date('i',$timestamp),0,date('m',$timestamp),date('d',$timestamp),date('Y',$timestamp)),
            mktime(date('H',$timestamp),date('i',$timestamp)+1,0,date('m',$timestamp),date('d',$timestamp),date('Y',$timestamp))-1
        ];
    }

    /**
     * 取该分钟 起始/结束 时间戳 (指定年/月/日/时/分)
     * @param $year
     * @param $mouth
     * @param $day
     * @param $hour
     * @param $minute
     * @return array
     */
    public function appoint_minute_scope_by_date($year,$mouth,$day,$hour,$minute): array{
        return [
            mktime($hour,$minute,0,$mouth,$day,$year),
            mktime($hour,$minute+1,0,$mouth,$day,$year)-1
        ];
    }

    /**
     * 取该分钟 所有秒 时间戳 (指定年/月/日/时/分)
     * @param $timestamp
     * @return array
     */
    public function appoint_minute_scope_all_by_timestamp($timestamp): array{
        $times = [];
        $year = date("Y",$timestamp);
        $mouth = date("m",$timestamp);
        $day = date("d",$timestamp);
        $hour = date("H",$timestamp);
        $minute = date("i",$timestamp);
        for ($i=0;$i<60;$i++){
            $times[]=$this->appoint_second_timestamp($year,$mouth,$day,$hour,$minute,$i);
        }
        return $times;
    }

    /**
     * 取该分钟 所有秒 时间戳 (指定年/月/日/时/分)
     * @param $year
     * @param $mouth
     * @param $day
     * @param $hour
     * @param $minute
     * @return array
     */
    public function appoint_minute_scope_all_by_date($year,$mouth,$day,$hour,$minute): array{
        $times = [];
        for ($i=0;$i<60;$i++){
            $times[]=$this->appoint_second_timestamp($year,$mouth,$day,$hour,$minute,$i);
        }
        return $times;
    }


    // [时区]

    /**
     * 取此小时 起始/结束 时间戳
     * @return array
     */
    public function current_hour_scope(): array{
        return [
            mktime(date('H'),0,0,date('m'),date('d'),date('Y')),
            mktime(date('H')+1,0,0,date('m'),date('d'),date('Y'))-1
        ];
    }

    /**
     * 取上小时 起始/结束 时间戳
     * @return array
     */
    public function last_hour_scope(): array{
        return [
            mktime(date('H')-1,0,0,date('m'),date('d'),date('Y')),
            mktime(date('H'),0,0,date('m'),date('d'),date('Y'))-1
        ];
    }

    /**
     * 取该小时 起始/结束 时间戳 (指定年/月/日/时)
     * @param $timestamp
     * @return array
     */
    public function appoint_hour_scope_by_timestamp($timestamp): array{
        return [
            mktime(date('H',$timestamp),0,0,date('m',$timestamp),date('d',$timestamp),date('Y',$timestamp)),
            mktime(date('H',$timestamp)+1,0,0,date('m',$timestamp),date('d',$timestamp),date('Y',$timestamp))-1
        ];
    }

    /**
     * 取该小时 起始/结束 时间戳 (指定年/月/日/时)
     * @param $year
     * @param $mouth
     * @param $day
     * @param $hour
     * @return array
     */
    public function appoint_hour_scope_by_date($year,$mouth,$day,$hour): array{
        return [
            mktime($hour,0,0,$mouth,$day,$year),
            mktime($hour+1,0,0,$mouth,$day,$year)-1,
        ];
    }

    /**
     * 取该小时 所有分钟 起始/结束 时间戳 (指定年/月/日/时)
     * @param $timestamp
     * @return array
     */
    public function appoint_hour_scope_all_by_timestamp($timestamp): array{
        $times = [];
        $year = date("Y",$timestamp);
        $mouth = date("m",$timestamp);
        $day = date("d",$timestamp);
        $hour = date("H",$timestamp);
        for ($i=0;$i<60;$i++){
            $times[]=$this->appoint_minute_scope_by_date($year,$mouth,$day,$hour,$i);
        }
        return $times;
    }

    /**
     * 取该小时 所有分钟 起始/结束 时间戳 (指定年/月/日/时)
     * @param $year
     * @param $mouth
     * @param $day
     * @param $hour
     * @return array
     */
    public function appoint_hour_scope_all_by_date($year,$mouth,$day,$hour): array{
        $times = [];
        for ($i=0;$i<60;$i++){
            $times[]=$this->appoint_minute_scope_by_date($year,$mouth,$day,$hour,$i);
        }
        return $times;
    }


    // [日区]

    /**
     * 取今日 起始/结束 时间戳
     * @return array
     */
    public function today_scope(): array{
        return [
            mktime(0,0,0,date('m'),date('d'),date('Y')),
            mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1
        ];
    }

    /**
     * 取昨日 起始/结束 时间戳
     * @return array
     */
    public function yesterday_scope():array{
        return [
            mktime(0,0,0,date('m'),date('d')-1,date('Y')),
            mktime(0,0,0,date('m'),date('d'),date('Y'))-1
        ];
    }

    /**
     * 取该日 起始/结束 时间戳 (指定年/月/日)
     * @param $year
     * @param $mouth
     * @param $day
     * @return array
     */
    public function appoint_day_scope_by_timestamp($timestamp): array{
        $year = date("Y",$timestamp);
        $mouth = date("m",$timestamp);
        $day = date("d",$timestamp);
        return [
            mktime(0,0,0,$mouth,$day,$year),
            mktime(0,0,0,$mouth,$day+1,$year)-1,
        ];
    }

    /**
     * 取该日 起始/结束 时间戳 (指定年/月/日)
     * @param $year
     * @param $mouth
     * @param $day
     * @return array
     */
    public function appoint_day_scope_by_date($year,$mouth,$day): array{
        return [
            mktime(0,0,0,$mouth,$day,$year),
            mktime(0,0,0,$mouth,$day+1,$year)-1,
        ];
    }

    /**
     * 取该日 所有小时 起始/结束 时间戳 (指定年/月/日)
     * @param $timestamp [任意时间戳]
     * @return array
     */
    public function appoint_day_scope_all_by_timestamp($timestamp): array{
        $times = [];
        $year = date("Y",$timestamp);
        $mouth = date("m",$timestamp);
        $day = date("d",$timestamp);
        for ($i=0;$i<24;$i++){
            $times[]=[
                mktime($i,0,0,$mouth,$day,$year),
                mktime($i+1,0,0,$mouth,$day,$year)-1,
            ];
        }
        return $times;
    }

    /**
     * 取该日 所有小时 起始/结束 时间戳 (指定年/月/日)
     * @param $year
     * @param $mouth
     * @param $day
     * @return array
     */
    public function appoint_day_scope_all_by_date($year,$mouth,$day): array{
        $times = [];
        for ($i=0;$i<24;$i++){
            $times[]=[
                mktime($i,0,0,$mouth,$day,$year),
                mktime($i+1,0,0,$mouth,$day,$year)-1,
            ];
        }
        return $times;
    }


    // [周区]

    /**
     * 取本周 起始/结束 时间戳
     * @return array
     */
    public function this_week_scope(): array{
        return [
            mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y")),
            mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))
        ];
    }

    /**
     * 取上周 起始/结束 时间戳
     * @return array
     */
    public function last_week_scope():array{
        return [
            mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')),
            mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'))
        ];
    }

    // [月区]
    /**
     * 取本月 起始/结束 时间戳
     * @return array
     */
    public function this_month_scope():array{
        return [
            mktime(0,0,0,date('m'),1,date('Y')),
            mktime(23,59,59,date('m'),date('t'),date('Y'))
        ];
    }

    /**
     * 取本月 有多少天
     * @return false|string
     */
    public function this_month_count(){
        return date('t');
    }

    /**
     * 取上月 起始/结束 时间戳
     * @return array
     */
    public function last_month_scope():array{
        return [
            mktime(0,0,0,date('m')-1,1,date('Y')),
            mktime(23,59,59,date('m'),0,date('Y'))
        ];
    }

    /**
     * 取该月 所有日 起始/结束 时间戳 (指定年/月/日)
     * @param $timestamp [任意时间戳]
     * @return array
     */
    public function appoint_mouth_scope_all($timestamp): array{
        $times = [];
        $year = date("Y",$timestamp);
        $mouth = date("m",$timestamp);
        $day_count = $this->appoint_mouth_count($year,$mouth);
        for($i=1;$i<=$day_count;$i++){
            echo($i);
            $times[] = $this->appoint_day_scope_by_date($year,$mouth,$i);
        }
        return $times;
    }

    /**
     * 取该月 有多少天 (指定年月)
     * @param $year
     * @param $mouth
     * @return int
     */
    public function appoint_mouth_count($year,$mouth): int{
        return cal_days_in_month(CAL_GREGORIAN, $mouth, $year);
    }

}