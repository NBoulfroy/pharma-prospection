<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\ExpenceAccount as BaseExpenseAccount;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Type(type="datetime")
     */
    protected $month;

    /**
     * @ORM\Column(name="night", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     */
    protected $night;

    /**
     * @ORM\Column(name="middayMeal", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     */
    protected $middayMeal;

    /**
     * @ORM\Column(name="totalAmount", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    protected $totalAmount;

    /**
     * @ORM\Column(name="mileage", type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
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
     * @Assert\NotBlank()
     * @Assert\Type(type="bool")
     */
    protected $isSubmit;
}
