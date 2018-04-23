<?php

namespace ProspectorBundle\Model;

abstract class Power
{
    /** @var int $id */
    protected $id;

    /** @var string $designation */
    protected $designation;

    /** @var float $cost */
    protected $cost;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }
}
