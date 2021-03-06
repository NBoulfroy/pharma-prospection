<?php

namespace ProspectorBundle\Model;

abstract class Car
{
    /** @var int $id */
    protected $id;

    /** @var string $numberPlate */
    protected $numberPlate;

    /** @var Object $power */
    protected $power;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNumberPlate()
    {
        return $this->numberPlate;
    }

    /**
     * @param string $numberPlate
     */
    public function setNumberPlate($numberPlate)
    {
        $this->numberPlate = $numberPlate;
    }

    /**
     * @return Object
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param Object $power
     */
    public function setPower($power)
    {
        $this->power = $power;
    }
}
