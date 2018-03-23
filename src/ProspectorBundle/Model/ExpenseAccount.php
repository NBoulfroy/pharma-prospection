<?php

namespace ProspectorBundle\Model;

use Doctrine\Common\Collections\Collection;

abstract class ExpenseAccount implements IControl, IManipulation
{
    /**
     * @var int $id
     *
     * Identity.
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * Expense account date.
     */
    protected $date;

    /**
     * @var int $night
     *
     * Number of nights.
     */
    protected $night;

    /**
     * @var int $middayMeal
     *
     * Number of midday meals.
     */
    protected $middayMeal;

    /**
     * @var int $mileage
     *
     * Number of mileages.
     */
    protected $mileage;

    /**
     * @var float $amount
     *
     * Total amount
     */
    protected $totalAmount;

    /**
     * @var boolean $isSubmit
     */
    protected $isSubmit;

    /** @var Object $person */
    protected $person;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getNight()
    {
        return $this->night;
    }

    /**
     * @param int $night
     */
    public function setNight($night)
    {
        $this->night = $night;
    }

    /**
     * @return int
     */
    public function getMiddayMeal()
    {
        return $this->middayMeal;
    }

    /**
     * @param int $middayMeal
     */
    public function setMiddayMeal($middayMeal)
    {
        $this->middayMeal = $middayMeal;
    }

    /**
     * @return int
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * @param int $mileage
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return bool
     */
    public function getIsSubmit()
    {
        return $this->isSubmit;
    }

    /**
     * @param bool $isSubmit
     */
    public function setIsSubmit($isSubmit)
    {
        $this->isSubmit = $isSubmit;
    }

    /**
     * @return Object
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Object $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * Controls variable.
     *
     * @param string $param - string variable which contains data
     * @param null $case - empty this time
     * @return bool
     */
    public static function control($param, $case = null)
    {
        if(!preg_match('/^([0-9]{1,})+(\.[0-9]{1,}?)?$/', $param)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Calculates the basic total amount (no other expense account).
     *
     * @param float|int $nightPrice
     * @param float|int $middayMealPrice
     * @param float|int $mileagePrice
     * @return float|int
     */
    public function amount($nightPrice, $middayMealPrice, $mileagePrice)
    {
        $amount = ($this->night * $nightPrice) + ($this->middayMeal * $middayMealPrice) + ($this->mileage * $mileagePrice);
        return number_format($amount, 2);
    }
}
