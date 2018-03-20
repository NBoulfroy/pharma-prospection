<?php

namespace ProspectorBundle\Model;

abstract class Power implements IControl
{
    /** @var int $id */
    protected $id;

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

    /**
     * Controls cost power.
     *
     * @param string $param - power cost
     * @param null|string $case - not necessary this time
     * @return bool
     */
    public static function control($param, $case = null)
    {
        if(!preg_match('', $param)) {
            return false;
        } else {
            return true;
        }
    }
}
