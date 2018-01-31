<?php

namespace ProspectorBundle\Model;

use Doctrine\Common\Collections\Collection;

abstract class ExpenceAccount
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
     * Expense account month.
     */
    protected $month;

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
     * @var Collection $othersExpansesAccount
     */
    protected $othersExpensesAccount;

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
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param \DateTime $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
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
     * @return Collection
     */
    public function getOthersExpensesAccount()
    {
        return $this->othersExpensesAccount;
    }

    /**
     * @param Collection $othersExpensesAccount
     */
    public function setOthersExpensesAccount($othersExpensesAccount)
    {
        $this->othersExpensesAccount = $othersExpensesAccount;
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
    public function setAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return bool
     */
    public function isSubmit()
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
}
