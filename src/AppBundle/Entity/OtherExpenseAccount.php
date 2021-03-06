<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\OtherExpenseAccount as BaseOtherExpenseAccount;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="otherExpenseAccount")
 */
class OtherExpenseAccount extends BaseOtherExpenseAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @ORM\Column(name="designation", type="string", nullable=false)
     */
    protected $designation;

    /**
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $amount;

    /**
     * @ORM\Column(name="file", type="string", nullable=false)
     */
    protected $file;

    /**
     * @ORM\ManyToOne(targetEntity="ExpenseAccount")
     * @ORM\JoinColumn(name="expenseAccount_id", referencedColumnName="id")
     */
    protected $expenseAccount;
}
