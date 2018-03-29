<?php

namespace ProspectorBundle\Model;

abstract class OtherExpenseAccount
{
    /**
     * @var int $id
     *
     * Identity
     */
    protected $id;

    /**
     * @var \DateTime $date
     *
     * Date of expanse account.
     */
    protected $date;

    /**
     * @var string $designation
     *
     * Description of this expanse account.
     */
    protected $designation;

    /**
     * @var mixed $amount
     *
     * Amount of this expanse account.
     */
    protected $amount;

    /**
     * @var string $file
     *
     * File name without his extension.
     */
    protected $file;

    /** @var Object $expenseAccount */
    protected $expenseAccount;

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
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return Object
     */
    public function getExpenseAccount()
    {
        return $this->expenseAccount;
    }

    /**
     * @param Object $expenseAccount
     */
    public function setExpenseAccount($expenseAccount)
    {
        $this->expenseAccount = $expenseAccount;
    }
}
