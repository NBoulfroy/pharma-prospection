<?php

namespace ProspectorBundle\Model;

use \DateTime;

abstract class Control
{
    /**
     * Controls if the date is between two days
     *
     * @param DateTime $today - the current day
     * @param DateTime $begin - the current day less than thirty days
     * @param string $value - the day which is verified between today and begin day
     * @return bool
     */
    public static function controlDate($today, $begin, $value)
    {
        $date = new Datetime($value);

        if ($date < $begin || $date > $today) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Controls if the date is between two days
     *
     * @param int $int - variable which contains integer value.
     * @return bool
     */
    public static function controlInt($int)
    {
        return is_int($int);
    }

    /**
     * Controls if the date is between two days
     *
     * @param float $float - variable which contains float value.
     * @return bool
     */
    public static function controlFloat($float)
    {
        return is_float($float);
    }

    /**
     * Controls if the date is between two days
     *
     * @param int|float $param - variable which contains int / float value.
     * @return bool
     */
    public static function controlValue($param)
    {
        return is_numeric($param);
    }

    /**
     * Controls if the date is between two days
     *
     * @param string $param - variable which contains string value.
     * @return bool
     */
    public static function controlString($param)
    {
        return preg_match('/^[a-zA-Z0-9 ,!?&éàçÉæ?\üÜûÛ-ÇÈœŒëÄâ²êËöÖäÀÙè\'\"]{1,}$/', $param);
    }

    /**
     * Controls if the date is between two days
     *
     * @param string $mime - type mime from a file passed in parameter.
     * @return bool
     */
    public static function controlTypeMime($mime)
    {
        return ($mime !== 'image/png' || $mime !== 'image/jpeg') ? false : true;
    }
}
