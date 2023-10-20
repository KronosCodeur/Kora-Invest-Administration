<?php

namespace App\Utils;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

class DateTimeUtils
{
    public function datetimeToString(DateTimeInterface $datetime, string $format = 'Y-m-d H:i:s'): string
    {
        return $datetime->format($format);
    }
    public function stringToDateTime(string $datetime, string $format =
    'Y-m-d H:i:s'): DateTime
    {
        return new DateTime($datetime, new DateTimeZone('UTC'));
    }
    public function dateIsNow(string $date, string $format = 'Y-m-d H:i:s'): string
    {
        $now= new DateTime();
        $today = $now->format($format);
        return  $today==$date;
    }

    public function dateDiffInDays(string $date1, string $date2, string $format = 'Y-m-d H:i:s'): int
    {
        $datetime1 = $this->stringToDateTime($date1, $format);
        $datetime2 = $this->stringToDateTime($date2, $format);
        return $datetime1->diff($datetime2)->days;
    }


}