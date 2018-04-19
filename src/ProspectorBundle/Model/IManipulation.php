<?php

namespace ProspectorBundle\Model;

interface IManipulation
{
    /**
     * Calculates the basic total amount (no other expense account).
     *
     * @param array $array contains all values will be calculated
     * @return int|float|double
     */
    public function amount($array);
}
