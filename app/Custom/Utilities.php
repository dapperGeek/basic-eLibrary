<?php

namespace App\Custom;

class Utilities {

    static string $DATE_FORMAT = 'Y-m-d H:i:s';
    
    public static function getRemainingOrOver($expectedDate, $currentDate)
    {
        $dateDiff = '';
        $warning = '';

        if ($currentDate > $expectedDate) {
            $dateDiff = self::dateDifferenceStamp($currentDate, $expectedDate);
            $timeToDays =  round($dateDiff / (60 * 60 * 24));
            $warning = $timeToDays . ' days overdue.';
        }
        else {
            $dateDiff = self::dateDifferenceStamp($expectedDate, $currentDate);
            $timeToDays =  round($dateDiff / (60 * 60 * 24));
            $warning = $timeToDays . ' days remaining to check in.';
        }

        return $warning;
    }

    public static function dateDifferenceStamp($firstDate, $secondDate)
    {
        return strtotime($firstDate) - strtotime($secondDate);
    }

    public static function displayDateFormat($dateTime)
    {
        return date('F j, Y', strtotime($dateTime));
    }
}