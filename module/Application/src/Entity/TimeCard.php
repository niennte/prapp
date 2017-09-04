<?php
namespace Application\Entity;

use Application\Model\AbstractSelfMappingModel;
use Application\Service\PayPeriodService;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\MApping\SequenceGenerator;
/**
 * Class TimeCard
 *
 * @package Application\Entity
 *
 *
 * @ORM\Entity(repositoryClass="\Application\Repository\TimeKeepingRepository")
 * @ORM\Table(name="time_cards")
 */
class TimeCard extends AbstractSelfMappingModel
{
    /**
     * @ORM\ID
     * @GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @SequenceGenerator(sequenceName="time_card_seq", initialValue=1, allocationSize=10)
     */
    protected $id;


    /**
     * @ORM\Column(name="date", type="date")
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
     * @ORM\Column(name="job_group_effective_rate")
     */
    protected $jobGroupEffectiveRate;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\TimeReport", inversedBy="timeCards")
     * @ORM\JoinColumn(name="time_report_id", referencedColumnName="id")
     */
    protected $timeReport;



    public static function fromModel($model){
        $self = parent::fromModel($model);
        $dateStamp = PayPeriodService::dateToTimestamp($model->getDate());
        $date = date('Y-m-d\TH:i:sP', $dateStamp);
        $self->date = new \DateTime($date);
        return $self;
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
    public function getTimeReport()
    {
        return $this->timeReport;
    }

    /**
     * @param mixed $timeReport
     *
     * @return TimeCard
     */
    public function setTimeReport($timeReport)
    {
        $this->timeReport = $timeReport;
        return $this;
    }

}