<?php

namespace Application\Model;

/**
 * Class PayrollReport
 * Represents a data view of time card entity with aggregated fields.
 *
 * @package Application\Model
 */
class PayrollReport extends AbstractSelfMappingModel
{
    protected $id;
    protected $employeeId;
    protected $amountPaid;
    protected $payPeriodStartDate;
    protected $payPeriodEndDate;

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
        // parent's method should keep data as expected by data store
        return parent::toArray();
    }
}