<?php

namespace ProspectorBundle\Model;

abstract class Profile implements IControl
{
    /** @var int $id */
    protected $id;

    /** @var string $lastName */
    protected $lastName;

    /** @var string $firstName */
    protected $firstName;

    /** @var string $mobilePhoneNumber */
    protected $mobilePhoneNumber;

    /** @var string $phoneNumber */
    protected $phoneNumber;

    /** @var Object $person */
    protected $person;

    /** @var Object $car */
    protected $car;

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
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMobilePhoneNumber()
    {
        return $this->mobilePhoneNumber;
    }

    /**
     * @param string $mobilePhoneNumber
     */
    public function setMobilePhoneNumber($mobilePhoneNumber)
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return Object
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Object $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return Object
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param Object $car
     */
    public function setCar($car)
    {
        $this->car = $car;
    }

    /**
     * Controls variable.
     *
     * @param string $param
     * @param null|string $case
     * @return bool
     */
    public static function control($param, $case = null)
    {
        switch ($case) {
            case 'lastName':
                break;
            case 'firstName':
                break;
            case 'mobilePhoneNumber':
                break;
            case 'phoneNumber':
                break;
        }

        return false;
    }
}
