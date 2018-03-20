<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\Power as BasePower;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\PowerRepository")
 * @ORM\Table(name="power")
 */
class Power extends BasePower
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    protected $cost;
}
