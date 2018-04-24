<?php

namespace ProspectorBundle\Model;

use \DateTime;

abstract class OtherExpenseAccount extends Control implements IControl
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

    /**
     * Controls variable.
     *
     * @param string|int|DateTime $param - string variable which contains data
     * @return bool
     */
    public static function control($param)
    {
        // Date control
        $verification = preg_match('/^[0-9]{1,4}\-[0-9]{2}\-[0-9]{1,4}$/', $param);

        // String control
        if (!$verification) {
            $verification = preg_match('/^[a-zA-Z0-9 ,!?&éàçÉæ?\üÜûÛ-ÇÈœŒëÄâ²êËöÖäÀÙè\'\"]{1,}$/', $param);
        }

        // Int - Float - Decimal control
        if (!$verification) {
            $verification = is_numeric($param);
        }

        // File control
        if (!$verification) {
            // Type mime verification
            $verification = ($param === 'image/png' || $param === 'image/jpeg') ? true : false;
        }

        return $verification;
    }

    /**
     *
     *
     * @param array $array
     * @return int
     */
    public static function verification($array)
    {
        $error = 0;

        foreach ($array as $item) {
            $verification = OtherExpenseAccount::control($item);

            if (!$verification) {
                var_dump($item);
                $error += 1;
            }
        }

        return $error;
    }
}
