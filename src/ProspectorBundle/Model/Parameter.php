<?php

namespace ProspectorBundle\Model;

abstract class Parameter implements IControl
{
    /** @var int $id */
    protected $id;

    /** @var string $designation */
    protected $designation;

    /** @var int|float|string $value */
    protected $value;

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
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return float|int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float|int|string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Controls variable.
     *
     * @param string $param - power cost
     * @param null|string $case -
     * @return bool
     */
    public static function control($param, $case = null)
    {
        switch ($case) {
            case 'designation':
                break;
            case 'value':
                break;
        }

        return false;
    }
}
