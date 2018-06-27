<?php
namespace Validator;

use DateTime;

class DateValidator
{
    public static function validate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }
}