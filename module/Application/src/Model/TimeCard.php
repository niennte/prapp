<?php
namespace Application\Model;

use Application\Model\Factory\PayrollFactory;
use Application\Service\RateService;

/**
 * Class TimeCard
 * Responsible for flat sets of well formed data
 * communicated between data store and models
 *
 * @package Application\Model
 */
class TimeCard extends AbstractSelfMappingModel
{
    protected $id;
    protected $date;
    protected $employeeId;
    protected $hoursWorked;
    protected $jobGroup;
    protected $timeReportId;
    protected $jobGroupEffectiveRate;

    private $payroll;


    /**
     * @param mixed $timeReportId
     */
    public function setTimeReportId($timeReportId)
    {
        $this->timeReportId = $timeReportId;
    }

    /**
     *
     * Combine incoming data.
     *
     * @param $data
     * @return void|static
     */
    public function exchangeArray($data) {
        parent::exchangeArray($data);
        $this->jobGroupEffectiveRate = $this->getEffectiveRate();
    }

    /**
     * Stub
     * Place to reformat data on the way out
     * @return array
     */
    public function getArrayCopy() {
        // parent's method will keep data as expected by data store
        return parent::toArray();
    }

    /**
     * @return $this
     */
    public function addToPayroll() {
        $payroll = PayrollFactory::fromTimeCard($this);
        $this->setPayroll($payroll);
        return $this;
    }

    public function getEffectiveRate() {
        return RateService::getForGroup($this->getJobGroup());
    }

    public function updatePayrollAmountPaid() {
        return $this->getHoursWorked() * $this->getEffectiveRate();
    }

    /**
     *
     * Stub.
     * Checks for nulls in data
     * Error propagates into container model as a warning
     *
     * @return bool|string
     */
    public function getErrors() {

        $fields = parent::toArray();
        unset($fields['id']);
        $key = array_search(null, $fields);
        return $key ? "Field $key cannot be null.": false;

    }

    /**
     *
     * Stub.
     * Checks for nulls in data
     * Error propagates into container model as a warning
     *
     * @return bool|string
     */
    public function isValid() {

        $fields = parent::toArray();
        unset($fields['id']);
        $key = array_search(null, $fields);
        return $key ? false : true;

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
     *
     * @return TimeCard
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return TimeCard
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
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
     *
     * @return TimeCard
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoursWorked()
    {
        return $this->hoursWorked;
    }

    /**
     * @param mixed $hoursWorked
     *
     * @return TimeCard
     */
    public function setHoursWorked($hoursWorked)
    {
        $this->hoursWorked = $hoursWorked;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobGroup()
    {
        return $this->jobGroup;
    }

    /**
     * @param mixed $jobGroup
     *
     * @return TimeCard
     */
    public function setJobGroup($jobGroup)
    {
        $this->jobGroup = $jobGroup;
        return $this;
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
     *
     * @return TimeCard
     */
    public function setJobGroupEffectiveRate($jobGroupEffectiveRate)
    {
        $this->jobGroupEffectiveRate = $jobGroupEffectiveRate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayroll()
    {
        return $this->payroll;
    }

    /**
     * @param mixed $payroll
     *
     * @return TimeCard
     */
    public function setPayroll($payroll)
    {
        $this->payroll = $payroll;
        return $this;
    }

}