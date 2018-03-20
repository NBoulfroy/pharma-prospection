<?php

namespace AppBundle\Entity;

use ProspectorBundle\Model\Parameter as BaseParameter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ProspectorBundle\Repository\ParameterRepository")
 * @ORM\Table(name="parameter")
 */
class Parameter extends BaseParameter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="designation", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $designation;

    /**
     * @ORM\Column(name="value", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    protected $value;
}
