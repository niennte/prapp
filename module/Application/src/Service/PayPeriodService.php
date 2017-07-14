<?php

namespace Application\Service;

/**
 * Class PayPeriodService
 * Static service for managing pay periods.
 *
 * @package Application\Service
 */
class PayPeriodService
{

    public static function getStartDate($date) {

        $dateStamp = self::dateToTimestamp($date);
        $dayOfMonth = date('d', $dateStamp) < 15 ? 1 : 16;

        return date('Y', $dateStamp) . "-" . date('m', $dateStamp) . "-" . $dayOfMonth;
    }

    public static function getEndDate($date) {

        $dateStamp = self::dateToTimestamp($date);
        if (date('d', $dateStamp) < 15) {
            $dayOfMonth = 15;
        } else {
            $dayOfMonth = date(
                't',
                mktime(
                    0,
                    0,
                    0,
                    date('m', $dateStamp),
                    1,
                    date('Y', $dateStamp)
                )
            );
        }

        return date('Y', $dateStamp) . "-" . date('m', $dateStamp) . "-" . $dayOfMonth;
    }

    public static function dateToTimestamp($date) {
        $date = $date = str_replace('/', '-', $date);
        return strtotime($date);
    }

}