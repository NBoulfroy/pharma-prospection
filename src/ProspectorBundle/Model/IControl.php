<?php

namespace ProspectorBundle\Model;

interface IControl
{
    /**
     * Controls the variable content by pattern.
     *
     * @param string|int $param
     * @param null|string $case
     * @return boolean
     */
    public static function control($param, $case = null);
}
