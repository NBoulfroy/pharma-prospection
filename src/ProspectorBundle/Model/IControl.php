<?php

namespace ProspectorBundle\Model;

interface IControl
{
    /**
     * Controls the variable content by pattern.
     *
     * @param int|string|float $param
     * @return boolean
     */
    static function control($param);

    /**
     * Controls the variable content by pattern.
     *
     * @param array $array
     * @return int
     */
    public static function verification($array);
}
