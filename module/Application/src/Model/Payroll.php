<?php

namespace Application\Model;

/**
 * Class Payroll
 * Represents a data view of time card entity with aggregated fields.
 *
 * @package Application\Model
 */
class Payroll extends AbstractSelfMappingModel
{
    protected $id;
    protected $employeeId;
    protected $payPeriodStartDate;
    protected $payPeriodEndDate;
    protected $totalHours;
    protected $amountPaid;
    protected $status;

    public $employeeIdToDisplay;
    public $amountToDisplay;
    public $payPeriodToDisplay;

    /**
     * Stub.
     * Combine incoming data here
     * @param $data
     */
    public function exchangeArray($data) {
        parent::exchangeArray($data);
    }

    /**
     * Stub.
     * Transform data on the way out
     * @return array
     */
    public function getArrayCopy() {
        return parent::toArray(\ReflectionProperty::IS_PROTECTED);
    }

    public function getPublicArrayCopy() {
        $this->employeeIdToDisplay = $this->getEmployeeId();
        $this->amountToDisplay = $this->getAmountPaid();
        $this->payPeriodToDisplay = date('d/m/Y', strtotime($this->getPayPeriodStartDate()))
            . ' - '
            . date('d/m/Y', strtotime($this->getPayPeriodEndDate()));
        return parent::toArray(\ReflectionProperty::IS_PUBLIC);
    }

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
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param mixed $employeeId
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return mixed
     */
    public function getPayPeriodStartDate()
    {
        return $this->payPeriodStartDate;
    }

    /**
     * @param mixed $payPeriodStartDate
     */
    public function setPayPeriodStartDate($payPeriodStartDate)
    {
        $this->payPeriodStartDate = $payPeriodStartDate;
    }

    /**
     * @return mixed
     */
    public function getPayPeriodEndDate()
    {
        return $this->payPeriodEndDate;
    }

    /**
     * @param mixed $payPeriodEndDate
     */
    public function setPayPeriodEndDate($payPeriodEndDate)
    {
        $this->payPeriodEndDate = $payPeriodEndDate;
    }

    /**
     * @return mixed
     */
    public function getTotalHours()
    {
        return $this->totalHours;
    }

    /**
     * @param mixed $totalHours
     */
    public function setTotalHours($totalHours)
    {
        $this->totalHours = $totalHours;
    }

    /**
     * @return mixed
     */
    public function getJobGroupEffectiveRate()
    {
        return $this->jobGroupEffectiveRate;
    }

    /**
     * @param mixed $jobGroupEffectiveRate
     */
    public function setJobGroupEffectiveRate($jobGroupEffectiveRate)
    {
        $this->jobGroupEffectiveRate = $jobGroupEffectiveRate;
    }



    /**
     * @return mixed
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * @param mixed $status
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


}