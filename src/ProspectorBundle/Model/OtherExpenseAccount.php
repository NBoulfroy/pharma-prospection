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
}
