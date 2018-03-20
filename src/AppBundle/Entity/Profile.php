<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\Profile as BaseProfile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\ProfileRepository")
 * @ORM\Table(name="profile")
 */
class Profile extends BaseProfile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="lastName", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(name="firstName", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $firstName;

    /**
     * @ORM\Column(name="mobilePhoneNumber", type="string", length=25, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $mobilePhoneNumber;

    /**
     * @ORM\Column(name="phoneNumber", type="string", length=25, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    protected $car;
}
