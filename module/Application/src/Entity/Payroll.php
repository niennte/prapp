<?php
namespace Application\Entity;

use Application\Model\AbstractSelfMappingModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TimeCard
 *
 * @package Application\Entity
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="payrolls")
 */
class Payroll extends AbstractSelfMappingModel
{


    /**
     * @ORM\Id
     * @ORM\Column(name="employee_id")
     */
    protected $employeeId;

    /**
     * @ORM\Id
     * @ORM\Column(name="pay_period_start_date")
     */
    protected $payPeriodStartDate;

    /**
     * @ORM\Column(name="pay_period_end_date")
     */
    protected $payPeriodEndDate;

    /**
     * @ORM\Column(name="total_hours")
     */
    protected $totalHours;

    /**
     * @ORM\Column(name="amount_paid")
     */
    protected $amountPaid;

    /**
     * @ORM\Column(name="status")
     */
    protected $status;

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
     * @return Payroll
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
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
     * @return Payroll
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
     * @return Payroll
     */
    public function setPayPeriodEndDate($payPeriodEndDate)
    {
        $this->payPeriodEndDate = $payPeriodEndDate;
        return $this;
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
     *
     * @return Payroll
     */
    public function setTotalHours($totalHours)
    {
        $this->totalHours = $totalHours;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * @param mixed $amountPaid
     *
     * @return Payroll
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;
        return $this;
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
     *
     * @return Payroll
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }



}