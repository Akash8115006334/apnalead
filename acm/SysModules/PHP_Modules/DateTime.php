<?php
//date formates
function DATE_FORMATES($format, $date)
{
    $newdateformate = $date;
    if ($date == null  || $date == "" || $date == "0000-00-00" || $date == " ") {
        $newdateformate = "No Update";
    } else {
        $newdateformate = date("$format", strtotime($date));
    }
    return $newdateformate;
}

/**
 * Current Date time 
 * You can call any of these date, time, or both at same time via CONSTANT DECLARATION METHOD
 */

DEFINE("CURRENT_DATE_TIME", date('Y-m-d h:i:s A'));
DEFINE("CURRENT_DATE", date('Y-m-d'));
DEFINE("CURRENT_TIME", date('h:i:s A'));

//function get minutes from two time
function GetMinutes($time2, $time1)
{
    $time1 = strtotime($time1);
    $time2 = strtotime($time2);

    if ($time1 > $time2) {
        list($time1, $time2) = array($time2, $time1);
        $prefix = "over";
    } else {
        $prefix = "left";
    }

    $diff_seconds = $time2 - $time1;
    $diff_minutes = round($diff_seconds / 60);

    $hours = floor($diff_minutes / 60);
    $remaining_minutes = $diff_minutes % 60;

    if ($diff_minutes == 0) {
        $diff_output = "Time Over";
    } else {
        $diff_output = abs($hours) . " hr " . abs($remaining_minutes) . " min " . $prefix;
    }

    return $diff_output;
}


//converts seconds into hours, minute and seconds
function GetDurations($second)
{

    if ($second == 0 || $second == null) {
        $results = "0 sec";
    } else {
        $hours = gmdate('H', $second);
        $minutes = gmdate('i', $second);
        $seconds = gmdate('s', $second);

        $results = $hours . "hr " . $minutes . "min " . $seconds . "sec";
    }
    return $results;
}
