<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\Car as BaseCar;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\CarRepository")
 * @ORM\Table(name="car")
 */
class Car extends BaseCar
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="numberPlate", type="string", length=25, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $numberPlate;

    /**
     * @ORM\ManyToOne(targetEntity="Power")
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id")
     */
    protected $power;
}
