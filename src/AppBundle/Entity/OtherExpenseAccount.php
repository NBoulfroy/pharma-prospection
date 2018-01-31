<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\OtherExpenseAccount as BaseOtherExpenseAccount;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\OtherExpenseRepository")
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
     * @ORM\Column(name="fileName", type="string", nullable=false)
     */
    protected $fileName;

    /**
     * @ORM\Column(name="fileMime", type="string", nullable=false)
     */
    protected $fileMime;
}
