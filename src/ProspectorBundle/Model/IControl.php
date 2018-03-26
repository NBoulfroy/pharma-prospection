<?php

namespace ProspectorBundle\Model;

interface IControl
{
    /**
     * Controls the variable content by pattern.
     *
     * @param string|int $param
     * @return boolean
     */
    public static function control($param);
}
