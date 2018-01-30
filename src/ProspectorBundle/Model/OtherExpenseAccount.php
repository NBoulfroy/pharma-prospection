<?php

namespace ProspectorBundle\Model;

abstract class OtherExpenseAccount
{
    /**
     * @var int $id
     *
     * Identity
     */
    protected $id;

    /**
     * @var \DateTime $date
     *
     * Date of expanse account.
     */
    protected $date;

    /**
     * @var string $designation
     *
     * Description of this expanse account.
     */
    protected $designation;

    /**
     * @var mixed $amount
     *
     * Amount of this expanse account.
     */
    protected $amount;

    /**
     * @var string $fileName
     *
     * File name without his extension.
     */
    protected $fileName;

    /**
     * @var string $fileMime
     *
     * Type MIME of this file (file extension).
     */
    protected $fileMime;

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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileMime()
    {
        return $this->fileMime;
    }

    /**
     * @param string $fileMime
     */
    public function setFileMime($fileMime)
    {
        $this->fileMime = $fileMime;
    }
}
