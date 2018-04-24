<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\ExpenseAccount as BaseExpenseAccount;
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
     * @ORM\Column(name="date", type="datetime", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="datetime")
     */
    protected $date;

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
     * @ORM\Column(name="isSubmit", type="boolean", options={"default": false}, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="bool")
     */
    protected $isSubmit;

    /**
     * @ORM\Column(name="remark", type="text", nullable=true)
     * @Assert\Type(type="text")
     */
    protected $remark;

    /**
     * @ORM\Column(name="isValidate", type="boolean", options={"default": false}, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="bool")
     */
    protected $isValidate;

    /**
     * @ORM\Column(name="isRepay", type="boolean", options={"default": false}, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="bool")
     */
    protected $isRepay;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;
}
