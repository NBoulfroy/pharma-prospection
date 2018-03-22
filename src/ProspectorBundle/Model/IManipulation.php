<?php

namespace ProspectorBundle\Model;

interface IManipulation
{
    /**
     * Calculates the basic total amount (no other expense account).
     *
     * @param int|float|double $nightPrice
     * @param int|float|double $middayMealPrice
     * @param int|float|double $mileagePrice
     * @return int|float|double
     */
    public function amount($nightPrice, $middayMealPrice, $mileagePrice);
}
