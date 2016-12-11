<?php
namespace Application\Entity;

use Application\Model\AbstractSelfMappingModel;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * This class represents an atomic record in the time keeping data store.
 * Stands in place of any number of relational entities managed by the ORM,
 * a noSQL data store interface, or a service.
 *
 * Interfaces with models representing a flat set of well formed data,
 * a wrapper model, and a data view.
 *
 *
 * @ORM\Entity(repositoryClass="\Application\Repository\TimeKeepingRepository")
 * @ORM\Table(name="time_keeping_data")
 */


class TimeKeepingDataRecord extends AbstractSelfMappingModel
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="date")
     */
    protected $date;

    /**
     * @ORM\Column(name="employee_id")
     */
    protected $employeeId;

    /**
     * @ORM\Column(name="hours_worked")
     */
    protected $hoursWorked;

    /**
     * @ORM\Column(name="job_group")
     */
    protected $jobGroup;

    /**
     * @ORM\Column(name="time_report_id")
     */
    protected $timeReportId;

    /**
     * @ORM\Column(name="pay_period_start_date")
     */
    protected $payPeriodStartDate;

    /**
     * @ORM\Column(name="pay_period_end_date")
     */
    protected $payPeriodEndDate;

    /**
     * @ORM\Column(name="job_group_effective_rate")
     */
    protected $jobGroupEffectiveRate;

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
     * @return TimeKeepingDataRecord
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
     * @return TimeKeepingDataRecord
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
     * @return TimeKeepingDataRecord
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
     * @return TimeKeepingDataRecord
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
     * @return TimeKeepingDataRecord
     */
    public function setJobGroup($jobGroup)
    {
        $this->jobGroup = $jobGroup;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeReportId()
    {
        return $this->timeReportId;
    }

    /**
     * @param mixed $timeReportId
     *
     * @return TimeKeepingDataRecord
     */
    public function setTimeReportId($timeReportId)
    {
        $this->timeReportId = $timeReportId;
        return $this;
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
     *
     * @return TimeKeepingDataRecord
     */
    public function setPayPeriodStartDate($payPeriodStartDate)
    {
        $this->payPeriodStartDate = $payPeriodStartDate;
        return $this;
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
     *
     * @return TimeKeepingDataRecord
     */
    public function setPayPeriodEndDate($payPeriodEndDate)
    {
        $this->payPeriodEndDate = $payPeriodEndDate;
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
     * @return TimeKeepingDataRecord
     */
    public function setJobGroupEffectiveRate($jobGroupEffectiveRate)
    {
        $this->jobGroupEffectiveRate = $jobGroupEffectiveRate;
        return $this;
    }


}