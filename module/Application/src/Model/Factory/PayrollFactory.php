<?php
namespace Application\Model\Factory;
use Application\Model\Payroll;
use Application\Model\TimeCard;
use Application\Service\PayPeriodService;

class PayrollFactory
{

    public static function fromTimeCard(TimeCard $timeCard)
    {
        $payroll = new Payroll();

        $payroll->exchangeArray([
            'employee_id' => $timeCard->getEmployeeId(),
            'pay_period_start_date' => PayPeriodService::getStartDate($timeCard->getDate()),
            'pay_period_end_date' => PayPeriodService::getEndDate($timeCard->getDate()),
            'total_hours' => $timeCard->getHoursWorked(),
            'amount_paid' => $timeCard->updatePayrollAmountPaid(),
            'status' => '',
        ]);

        return $payroll;
    }

}