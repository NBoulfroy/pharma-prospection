<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\ExpenceAccount as BaseExpenseAccount;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\ExpenseAccountRepository")
 * @ORM\Table(name="expenseAccount")
 */
class ExpenseAccount extends BaseExpenseAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="month", type="datetime", nullable=false)
     */
    protected $month;

    /**
     * @ORM\Column(name="night", type="integer", nullable=true)
     */
    protected $night;

    /**
     * @ORM\Column(name="middayMeal", type="integer", nullable=true)
     */
    protected $middayMeal;

    /**
     * @ORM\Column(name="totalAmount", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $totalAmount;

    /**
     * @ORM\Column(name="mileage", type="integer", nullable=false)
     */
    protected $mileage;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OtherExpenseAccount")
     * @ORM\JoinTable(name="include",
     *      joinColumns={@ORM\JoinColumn(name="expenseAccount_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="otherExpenseAccount_id", referencedColumnName="id")}
     * )
     */
    protected $othersExpensesAccount;

    /**
     * @ORM\Column(name="isSubmit", type="boolean", options={"default": false})
     */
    protected $isSubmit;
}
