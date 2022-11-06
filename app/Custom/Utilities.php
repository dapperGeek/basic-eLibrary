<?php

namespace App\Custom;

class Utilities {

    static string $DATE_FORMAT = 'Y-m-d H:i:s';
    static int $REMINDER_INTERVAL = 2;
    
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

    public static function getRemainingDaysCount($expectedDate, $currentDate)
    {
        $dateDiff = self::dateDifferenceStamp($expectedDate, $currentDate);
        return round($dateDiff / (60 * 60 * 24));
    }


    public static function confirmToSend($expectedDate, $currentDate)
    {
        $remainingDaysCount = self::getRemainingDaysCount($expectedDate, $currentDate);
        return $remainingDaysCount <= self::$REMINDER_INTERVAL;
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